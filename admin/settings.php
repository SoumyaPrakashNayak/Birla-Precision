<?php
$active_tab = 'settings';
$page_title = 'Settings & Diagnostics — Birla Precision Admin';

require_once __DIR__ . '/header.php';

$pdo = get_db();
$driver = get_db_driver();

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_credentials'])) {
    $new_user = trim($_POST['username'] ?? '');
    $cur_pass = trim($_POST['current_password'] ?? '');
    $new_pass = trim($_POST['new_password'] ?? '');
    $cnf_pass = trim($_POST['confirm_password'] ?? '');

    if (empty($cur_pass)) {
        $error = 'Current password is required to make changes.';
    } elseif (empty($new_user)) {
        $error = 'Username cannot be empty.';
    } else {
        $stmt = $pdo->prepare("SELECT * FROM admins WHERE id = ?");
        $stmt->execute([(int)$_SESSION['bptl_admin_id']]);
        $user = $stmt->fetch();

        if (!$user || !password_verify($cur_pass, $user['password_hash'])) {
            $error = 'Current password is incorrect.';
        } else {
            // Check if username already used by another admin
            $chk = $pdo->prepare("SELECT id FROM admins WHERE username = ? AND id != ?");
            $chk->execute([$new_user, (int)$user['id']]);
            if ($chk->fetch()) {
                $error = 'Username "' . htmlspecialchars($new_user) . '" is already taken.';
            } else {
                $update_pass = false;
                if (!empty($new_pass)) {
                    if ($new_pass !== $cnf_pass) {
                        $error = 'New password and confirmation do not match.';
                    } elseif (strlen($new_pass) < 6) {
                        $error = 'New password must be at least 6 characters long.';
                    } else {
                        $update_pass = true;
                    }
                }

                if (!$error) {
                    if ($update_pass) {
                        $new_hash = password_hash($new_pass, PASSWORD_BCRYPT);
                        $stmt = $pdo->prepare("UPDATE admins SET username = ?, password_hash = ? WHERE id = ?");
                        $stmt->execute([$new_user, $new_hash, $user['id']]);
                    } else {
                        $stmt = $pdo->prepare("UPDATE admins SET username = ? WHERE id = ?");
                        $stmt->execute([$new_user, $user['id']]);
                    }
                    $_SESSION['bptl_admin_user'] = $new_user;
                    $message = 'Admin credentials updated successfully.';
                }
            }
        }
    }
}
?>

<div class="admin-page-header">
  <div>
    <h1 class="admin-page-title">Settings &amp; Database Diagnostics</h1>
    <p class="admin-page-subtitle">Hostinger MySQL configuration status and security credentials.</p>
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

<div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;">

  <!-- Database Information Card -->
  <div class="admin-card">
    <div class="admin-card-header">
      <h2 class="admin-card-title">Database Connection Status</h2>
      <span class="admin-badge admin-badge-active"><?= strtoupper($driver) ?></span>
    </div>

    <table class="admin-table">
      <tr>
        <td style="font-weight:600;width:170px;">Target Hostinger DB:</td>
        <td><code><?= htmlspecialchars(HOSTINGER_DB_NAME) ?></code></td>
      </tr>
      <tr>
        <td style="font-weight:600;">Hostinger Username:</td>
        <td><code><?= htmlspecialchars(HOSTINGER_DB_USER) ?></code></td>
      </tr>
      <tr>
        <td style="font-weight:600;">Hostinger Host:</td>
        <td><code><?= htmlspecialchars(HOSTINGER_DB_HOST) ?></code></td>
      </tr>
      <tr>
        <td style="font-weight:600;">Active Local Driver:</td>
        <td><strong><?= strtoupper($driver) ?></strong> (<?= $driver === 'sqlite' ? 'SQLite Engine' : 'MySQL Engine' ?>)</td>
      </tr>
      <tr>
        <td style="font-weight:600;">Status:</td>
        <td><span style="color:#059669;font-weight:700;">&check; Connected &amp; Operational</span></td>
      </tr>
    </table>

    <div style="margin-top:20px;padding:14px;background:var(--admin-gray-50);border-radius:6px;border:1px solid var(--admin-border);">
      <div style="font-size:12px;color:var(--admin-gray-700);margin-bottom:10px;">
        <strong>Hostinger Deployment Note:</strong> When uploading to Hostinger, the application automatically connects to your Hostinger MySQL database <code>u641661223_DRILLMAC</code>. You can also import the setup schema directly in Hostinger phpMyAdmin if required.
      </div>
      <a href="../database/hostinger_drillmac_setup.sql" download class="admin-btn admin-btn-secondary admin-btn-sm">
        Download hostinger_drillmac_setup.sql
      </a>
    </div>
  </div>

  <!-- Change Credentials Card -->
  <div class="admin-card">
    <div class="admin-card-header">
      <h2 class="admin-card-title">Admin Account Credentials</h2>
    </div>

    <form method="POST">
      <input type="hidden" name="change_credentials" value="1">

      <div class="admin-form-group">
        <label class="admin-label" for="username">Admin Username</label>
        <input 
          type="text" 
          id="username" 
          name="username" 
          class="admin-input" 
          required 
          value="<?= htmlspecialchars($_SESSION['bptl_admin_user'] ?? 'admin') ?>"
        >
      </div>

      <div class="admin-form-group">
        <label class="admin-label" for="current_password">Current Password (Required)</label>
        <input type="password" id="current_password" name="current_password" class="admin-input" required placeholder="Enter current password to confirm">
      </div>

      <div class="admin-form-group">
        <label class="admin-label" for="new_password">New Password (Leave blank to keep current password)</label>
        <input type="password" id="new_password" name="new_password" class="admin-input" minlength="6" placeholder="Optional — minimum 6 characters">
      </div>

      <div class="admin-form-group">
        <label class="admin-label" for="confirm_password">Confirm New Password</label>
        <input type="password" id="confirm_password" name="confirm_password" class="admin-input" minlength="6" placeholder="Re-enter new password">
      </div>

      <div style="margin-top:20px;">
        <button type="submit" class="admin-btn admin-btn-primary">
          Update Credentials &rarr;
        </button>
      </div>
    </form>
  </div>

</div>

<?php require_once __DIR__ . '/footer.php'; ?>
