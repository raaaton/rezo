<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require dirname(__DIR__, 1) . '/includes/db.php';

if (isset($_COOKIE['auth_token'])) {
    $token = $_COOKIE['auth_token'];

    $stmt = $pdo->prepare("SELECT user_id FROM user_tokens WHERE token = ? AND expires_at > NOW()");
    $stmt->execute([$token]);
    $user = $stmt->fetch();

    if ($user) {
        header('Location: /index.php');
        exit;
    }
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $errors[] = "Please fill in all fields.";
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT id, username, password FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $token = bin2hex(random_bytes(32));
            $expiry = date('Y-m-d H:i:s', time() + 3600 * 24 * 30);

            $stmt = $pdo->prepare("INSERT INTO user_tokens (user_id, token, expires_at, user_agent, ip_address) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([
                $user['id'],
                $token,
                $expiry,
                $_SERVER['HTTP_USER_AGENT'] ?? '',
                $_SERVER['REMOTE_ADDR'] ?? ''
            ]);

            setcookie('auth_token', $token, [
                'expires' => time() + 3600 * 24 * 30,
                'path' => '/',
                'secure' => false,
                'samesite' => 'Lax',
                'secure' => true,
            ]);

            header('Location: /index.php');
            exit;
        } else {
            $errors[] = "Invalid username or password.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- "Add to home screen" support -->
    <link rel="manifest" href="/manifest.json" />
    <meta name="theme-color" content="#05141C" />
    <!--  -->
    <link rel="icon" type="image/png" href="../img/logo.png" />
    <link rel="stylesheet" href="../assets/css/styles.css" />
    <title>Login | Rezo</title>
</head>
<body>
    <h1>Login</h1>
    <?php if (!empty($errors)): ?>
        <ul>
            <?php foreach($errors as $error): ?>
                <li><?=htmlspecialchars($error)?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <form id="loginForm" method="post" action="login.php">
        <label>Username: <input type="text" name="username" required></label><br>
        <label>Password: <input type="password" name="password" required></label><br>
        <button type="submit">Login</button>
    </form>
    <a href="register.php">Don't have an account? Register</a>
</body>
</html>