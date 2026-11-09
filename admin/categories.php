<?php
$active_tab = 'categories';
$page_title = 'Categories & Subcategories Manager — Birla Precision Admin';

require_once __DIR__ . '/header.php';

$pdo = get_db();

$message = $_GET['msg'] ?? '';
$error = $_GET['err'] ?? '';

// Handle Delete
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $del_id = (int)$_GET['id'];
    if ($del_id > 0) {
        // Fetch category to know if it's parent
        $cat = get_category_by_id_or_slug($del_id);
        if ($cat) {
            // Unlink products
            $pdo->prepare("UPDATE products SET category_id = NULL WHERE category_id = ?")->execute([$del_id]);
            $pdo->prepare("UPDATE products SET subcategory_id = NULL WHERE subcategory_id = ?")->execute([$del_id]);

            // If it's a parent category, also unlink or delete subcategories
            $sub_ids = $pdo->prepare("SELECT id FROM categories WHERE parent_id = ?");
            $sub_ids->execute([$del_id]);
            $child_ids = $sub_ids->fetchAll(PDO::FETCH_COLUMN);

            foreach ($child_ids as $cid) {
                $pdo->prepare("UPDATE products SET subcategory_id = NULL WHERE subcategory_id = ?")->execute([$cid]);
                $pdo->prepare("DELETE FROM categories WHERE id = ?")->execute([$cid]);
            }

            // Delete the category itself
            $pdo->prepare("DELETE FROM categories WHERE id = ?")->execute([$del_id]);

            header("Location: categories.php?msg=" . urlencode('Category and any child subcategories deleted successfully.'));
            exit;
        }
    }
}

// Fetch categories tree
$categories_tree = get_categories_tree(false); // include inactive for admin
$all_categories = get_categories(null, false);
$top_count = count(array_filter($all_categories, function($c) { return empty($c['parent_id']); }));
$sub_count = count($all_categories) - $top_count;
?>

<div class="admin-page-header">
  <div>
    <h1 class="admin-page-title">Categories &amp; Subcategories Manager</h1>
    <p class="admin-page-subtitle">Organize and manage catalog categories and subcategories. Changes instantly update the storefront navigation and mega dropdown.</p>
  </div>
  <div style="display:flex;gap:10px;">
    <a href="category_edit.php" class="admin-btn admin-btn-primary">
      <span>+ Add New Category</span>
    </a>
  </div>
</div>

<?php if ($message): ?>
  <div class="admin-alert admin-alert-success">
    <span><?= htmlspecialchars($message) ?></span>
  </div>
<?php endif; ?>

<?php if ($error): ?>
  <div class="admin-alert admin-alert-error">
    <span><?= htmlspecialchars($error) ?></span>
  </div>
<?php endif; ?>

<!-- Stats Strip -->
<div class="admin-stats-grid" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); margin-bottom: 24px;">
  <div class="admin-stat-card">
    <div class="admin-stat-icon" style="background:#E0E7FF;color:#4338CA;">📁</div>
    <div>
      <div class="admin-stat-val"><?= $top_count ?></div>
      <div class="admin-stat-label">Main Categories</div>
    </div>
  </div>

  <div class="admin-stat-card">
    <div class="admin-stat-icon" style="background:#FEF3C7;color:#D97706;">📂</div>
    <div>
      <div class="admin-stat-val"><?= $sub_count ?></div>
      <div class="admin-stat-label">Subcategories</div>
    </div>
  </div>

  <div class="admin-stat-card">
    <div class="admin-stat-icon" style="background:#DEF7EC;color:#03543F;">📦</div>
    <div>
      <div class="admin-stat-val"><?= count($all_categories) ?></div>
      <div class="admin-stat-label">Total Taxonomy Groups</div>
    </div>
  </div>
</div>

