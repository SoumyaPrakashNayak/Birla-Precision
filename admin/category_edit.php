<?php
$active_tab = 'categories';
$page_title = 'Category Editor — Birla Precision Admin';

require_once __DIR__ . '/header.php';
require_once __DIR__ . '/../includes/upload_helper.php';

$pdo = get_db();
$category_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$preset_parent_id = isset($_GET['parent_id']) ? (int)$_GET['parent_id'] : 0;
$category = null;

if ($category_id > 0) {
    $category = get_category_by_id_or_slug($category_id);
}

// Fetch all available top-level categories for the parent dropdown
$top_categories = $pdo->query("
    SELECT * FROM categories 
    WHERE (parent_id IS NULL OR parent_id = 0) 
    ORDER BY sort_order ASC, name ASC
")->fetchAll();

$error = '';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name        = trim($_POST['name'] ?? '');
    $slug        = trim($_POST['slug'] ?? '');
    $parent_id   = !empty($_POST['parent_id']) ? (int)$_POST['parent_id'] : null;
    $description = trim($_POST['description'] ?? '');
    $image_path  = trim($_POST['image_url'] ?? ($category['image'] ?? ''));
    $sort_order  = (int)($_POST['sort_order'] ?? 1);
    $is_active   = isset($_POST['is_active']) ? 1 : 0;

    // Validate
    if (empty($name)) {
        $error = 'Category Name is required.';
    }

    // Auto-generate slug if blank
    if (empty($slug) && !empty($name)) {
        $slug = preg_replace('/[^a-z0-9]+/', '-', strtolower($name));
        $slug = trim($slug, '-');
    }

    // Category cannot be its own parent
    if ($category_id > 0 && $parent_id === $category_id) {
        $error = 'A category cannot have itself as its parent.';
    }

    // Slug uniqueness check
    if (!$error) {
        $chk_slug = $pdo->prepare("SELECT id FROM categories WHERE slug = ? AND id != ?");
        $chk_slug->execute([$slug, $category_id]);
        if ($chk_slug->fetch()) {
            $error = 'The URL slug "' . htmlspecialchars($slug) . '" is already in use by another category. Please enter a unique slug.';
        }
    }

    // Handle image upload if provided
    if (!$error && !empty($_FILES['image_file']['name'])) {
        $upload_res = handle_image_upload($_FILES['image_file'], 'collections');
        if ($upload_res['success']) {
            $image_path = $upload_res['file_path'];
        } else {
            $error = 'Image upload error: ' . $upload_res['error'];
        }
    }

    if (!$error) {
        try {
            if ($category) {
                // Update
                $stmt = $pdo->prepare("
                    UPDATE categories 
                    SET parent_id = ?, name = ?, slug = ?, description = ?, image = ?, sort_order = ?, is_active = ?
                    WHERE id = ?
                ");
                $stmt->execute([$parent_id, $name, $slug, $description, $image_path, $sort_order, $is_active, $category_id]);

                // Sync category_name on products if this is a top category or subcategory
                if (empty($parent_id)) {
                    $pdo->prepare("UPDATE products SET category_name = ?, category = ? WHERE category_id = ?")->execute([$name, $slug, $category_id]);
                }
            } else {
                // Insert
                $stmt = $pdo->prepare("
                    INSERT INTO categories (parent_id, name, slug, description, image, sort_order, is_active)
                    VALUES (?, ?, ?, ?, ?, ?, ?)
                ");
                $stmt->execute([$parent_id, $name, $slug, $description, $image_path, $sort_order, $is_active]);
            }

            header("Location: categories.php?msg=" . urlencode($category ? 'Category updated successfully' : 'Category created successfully'));
            exit;
        } catch (PDOException $e) {
            $error = 'Database save error: ' . $e->getMessage();
        }
    }
}
?>

<div class="admin-page-header">
  <div>
    <h1 class="admin-page-title"><?= $category ? 'Edit Category' : 'Add New Category' ?></h1>
    <p class="admin-page-subtitle">Configure category taxonomy, hierarchy (main or subcategory), and mega menu visual imagery.</p>
  </div>
  <div>
    <a href="categories.php" class="admin-btn admin-btn-secondary">
      &larr; Back to Categories List
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

    <!-- Left Column: Primary Details -->
    <div>
      <div class="admin-card">
        <h2 class="admin-card-title" style="margin-bottom:16px;">Category Specification</h2>

        <div class="admin-form-group">
          <label class="admin-label" for="name">Category Name *</label>
          <input 
            type="text" 
            id="name" 
            name="name" 
            class="admin-input" 
            required 
            placeholder="e.g. HSS Twist Drills, Cobalt Drills, or Parallel Shank Series" 
            value="<?= htmlspecialchars($_POST['name'] ?? ($category['name'] ?? '')) ?>"
          >
          <span class="admin-help">This is displayed in the navigation menu, dropdowns, and category listings.</span>
        </div>

        <div class="admin-form-grid">
          <div class="admin-form-group">
            <label class="admin-label" for="slug">URL / Identifier Slug</label>
            <input 
              type="text" 
              id="slug" 
              name="slug" 
              class="admin-input" 
              placeholder="e.g. twist_drills (auto-generated from name if left empty)" 
              value="<?= htmlspecialchars($_POST['slug'] ?? ($category['slug'] ?? '')) ?>"
            >
          </div>

          <div class="admin-form-group">
            <label class="admin-label" for="parent_id">Category Hierarchy (Parent)</label>
            <select id="parent_id" name="parent_id" class="admin-select">
              <option value="">None — Top-Level Main Category</option>
              <?php 
                $selected_parent = $_POST['parent_id'] ?? ($category['parent_id'] ?? $preset_parent_id);
                foreach ($top_categories as $top): 
                  if ($category && $top['id'] == $category['id']) continue; // Cannot be its own parent
              ?>
                <option value="<?= $top['id'] ?>" <?= ($selected_parent == $top['id']) ? 'selected' : '' ?>>
                  ↳ Subcategory of: <?= htmlspecialchars($top['name']) ?>
                </option>
              <?php endforeach; ?>
            </select>
            <span class="admin-help">Choose "None" to show in column 1 of mega dropdown, or select a parent to make it a subcategory.</span>
          </div>
        </div>

        <div class="admin-form-group">
          <label class="admin-label" for="description">Description (Optional)</label>
          <textarea 
            id="description" 
            name="description" 
            class="admin-textarea" 
            placeholder="Brief engineering summary or industrial standard overview for this category..."
          ><?= htmlspecialchars($_POST['description'] ?? ($category['description'] ?? '')) ?></textarea>
        </div>

      </div>

      <!-- Mega Menu Visual Banner Card -->
      <div class="admin-card">
        <h2 class="admin-card-title" style="margin-bottom:14px;">Mega Dropdown Visual Card (Column 3)</h2>
        <p class="admin-help" style="margin-bottom:16px;">
          When this category is hovered in the storefront header mega menu, column 3 can display this featured promotional image.
        </p>

        <?php 
          $curr_img = $_POST['image_url'] ?? ($category['image'] ?? '');
          if (!empty($curr_img)):
        ?>
          <div style="margin-bottom:16px;display:flex;align-items:center;gap:16px;background:#F8FAFC;padding:12px;border-radius:8px;border:1px solid #E2E8F0;">
            <img src="../<?= htmlspecialchars($curr_img) ?>" alt="Category Preview" style="max-height:80px;border-radius:6px;object-fit:cover;border:1px solid #CBD5E1;">
            <div>
              <div style="font-size:13px;font-weight:600;color:#1E293B;">Active Card Image</div>
              <div style="font-size:12px;color:#64748B;word-break:break-all;"><?= htmlspecialchars($curr_img) ?></div>
            </div>
          </div>
        <?php endif; ?>

        <div class="admin-form-group">
          <label class="admin-label" for="image_file">Upload New Visual Banner Image</label>
          <input type="file" id="image_file" name="image_file" class="admin-input" accept="image/*">
        </div>

        <div class="admin-form-group">
          <label class="admin-label" for="image_url">Or Image File Path</label>
          <input 
            type="text" 
            id="image_url" 
            name="image_url" 
            class="admin-input" 
            placeholder="e.g. assets/images/products/mega_menu_featured_card.png" 
            value="<?= htmlspecialchars($curr_img) ?>"
          >
        </div>

      </div>

    </div>

    <!-- Right Column: Status & Display Order -->
    <div>
      <div class="admin-card">
        <h2 class="admin-card-title" style="margin-bottom:14px;">Publishing &amp; Priority</h2>

        <div class="admin-form-group">
          <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
            <input type="checkbox" name="is_active" value="1" <?= (!isset($category) || $category['is_active']) ? 'checked' : '' ?> style="width:18px;height:18px;">
            <span style="font-weight:600;font-size:13.5px;">Active &amp; Visible on Live Storefront</span>
          </label>
          <span class="admin-help">Inactive categories and their subcategories are hidden from the live dropdown menu.</span>
        </div>

        <div class="admin-form-group">
          <label class="admin-label" for="sort_order">Display Priority / Sort Order</label>
          <input 
            type="number" 
            id="sort_order" 
            name="sort_order" 
            class="admin-input" 
            value="<?= (int)($_POST['sort_order'] ?? ($category['sort_order'] ?? 1)) ?>"
          >
          <span class="admin-help">Lower numbers appear first (e.g. 1, 2, 3...).</span>
        </div>

        <div style="margin-top:24px;">
          <button type="submit" class="admin-btn admin-btn-primary" style="width:100%;justify-content:center;padding:12px;">
            Save Category &rarr;
          </button>
        </div>
      </div>

      <div class="admin-card" style="background:#F8FAFC;">
        <h3 style="font-size:14px;font-weight:700;margin-bottom:8px;color:#1E293B;">Quick Guide</h3>
        <ul style="font-size:12.5px;color:#64748B;line-height:1.6;margin:0;padding-left:18px;">
          <li><strong>Main Categories</strong> appear in the left column (Column 1) of the header mega menu.</li>
          <li><strong>Subcategories</strong> appear in the middle column (Column 2) under their parent.</li>
          <li>Assign products to either a Main Category or a specific Subcategory in the <strong>Products Space</strong> editor.</li>
        </ul>
      </div>

    </div>

  </div>

</form>

<?php require_once __DIR__ . '/footer.php'; ?>
