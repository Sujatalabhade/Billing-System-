<?php
include 'db.php';

// Check if the ID is set in the URL
if (isset($_GET['id'])) {
    $customer_id = $_GET['id'];

    // Delete the customer from the database
    $query = "DELETE FROM customers WHERE id = $customer_id";
    if ($conn->query($query)) {
        echo "<script>alert('Customer deleted successfully!'); window.location.href='view_cutomers.php';</script>";
    } else {
        echo "<script>alert('Error deleting customer: " . $conn->error . "'); window.location.href='view_cutomers.php';</script>";
    }
}
?>
