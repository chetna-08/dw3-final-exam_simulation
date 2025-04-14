<?php
require 'session.php';
require_login();
require 'db.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'] ?? '';
    $desc = $_POST['description'] ?? '';
    $price = $_POST['price'] ?? '';

    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $file = $_FILES['image'];
        $allowed = ['jpg', 'jpeg', 'png'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (in_array($ext, $allowed) && $file['size'] <= 2 * 1024 * 1024) {
            $imageName = uniqid() . ".$ext";
            move_uploaded_file($file['tmp_name'], "uploads/$imageName");

            $stmt = $pdo->prepare("INSERT INTO products (user_id, name, description, price, image_path) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$_SESSION['user_id'], $name, $desc, $price, $imageName]);

            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Invalid image (type/size).";
        }
    } else {
        $error = "Image upload failed.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<h2>Add Product</h2>

<form method="POST" enctype="multipart/form-data">
    <input type="text" name="name" placeholder="Product Name" required><br>
    <textarea name="description" placeholder="Description" required></textarea><br>
    <input type="number" name="price" placeholder="Price" required step="0.01"><br>
    <input type="file" name="image" required><br>
    <button type="submit">Add Product</button>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
</form>
