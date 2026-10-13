<?php
$active_tab = 'sections';
$page_title = 'Section Uploads & Content Manager — Birla Precision Admin';

require_once __DIR__ . '/header.php';
require_once __DIR__ . '/../includes/upload_helper.php';

$pdo = get_db();
$current_subtab = $_GET['tab'] ?? 'hero';
if (!in_array($current_subtab, ['hero', 'tiles', 'collections'], true)) {
    $current_subtab = 'hero';
}

$message = $_GET['msg'] ?? '';
$error = $_GET['err'] ?? '';

// Handle quick delete if requested
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $del_id = (int)$_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM site_sections WHERE id = ?");
    $stmt->execute([$del_id]);
    header("Location: sections.php?tab={$current_subtab}&msg=Item+deleted+successfully");
    exit;
}

// Fetch items for current tab
$stmt = $pdo->prepare("SELECT * FROM site_sections WHERE section_key = ? ORDER BY sort_order ASC, id ASC");
$db_section_key = ($current_subtab === 'tiles') ? 'feature_tiles' : $current_subtab;
$stmt->execute([$db_section_key]);
$items = $stmt->fetchAll();
?>

<div class="admin-page-header">
  <div>
    <h1 class="admin-page-title">Homepage Section Managers</h1>
    <p class="admin-page-subtitle">Upload and update images and text section-by-section for the homepage.</p>
  </div>
  <?php if ($current_subtab !== 'tiles'): ?>
    <div>
      <a href="section_edit.php?section=<?= $current_subtab ?>" class="admin-btn admin-btn-primary">
        <span>+ Add New <?= $current_subtab === 'hero' ? 'Hero Slide' : 'Collection Item' ?></span>
      </a>
    </div>
  <?php endif; ?>
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

<!-- Tabs -->
<div class="admin-tabs">
  <a href="sections.php?tab=hero" class="admin-tab <?= $current_subtab === 'hero' ? 'active' : '' ?>">
    1. Hero Page Carousel (<?= $current_subtab === 'hero' ? count($items) : '' ?>)
  </a>
  <a href="sections.php?tab=tiles" class="admin-tab <?= $current_subtab === 'tiles' ? 'active' : '' ?>">
    2. Feature Tiles Section (4 Tiles)
  </a>
  <a href="sections.php?tab=collections" class="admin-tab <?= $current_subtab === 'collections' ? 'active' : '' ?>">
    3. Collection List (<?= $current_subtab === 'collections' ? count($items) : '' ?>)
  </a>
</div>

<!-- =========================================================================
     TAB 1: HERO CAROUSEL SLIDES
     ========================================================================= -->
<?php if ($current_subtab === 'hero'): ?>
  <div class="admin-card">
    <div class="admin-card-header">
      <div>
        <h2 class="admin-card-title">Homepage Hero Carousel Slides</h2>
        <p class="admin-help">Manage hero background images, red eyebrows, headlines, and call-to-action buttons.</p>
      </div>
      <a href="section_edit.php?section=hero" class="admin-btn admin-btn-primary admin-btn-sm">+ Add Slide</a>
    </div>

    <div class="admin-table-wrapper">
      <table class="admin-table">
        <thead>
          <tr>
            <th style="width: 70px;">Order</th>
            <th style="width: 140px;">Slide Image</th>
            <th>Eyebrow &amp; Heading</th>
            <th>Subtitle / Description</th>
            <th>Button Link</th>
            <th style="width: 130px; text-align:right;">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($items)): ?>
            <tr><td colspan="6" style="text-align:center;padding:30px;color:var(--admin-gray-500);">No hero slides found. Click "+ Add Slide" to create one.</td></tr>
          <?php else: ?>
            <?php foreach ($items as $s): ?>
              <tr>
                <td><strong>#<?= (int)$s['sort_order'] ?></strong></td>
                <td>
                  <img src="../<?= htmlspecialchars($s['image_url']) ?>" alt="" class="admin-thumb-wide" onerror="this.src='../assets/images/brand/dagger_brand_logo.png'">
                </td>
                <td>
                  <span style="display:inline-block;font-size:10px;font-weight:700;color:var(--admin-primary);text-transform:uppercase;"><?= htmlspecialchars($s['eyebrow'] ?? '') ?></span>
                  <div style="font-weight:700;font-size:14px;"><?= strip_tags($s['title']) ?></div>
                </td>
                <td>
                  <div style="max-width:320px;font-size:12px;color:var(--admin-gray-700);line-height:1.4;">
                    <?= htmlspecialchars(mb_strimwidth($s['subtitle'] ?? '', 0, 100, '...')) ?>
                  </div>
                </td>
                <td>
                  <code style="font-size:11px;background:#F3F4F6;padding:2px 6px;border-radius:4px;"><?= htmlspecialchars($s['link_url'] ?? 'products.php') ?></code>
                </td>
                <td style="text-align:right;">
                  <a href="section_edit.php?id=<?= $s['id'] ?>" class="admin-btn admin-btn-secondary admin-btn-sm">Edit</a>
                  <a href="sections.php?tab=hero&action=delete&id=<?= $s['id'] ?>" class="admin-btn admin-btn-danger admin-btn-sm" onclick="return confirm('Are you sure you want to delete this hero slide?');">Delete</a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
