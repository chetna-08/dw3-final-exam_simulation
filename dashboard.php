<?php
require 'session.php';
require_login();
require 'db.php';

$stmt = $pdo->prepare("SELECT * FROM products WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$products = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<h2>Welcome to Dashboard</h2>
<a href="add_product.php">Add Product</a> | 
<a href="logout.php">Logout</a>

<table border="1">
    <tr><th>Image</th><th>Name</th><th>Description</th><th>Price</th><th>Action</th></tr>
    <?php foreach ($products as $product): ?>
    <tr>
        <td><img src="uploads/<?= htmlspecialchars($product['image_path']) ?>" width="100"></td>
        <td><?= htmlspecialchars($product['name']) ?></td>
        <td><?= htmlspecialchars($product['description']) ?></td>
        <td>$<?= number_format($product['price'], 2) ?></td>
        <td><a href="delete_product.php?id=<?= $product['id'] ?>">Delete</a></td>
    </tr>
    <?php endforeach; ?>
</table>
