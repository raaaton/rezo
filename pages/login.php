<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require '/includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $errors = [];

    if (empty($username) || empty($password)) {
        $errors[] = "Please fill in all fields.";
    }

    if (empty($errors)) {
        // Fetch user by username
        $stmt = $pdo->prepare("SELECT id, username, password FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Password matches, log user in
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: /index.php");
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
        <title>Login</title>
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
        <form method="post" action="/pages/login.php">
            <label>Username: <input type="text" name="username" required></label><br>
            <label>Password: <input type="password" name="password" required></label><br>
            <button type="submit">Login</button>
        </form>
        <a href="/pages/register.php">Don't have an account? Register</a>
    </body>
</html>
