<?php
require __DIR__ . '/../../includes/db.php';

if (!isset($_COOKIE['auth_token'])) {
    header('Location: ../../pages/login.php');
    exit;
}

$token = $_COOKIE['auth_token'];

$stmt = $pdo->prepare("SELECT id, username FROM users WHERE auth_token = ? AND token_expiry > NOW()");
$stmt->execute([$token]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    setcookie('auth_token', '', time() - 3600, '/');
    header('Location: ../../pages/login.php');
    exit;
}
?>