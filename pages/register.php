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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $errors = [];

    if (empty($username) || strlen($username) < 3) {
        $errors[] = "Username must be at least 3 characters.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email address.";
    }
    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters.";
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        if ($stmt->fetch()) {
            $errors[] = "Username or email already taken.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            if ($stmt->execute([$username, $email, $hash])) {
                $_SESSION['user_id'] = $pdo->lastInsertId();
                $_SESSION['username'] = $username;
                header("Location: /index.php");
                exit;
            } else {
                $errors[] = "Database error during registration.";
            }
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
        <meta name="msapplication-TileColor" content="#05141C" />
        <meta name="msapplication-TileImage" content="/ms-icon-144x144.png" />
        <meta name="theme-color" content="#05141C" />
        <!--  -->
        <link rel="icon" type="image/png" href="../img/logo.png" />
        <link rel="stylesheet" href="../assets/css/styles.css" />
        <title>Register | Rezo</title>
    </head>
    <body>
        <?php if (!empty($errors)): ?>
            <ul>
                <?php foreach($errors as $error): ?>
                    <li><?=htmlspecialchars($error)?></li>
                 <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <div class="content">
            <div class="login-container">
                <h1 class="login-h1">Register</h1>
                <form class="login-form">
                    <i class="fa-solid fa-envelope form-icon"></i>
                    <input type="email" name="email" placeholder="Email" class="form-input" required>
                    <i class="fa-solid fa-user form-icon"></i>
                    <input type="text" name="username" placeholder="Username" class="form-input" required>
                    <i class="fa-solid fa-lock form-icon"></i>
                    <input type="password" name="password" placeholder="Password" class="form-input" required>
                    <button class="login-button" type="submit" class="form-btn" class="login-button">Register</button>
                </form>
                <span class="register-span">Don't have an account? <strong><a href="login.php">Login</a></strong></span>
            </div>
        </div>
        
        <script src="https://kit.fontawesome.com/3ac14f7443.js" crossorigin="anonymous"></script>
    </body>
</html>