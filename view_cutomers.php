<?php
include 'db.php';

// Query to fetch all customers
$query = "SELECT * FROM customers";
$result = $conn->query($query);

// Check if the query was successful
if (!$result) {
    die("Query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Customers</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <!-- Include the header for navigation -->
    <?php include 'templates/header.php'; ?>

    <div class="table-container">
        <h2>Customers</h2>
        <table>
            <tr>
                <th>Name</th>
                <th>Gender</th>
                <th>Contact</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>

            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <!-- Debug each field -->
                    <td><?php echo "" . htmlspecialchars($row['name']); ?></td>
                    <td><?php echo "" . htmlspecialchars($row['gender']); ?></td>
                    <td><?php echo "" . htmlspecialchars($row['contact']); ?></td>
                    <td><?php echo "" . htmlspecialchars($row['email']); ?></td>
                    <td>
                        <a href="edit_customer.php?id=<?= $row['id']; ?>">Edit</a>
                        <a href="delete_customer.php?id=<?= $row['id']; ?>">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No customers found.</td>
                </tr>
            <?php endif; ?>
        </table>
    </div>

    <script src="js/script.js"></script>
</body>
</html>
