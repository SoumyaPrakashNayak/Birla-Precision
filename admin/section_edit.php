<?php
$active_tab = 'sections';
$page_title = 'Edit Section Item — Birla Precision Admin';

require_once __DIR__ . '/header.php';
require_once __DIR__ . '/../includes/upload_helper.php';

$pdo = get_db();
$item_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$section_type = $_GET['section'] ?? 'hero';
if ($section_type === 'tiles') $section_type = 'feature_tiles';

$item = null;
if ($item_id > 0) {
    $stmt = $pdo->prepare("SELECT * FROM site_sections WHERE id = ?");
    $stmt->execute([$item_id]);
    $item = $stmt->fetch();
    if ($item) {
        $section_type = $item['section_key'];
    }
}

$error = '';
$success = '';

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $section_key = $_POST['section_key'] ?? $section_type;
    $title       = trim($_POST['title'] ?? '');
    $subtitle    = trim($_POST['subtitle'] ?? '');
    $eyebrow     = trim($_POST['eyebrow'] ?? '');
    $link_url    = trim($_POST['link_url'] ?? 'products/parallel-shank-twist-drills.php');
    $sort_order  = (int)($_POST['sort_order'] ?? 0);
    $item_key    = trim($_POST['item_key'] ?? '');

    if (empty($title)) {
        $error = 'Title / Label cannot be empty.';
    } else {
        // Image handling
        $image_url = $item ? $item['image_url'] : '';

        if (!empty($_FILES['image']['name'])) {
            $dest_folder = ($section_key === 'hero') ? 'hero' : (($section_key === 'feature_tiles') ? 'tiles' : 'collections');
            $upload_res = handle_image_upload($_FILES['image'], $dest_folder);
            if ($upload_res['success']) {
                $image_url = $upload_res['file_path'];
            } else {
                $error = 'Image upload failed: ' . $upload_res['error'];
            }
        }

        if (empty($image_url) && !$item) {
            $error = 'Please select an image to upload.';
        }

        if (!$error) {
            if (empty($item_key)) {
                $item_key = preg_replace('/[^a-z0-9_]/', '_', strtolower(strip_tags($title)));
                $item_key = substr($item_key, 0, 30);
            }

            if ($item) {
                // Update
                $stmt = $pdo->prepare("
                    UPDATE site_sections 
                    SET title = ?, subtitle = ?, eyebrow = ?, image_url = ?, link_url = ?, sort_order = ? 
                    WHERE id = ?
                ");
                $stmt->execute([$title, $subtitle, $eyebrow, $image_url, $link_url, $sort_order, $item['id']]);
                $tab_param = ($section_key === 'feature_tiles') ? 'tiles' : $section_key;
                header("Location: sections.php?tab={$tab_param}&msg=Section+item+updated+successfully");
                exit;
            } else {
                // Insert
                $stmt = $pdo->prepare("
                    INSERT INTO site_sections 
                    (section_key, item_key, title, subtitle, eyebrow, image_url, link_url, sort_order) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)
                ");
                $stmt->execute([$section_key, $item_key, $title, $subtitle, $eyebrow, $image_url, $link_url, $sort_order]);
                $tab_param = ($section_key === 'feature_tiles') ? 'tiles' : $section_key;
                header("Location: sections.php?tab={$tab_param}&msg=New+item+added+successfully");
                exit;
            }
        }
    }
}

$tab_back = ($section_type === 'feature_tiles') ? 'tiles' : $section_type;
?>

<div class="admin-page-header">
  <div>
    <h1 class="admin-page-title"><?= $item ? 'Edit Section Item' : 'Add New Section Item' ?></h1>
    <p class="admin-page-subtitle">Configure image and promotional text for section: <strong><?= strtoupper(str_replace('_', ' ', $section_type)) ?></strong></p>
  </div>
  <div>
    <a href="sections.php?tab=<?= $tab_back ?>" class="admin-btn admin-btn-secondary">
      &larr; Back to Sections
    </a>
  </div>
</div>

<?php if ($error): ?>
  <div class="admin-alert admin-alert-error">
    <span><?= htmlspecialchars($error) ?></span>
  </div>
<?php endif; ?>

