<?php
require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/../includes/db.php';

$active_tab = $active_tab ?? 'dashboard';
$db_driver = get_db_driver();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($page_title ?? 'Admin Panel — Birla Precision Technologies') ?></title>
  <link rel="stylesheet" href="admin.css">
  <link rel="icon" type="image/png" href="../assets/images/brand/dagger_brand_logo.png">
</head>
<body>

  <!-- Admin Navigation Header -->
  <header class="admin-navbar">
    <a href="index.php" class="admin-nav-brand">
      <img src="../assets/images/brand/dagger_brand_logo.png" alt="Birla Precision" class="admin-nav-logo">
      <span class="admin-nav-title">Birla Precision Admin</span>
      <span class="admin-nav-badge"><?= strtoupper($db_driver) ?></span>
    </a>

    <nav>
      <ul class="admin-nav-links">
        <li>
          <a href="index.php" class="<?= $active_tab === 'dashboard' ? 'active' : '' ?>">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
            Dashboard
          </a>
        </li>
        <li>
          <a href="sections.php" class="<?= $active_tab === 'sections' ? 'active' : '' ?>">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
            Section Uploads
          </a>
        </li>
        <li>
          <a href="products.php" class="<?= $active_tab === 'products' ? 'active' : '' ?>">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
            Products Space
          </a>
        </li>
        <li>
          <a href="enquiries.php" class="<?= $active_tab === 'enquiries' ? 'active' : '' ?>">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
            Enquiries
          </a>
        </li>
        <li>
          <a href="settings.php" class="<?= $active_tab === 'settings' ? 'active' : '' ?>">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
            Settings
          </a>
        </li>
      </ul>
    </nav>

    <div class="admin-nav-user">
      <a href="../index.php" target="_blank" class="admin-btn admin-btn-secondary admin-btn-sm" style="color:#D1D5DB;border-color:rgba(255,255,255,0.2);background:transparent;">
        View Live Site &nearr;
      </a>
      <span class="admin-user-pill">
        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
        <?= htmlspecialchars($_SESSION['bptl_admin_user'] ?? 'Admin') ?>
      </span>
      <a href="logout.php" class="admin-btn-logout">Logout</a>
    </div>
  </header>

  <main class="admin-container">
