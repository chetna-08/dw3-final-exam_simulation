<?php
require 'session.php';
require_login();
require 'db.php';

$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ? AND user_id = ?");
$stmt->execute([$id, $_SESSION['user_id']]);
$product = $stmt->fetch();

if ($product) {
    if (file_exists("uploads/" . $product['image_path'])) {
        unlink("uploads/" . $product['image_path']);
    }
    $del = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $del->execute([$id]);
}
header("Location: dashboard.php");
exit;
?>
