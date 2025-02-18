<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $brand = $_POST['brand'];
    $supplier = $_POST['supplier'];
    $category = $_POST['category'];

    $query = "INSERT INTO products (name, price, quantity, brand, supplier, category) VALUES ('$name', '$price', '$quantity', '$brand', '$supplier', '$category')";
    if ($conn->query($query)) {
        echo "<script>alert('Product added successfully!');</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <!-- Include the header for navigation -->
    <?php include 'templates/header.php'; ?>

    <div class="form-container">
        <h2>Add Product</h2>
        <form method="POST" action="">
            <input type="text" name="name" placeholder="Product Name" required>
            <input type="number" name="price" placeholder="Price" required>
            <input type="number" name="quantity" placeholder="Quantity" required>
            <input type="text" name="brand" placeholder="Brand" required>
            <input type="text" name="supplier" placeholder="Supplier" required>
            <input type="text" name="category" placeholder="Category" required>
            
            <button type="submit">Save</button>
        </form>
    </div>

    <script src="js/script.js"></script>
</body>
</html>
