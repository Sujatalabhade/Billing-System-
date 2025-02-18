<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];

    $query = "INSERT INTO customers (name, gender, contact, email) VALUES ('$name', '$gender', '$contact', '$email')";
    if ($conn->query($query)) {
        echo "<script>alert('Customer added successfully!');</script>";
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
    <title>Add Customer</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <!-- Include the header for navigation -->
    <?php include 'templates/header.php'; ?>

    <div class="form-container">
        <h2>Add Customer</h2>
        <form method="POST" action="">
            <input type="text" name="name" placeholder="Name" required>
            <input type="text" name="gender" placeholder="Gender" required>
            <input type="number" name="contact" placeholder="Contact" required>
            <input type="email" name="email" placeholder="Email" required>
            <button type="submit">Save</button>
        </form>
    </div>

    <script src="js/script.js"></script>
</body>
</html>