<div class="admin-card">
  <div class="admin-card-header">
    <div>
      <h2 class="admin-card-title">All Categories Hierarchy</h2>
      <p class="admin-help">Main categories appear in the storefront mega menu's "Listed Categories" column. Subcategories and products appear in column 2.</p>
    </div>
    <div>
      <a href="category_edit.php" class="admin-btn admin-btn-secondary admin-btn-sm">+ Add Category</a>
    </div>
  </div>

  <div class="admin-table-wrapper">
    <table class="admin-table">
      <thead>
        <tr>
          <th style="width: 50px;">#</th>
          <th>Category / Subcategory Name</th>
          <th style="width: 140px;">Classification</th>
          <th style="width: 120px;">Products</th>
          <th style="width: 90px;">Sort Order</th>
          <th style="width: 90px;">Status</th>
          <th style="width: 230px; text-align:right;">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($categories_tree)): ?>
          <tr>
            <td colspan="7" style="text-align:center;padding:30px;color:var(--admin-gray-500);">
              No categories configured yet. Click "+ Add New Category" to create your first category.
            </td>
          </tr>
        <?php else: ?>
          <?php foreach ($categories_tree as $t_idx => $top): ?>
            <!-- Main Parent Category Row -->
            <tr style="background:#F9FAFB;border-top:2px solid #E5E7EB;">
              <td><strong><?= $t_idx + 1 ?></strong></td>
              <td>
                <div style="display:flex;align-items:center;gap:10px;">
                  <?php if (!empty($top['image'])): ?>
                    <img src="../<?= htmlspecialchars($top['image']) ?>" alt="" style="width:36px;height:36px;object-fit:cover;border-radius:6px;border:1px solid #E5E7EB;">
                  <?php else: ?>
                    <div style="width:36px;height:36px;border-radius:6px;background:#E0E7FF;color:#4338CA;display:flex;align-items:center;justify-content:center;font-size:18px;">📁</div>
                  <?php endif; ?>
                  <div>
                    <strong style="font-size:14.5px;color:var(--admin-gray-900);"><?= htmlspecialchars($top['name']) ?></strong>
                    <div style="font-size:12px;color:var(--admin-gray-500);margin-top:2px;">
                      Slug: <code style="background:#EDF2F7;padding:1px 5px;border-radius:4px;"><?= htmlspecialchars($top['slug']) ?></code>
                      <?php if (!empty($top['description'])): ?>
                        &bull; <?= htmlspecialchars(mb_strimwidth($top['description'], 0, 50, '...')) ?>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
              </td>
              <td>
                <span class="admin-badge admin-badge-gray" style="font-weight:700;">Main Category</span>
              </td>
              <td>
                <span class="admin-badge admin-badge-red"><?= count($top['all_products']) ?> products</span>
                <?php if (!empty($top['subcategories'])): ?>
                  <span class="admin-badge admin-badge-gray" style="margin-left:4px;"><?= count($top['subcategories']) ?> sub</span>
                <?php endif; ?>
              </td>
              <td><?= (int)$top['sort_order'] ?></td>
              <td>
                <span class="admin-badge <?= $top['is_active'] ? 'admin-badge-active' : 'admin-badge-gray' ?>">
                  <?= $top['is_active'] ? 'Published' : 'Draft' ?>
                </span>
              </td>
              <td style="text-align:right;">
                <a href="category_edit.php?parent_id=<?= $top['id'] ?>" class="admin-btn admin-btn-secondary admin-btn-sm" title="Add a subcategory directly under this category">+ Subcategory</a>
                <a href="category_edit.php?id=<?= $top['id'] ?>" class="admin-btn admin-btn-secondary admin-btn-sm">Edit</a>
                <a href="categories.php?action=delete&id=<?= $top['id'] ?>" class="admin-btn admin-btn-danger admin-btn-sm" onclick="return confirm('Are you sure? Deleting this category will also remove its subcategories and unlink assigned products.');">Delete</a>
              </td>
            </tr>

            <!-- Subcategory Nested Rows -->
            <?php if (!empty($top['subcategories'])): ?>
              <?php foreach ($top['subcategories'] as $s_idx => $sub): ?>
                <tr>
                  <td></td>
                  <td style="padding-left:44px;">
                    <div style="display:flex;align-items:center;gap:8px;">
                      <span style="color:#94A3B8;font-weight:600;">└─</span>
                      <?php if (!empty($sub['image'])): ?>
                        <img src="../<?= htmlspecialchars($sub['image']) ?>" alt="" style="width:28px;height:28px;object-fit:cover;border-radius:4px;border:1px solid #E5E7EB;">
                      <?php else: ?>
                        <div style="width:28px;height:28px;border-radius:4px;background:#FEF3C7;color:#D97706;display:flex;align-items:center;justify-content:center;font-size:14px;">📂</div>
                      <?php endif; ?>
                      <div>
                        <span style="font-size:13.5px;font-weight:600;color:var(--admin-gray-800);"><?= htmlspecialchars($sub['name']) ?></span>
                        <div style="font-size:11.5px;color:var(--admin-gray-500);">
                          Slug: <code style="background:#F1F5F9;padding:1px 4px;border-radius:3px;"><?= htmlspecialchars($sub['slug']) ?></code>
                        </div>
                      </div>
                    </div>
                  </td>
                  <td>
                    <span class="admin-badge" style="background:#EEF2FF;color:#4338CA;">Subcategory</span>
                  </td>
                  <td>
                    <span class="admin-badge admin-badge-gray"><?= count($sub['products'] ?? []) ?> products</span>
                  </td>
                  <td><?= (int)$sub['sort_order'] ?></td>
                  <td>
                    <span class="admin-badge <?= $sub['is_active'] ? 'admin-badge-active' : 'admin-badge-gray' ?>">
                      <?= $sub['is_active'] ? 'Published' : 'Draft' ?>
                    </span>
                  </td>
                  <td style="text-align:right;">
                    <a href="category_edit.php?id=<?= $sub['id'] ?>" class="admin-btn admin-btn-secondary admin-btn-sm">Edit</a>
                    <a href="categories.php?action=delete&id=<?= $sub['id'] ?>" class="admin-btn admin-btn-danger admin-btn-sm" onclick="return confirm('Delete this subcategory? Assigned products will be unlinked.');">Delete</a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>

          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
