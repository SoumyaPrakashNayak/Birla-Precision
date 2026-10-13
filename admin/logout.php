<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$_SESSION['bptl_admin_logged_in'] = false;
unset($_SESSION['bptl_admin_logged_in']);
unset($_SESSION['bptl_admin_user']);
session_destroy();

header('Location: login.php');
exit;
