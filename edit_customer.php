<?php
include 'db.php';

// Check if the ID is set in the URL and is a valid integer
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $customer_id = intval($_GET['id']); // Convert to integer

    // Fetch the customer details
    $query = "SELECT * FROM customers WHERE id = $customer_id";
    $result = $conn->query($query);

    // Check if the query was successful
    if (!$result) {
        die("Query failed: " . $conn->error);
    }

    $customer = $result->fetch_assoc();

    // Check if a customer was found
    if (!$customer) {
        die("Customer not found.");
    }
} else {
    die("Invalid customer ID.");
}

// Update customer details if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];

    $update_query = "UPDATE customers SET name='$name', gender='$gender', contact='$contact', email='$email' WHERE id=$customer_id";
    if ($conn->query($update_query)) {
        echo "<script>alert('Customer updated successfully!'); window.location.href='view_cutomers.php';</script>";
    } else {
        echo "<script>alert('Error updating customer: " . $conn->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Customer</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <!-- Include the header for navigation -->
    <?php include 'templates/header.php'; ?>

    <div class="form-container">
        <h2>Edit Customer</h2>
        <form method="POST" action="">
            <input type="text" name="name" placeholder="Name" value="<?php echo htmlspecialchars($customer['name']); ?>" required>
            <input type="text" name="gender" placeholder="Gender" value="<?php echo htmlspecialchars($customer['gender']); ?>" required>
            <input type="text" name="contact" placeholder="Contact" value="<?php echo htmlspecialchars($customer['contact']); ?>" required>
            <input type="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($customer['email']); ?>" required>
            <button type="submit">Update</button>
        </form>
    </div>

    <script src="js/script.js"></script>
</body>
</html>