<?php endif; ?>

<!-- =========================================================================
     TAB 2: FEATURE TILES SECTION (4 ASYMMETRICAL TILES)
     ========================================================================= -->
<?php if ($current_subtab === 'tiles'): ?>
  <div class="admin-card">
    <div class="admin-card-header">
      <div>
        <h2 class="admin-card-title">Homepage Feature Tiles (4 Asymmetric Equipment Tiles)</h2>
        <p class="admin-help">Edit the 4 main tiles on the homepage: Chain Saws, Drivers &amp; Drills, Cutting Tools, and Power Tools.</p>
      </div>
    </div>

    <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(260px, 1fr));gap:20px;">
      <?php foreach ($items as $idx => $t): ?>
        <div style="border:1px solid var(--admin-border);border-radius:8px;overflow:hidden;background:#fff;box-shadow:var(--admin-shadow);">
          <div style="position:relative;height:160px;background:#000;">
            <img src="../<?= htmlspecialchars($t['image_url']) ?>" alt="" style="width:100%;height:100%;object-fit:cover;opacity:0.85;">
            <span style="position:absolute;top:10px;left:10px;background:rgba(0,0,0,0.65);color:#fff;font-size:11px;font-weight:700;padding:2px 8px;border-radius:4px;">
              Tile <?= $idx + 1 ?>
            </span>
          </div>
          <div style="padding:16px;">
            <h3 style="font-size:16px;font-weight:800;color:var(--admin-gray-900);margin-bottom:4px;">
              <?= htmlspecialchars($t['title']) ?>
            </h3>
            <p style="font-size:12px;color:var(--admin-gray-500);margin-bottom:12px;">
              <?= htmlspecialchars($t['subtitle'] ?? '') ?>
            </p>
            <div style="font-size:11px;color:var(--admin-gray-500);margin-bottom:16px;">
              <strong>Link:</strong> <?= htmlspecialchars($t['link_url'] ?? 'products/parallel-shank-twist-drills.php') ?>
            </div>
            <a href="section_edit.php?id=<?= $t['id'] ?>" class="admin-btn admin-btn-primary admin-btn-sm" style="width:100%;justify-content:center;">
              Edit Image &amp; Text &rarr;
            </a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
<?php endif; ?>

<!-- =========================================================================
     TAB 3: COLLECTION LIST (10 ITEMS GRID)
     ========================================================================= -->
<?php if ($current_subtab === 'collections'): ?>
  <div class="admin-card">
    <div class="admin-card-header">
      <div>
        <h2 class="admin-card-title">Homepage Collection List</h2>
        <p class="admin-help">Manage collection cards, upload transparent PNG/JPG tool graphics, and configure click destinations.</p>
      </div>
      <a href="section_edit.php?section=collections" class="admin-btn admin-btn-primary admin-btn-sm">+ Add Collection Item</a>
    </div>

    <div class="admin-table-wrapper">
      <table class="admin-table">
        <thead>
          <tr>
            <th style="width: 70px;">Order</th>
            <th style="width: 90px;">Icon / Image</th>
            <th>Collection Title</th>
            <th>Redirect URL</th>
            <th style="width: 140px; text-align:right;">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($items)): ?>
            <tr><td colspan="5" style="text-align:center;padding:30px;color:var(--admin-gray-500);">No collection items found. Click "+ Add Collection Item" to create one.</td></tr>
          <?php else: ?>
            <?php foreach ($items as $c): ?>
              <tr>
                <td><strong>#<?= (int)$c['sort_order'] ?></strong></td>
                <td>
                  <div style="width:60px;height:60px;display:flex;align-items:center;justify-content:center;background:#F9FAFB;border:1px solid var(--admin-border);border-radius:6px;padding:4px;">
                    <img src="../<?= htmlspecialchars($c['image_url']) ?>" alt="" style="max-width:100%;max-height:100%;object-fit:contain;" onerror="this.src='../assets/images/brand/dagger_brand_logo.png'">
                  </div>
                </td>
                <td>
                  <strong style="font-size:14px;color:var(--admin-gray-900);"><?= htmlspecialchars($c['title']) ?></strong>
                  <div style="font-size:11px;color:var(--admin-gray-500);">Item key: <?= htmlspecialchars($c['item_key']) ?></div>
                </td>
                <td>
                  <code style="font-size:11px;background:#F3F4F6;padding:2px 6px;border-radius:4px;"><?= htmlspecialchars($c['link_url'] ?? 'products/parallel-shank-twist-drills.php') ?></code>
                </td>
                <td style="text-align:right;">
                  <a href="section_edit.php?id=<?= $c['id'] ?>" class="admin-btn admin-btn-secondary admin-btn-sm">Edit</a>
                  <a href="sections.php?tab=collections&action=delete&id=<?= $c['id'] ?>" class="admin-btn admin-btn-danger admin-btn-sm" onclick="return confirm('Are you sure you want to delete this collection item?');">Delete</a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
<?php endif; ?>

<?php require_once __DIR__ . '/footer.php'; ?>
