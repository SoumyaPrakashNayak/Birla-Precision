<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['bptl_admin_logged_in']) || $_SESSION['bptl_admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}
