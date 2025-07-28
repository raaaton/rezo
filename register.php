<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $errors = [];

    // Basic validation
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
        // Check if username or email already exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        if ($stmt->fetch()) {
            $errors[] = "Username or email already taken.";
        } else {
            // Insert new user with hashed password
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");
            if ($stmt->execute([$username, $email, $hash])) {
                $_SESSION['user_id'] = $pdo->lastInsertId();
                $_SESSION['username'] = $username;
                header("Location: home.php");
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
<head><title>Register</title></head>
<body>
<h1>Register</h1>
<?php if (!empty($errors)): ?>
<ul>
  <?php foreach($errors as $error): ?>
  <li><?=htmlspecialchars($error)?></li>
  <?php endforeach; ?>
</ul>
<?php endif; ?>
<form method="post" action="register.php">
  <label>Username: <input type="text" name="username" required></label><br>
  <label>Email: <input type="email" name="email" required></label><br>
  <label>Password: <input type="password" name="password" required></label><br>
  <button type="submit">Register</button>
</form>
<a href="login.php">Already have an account? Login</a>
</body>
</html>
