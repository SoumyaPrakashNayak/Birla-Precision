<?php
$active_tab = 'dashboard';
$page_title = 'Admin Dashboard — Birla Precision Technologies';

require_once __DIR__ . '/header.php';

$pdo = get_db();

// Fetch summary metrics
$count_products = (int)$pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
$count_hero = (int)$pdo->query("SELECT COUNT(*) FROM site_sections WHERE section_key = 'hero'")->fetchColumn();
$count_tiles = (int)$pdo->query("SELECT COUNT(*) FROM site_sections WHERE section_key = 'feature_tiles'")->fetchColumn();
$count_collections = (int)$pdo->query("SELECT COUNT(*) FROM site_sections WHERE section_key = 'collections'")->fetchColumn();
$count_enquiries = (int)$pdo->query("SELECT COUNT(*) FROM enquiries")->fetchColumn();

// Fetch recent products
$recent_products = $pdo->query("SELECT * FROM products ORDER BY id DESC LIMIT 5")->fetchAll();

// Fetch recent enquiries
$recent_enquiries = $pdo->query("SELECT * FROM enquiries ORDER BY id DESC LIMIT 5")->fetchAll();
?>

<div class="admin-page-header">
  <div>
    <h1 class="admin-page-title">Dashboard Overview</h1>
    <p class="admin-page-subtitle">Welcome back, <?= htmlspecialchars($_SESSION['bptl_admin_user'] ?? 'Admin') ?>. Manage homepage sections, products catalogue, and customer quotation requests.</p>
  </div>
  <div style="display:flex;gap:10px;">
    <a href="product_edit.php" class="admin-btn admin-btn-primary">
      <span>+ Add New Product</span>
    </a>
    <a href="sections.php" class="admin-btn admin-btn-secondary">
      <span>Manage Homepage Sections</span>
    </a>
  </div>
</div>

<!-- Stats Grid -->
<div class="admin-stats-grid">
  <div class="admin-stat-card">
    <div class="admin-stat-icon">📦</div>
    <div>
      <div class="admin-stat-val"><?= $count_products ?></div>
      <div class="admin-stat-label">Listed Products</div>
    </div>
  </div>

  <div class="admin-stat-card">
    <div class="admin-stat-icon" style="background:#E0E7FF;color:#4338CA;">🖼️</div>
    <div>
      <div class="admin-stat-val"><?= $count_hero ?></div>
      <div class="admin-stat-label">Hero Carousel Slides</div>
    </div>
  </div>

  <div class="admin-stat-card">
    <div class="admin-stat-icon" style="background:#FEF3C7;color:#D97706;">🧱</div>
    <div>
      <div class="admin-stat-val"><?= $count_tiles ?></div>
      <div class="admin-stat-label">Feature Tiles</div>
    </div>
  </div>

  <div class="admin-stat-card">
    <div class="admin-stat-icon" style="background:#DCFCE7;color:#15803D;">📑</div>
    <div>
      <div class="admin-stat-val"><?= $count_collections ?></div>
      <div class="admin-stat-label">Collection Items</div>
    </div>
  </div>

  <div class="admin-stat-card">
    <div class="admin-stat-icon" style="background:#FCE7F3;color:#BE185D;">📩</div>
    <div>
      <div class="admin-stat-val"><?= $count_enquiries ?></div>
      <div class="admin-stat-label">Quotation Inquiries</div>
    </div>
  </div>
</div>

