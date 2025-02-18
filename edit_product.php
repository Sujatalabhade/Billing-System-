<?php
include 'db.php';

// Check if the product ID is set in the URL and is a valid integer
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $product_id = intval($_GET['id']); // Convert to integer

    // Fetch the product details
    $query = "SELECT * FROM products WHERE id = $product_id";
    $result = $conn->query($query);

    // Check if the query was successful
    if (!$result) {
        die("Query failed: " . $conn->error);
    }

    $product = $result->fetch_assoc();

    // Check if a product was found
    if (!$product) {
        die("Product not found.");
    }
} else {
    die("Invalid product ID.");
}

// Update product details if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $brand = $_POST['brand'];
    $supplier = $_POST['supplier'];
    $category = $_POST['category'];

    // Update the product details
    $update_query = "UPDATE products SET name='$name', price='$price', quantity='$quantity', brand='$brand', supplier='$supplier', category='$category' WHERE id=$product_id";
    if ($conn->query($update_query)) {
        echo "<script>alert('Product updated successfully!'); window.location.href='view_product.php';</script>";
    } else {
        echo "<script>alert('Error updating product: " . $conn->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <!-- Include the header for navigation -->
    <?php include 'templates/header.php'; ?>

    <div class="form-container">
        <h2>Edit Product</h2>
        <form method="POST" action="">
            <input type="text" name="name" placeholder="Product Name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
            <input type="number" name="price" placeholder="Price" value="<?php echo htmlspecialchars($product['price']); ?>" required>
            <input type="number" name="quantity" placeholder="Quantity" value="<?php echo htmlspecialchars($product['quantity']); ?>" required>
            <input type="text" name="brand" placeholder="Brand" value="<?php echo htmlspecialchars($product['brand']); ?>" required>
            <input type="text" name="supplier" placeholder="Supplier" value="<?php echo htmlspecialchars($product['supplier']); ?>" required>
            <input type="text" name="category" placeholder="Category" value="<?php echo htmlspecialchars($product['category']); ?>" required>
            <button type="submit">Update</button>
        </form>
    </div>

    <script src="js/script.js"></script>
</body>
</html>
