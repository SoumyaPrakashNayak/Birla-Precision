<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../includes/db.php';

// If already logged in, redirect to dashboard
if (!empty($_SESSION['bptl_admin_logged_in']) && $_SESSION['bptl_admin_logged_in'] === true) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($username) || empty($password)) {
        $error = 'Please enter both username and password.';
    } else {
        $pdo = get_db();
        $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ? LIMIT 1");
        $stmt->execute([$username]);
        $admin = $stmt->fetch();

        if ($admin && password_verify($password, $admin['password_hash'])) {
            $_SESSION['bptl_admin_logged_in'] = true;
            $_SESSION['bptl_admin_id'] = $admin['id'];
            $_SESSION['bptl_admin_user'] = $admin['username'];
            header('Location: index.php');
            exit;
        } else {
            $error = 'Invalid username or password.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login — Birla Precision Technologies</title>
  <link rel="stylesheet" href="admin.css">
  <link rel="icon" type="image/png" href="../assets/images/brand/dagger_brand_logo.png">
</head>
<body class="admin-login-wrapper">

  <div class="admin-login-box">
    <div class="admin-login-header">
      <img src="../assets/images/brand/dagger_brand_logo.png" alt="Birla Precision Dagger Brand">
      <h1>Admin Portal</h1>
      <p>Birla Precision Technologies Limited</p>
    </div>

    <?php if ($error): ?>
      <div class="admin-alert admin-alert-error">
        <span><?= htmlspecialchars($error) ?></span>
      </div>
    <?php endif; ?>

    <form method="POST" action="login.php">
      <div class="admin-form-group">
        <label class="admin-label" for="username">Username</label>
        <input 
          type="text" 
          id="username" 
          name="username" 
          class="admin-input" 
          required 
          autofocus 
          placeholder="admin"
          value="<?= htmlspecialchars($_POST['username'] ?? 'admin') ?>"
        >
      </div>

      <div class="admin-form-group">
        <label class="admin-label" for="password">Password</label>
        <input 
          type="password" 
          id="password" 
          name="password" 
          class="admin-input" 
          required 
          placeholder="••••••••"
        >
      </div>

      <div style="margin-top: 24px;">
        <button type="submit" class="admin-btn admin-btn-primary" style="width:100%;justify-content:center;padding:11px;">
          Log In &rarr;
        </button>
      </div>
    </form>

    <div style="margin-top: 20px; text-align: center; font-size: 11px; color: var(--admin-gray-500); background: #F8FAFC; padding: 10px; border-radius: 6px;">
      Default Credentials: <strong>admin</strong> / <strong>admin123</strong>
      <div style="margin-top:4px;"><a href="../index.php" style="color:var(--admin-primary);text-decoration:none;">&larr; Return to Website</a></div>
    </div>
  </div>

</body>
</html>
