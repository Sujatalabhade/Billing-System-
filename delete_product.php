<?php
include 'db.php';

// Check if the ID is set in the URL
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Delete the product from the database
    $query = "DELETE FROM products WHERE id = $product_id";
    if ($conn->query($query)) {
        echo "<script>alert('Product deleted successfully!'); window.location.href='view_product.php';</script>";
    } else {
        echo "<script>alert('Error deleting product: " . $conn->error . "'); window.location.href='view_product.php';</script>";
    }
}
?>
