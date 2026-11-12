<?php
$active_tab = 'products';
$page_title = 'Product Editor — Birla Precision Admin';

require_once __DIR__ . '/header.php';
require_once __DIR__ . '/../includes/upload_helper.php';

$pdo = get_db();
$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$product = null;

$all_size_types = get_all_size_types();
$size_types_lib_map = [];
foreach ($all_size_types as $st) {
    $size_types_lib_map[$st['code']] = $st;
}

// Build initial size type blocks for editor
$editor_size_blocks = [];

if ($product_id > 0) {
    $product = get_product_by_id_or_slug($product_id);
    if ($product) {
        $cfg = get_product_size_config($product);

        // If flagship product has not yet been customized with size_types_json, hydrate full 262 Jobber sizes from JSON so none are lost
        $jobber_override = [];
        if ($product['slug'] === 'parallel-shank-twist-drills' && empty($product['size_types_json'])) {
            $json_path = __DIR__ . '/../jobber_series_data.json';
            if (file_exists($json_path)) {
                $jdata = json_decode(file_get_contents($json_path), true);
                if (is_array($jdata) && !empty($jdata)) {
                    $mm_vals = [];
                    $inch_vals = [];
                    foreach ($jdata as $jrow) {
                        if (!empty($jrow['mm'])) $mm_vals[] = trim((string)$jrow['mm']);
                        if (!empty($jrow['inch'])) {
                            $iv = trim(str_replace("\xef\x82\xab", '', (string)$jrow['inch']));
                            if ($iv !== '' && !in_array($iv, $inch_vals, true)) $inch_vals[] = $iv;
                        }
                    }
                    $jobber_override['mm'] = $mm_vals;
                    $jobber_override['inch'] = $inch_vals;
                }
            }
        }

        foreach ($cfg['size_types'] as $st) {
            $code = $st['code'];
            if (isset($jobber_override[$code])) {
                $vals = $jobber_override[$code];
            } else {
                $vals = array_column($cfg['sizes_by_type'][$code] ?? [], 'val');
            }
            $editor_size_blocks[] = [
                'code' => $code,
                'label' => $st['label'],
                'unit_suffix' => $st['unit_suffix'] ?? '',
                'placeholder' => $st['placeholder'] ?? '',
                'sizes_text' => implode("\n", $vals),
                'popular_text' => implode(', ', $st['popular'] ?? [])
            ];
        }
    }
}

if (empty($editor_size_blocks)) {
    $editor_size_blocks = [
        [
            'code' => 'mm',
            'label' => 'Metric (mm)',
            'unit_suffix' => 'mm',
            'placeholder' => 'Select or type size (e.g. 3.5)',
            'sizes_text' => '',
            'popular_text' => '2.00, 3.00, 4.00, 5.00, 6.00, 8.00, 10.00, 12.00'
        ],
        [
            'code' => 'inch',
            'label' => 'Inch',
            'unit_suffix' => '"',
            'placeholder' => 'Select or type size (e.g. 1/8")',
            'sizes_text' => '',
            'popular_text' => '1/16", 1/8", 3/16", 1/4", 5/16", 3/8", 7/16", 1/2"'
        ]
    ];
}

$error = '';
$message = '';

