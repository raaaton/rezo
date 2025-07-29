<?php
require dirname(__DIR__, 2) . '/includes/db.php';

if (isset($_COOKIE['auth_token'])) {
    $stmt = $pdo->prepare("DELETE FROM user_tokens WHERE token = ?");
    $stmt->execute([$_COOKIE['auth_token']]);
    setcookie('auth_token', '', time() - 3600, '/');
}

header('Location: /pages/login.php');
exit;
?>