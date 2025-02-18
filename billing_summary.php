
<?php
session_start(); // Start the session

// Check if session variables are set
if (!isset($_SESSION['customer_id']) || !isset($_SESSION['product_ids']) || !isset($_SESSION['quantities']) || !isset($_SESSION['total_amount']) || !isset($_SESSION['bill_id'])) {
    header("Location: billing.php"); // Redirect to billing page if not set
    exit;
}

// Retrieve the data from session variables
$customer_id = $_SESSION['customer_id'];
$product_ids = $_SESSION['product_ids'];
$quantities = $_SESSION['quantities'];
$total_amount = $_SESSION['total_amount'];
$bill_id = $_SESSION['bill_id'];

// Fetch customer name from the database
include 'db.php';
$customer_query = "SELECT name FROM customers WHERE id = $customer_id";
$customer_result = $conn->query($customer_query);
$customer = $customer_result->fetch_assoc();

// Debugging: Check if customer data was fetched
if (!$customer) {
    die("Customer not found for ID: $customer_id");
}

// Fetch product details
$product_details = array(); // Initialize as array()
foreach ($product_ids as $product_id) {
    $product_query = "SELECT name, price FROM products WHERE id = $product_id";
    $product_result = $conn->query($product_query);

    if (!$product_result) {
        die("Error fetching product: " . $conn->error);
    }

    $product_row = $product_result->fetch_assoc();
    if ($product_row) {
        $product_details[] = $product_row; // Store the product details
    } else {
        die("Product not found for ID: $product_id");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billing Summary</title>
    <link rel="stylesheet" href="css/style.css"> <!-- Link to your CSS file -->
    <style>
        body {
            display: flex; /* Use flexbox to center the content */
            justify-content: center; /* Center horizontally */
            align-items: center; /* Center vertically */
            height: 100vh; /* Full height of the viewport */
            margin: 0; /* Remove default margin */
            background-color: #f9f9f9; /* Background color for the page */
        }

        .summary-container {
            text-align: center; /* Center text */
            padding: 100px; /* Padding around the container */
            border: 1px solid #ccc; /* Border around the container */
            border-radius: 10px; /* Rounded corners */
            background-color: #fff; /* White background for the summary */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
        }

        /* Button Styles */
        .generate-bill-btn {
            background-color: black; /* Black background */
            color: white; /* White text */
            padding: 10px 20px; /* Padding around text */
            border: none; /* No border */
            border-radius: 5px; /* Rounded corners */
            text-align: center; /* Center text */
            text-decoration: none; /* No underline */
            font-size: 16px; /* Font size */
            cursor: pointer; /* Pointer cursor on hover */
            transition: background-color 0.3s ease; /* Smooth background color transition */
        }
        .generate-bill-btn:hover {
            background-color: #444; /* Darker shade on hover */
        }
    </style>
</head>
<body>
    <div class="summary-container">
        <h2>Billing Summary</h2>

        <!-- Display customer name -->
        <?php
        $customer_name = htmlspecialchars($customer['name']);
        ?>
        <p><strong>Customer:</strong> <?php echo $customer_name; ?></p>

        <!-- Display bill ID -->
        <p><strong>Bill ID:</strong> <?php echo $bill_id; ?></p>

        <!-- Display total amount -->
        <p><strong>Total Amount:</strong> $<?php echo number_format($total_amount, 2); ?></p>

        <h3>Products:</h3>
        <ul>
            <!-- Check if product_details is not empty -->
            <?php if (!empty($product_details) && !empty($quantities)): ?>
                <?php foreach ($product_details as $index => $product): ?>
                    <li>
                        <?php echo htmlspecialchars($product['name']); ?> 
                        - Quantity: <?php echo htmlspecialchars($quantities[$index]); ?> 
                        - Price: $<?php echo number_format($product['price'], 2); ?>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li>No products found.</li>
            <?php endif; ?>
        </ul>

        <!-- Generate Another Bill Button -->
        <a href="billing.php" class="generate-bill-btn">Generate Another Bill</a>
    </div>

    <?php
    // Clear session variables after displaying
    session_unset();
    session_destroy();
    ?>
</body>
</html>