$all_top_cats = get_categories(0, false);
$all_sub_cats = array_filter(get_categories(null, false), function($c) { return !empty($c['parent_id']); });

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title          = trim($_POST['title'] ?? '');
    $slug           = trim($_POST['slug'] ?? '');
    $category_id    = !empty($_POST['category_id']) ? (int)$_POST['category_id'] : null;
    $subcategory_id = !empty($_POST['subcategory_id']) ? (int)$_POST['subcategory_id'] : null;

    // Lookup Category info to keep backward compatibility columns in sync
    $cat_rec = $category_id ? get_category_by_id_or_slug($category_id) : null;
    $category      = $cat_rec ? $cat_rec['slug'] : trim($_POST['category'] ?? 'twist_drills');
    $category_name = $cat_rec ? $cat_rec['name'] : trim($_POST['category_name'] ?? 'HSS Twist Drills');
    $standard      = trim($_POST['standard'] ?? 'IS : 5101 / ISO 235');
    $hsn_code      = trim($_POST['hsn_code'] ?? '8207');
    $brand         = trim($_POST['brand'] ?? 'Dagger Brand / Birla Precision');
    $badge         = trim($_POST['badge'] ?? '');
    $badge_class   = trim($_POST['badge_class'] ?? 'badge-red');
    $description   = trim($_POST['description'] ?? '');
    $full_details  = trim($_POST['full_details'] ?? '');
    $features_raw  = trim($_POST['features_raw'] ?? '');
    $is_active     = isset($_POST['is_active']) ? 1 : 0;
    $sort_order    = (int)($_POST['sort_order'] ?? 1);

    // Preserve submitted size type blocks in case of validation error
    if (!empty($_POST['size_type_codes']) && is_array($_POST['size_type_codes'])) {
        $editor_size_blocks = [];
        foreach ($_POST['size_type_codes'] as $oc) {
            $oc = trim((string)$oc);
            if ($oc === '') continue;
            $editor_size_blocks[] = [
                'code' => $oc,
                'label' => trim((string)($_POST['size_type_labels'][$oc] ?? $oc)),
                'unit_suffix' => trim((string)($_POST['size_type_suffixes'][$oc] ?? '')),
                'placeholder' => trim((string)($_POST['size_type_placeholders'][$oc] ?? '')),
                'sizes_text' => (string)($_POST['sizes_by_type'][$oc] ?? ''),
                'popular_text' => (string)($_POST['popular_by_type'][$oc] ?? '')
            ];
        }
    }

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

                // Collect submitted Size Types & their sizes
                $submitted_codes        = $_POST['size_type_codes'] ?? [];
                $submitted_labels       = $_POST['size_type_labels'] ?? [];
                $submitted_suffixes     = $_POST['size_type_suffixes'] ?? [];
                $submitted_placeholders = $_POST['size_type_placeholders'] ?? [];
                $submitted_sizes_map    = $_POST['sizes_by_type'] ?? [];
                $submitted_pop_map      = $_POST['popular_by_type'] ?? [];

                $size_types_config = [];
                $sizes_to_insert   = []; // rows of [size_type, size_value, size_mm, size_inch, dg, is_popular]

                foreach ($submitted_codes as $orig_code) {
                    $orig_code = trim((string)$orig_code);
                    if ($orig_code === '') continue;

                    $st_label       = trim((string)($submitted_labels[$orig_code] ?? $orig_code));
                    $st_suffix      = trim((string)($submitted_suffixes[$orig_code] ?? ''));
                    $st_placeholder = trim((string)($submitted_placeholders[$orig_code] ?? ''));

                    // Ensure size type exists in global size_types library (creates custom ones automatically)
                    $st_rec = create_or_get_size_type($st_label, $st_suffix, $st_placeholder, $orig_code);
                    $final_code = $st_rec ? $st_rec['code'] : $orig_code;
                    if ($st_rec && empty($st_placeholder)) {
                        $st_placeholder = $st_rec['placeholder'];
                    }

                    $raw_text = trim((string)($submitted_sizes_map[$orig_code] ?? ''));
                    $pop_raw  = trim((string)($submitted_pop_map[$orig_code] ?? ''));

                    $pop_list = array_values(array_filter(array_map('trim', explode(',', $pop_raw)), function($v) {
                        return $v !== '';
                    }));
                    $pop_lookup = [];
                    foreach ($pop_list as $pv) {
                        $pop_lookup[strtolower($pv)] = true;
                    }

                    $lines = preg_split('/[\r\n,]+/', $raw_text);
                    $type_vals = [];

                    foreach ($lines as $sline) {
                        $sline = trim($sline);
                        if ($sline === '') continue;

                        // Backward-compatible support for "3.17 (1/8")" in Metric (mm) textarea
                        $val = $sline;
                        $mm_col = '';
                        $inch_col = '';
                        $dg_col = '';

                        if ($final_code === 'mm' && preg_match('/^([0-9\.]+)\s*\((.*?)\)$/', $sline, $m)) {
                            $val = trim($m[1]);
                            $inch_col = trim($m[2]);
                            $mm_col = $val;
                        } elseif ($final_code === 'mm') {
                            $mm_col = $val;
                        } elseif ($final_code === 'inch') {
                            $inch_col = $val;
                        } elseif ($final_code === 'dg') {
                            $dg_col = $val;
                        }

                        $is_pop = isset($pop_lookup[strtolower($val)]) || isset($pop_lookup[strtolower($sline)]) ? 1 : 0;
                        $type_vals[] = $val;

                        $sizes_to_insert[] = [
                            'size_type' => $final_code,
                            'size_value' => $val,
                            'size_mm' => $mm_col !== '' ? $mm_col : $val,
                            'size_inch' => $inch_col,
                            'dg' => $dg_col,
                            'is_popular' => $is_pop
                        ];
                    }

                    if (empty($pop_list) && !empty($type_vals)) {
                        $pop_list = array_slice(array_values(array_unique($type_vals)), 0, 8);
                    }

                    // Avoid duplicate size type codes on the same product
                    $already = false;
                    foreach ($size_types_config as $stc) {
                        if ($stc['code'] === $final_code) { $already = true; break; }
                    }
                    if (!$already) {
                        $size_types_config[] = [
                            'code' => $final_code,
                            'label' => $st_label,
                            'unit_suffix' => $st_suffix,
                            'placeholder' => $st_placeholder,
                            'popular' => $pop_list
                        ];
                    }
                }

                $size_types_json = !empty($size_types_config)
                    ? json_encode($size_types_config, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
                    : null;

                if ($product) {
                    // Update product
                    $stmt = $pdo->prepare("
                        UPDATE products 
                        SET slug = ?, title = ?, standard = ?, hsn_code = ?, brand = ?, 
                            category = ?, category_name = ?, category_id = ?, subcategory_id = ?, badge = ?, badge_class = ?, 
                            description = ?, full_details = ?, image = ?, gallery_json = ?, 
                            features_json = ?, size_types_json = ?, is_active = ?, sort_order = ?
                        WHERE id = ?
                    ");
                    $stmt->execute([
                        $slug, $title, $standard, $hsn_code, $brand,
                        $category, $category_name, $category_id, $subcategory_id, $badge, $badge_class,
                        $description, $full_details, $image_path, $gallery_json,
                        $features_json, $size_types_json, $is_active, $sort_order, $product['id']
                    ]);
                    $saved_id = $product['id'];
                } else {
                    // Insert new product
                    $stmt = $pdo->prepare("
                        INSERT INTO products 
                        (slug, title, standard, hsn_code, brand, category, category_name, category_id, subcategory_id, badge, badge_class, description, full_details, image, gallery_json, features_json, size_types_json, is_active, sort_order) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                    ");
                    $stmt->execute([
                        $slug, $title, $standard, $hsn_code, $brand,
                        $category, $category_name, $category_id, $subcategory_id, $badge, $badge_class,
                        $description, $full_details, $image_path, $gallery_json,
                        $features_json, $size_types_json, $is_active, $sort_order
                    ]);
                    $saved_id = (int)$pdo->lastInsertId();
                }

            // Save Sizes
            $pdo->prepare("DELETE FROM product_sizes WHERE product_id = ?")->execute([$saved_id]);

            $size_insert = $pdo->prepare("
                INSERT INTO product_sizes (product_id, size_type, size_value, size_mm, size_inch, dg, is_popular, sort_order) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ");

            $order = 1;
            foreach ($sizes_to_insert as $szRow) {
                $size_insert->execute([
                    $saved_id,
                    $szRow['size_type'],
                    $szRow['size_value'],
                    $szRow['size_mm'],
                    $szRow['size_inch'],
                    $szRow['dg'],
                    $szRow['is_popular'],
                    $order++
                ]);
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

      <!-- Card 2: Size Types & Available Sizes Manager (Step 1 Configurator) -->
      <div class="admin-card">
        <div class="admin-card-header" style="align-items:flex-start;flex-wrap:wrap;gap:12px;">
          <div>
            <h2 class="admin-card-title">Size Types &amp; Available Sizes (ITM Price List Spec)</h2>
            <p class="admin-help">Add one or more size types (Metric mm, Inch, Drill Gauge DG, Morse Taper MT, Thread Pitch, Dimensions, or Custom). Each added size type gets its own textarea and automatically appears in Step 1 ("Add sizes and quantity").</p>
          </div>
          <div style="display:flex;gap:8px;flex-wrap:wrap;">
            <button type="button" class="admin-btn admin-btn-secondary admin-btn-sm" id="btnPresetMetric">
              + Load Metric 1-13mm
            </button>
            <button type="button" class="admin-btn admin-btn-secondary admin-btn-sm" id="btnPresetAllDrills">
              + Load 262 Jobber Sizes
            </button>
          </div>
        </div>

        <!-- Dropdown FIRST: Select or Create a Size Type -->
        <div style="background:#F8FAFC;border:1px solid #E2E8F0;border-radius:8px;padding:14px 16px;margin-bottom:18px;">
          <label class="admin-label" for="addSizeTypeSelect" style="margin-bottom:8px;">Add Type of Size (From ITM Price List PDF or Custom)</label>
          <div style="display:flex;gap:8px;flex-wrap:wrap;align-items:center;">
            <select id="addSizeTypeSelect" class="admin-select" style="flex:1;min-width:220px;">
              <?php foreach ($all_size_types as $st_opt): ?>
                <option 
                  value="<?= htmlspecialchars($st_opt['code']) ?>"
                  data-label="<?= htmlspecialchars($st_opt['label']) ?>"
                  data-suffix="<?= htmlspecialchars($st_opt['unit_suffix'] ?? '') ?>"
                  data-placeholder="<?= htmlspecialchars($st_opt['placeholder'] ?? '') ?>"
                >
                  <?= htmlspecialchars($st_opt['label']) ?><?= !empty($st_opt['unit_suffix']) ? ' [' . htmlspecialchars($st_opt['unit_suffix']) . ']' : '' ?>
                </option>
              <?php endforeach; ?>
            </select>
            <button type="button" class="admin-btn admin-btn-primary admin-btn-sm" id="btnAddSelectedSizeType">
              + Add Size Type to Textarea
            </button>
            <button type="button" class="admin-btn admin-btn-secondary admin-btn-sm" id="btnToggleCustomSizeType">
              + New Custom Type
            </button>
          </div>

          <!-- Inline Custom Size Type Creator -->
          <div id="customSizeTypeBox" style="display:none;margin-top:12px;padding-top:12px;border-top:1px dashed #CBD5E1;">
            <div style="display:grid;grid-template-columns:2fr 1fr 2fr auto;gap:8px;align-items:end;">
              <div>
                <label class="admin-label" for="customTypeName" style="font-size:11.5px;">Custom Size Type Name *</label>
                <input type="text" id="customTypeName" class="admin-input" placeholder="e.g. Bore Size (mm) or Shank Dia">
              </div>
              <div>
                <label class="admin-label" for="customTypeSuffix" style="font-size:11.5px;">Unit Suffix</label>
                <input type="text" id="customTypeSuffix" class="admin-input" placeholder="e.g. mm, MT, TPI">
              </div>
              <div>
                <label class="admin-label" for="customTypePlaceholder" style="font-size:11.5px;">Input Hint / Placeholder</label>
                <input type="text" id="customTypePlaceholder" class="admin-input" placeholder="e.g. Select or type bore size">
              </div>
              <button type="button" class="admin-btn admin-btn-primary admin-btn-sm" id="btnCreateCustomSizeType" style="height:38px;">
                + Add Custom Type
              </button>
            </div>
          </div>
        </div>

        <!-- Per-Size-Type Textarea Blocks -->
        <div id="sizeTypeBlocksContainer" style="display:flex;flex-direction:column;gap:16px;">
          <?php foreach ($editor_size_blocks as $b_idx => $blk): 
            $b_code = $blk['code'];
            $b_label = $blk['label'];
            $b_suffix = $blk['unit_suffix'];
            $b_ph = $blk['placeholder'];
            $b_sizes = $_POST['sizes_by_type'][$b_code] ?? $blk['sizes_text'];
            $b_pop = $_POST['popular_by_type'][$b_code] ?? $blk['popular_text'];
            $has_presets = !empty($size_types_lib_map[$b_code]['presets_text']);
          ?>
            <div class="size-type-editor-block" data-code="<?= htmlspecialchars($b_code) ?>" style="border:1px solid #CBD5E1;border-radius:8px;padding:16px;background:#FFFFFF;">
              <input type="hidden" name="size_type_codes[]" value="<?= htmlspecialchars($b_code) ?>">
              <input type="hidden" name="size_type_labels[<?= htmlspecialchars($b_code) ?>]" value="<?= htmlspecialchars($b_label) ?>">
              <input type="hidden" name="size_type_suffixes[<?= htmlspecialchars($b_code) ?>]" value="<?= htmlspecialchars($b_suffix) ?>">
              <input type="hidden" name="size_type_placeholders[<?= htmlspecialchars($b_code) ?>]" value="<?= htmlspecialchars($b_ph) ?>">

              <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;margin-bottom:12px;padding-bottom:10px;border-bottom:1px solid #F1F5F9;">
                <div style="display:flex;align-items:center;gap:8px;">
                  <span class="size-type-order-badge admin-badge admin-badge-red">#<?= $b_idx + 1 ?></span>
                  <strong style="font-size:14px;color:#0F172A;"><?= htmlspecialchars($b_label) ?></strong>
                  <?php if ($b_suffix !== ''): ?>
                    <span class="admin-badge admin-badge-gray">Unit: <?= htmlspecialchars($b_suffix) ?></span>
                  <?php endif; ?>
                </div>
                <div style="display:flex;gap:6px;align-items:center;">
                  <?php if ($has_presets): ?>
                    <button type="button" class="admin-btn admin-btn-secondary admin-btn-sm btn-load-type-presets" data-code="<?= htmlspecialchars($b_code) ?>">
                      + Load PDF Presets
                    </button>
                  <?php endif; ?>
                  <button type="button" class="admin-btn admin-btn-secondary admin-btn-sm btn-move-type-up" title="Move Up">&uarr;</button>
                  <button type="button" class="admin-btn admin-btn-secondary admin-btn-sm btn-move-type-down" title="Move Down">&darr;</button>
                  <button type="button" class="admin-btn admin-btn-danger admin-btn-sm btn-remove-size-type">Remove</button>
                </div>
              </div>

              <div class="admin-form-group" style="margin-bottom:12px;">
                <label class="admin-label">Available Sizes for <?= htmlspecialchars($b_label) ?> (One per line or comma-separated)</label>
                <textarea 
                  name="sizes_by_type[<?= htmlspecialchars($b_code) ?>]" 
                  class="admin-textarea size-type-textarea" 
                  style="min-height: 140px; font-family: monospace; font-size: 13px;"
                  placeholder="<?= htmlspecialchars($b_ph ?: 'Enter sizes one per line...') ?>"
                ><?= htmlspecialchars($b_sizes) ?></textarea>
              </div>

              <div class="admin-form-group" style="margin-bottom:0;">
                <label class="admin-label">Popular Quick-Select Pills for <?= htmlspecialchars($b_label) ?> (Comma-separated)</label>
                <input 
                  type="text" 
                  name="popular_by_type[<?= htmlspecialchars($b_code) ?>]" 
                  class="admin-input size-type-popular" 
                  placeholder="Optional comma-separated quick sizes (auto-selects first 8 if empty)"
                  value="<?= htmlspecialchars($b_pop) ?>"
                >
              </div>
            </div>
          <?php endforeach; ?>
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
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;">
          <h2 class="admin-card-title" style="margin:0;">Category Classification</h2>
          <a href="category_edit.php" target="_blank" style="font-size:12px;color:var(--admin-primary);text-decoration:none;font-weight:600;">+ New Category</a>
        </div>

        <?php
          $cur_cat_id = (int)($_POST['category_id'] ?? ($product['category_id'] ?? 0));
          $cur_sub_id = (int)($_POST['subcategory_id'] ?? ($product['subcategory_id'] ?? 0));
          $cur_cat_slug = $_POST['category'] ?? ($product['category'] ?? '');
        ?>

        <div class="admin-form-group">
          <label class="admin-label" for="category_id">Main Category *</label>
          <select id="category_id" name="category_id" class="admin-select" onchange="filterSubcategoryOptions(this.value)">
            <option value="">-- Select Main Category --</option>
            <?php foreach ($all_top_cats as $tc): ?>
              <?php 
                $is_sel = ($cur_cat_id === (int)$tc['id']) || (empty($cur_cat_id) && $cur_cat_slug === $tc['slug']);
              ?>
              <option value="<?= $tc['id'] ?>" <?= $is_sel ? 'selected' : '' ?>>
                <?= htmlspecialchars($tc['name']) ?> (<?= htmlspecialchars($tc['slug']) ?>)
              </option>
            <?php endforeach; ?>
          </select>
          <span class="admin-help">Main categories appear in column 1 ("Listed Categories") of the mega dropdown.</span>
        </div>

        <div class="admin-form-group">
          <label class="admin-label" for="subcategory_id">Subcategory (Optional)</label>
          <select id="subcategory_id" name="subcategory_id" class="admin-select">
            <option value="">-- None (Direct Main Category Product) --</option>
            <?php foreach ($all_sub_cats as $sc): ?>
              <option 
                value="<?= $sc['id'] ?>" 
                data-parent="<?= $sc['parent_id'] ?>" 
                <?= ($cur_sub_id === (int)$sc['id']) ? 'selected' : '' ?>
              >
                <?= htmlspecialchars($sc['name']) ?>
              </option>
            <?php endforeach; ?>
          </select>
          <span class="admin-help">If chosen, this product is grouped under this subcategory in column 2 of the mega dropdown.</span>
        </div>

        <script>
        function filterSubcategoryOptions(selectedParentId) {
          var subSelect = document.getElementById('subcategory_id');
          if (!subSelect) return;
          var opts = subSelect.querySelectorAll('option[data-parent]');
          opts.forEach(function(opt) {
            var pId = opt.getAttribute('data-parent');
            if (!selectedParentId || pId === selectedParentId) {
              opt.style.display = '';
            } else {
              opt.style.display = 'none';
              if (opt.selected) {
                subSelect.value = '';
              }
            }
          });
        }
        document.addEventListener('DOMContentLoaded', function() {
          var mainCat = document.getElementById('category_id');
          if (mainCat && mainCat.value) {
            filterSubcategoryOptions(mainCat.value);
          }
        });
        </script>

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
(function() {
  var sizeTypesLib = <?= json_encode($size_types_lib_map, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>;
  var container = document.getElementById('sizeTypeBlocksContainer');
  var addSelect = document.getElementById('addSizeTypeSelect');
  var btnAddSelected = document.getElementById('btnAddSelectedSizeType');
  var btnToggleCustom = document.getElementById('btnToggleCustomSizeType');
  var customBox = document.getElementById('customSizeTypeBox');
  var btnCreateCustom = document.getElementById('btnCreateCustomSizeType');

  function escHtml(s) {
    return String(s || '')
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;');
  }

  function refreshOrderBadges() {
    if (!container) return;
    var blocks = container.querySelectorAll('.size-type-editor-block');
    blocks.forEach(function(blk, idx) {
      var badge = blk.querySelector('.size-type-order-badge');
      if (badge) badge.textContent = '#' + (idx + 1);
    });
  }

  function wireBlock(blk) {
    var code = blk.getAttribute('data-code');
    var btnPreset = blk.querySelector('.btn-load-type-presets');
    var btnUp = blk.querySelector('.btn-move-type-up');
    var btnDown = blk.querySelector('.btn-move-type-down');
    var btnRemove = blk.querySelector('.btn-remove-size-type');
    var ta = blk.querySelector('.size-type-textarea');

    if (btnPreset) {
      btnPreset.addEventListener('click', function() {
        var meta = sizeTypesLib[code];
        if (meta && meta.presets_text && ta) {
          ta.value = meta.presets_text;
        }
      });
    }
    if (btnUp) {
      btnUp.addEventListener('click', function() {
        var prev = blk.previousElementSibling;
        if (prev) {
          container.insertBefore(blk, prev);
          refreshOrderBadges();
        }
      });
    }
    if (btnDown) {
      btnDown.addEventListener('click', function() {
        var next = blk.nextElementSibling;
        if (next) {
          container.insertBefore(next, blk);
          refreshOrderBadges();
        }
      });
    }
    if (btnRemove) {
      btnRemove.addEventListener('click', function() {
        if (container.querySelectorAll('.size-type-editor-block').length <= 1) {
          alert('At least one size type block is required.');
          return;
        }
        blk.remove();
        refreshOrderBadges();
      });
    }
  }

  function addOrFocusSizeTypeBlock(code, label, suffix, placeholder, initialSizes) {
    if (!container) return;
    var existing = container.querySelector('.size-type-editor-block[data-code="' + code.replace(/"/g, '\\"') + '"]');
    if (existing) {
      var existingTa = existing.querySelector('.size-type-textarea');
      if (existingTa) existingTa.focus();
      existing.scrollIntoView({ behavior: 'smooth', block: 'center' });
      return existing;
    }

    var meta = sizeTypesLib[code] || {};
    var hasPresets = Boolean(meta.presets_text);
    var div = document.createElement('div');
    div.className = 'size-type-editor-block';
    div.setAttribute('data-code', code);
    div.style.cssText = 'border:1px solid #CBD5E1;border-radius:8px;padding:16px;background:#FFFFFF;';
    div.innerHTML =
      '<input type="hidden" name="size_type_codes[]" value="' + escHtml(code) + '">' +
      '<input type="hidden" name="size_type_labels[' + escHtml(code) + ']" value="' + escHtml(label) + '">' +
      '<input type="hidden" name="size_type_suffixes[' + escHtml(code) + ']" value="' + escHtml(suffix) + '">' +
      '<input type="hidden" name="size_type_placeholders[' + escHtml(code) + ']" value="' + escHtml(placeholder) + '">' +
      '<div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;margin-bottom:12px;padding-bottom:10px;border-bottom:1px solid #F1F5F9;">' +
        '<div style="display:flex;align-items:center;gap:8px;">' +
          '<span class="size-type-order-badge admin-badge admin-badge-red">#</span>' +
          '<strong style="font-size:14px;color:#0F172A;">' + escHtml(label) + '</strong>' +
          (suffix ? '<span class="admin-badge admin-badge-gray">Unit: ' + escHtml(suffix) + '</span>' : '') +
        '</div>' +
        '<div style="display:flex;gap:6px;align-items:center;">' +
          (hasPresets ? '<button type="button" class="admin-btn admin-btn-secondary admin-btn-sm btn-load-type-presets" data-code="' + escHtml(code) + '">+ Load PDF Presets</button>' : '') +
          '<button type="button" class="admin-btn admin-btn-secondary admin-btn-sm btn-move-type-up" title="Move Up">&uarr;</button>' +
          '<button type="button" class="admin-btn admin-btn-secondary admin-btn-sm btn-move-type-down" title="Move Down">&darr;</button>' +
          '<button type="button" class="admin-btn admin-btn-danger admin-btn-sm btn-remove-size-type">Remove</button>' +
        '</div>' +
      '</div>' +
      '<div class="admin-form-group" style="margin-bottom:12px;">' +
        '<label class="admin-label">Available Sizes for ' + escHtml(label) + ' (One per line or comma-separated)</label>' +
        '<textarea name="sizes_by_type[' + escHtml(code) + ']" class="admin-textarea size-type-textarea" style="min-height: 140px; font-family: monospace; font-size: 13px;" placeholder="' + escHtml(placeholder || 'Enter sizes one per line...') + '">' + escHtml(initialSizes || (meta.presets_text || '')) + '</textarea>' +
      '</div>' +
      '<div class="admin-form-group" style="margin-bottom:0;">' +
        '<label class="admin-label">Popular Quick-Select Pills for ' + escHtml(label) + ' (Comma-separated)</label>' +
        '<input type="text" name="popular_by_type[' + escHtml(code) + ']" class="admin-input size-type-popular" placeholder="Optional comma-separated quick sizes (auto-selects first 8 if empty)" value="">' +
      '</div>';

    container.appendChild(div);
    wireBlock(div);
    refreshOrderBadges();
    var newTa = div.querySelector('.size-type-textarea');
    if (newTa) newTa.focus();
    return div;
  }

  if (container) {
    container.querySelectorAll('.size-type-editor-block').forEach(wireBlock);
    refreshOrderBadges();
  }

  if (btnAddSelected && addSelect) {
    btnAddSelected.addEventListener('click', function() {
      var opt = addSelect.options[addSelect.selectedIndex];
      if (!opt) return;
      var code = opt.value;
      var label = opt.getAttribute('data-label') || opt.textContent;
      var suffix = opt.getAttribute('data-suffix') || '';
      var placeholder = opt.getAttribute('data-placeholder') || '';
      addOrFocusSizeTypeBlock(code, label, suffix, placeholder);
    });
  }

  if (btnToggleCustom && customBox) {
    btnToggleCustom.addEventListener('click', function() {
      customBox.style.display = (customBox.style.display === 'none') ? 'block' : 'none';
    });
  }

  if (btnCreateCustom) {
    btnCreateCustom.addEventListener('click', function() {
      var nameInp = document.getElementById('customTypeName');
      var sufInp = document.getElementById('customTypeSuffix');
      var phInp = document.getElementById('customTypePlaceholder');
      var label = nameInp ? nameInp.value.trim() : '';
      if (!label) {
        alert('Please enter a Custom Size Type Name (e.g. Bore Size, Morse Taper).');
        if (nameInp) nameInp.focus();
        return;
      }
      var suffix = sufInp ? sufInp.value.trim() : '';
      var placeholder = phInp ? phInp.value.trim() : ('Select or type ' + label);
      var code = label.toLowerCase().replace(/[^a-z0-9]+/g, '_').replace(/^_+|_+$/g, '');
      if (!code) code = 'custom_' + Date.now();

      // Add to dropdown select too so it's visible
      if (addSelect && !addSelect.querySelector('option[value="' + code + '"]')) {
        var newOpt = document.createElement('option');
        newOpt.value = code;
        newOpt.setAttribute('data-label', label);
        newOpt.setAttribute('data-suffix', suffix);
        newOpt.setAttribute('data-placeholder', placeholder);
        newOpt.textContent = label + (suffix ? ' [' + suffix + ']' : '');
        addSelect.appendChild(newOpt);
        addSelect.value = code;
      }

      addOrFocusSizeTypeBlock(code, label, suffix, placeholder, '');
      if (nameInp) nameInp.value = '';
      if (sufInp) sufInp.value = '';
      if (phInp) phInp.value = '';
      if (customBox) customBox.style.display = 'none';
    });
  }

  // Quick presets for Metric 1-13mm and 262 Jobber Sizes
  var btnMetric = document.getElementById('btnPresetMetric');
  if (btnMetric) {
    btnMetric.addEventListener('click', function() {
      var mmBlk = addOrFocusSizeTypeBlock('mm', 'Metric (mm)', 'mm', 'Select or type size (e.g. 3.5)', '');
      var ta = mmBlk.querySelector('.size-type-textarea');
      var metricPresets = [
        '1.00', '1.50', '2.00', '2.50', '3.00', '3.17', '3.50', '4.00', '4.50', '5.00',
        '5.50', '6.00', '6.35', '6.80', '7.00', '7.50', '8.00', '8.50', '9.00', '9.52',
        '10.00', '10.50', '11.00', '11.50', '12.00', '12.70', '13.00'
      ];
      if (ta) ta.value = metricPresets.join('\n');
    });
  }

  var btnAllDrills = document.getElementById('btnPresetAllDrills');
  if (btnAllDrills) {
    btnAllDrills.addEventListener('click', function() {
      fetch('../api/get_product_data.php?action=all')
        .then(function(res) { return res.json(); })
        .then(function(data) {
          if (data && data.sizes) {
            var mmVals = [], inchVals = [], dgVals = [];
            data.sizes.forEach(function(s) {
              if (s.mm && mmVals.indexOf(s.mm) === -1) mmVals.push(s.mm);
              if (s.inch) {
                var iv = String(s.inch).replace(/\uf0ab/g, '').trim();
                if (iv && inchVals.indexOf(iv) === -1) inchVals.push(iv);
              }
              if (s.dg) {
                var dv = String(s.dg).replace(/\uf0ab/g, '').trim();
                if (dv && dgVals.indexOf(dv) === -1) dgVals.push(dv);
              }
            });
            var mmBlk = addOrFocusSizeTypeBlock('mm', 'Metric (mm)', 'mm', 'Select or type size (e.g. 3.5)', '');
            if (mmBlk) mmBlk.querySelector('.size-type-textarea').value = mmVals.join('\n');
            if (inchVals.length > 0) {
              var inBlk = addOrFocusSizeTypeBlock('inch', 'Inch', '"', 'Select or type size (e.g. 1/8")', '');
              if (inBlk) inBlk.querySelector('.size-type-textarea').value = inchVals.join('\n');
            }
            if (dgVals.length > 0) {
              var dgBlk = addOrFocusSizeTypeBlock('dg', 'Drill Gauge (DG / No.)', 'DG', 'Select or type gauge (e.g. 60, A)', '');
              if (dgBlk) dgBlk.querySelector('.size-type-textarea').value = dgVals.join('\n');
            }
            alert('Loaded ' + mmVals.length + ' Metric, ' + inchVals.length + ' Inch, and ' + dgVals.length + ' Drill Gauge sizes from ITM 2026 Price List!');
          }
        })
        .catch(function() {
          alert('Could not fetch preset sizes from API.');
        });
    });
  }
})();
</script>

<?php require_once __DIR__ . '/footer.php'; ?>
