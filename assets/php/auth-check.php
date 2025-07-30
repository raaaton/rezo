<?php
session_start();
require dirname(__DIR__, 2) . '/includes/db.php';

if (!isset($_COOKIE['auth_token'])) {
    header('Location: /pages/login.php');
    exit;
}

$token = $_COOKIE['auth_token'];

$stmt = $pdo->prepare("
    SELECT users.id, users.username 
    FROM user_tokens 
    JOIN users ON user_tokens.user_id = users.id 
    WHERE user_tokens.token = ? AND user_tokens.expires_at > NOW()
");
$stmt->execute([$token]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    setcookie('auth_token', '', time() - 3600, '/');
    header('Location: /pages/login.php');
    exit;
}

$_SESSION['user_id'] = $user['id'];
$_SESSION['username'] = $user['username'];
?>