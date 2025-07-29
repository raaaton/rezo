<?php
require '../../includes/db.php';

try {
    $stmt = $pdo->prepare("DELETE FROM user_tokens WHERE expires_at < NOW()");
    $stmt->execute();
    echo "Expired tokens purged successfully.\n";
} catch (Exception $e) {
    error_log("Error purging tokens: " . $e->getMessage());
    echo "Error purging tokens.\n";
}