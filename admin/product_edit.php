<?php
$active_tab = 'products';
$page_title = 'Product Editor — Birla Precision Admin';

require_once __DIR__ . '/header.php';
require_once __DIR__ . '/../includes/upload_helper.php';

$pdo = get_db();
$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$product = null;
$existing_sizes_text = '';
$existing_popular_text = '';

if ($product_id > 0) {
    $product = get_product_by_id_or_slug($product_id);
    if ($product) {
        $lines = [];
        $popular = [];
        foreach ($product['sizes'] as $sz) {
            $line = $sz['size_mm'];
            if (!empty($sz['size_inch'])) {
                $line .= ' (' . $sz['size_inch'] . ')';
            }
            $lines[] = $line;
            if ($sz['is_popular']) {
                $popular[] = $sz['size_mm'];
            }
        }
        $existing_sizes_text = implode("\n", $lines);
        $existing_popular_text = implode(', ', $popular);
    }
}

$error = '';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title         = trim($_POST['title'] ?? '');
    $slug          = trim($_POST['slug'] ?? '');
    $category      = trim($_POST['category'] ?? 'twist_drills');
    $category_name = trim($_POST['category_name'] ?? 'HSS Twist Drills');
    $standard      = trim($_POST['standard'] ?? 'IS : 5101 / ISO 235');
    $hsn_code      = trim($_POST['hsn_code'] ?? '8207');
    $brand         = trim($_POST['brand'] ?? 'Dagger Brand / Birla Precision');
    $badge         = trim($_POST['badge'] ?? '');
    $badge_class   = trim($_POST['badge_class'] ?? 'badge-red');
    $description   = trim($_POST['description'] ?? '');
    $full_details  = trim($_POST['full_details'] ?? '');
    $features_raw  = trim($_POST['features_raw'] ?? '');
    $sizes_raw     = trim($_POST['sizes_raw'] ?? '');
    $popular_raw   = trim($_POST['popular_raw'] ?? '');
    $is_active     = isset($_POST['is_active']) ? 1 : 0;
    $sort_order    = (int)($_POST['sort_order'] ?? 1);

    if (empty($title)) {
        $error = 'Product Title is required.';
    } else {
        // Auto slug if empty
        if (empty($slug)) {
            $slug = preg_replace('/[^a-z0-9]+/', '-', strtolower($title));
            $slug = trim($slug, '-');
        }

        // Primary Image upload
        $image_path = $product ? $product['image'] : 'assets/images/collections/jobber_drills.png';
        if (!empty($_FILES['image']['name'])) {
            $upload_res = handle_image_upload($_FILES['image'], 'products');
            if ($upload_res['success']) {
                $image_path = $upload_res['file_path'];
            } else {
                $error = 'Primary image upload failed: ' . $upload_res['error'];
            }
        }

        // Gallery Images upload
        $gallery = [];
        if ($product && !empty($product['gallery_json'])) {
            $gallery = json_decode($product['gallery_json'], true) ?: [];
        }
        if (empty($gallery) && !empty($image_path)) {
            $gallery[] = $image_path;
        }

        if (isset($_FILES['gallery_images']) && is_array($_FILES['gallery_images']['name'])) {
            $file_count = count($_FILES['gallery_images']['name']);
            for ($i = 0; $i < $file_count; $i++) {
                if (!empty($_FILES['gallery_images']['name'][$i])) {
                    $single_file = [
                        'name' => $_FILES['gallery_images']['name'][$i],
                        'type' => $_FILES['gallery_images']['type'][$i],
                        'tmp_name' => $_FILES['gallery_images']['tmp_name'][$i],
                        'error' => $_FILES['gallery_images']['error'][$i],
                        'size' => $_FILES['gallery_images']['size'][$i]
                    ];
                    $g_res = handle_image_upload($single_file, 'products');
                    if ($g_res['success']) {
                        $gallery[] = $g_res['file_path'];
                    }
                }
            }
        }

        // Key features array
        $features = [];
        if (!empty($features_raw)) {
            $f_lines = preg_split('/[\r\n]+/', $features_raw);
            foreach ($f_lines as $fl) {
                $fl = trim($fl);
                if (!empty($fl)) $features[] = $fl;
            }
        }

        // Slug uniqueness check
        if (!$error) {
            $chk_slug = $pdo->prepare("SELECT id FROM products WHERE slug = ? AND id != ?");
            $chk_slug->execute([$slug, (int)($product['id'] ?? 0)]);
            if ($chk_slug->fetch()) {
                $error = 'The URL slug "' . htmlspecialchars($slug) . '" is already in use by another product. Please specify a unique slug.';
            }
        }

        if (!$error) {
            try {
                $features_json = json_encode($features, JSON_UNESCAPED_SLASHES);
                $gallery_json  = json_encode(array_values(array_unique($gallery)), JSON_UNESCAPED_SLASHES);

                if ($product) {
                    // Update product
                    $stmt = $pdo->prepare("
                        UPDATE products 
                        SET slug = ?, title = ?, standard = ?, hsn_code = ?, brand = ?, 
                            category = ?, category_name = ?, badge = ?, badge_class = ?, 
                            description = ?, full_details = ?, image = ?, gallery_json = ?, 
                            features_json = ?, is_active = ?, sort_order = ?
                        WHERE id = ?
                    ");
                    $stmt->execute([
                        $slug, $title, $standard, $hsn_code, $brand,
                        $category, $category_name, $badge, $badge_class,
                        $description, $full_details, $image_path, $gallery_json,
                        $features_json, $is_active, $sort_order, $product['id']
                    ]);
                    $saved_id = $product['id'];
                } else {
                    // Insert new product
                    $stmt = $pdo->prepare("
                        INSERT INTO products 
                        (slug, title, standard, hsn_code, brand, category, category_name, badge, badge_class, description, full_details, image, gallery_json, features_json, is_active, sort_order) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                    ");
                    $stmt->execute([
                        $slug, $title, $standard, $hsn_code, $brand,
                        $category, $category_name, $badge, $badge_class,
                        $description, $full_details, $image_path, $gallery_json,
                        $features_json, $is_active, $sort_order
                    ]);
                    $saved_id = (int)$pdo->lastInsertId();
                }

            // Save Sizes
            // Delete old sizes for this product
            $pdo->prepare("DELETE FROM product_sizes WHERE product_id = ?")->execute([$saved_id]);

            // Parse popular sizes
            $pop_array = array_map('trim', explode(',', $popular_raw));
            $pop_set = array_flip($pop_array);

            // Parse sizes lines/commas
            $size_lines = preg_split('/[\r\n,]+/', $sizes_raw);
            $size_insert = $pdo->prepare("
                INSERT INTO product_sizes (product_id, size_mm, size_inch, dg, is_popular, sort_order) 
                VALUES (?, ?, ?, ?, ?, ?)
            ");

            $order = 1;
            foreach ($size_lines as $sline) {
                $sline = trim($sline);
                if (empty($sline)) continue;

                $mm = '';
                $inch = '';

                // Extract (inch) if present: e.g. "3.17 (1/8")"
                if (preg_match('/^([0-9\.\/]+)\s*\((.*?)\)$/', $sline, $m)) {
                    $mm = trim($m[1]);
                    $inch = trim($m[2]);
                } elseif (strpos($sline, '"') !== false || strpos($sline, '/') !== false) {
                    // Raw inch e.g. "1/8""
                    $inch = $sline;
                    $mm = $sline;
                } else {
                    $mm = $sline;
                }

                $is_pop = isset($pop_set[$mm]) || isset($pop_set[$sline]) || ($order <= 6 && empty($popular_raw)) ? 1 : 0;

                $size_insert->execute([$saved_id, $mm, $inch, '', $is_pop, $order++]);
            }

            header("Location: products.php?msg=" . urlencode($product ? 'Product updated successfully' : 'Product created successfully'));
            exit;
        } catch (PDOException $e) {
            $error = 'Database save error: ' . $e->getMessage();
        }
    }
}
}
?>

<div class="admin-page-header">
  <div>
    <h1 class="admin-page-title"><?= $product ? 'Edit Product' : 'Add New Product' ?></h1>
    <p class="admin-page-subtitle">Configure product specifications, images, and available drill sizes for the dynamic quotation configurator.</p>
  </div>
  <div>
    <a href="products.php" class="admin-btn admin-btn-secondary">
      &larr; Back to Products List
    </a>
  </div>
</div>

<?php if ($error): ?>
  <div class="admin-alert admin-alert-error">
    <span><?= htmlspecialchars($error) ?></span>
  </div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">
  
  <div style="display:grid;grid-template-columns: 2fr 1fr;gap:24px;">

    <!-- Left Column: Core Product Info & Sizes -->
    <div>
      
      <!-- Card 1: Basic Information -->
      <div class="admin-card">
        <h2 class="admin-card-title" style="margin-bottom:16px;">General Information</h2>

        <div class="admin-form-group">
          <label class="admin-label" for="title">Product Title / Name *</label>
          <input 
            type="text" 
            id="title" 
            name="title" 
            class="admin-input" 
            required 
            placeholder="e.g. HSS Parallel Shank Twist Drills (Jobber Series)" 
            value="<?= htmlspecialchars($_POST['title'] ?? ($product['title'] ?? '')) ?>"
          >
        </div>

        <div class="admin-form-grid">
          <div class="admin-form-group">
            <label class="admin-label" for="slug">URL Slug</label>
            <input 
              type="text" 
              id="slug" 
              name="slug" 
              class="admin-input" 
              placeholder="e.g. hss-jobber-drills (auto-generated if empty)" 
              value="<?= htmlspecialchars($_POST['slug'] ?? ($product['slug'] ?? '')) ?>"
            >
          </div>

          <div class="admin-form-group">
            <label class="admin-label" for="brand">Brand</label>
            <input 
              type="text" 
              id="brand" 
              name="brand" 
              class="admin-input" 
              value="<?= htmlspecialchars($_POST['brand'] ?? ($product['brand'] ?? 'Dagger Brand / Birla Precision')) ?>"
            >
          </div>
        </div>

        <div class="admin-form-grid">
          <div class="admin-form-group">
            <label class="admin-label" for="standard">Standard Specification</label>
            <input 
              type="text" 
              id="standard" 
              name="standard" 
              class="admin-input" 
              placeholder="e.g. IS : 5101 / ISO 235 / DIN 338" 
              value="<?= htmlspecialchars($_POST['standard'] ?? ($product['standard'] ?? 'IS : 5101 / ISO 235')) ?>"
            >
          </div>

          <div class="admin-form-group">
            <label class="admin-label" for="hsn_code">HSN Code</label>
            <input 
              type="text" 
              id="hsn_code" 
              name="hsn_code" 
              class="admin-input" 
              placeholder="8207" 
              value="<?= htmlspecialchars($_POST['hsn_code'] ?? ($product['hsn_code'] ?? '8207')) ?>"
            >
          </div>
        </div>

        <div class="admin-form-group">
          <label class="admin-label" for="description">Short Lead Description</label>
          <textarea 
            id="description" 
            name="description" 
            class="admin-textarea" 
            placeholder="A compelling high-level summary of the tool application and metallurgical properties..."
          ><?= htmlspecialchars($_POST['description'] ?? ($product['description'] ?? '')) ?></textarea>
        </div>

        <div class="admin-form-group">
          <label class="admin-label" for="full_details">Detailed Engineering Overview</label>
          <textarea 
            id="full_details" 
            name="full_details" 
            class="admin-textarea" 
            placeholder="Detailed metallurgical composition, grinding point angle, flute geometry, and factory plant details..."
            style="min-height:120px;"
          ><?= htmlspecialchars($_POST['full_details'] ?? ($product['full_details'] ?? '')) ?></textarea>
        </div>

        <div class="admin-form-group">
          <label class="admin-label" for="features_raw">Key Feature Highlights (One per line)</label>
          <?php
            $f_val = '';
            if ($product && !empty($product['features_json'])) {
                $f_arr = json_decode($product['features_json'], true);
                if (is_array($f_arr)) $f_val = implode("\n", $f_arr);
            }
          ?>
          <textarea 
            id="features_raw" 
            name="features_raw" 
            class="admin-textarea" 
            placeholder="262 Standard Sizes&#10;0.30mm – 22.22mm&#10;M2 High-Speed Steel&#10;118° Point Angle"
          ><?= htmlspecialchars($_POST['features_raw'] ?? $f_val) ?></textarea>
          <span class="admin-help">These appear as feature pills on the product page and cards.</span>
        </div>

      </div>

      <!-- Card 2: Available Sizes Manager (Step 1 Configurator) -->
      <div class="admin-card">
        <div class="admin-card-header">
          <div>
            <h2 class="admin-card-title">Available Sizes &amp; Diameters</h2>
            <p class="admin-help">Enter the sizes available for this product. These populate Step 1 in the live customer configurator.</p>
          </div>
          <div style="display:flex;gap:8px;">
            <button type="button" class="admin-btn admin-btn-secondary admin-btn-sm" id="btnPresetMetric">
              + Load Metric 1-13mm
            </button>
            <button type="button" class="admin-btn admin-btn-secondary admin-btn-sm" id="btnPresetAllDrills">
              + Load 262 Jobber Sizes
            </button>
          </div>
        </div>

        <div class="admin-form-group">
          <label class="admin-label" for="sizes_raw">Available Sizes (Enter one per line, or comma-separated)</label>
          <textarea 
            id="sizes_raw" 
            name="sizes_raw" 
            class="admin-textarea" 
            style="min-height: 180px; font-family: monospace; font-size: 13px;"
            placeholder="1.00&#10;1.50&#10;2.00&#10;2.50&#10;3.00&#10;3.17 (1/8&quot;)&#10;4.00&#10;5.00&#10;6.00&#10;6.35 (1/4&quot;)&#10;8.00&#10;10.00&#10;12.00&#10;12.70 (1/2&quot;)"
          ><?= htmlspecialchars($_POST['sizes_raw'] ?? $existing_sizes_text) ?></textarea>
          <span class="admin-help">Format: Enter metric diameter (e.g. <code>3.50</code>) or include inch equivalent in brackets (e.g. <code>3.17 (1/8")</code>).</span>
        </div>

        <div class="admin-form-group">
          <label class="admin-label" for="popular_raw">Popular Quick-Select Sizes (Comma-separated)</label>
          <input 
            type="text" 
            id="popular_raw" 
            name="popular_raw" 
            class="admin-input" 
            placeholder="2.00, 3.00, 4.00, 5.00, 6.00, 8.00, 10.00, 12.00" 
            value="<?= htmlspecialchars($_POST['popular_raw'] ?? ($existing_popular_text ?: '2.00, 3.00, 4.00, 5.00, 6.00, 8.00, 10.00, 12.00')) ?>"
          >
          <span class="admin-help">These appear as quick clickable pills right below Step 1's input box.</span>
        </div>

      </div>

    </div>

    <!-- Right Column: Media, Categories, and Publishing -->
    <div>
      
      <!-- Publishing Card -->
      <div class="admin-card">
        <h2 class="admin-card-title" style="margin-bottom:14px;">Publishing Status</h2>

        <div class="admin-form-group">
          <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
            <input type="checkbox" name="is_active" value="1" <?= (!isset($product) || $product['is_active']) ? 'checked' : '' ?> style="width:18px;height:18px;">
            <span style="font-weight:600;font-size:13px;">Publish Product Live</span>
          </label>
        </div>

        <div class="admin-form-group">
          <label class="admin-label" for="sort_order">Display Priority Order</label>
          <input 
            type="number" 
            id="sort_order" 
            name="sort_order" 
            class="admin-input" 
            value="<?= (int)($_POST['sort_order'] ?? ($product['sort_order'] ?? 1)) ?>"
          >
        </div>

        <div style="margin-top:20px;">
          <button type="submit" class="admin-btn admin-btn-primary" style="width:100%;justify-content:center;padding:12px;">
            Save Product &rarr;
          </button>
        </div>
      </div>

      <!-- Category & Classification -->
      <div class="admin-card">
        <h2 class="admin-card-title" style="margin-bottom:14px;">Category Classification</h2>

        <div class="admin-form-group">
          <label class="admin-label" for="category">Category Filter Key</label>
          <select id="category" name="category" class="admin-select">
            <?php
              $cur_cat = $_POST['category'] ?? ($product['category'] ?? 'twist_drills');
            ?>
            <option value="twist_drills" <?= $cur_cat === 'twist_drills' ? 'selected' : '' ?>>HSS Twist Drills (twist_drills)</option>
            <option value="high_performance" <?= $cur_cat === 'high_performance' ? 'selected' : '' ?>>Cobalt &amp; High Performance (high_performance)</option>
            <option value="cutting_tools" <?= $cur_cat === 'cutting_tools' ? 'selected' : '' ?>>Milling &amp; Core Cutters (cutting_tools)</option>
            <option value="power_tools" <?= $cur_cat === 'power_tools' ? 'selected' : '' ?>>Industrial Power Tools (power_tools)</option>
          </select>
        </div>

        <div class="admin-form-group">
          <label class="admin-label" for="category_name">Category Display Label</label>
          <input 
            type="text" 
            id="category_name" 
            name="category_name" 
            class="admin-input" 
            value="<?= htmlspecialchars($_POST['category_name'] ?? ($product['category_name'] ?? 'HSS Twist Drills')) ?>"
          >
        </div>

        <div class="admin-form-group">
          <label class="admin-label" for="badge">Product Badge (Optional)</label>
          <input 
            type="text" 
            id="badge" 
            name="badge" 
            class="admin-input" 
            placeholder="e.g. M35 COBALT, FLAGSHIP, etc." 
            value="<?= htmlspecialchars($_POST['badge'] ?? ($product['badge'] ?? '')) ?>"
          >
        </div>
      </div>

      <!-- Product Media -->
      <div class="admin-card">
        <h2 class="admin-card-title" style="margin-bottom:14px;">Product Photography</h2>

        <div class="admin-form-group">
          <label class="admin-label" for="image">Primary Image</label>
          <input 
            type="file" 
            id="image" 
            name="image" 
            class="admin-input" 
            accept="image/*"
          >
          <?php if ($product && !empty($product['image'])): ?>
            <div class="admin-preview-box">
              <img src="../<?= htmlspecialchars($product['image']) ?>" alt="" class="admin-thumb" onerror="this.src='../assets/images/brand/dagger_brand_logo.png'">
              <div>
                <div style="font-size:11px;font-weight:600;">Current Primary:</div>
                <code style="font-size:10px;"><?= htmlspecialchars($product['image']) ?></code>
              </div>
            </div>
          <?php endif; ?>
        </div>

        <div class="admin-form-group">
          <label class="admin-label" for="gallery_images">Additional Gallery Views (Multiple)</label>
          <input 
            type="file" 
            id="gallery_images" 
            name="gallery_images[]" 
            class="admin-input" 
            accept="image/*" 
            multiple
          >
          <span class="admin-help">Select multiple files to appear in the 5-item gallery thumbnail strip.</span>

          <?php if ($product && !empty($product['gallery_json'])): 
            $g_views = json_decode($product['gallery_json'], true) ?: [];
          ?>
            <?php if (!empty($g_views)): ?>
              <div style="display:flex;gap:6px;flex-wrap:wrap;margin-top:10px;">
                <?php foreach ($g_views as $gv): ?>
                  <img src="../<?= htmlspecialchars($gv) ?>" alt="" style="width:48px;height:48px;object-fit:cover;border-radius:4px;border:1px solid var(--admin-border);" onerror="this.src='../assets/images/brand/dagger_brand_logo.png'">
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
          <?php endif; ?>
        </div>

      </div>

    </div>

  </div>

</form>

<script>
// Quick presets for sizes manager
document.getElementById('btnPresetMetric').addEventListener('click', function() {
  var metricPresets = [
    '1.00', '1.50', '2.00', '2.50', '3.00', '3.17 (1/8")', '3.50', '4.00', '4.50', '5.00',
    '5.50', '6.00', '6.35 (1/4")', '6.80', '7.00', '7.50', '8.00', '8.50', '9.00', '9.52 (3/8")',
    '10.00', '10.50', '11.00', '11.50', '12.00', '12.70 (1/2")', '13.00'
  ];
  document.getElementById('sizes_raw').value = metricPresets.join('\n');
});

document.getElementById('btnPresetAllDrills').addEventListener('click', function() {
  fetch('../api/get_product_data.php?action=all')
    .then(function(res) { return res.json(); })
    .then(function(data) {
      if (data && data.sizes) {
        var lines = data.sizes.map(function(s) {
          var str = s.mm;
          if (s.inch) str += ' (' + s.inch + ')';
          return str;
        });
        document.getElementById('sizes_raw').value = lines.join('\n');
        alert('Loaded ' + lines.length + ' official IS : 5101 Jobber series diameters!');
      }
    })
    .catch(function(err) {
      alert('Could not fetch preset sizes from API.');
    });
});
</script>

<?php require_once __DIR__ . '/footer.php'; ?>
