<?php
require __DIR__ . '/../../includes/db.php';

if (isset($_COOKIE['auth_token'])) {
    $stmt = $pdo->prepare("UPDATE users SET auth_token = NULL, token_expiry = NULL WHERE auth_token = ?");
    $stmt->execute([$_COOKIE['auth_token']]);

    setcookie('auth_token', '', time() - 3600, '/');
}

header('Location: ../../pages/login.php');
exit;
?>