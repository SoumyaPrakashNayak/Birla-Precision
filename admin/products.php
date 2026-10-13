<?php
$active_tab = 'products';
$page_title = 'Products Space Manager — Birla Precision Admin';

require_once __DIR__ . '/header.php';

$pdo = get_db();

$message = $_GET['msg'] ?? '';
$error = $_GET['err'] ?? '';

// Handle Delete
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $del_id = (int)$_GET['id'];
    if ($del_id > 0) {
        // Delete sizes first
        $pdo->prepare("DELETE FROM product_sizes WHERE product_id = ?")->execute([$del_id]);
        // Delete product
        $pdo->prepare("DELETE FROM products WHERE id = ?")->execute([$del_id]);
        header("Location: products.php?msg=Product+deleted+successfully");
        exit;
    }
}

// Fetch all products with their sizes count (using correlated subquery for universal MySQL ONLY_FULL_GROUP_BY compatibility)
$products = $pdo->query("
    SELECT p.*, (SELECT COUNT(*) FROM product_sizes WHERE product_id = p.id) AS size_count 
    FROM products p 
    ORDER BY p.sort_order ASC, p.id ASC
")->fetchAll();
?>

<div class="admin-page-header">
  <div>
    <h1 class="admin-page-title">Products Catalogue Space</h1>
    <p class="admin-page-subtitle">Add and manage industrial tooling products, upload high-resolution photography, descriptions, and size specifications.</p>
  </div>
  <div>
    <a href="product_edit.php" class="admin-btn admin-btn-primary">
      <span>+ Add New Product</span>
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

<div class="admin-card">
  <div class="admin-card-header">
    <div>
      <h2 class="admin-card-title">All Listed Products (<?= count($products) ?>)</h2>
      <p class="admin-help">All listed products appear in the Products Space catalogue and link to the interactive two-step configurator template.</p>
    </div>
  </div>

  <div class="admin-table-wrapper">
    <table class="admin-table">
      <thead>
        <tr>
          <th style="width: 50px;">#</th>
          <th style="width: 80px;">Image</th>
          <th>Product Name &amp; Standards</th>
          <th>Category</th>
          <th>Sizes Count</th>
          <th>Status</th>
          <th style="width: 170px; text-align:right;">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($products)): ?>
          <tr><td colspan="7" style="text-align:center;padding:30px;color:var(--admin-gray-500);">No products found. Click "+ Add New Product" to list your first product.</td></tr>
        <?php else: ?>
          <?php foreach ($products as $idx => $p): ?>
            <tr>
              <td><strong><?= $idx + 1 ?></strong></td>
              <td>
                <div style="width:60px;height:60px;display:flex;align-items:center;justify-content:center;background:#fff;border:1px solid var(--admin-border);border-radius:6px;padding:4px;">
                  <img src="../<?= htmlspecialchars($p['image']) ?>" alt="" style="max-width:100%;max-height:100%;object-fit:contain;" onerror="this.src='../assets/images/brand/dagger_brand_logo.png'">
                </div>
              </td>
              <td>
                <strong style="font-size:14px;color:var(--admin-gray-900);"><?= htmlspecialchars($p['title']) ?></strong>
                <div style="font-size:12px;color:var(--admin-gray-500);margin-top:2px;">
                  Standard: <strong><?= htmlspecialchars($p['standard'] ?? 'IS : 5101') ?></strong> &bull; HSN: <?= htmlspecialchars($p['hsn_code'] ?? '8207') ?>
                </div>
              </td>
              <td>
                <span class="admin-badge admin-badge-gray"><?= htmlspecialchars($p['category_name'] ?? 'HSS Twist Drills') ?></span>
              </td>
              <td>
                <span class="admin-badge admin-badge-red"><?= (int)$p['size_count'] ?> sizes</span>
              </td>
              <td>
                <span class="admin-badge admin-badge-active"><?= $p['is_active'] ? 'Published' : 'Draft' ?></span>
              </td>
              <td style="text-align:right;">
                <a href="../products/view.php?id=<?= $p['id'] ?>" target="_blank" class="admin-btn admin-btn-secondary admin-btn-sm" title="View live product page">View &nearr;</a>
                <a href="product_edit.php?id=<?= $p['id'] ?>" class="admin-btn admin-btn-secondary admin-btn-sm">Edit</a>
                <a href="products.php?action=delete&id=<?= $p['id'] ?>" class="admin-btn admin-btn-danger admin-btn-sm" onclick="return confirm('Are you sure you want to delete this product? All configured sizes will also be removed.');">Delete</a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
