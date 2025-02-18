<?php
session_start(); // Start the session
include 'db.php'; // Include database connection

// Fetch customers for the dropdown
$customers_query = "SELECT * FROM customers";
$customers_result = $conn->query($customers_query);

// Fetch products for the dropdown
$products_query = "SELECT * FROM products";
$products_result = $conn->query($products_query);

// Check if the queries were successful
if (!$customers_result || !$products_result) {
    die("Error fetching data: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billing System</title>
    <link rel="stylesheet" href="css/style.css"> <!-- Link to your CSS file -->
</head>
<body>

    <!-- Include the header for navigation -->
    <?php include 'templates/header.php'; ?>

    <div class="form-container">
        <h2>Billing System</h2>
        <form method="POST" action="">
            <!-- Customer dropdown -->
            <label for="customer_id">Select Customer:</label>
            <select name="customer_id" required>
                <option value="">Select Customer</option>
                <?php
                while ($customer = $customers_result->fetch_assoc()) {
                    echo "<option value='{$customer['id']}'>{$customer['name']}</option>";
                }
                ?>
            </select>

            <!-- Products dropdown -->
            <label for="product_id">Select Products:</label>
            <select name="product_ids[]" required>
                <option value="">Select Product</option>
                <?php
                while ($product = $products_result->fetch_assoc()) {
                    echo "<option value='{$product['id']}'>{$product['name']} - $ {$product['price']}</option>";
                }
                ?>
            </select>

            <!-- Quantities input -->
            <label for="quantities">Enter Quantities:</label>
            <input type="text" name="quantities[]" placeholder="Enter Quantity for selected products" required>

            <!-- Submit button -->
            <button type="submit">Generate Bill</button>
        </form>
    </div>

    <?php
    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Fetch form data
        $customer_id = $_POST['customer_id'];
        $product_ids = $_POST['product_ids']; // An array of selected product IDs
        $quantities = $_POST['quantities']; // An array of corresponding quantities

        // Validate customer_id
        if (empty($customer_id)) {
            die("Customer ID is not set.");
        }

        // Validate product_ids
        foreach ($product_ids as $product_id) {
            if (empty($product_id)) {
                die("Invalid product ID: $product_id");
            }
        }

        // Calculate total amount
        $total_amount = 0;

        foreach ($product_ids as $index => $product_id) {
            // Check if product_id is valid
            if (!is_numeric($product_id)) {
                die("Invalid product ID: $product_id");
            }

            // Fetch the product price
            $query = "SELECT price FROM products WHERE id = $product_id";
            $result = $conn->query($query);

            // Check if the query was successful
            if (!$result) {
                die("Error fetching product price: " . $conn->error);
            }

            // Check if a product price was found
            if ($row = $result->fetch_assoc()) {
                $total_amount += $row['price'] * $quantities[$index]; // Calculate total amount
            } else {
                die("Product with ID $product_id not found.");
            }
        }

        // Insert billing record
        $insert_query = "INSERT INTO bills (customer_id, total_amount) VALUES ('$customer_id', '$total_amount')";
        if ($conn->query($insert_query)) {
            $bill_id = $conn->insert_id;

            // Insert bill items
            foreach ($product_ids as $index => $product_id) {
                $quantity = $quantities[$index];
                $price_query = "SELECT price FROM products WHERE id = $product_id";
                $price_result = $conn->query($price_query);

                if ($price_row = $price_result->fetch_assoc()) {
                    $price = $price_row['price'];
                    $insert_item_query = "INSERT INTO bill_items (bill_id, product_id, quantity, price) VALUES ('$bill_id', '$product_id', '$quantity', '$price')";
                    if (!$conn->query($insert_item_query)) {
                        die("Error inserting bill item: " . $conn->error);
                    }
                } else {
                    die("Product with ID $product_id not found during billing.");
                }
            }

            // Store data in session variables for summary page
            $_SESSION['customer_id'] = $customer_id;
            $_SESSION['product_ids'] = $product_ids;
            $_SESSION['quantities'] = $quantities;
            $_SESSION['total_amount'] = $total_amount;
            $_SESSION['bill_id'] = $bill_id;

            // Redirect to the billing summary page
            if (!headers_sent()) {
                header("Location: billing_summary.php");
                exit;
            } else {
                die("Headers already sent. Cannot redirect.");
            }
        } else {
            die("Error generating bill: " . $conn->error);
        }
    }
    ?>

</body>
</html>
