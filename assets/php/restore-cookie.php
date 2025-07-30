<?php
require dirname(__DIR__, 1) . '/includes/db.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$token = $data['token'] ?? '';

if (!$token) {
    http_response_code(400);
    echo json_encode(['error' => 'Token missing']);
    exit;
}

$stmt = $pdo->prepare("SELECT id FROM user_tokens WHERE token = ? AND expires_at > NOW()");
$stmt->execute([$token]);
$userToken = $stmt->fetch();

if (!$userToken) {
    http_response_code(401);
    echo json_encode(['error' => 'Invalid token']);
    exit;
}

setcookie('auth_token', $token, [
    'expires' => time() + 3600 * 24 * 30,
    'path' => '/',
    'secure' => false,
    'httponly' => true,
    'samesite' => 'Strict',
]);

echo json_encode(['success' => true]);