<div class="admin-card" style="max-width: 760px;">
  <form method="POST" enctype="multipart/form-data">
    <input type="hidden" name="section_key" value="<?= htmlspecialchars($section_type) ?>">

    <!-- Section Type Display -->
    <div class="admin-form-group">
      <label class="admin-label">Section Placement</label>
      <input type="text" class="admin-input" value="<?= htmlspecialchars(strtoupper(str_replace('_', ' ', $section_type))) ?>" readonly style="background:#F3F4F6;color:#6B7280;">
    </div>

    <?php if ($section_type === 'hero'): ?>
      <!-- Hero Specific: Eyebrow -->
      <div class="admin-form-group">
        <label class="admin-label" for="eyebrow">Red Eyebrow Badge Text</label>
        <input 
          type="text" 
          id="eyebrow" 
          name="eyebrow" 
          class="admin-input" 
          placeholder="e.g. HSS TWIST DRILLS or DAGGER BRAND • SINCE 1937" 
          value="<?= htmlspecialchars($_POST['eyebrow'] ?? ($item['eyebrow'] ?? 'HSS TWIST DRILLS')) ?>"
        >
        <span class="admin-help">Displays in bold red above the main hero heading.</span>
      </div>
    <?php endif; ?>

    <!-- Title -->
    <div class="admin-form-group">
      <label class="admin-label" for="title">
        <?= $section_type === 'hero' ? 'Hero Heading (HTML allowed for styling)' : ($section_type === 'feature_tiles' ? 'Tile Label (Uppercase)' : 'Collection Name') ?> *
      </label>
      <input 
        type="text" 
        id="title" 
        name="title" 
        class="admin-input" 
        required 
        placeholder="<?= $section_type === 'hero' ? '<span class=\"trusted-word\">Trusted</span> for Precision' : 'CHAIN SAWS' ?>" 
        value="<?= htmlspecialchars($_POST['title'] ?? ($item['title'] ?? '')) ?>"
      >
      <?php if ($section_type === 'hero'): ?>
        <span class="admin-help">Use <code>&lt;span class="trusted-word"&gt;Trusted&lt;/span&gt; for Precision</code> to apply italic serif styling to the first word.</span>
      <?php endif; ?>
    </div>

    <?php if ($section_type !== 'collections'): ?>
      <!-- Subtitle / Subtext -->
      <div class="admin-form-group">
        <label class="admin-label" for="subtitle">
          <?= $section_type === 'hero' ? 'Subheading / Paragraph' : 'Tile Subtext' ?>
        </label>
        <textarea 
          id="subtitle" 
          name="subtitle" 
          class="admin-textarea" 
          placeholder="Short description or sub-label..."
        ><?= htmlspecialchars($_POST['subtitle'] ?? ($item['subtitle'] ?? '')) ?></textarea>
      </div>
    <?php endif; ?>

    <!-- Image Upload -->
    <div class="admin-form-group">
      <label class="admin-label" for="image">
        <?= $item ? 'Replace Image (Leave blank to keep current)' : 'Upload Image' ?> *
      </label>
      <input 
        type="file" 
        id="image" 
        name="image" 
        class="admin-input" 
        accept="image/png, image/jpeg, image/webp, image/gif, image/svg+xml"
      >
      <span class="admin-help">Recommended formats: WebP, JPG, or PNG. Maximum 15MB.</span>

      <?php if ($item && !empty($item['image_url'])): ?>
        <div class="admin-preview-box">
          <img src="../<?= htmlspecialchars($item['image_url']) ?>" alt="Current image" class="admin-thumb-wide" onerror="this.src='../assets/images/brand/dagger_brand_logo.png'">
          <div>
            <div style="font-size:12px;font-weight:600;">Current Active Image:</div>
            <code style="font-size:11px;color:var(--admin-gray-500);"><?= htmlspecialchars($item['image_url']) ?></code>
          </div>
        </div>
      <?php endif; ?>
    </div>

    <!-- Link URL & Sort Order -->
    <div class="admin-form-grid">
      <div class="admin-form-group">
        <label class="admin-label" for="link_url">Click Destination URL</label>
        <input 
          type="text" 
          id="link_url" 
          name="link_url" 
          class="admin-input" 
          placeholder="products/parallel-shank-twist-drills.php" 
          value="<?= htmlspecialchars($_POST['link_url'] ?? ($item['link_url'] ?? 'products/parallel-shank-twist-drills.php')) ?>"
        >
      </div>

      <div class="admin-form-group">
        <label class="admin-label" for="sort_order">Display Order / Position</label>
        <input 
          type="number" 
          id="sort_order" 
          name="sort_order" 
          class="admin-input" 
          min="1" 
          max="99" 
          value="<?= (int)($_POST['sort_order'] ?? ($item['sort_order'] ?? 1)) ?>"
        >
      </div>
    </div>

    <div style="margin-top:24px;display:flex;gap:12px;">
      <button type="submit" class="admin-btn admin-btn-primary" style="padding:10px 24px;">
        Save Changes &rarr;
      </button>
      <a href="sections.php?tab=<?= $tab_back ?>" class="admin-btn admin-btn-secondary">
        Cancel
      </a>
    </div>

  </form>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