<!-- Quick Navigation Cards -->
<div class="admin-card">
  <div class="admin-card-header">
    <h2 class="admin-card-title">Homepage Section Managers</h2>
    <span style="font-size:12px;color:var(--admin-gray-500);">Live content updates on homepage</span>
  </div>
  <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(280px, 1fr));gap:16px;">
    
    <div style="border:1px solid var(--admin-border);padding:16px;border-radius:8px;background:var(--admin-gray-50);">
      <h3 style="font-size:15px;margin-bottom:6px;">1. Hero Carousel</h3>
      <p style="font-size:12px;color:var(--admin-gray-500);margin-bottom:12px;">Upload hero carousel slide images, customize eyebrows, trusted headings, and button links.</p>
      <a href="sections.php?tab=hero" class="admin-btn admin-btn-secondary admin-btn-sm">Edit Hero Slides &rarr;</a>
    </div>

    <div style="border:1px solid var(--admin-border);padding:16px;border-radius:8px;background:var(--admin-gray-50);">
      <h3 style="font-size:15px;margin-bottom:6px;">2. Feature Tiles Section</h3>
      <p style="font-size:12px;color:var(--admin-gray-500);margin-bottom:12px;">Update images and text for the 4 large asymmetrical tiles (Chain Saws, Drivers & Drills, etc.).</p>
      <a href="sections.php?tab=tiles" class="admin-btn admin-btn-secondary admin-btn-sm">Edit Feature Tiles &rarr;</a>
    </div>

    <div style="border:1px solid var(--admin-border);padding:16px;border-radius:8px;background:var(--admin-gray-50);">
      <h3 style="font-size:15px;margin-bottom:6px;">3. Collection List</h3>
      <p style="font-size:12px;color:var(--admin-gray-500);margin-bottom:12px;">Upload images and names for the 10 collection grid items or add new categories.</p>
      <a href="sections.php?tab=collections" class="admin-btn admin-btn-secondary admin-btn-sm">Edit Collection List &rarr;</a>
    </div>

  </div>
</div>

<!-- Recent Products & Recent Enquiries Grid -->
<div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;">

  <!-- Recent Products -->
  <div class="admin-card">
    <div class="admin-card-header">
      <h2 class="admin-card-title">Recent Products</h2>
      <a href="products.php" class="admin-btn admin-btn-secondary admin-btn-sm">All Products &rarr;</a>
    </div>

    <div class="admin-table-wrapper">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Product</th>
            <th>Category</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($recent_products)): ?>
            <tr><td colspan="3" style="text-align:center;color:var(--admin-gray-500);padding:24px;">No products found.</td></tr>
          <?php else: ?>
            <?php foreach ($recent_products as $p): ?>
              <tr>
                <td>
                  <div style="display:flex;align-items:center;gap:10px;">
                    <img src="../<?= htmlspecialchars($p['image']) ?>" alt="" class="admin-thumb" onerror="this.src='../assets/images/brand/dagger_brand_logo.png'">
                    <div>
                      <strong style="font-size:13px;"><?= htmlspecialchars($p['title']) ?></strong>
                      <div style="font-size:11px;color:var(--admin-gray-500);"><?= htmlspecialchars($p['standard'] ?? 'Standard') ?></div>
                    </div>
                  </div>
                </td>
                <td><span class="admin-badge admin-badge-gray"><?= htmlspecialchars($p['category_name'] ?? 'Drills') ?></span></td>
                <td>
                  <a href="product_edit.php?id=<?= $p['id'] ?>" class="admin-btn admin-btn-secondary admin-btn-sm">Edit</a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Recent Quotation Enquiries -->
  <div class="admin-card">
    <div class="admin-card-header">
      <h2 class="admin-card-title">Recent Quotation Inquiries</h2>
      <a href="enquiries.php" class="admin-btn admin-btn-secondary admin-btn-sm">All Enquiries &rarr;</a>
    </div>

    <div class="admin-table-wrapper">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Reference</th>
            <th>Customer</th>
            <th>Qty</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($recent_enquiries)): ?>
            <tr><td colspan="3" style="text-align:center;color:var(--admin-gray-500);padding:24px;">No quotation inquiries received yet.</td></tr>
          <?php else: ?>
            <?php foreach ($recent_enquiries as $eq): ?>
              <tr>
                <td>
                  <strong><?= htmlspecialchars($eq['enquiry_ref']) ?></strong>
                  <div style="font-size:11px;color:var(--admin-gray-500);"><?= htmlspecialchars($eq['created_at']) ?></div>
                </td>
                <td>
                  <div><?= htmlspecialchars($eq['customer_name']) ?></div>
                  <div style="font-size:11px;color:var(--admin-gray-500);"><?= htmlspecialchars($eq['phone']) ?></div>
                </td>
                <td>
                  <span class="admin-badge admin-badge-red"><?= (int)$eq['quantity'] ?> pcs</span>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

</div>

<?php require_once __DIR__ . '/footer.php'; ?>
