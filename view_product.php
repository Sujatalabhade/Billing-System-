<?php
include 'db.php';

// Query to fetch all products
$query = "SELECT * FROM products";
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
    <title>View Products</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <!-- Include the header for navigation -->
    <?php include 'templates/header.php'; ?>

    <div class="table-container">
        <h2>Products</h2>
        <table>
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Brand</th>
                <th>Supplier</th>
                <th>Actions</th>
            </tr>

            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <!-- Debug each field -->
                    <td><?php echo "" . htmlspecialchars($row['name']); ?></td>
                    <td><?php echo "" . htmlspecialchars($row['price']); ?></td>
                    <td><?php echo "" . htmlspecialchars($row['quantity']); ?></td>
                    <td><?php echo "" . htmlspecialchars($row['brand']); ?></td>
                    <td><?php echo "" . htmlspecialchars($row['supplier']); ?></td>
                    <td>
                        <a href="edit_product.php?id=<?= $row['id']; ?>">Edit</a>
                        <a href="delete_product.php?id=<?= $row['id']; ?>">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <!-- If no products were found -->
                <tr>
                    <td colspan="6">No products found.</td>
                </tr>
            <?php endif; ?>
        </table>
    </div>

    <script src="js/script.js"></script>
</body>
</html>
