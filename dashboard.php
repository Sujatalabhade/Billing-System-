<?php
include 'db.php';

// Get total sales and total revenue
$sales_query = "SELECT COUNT(id) AS total_sales FROM bills";
$sales_result = $conn->query($sales_query);
$sales_row = $sales_result->fetch_assoc();
$total_sales = $sales_row['total_sales'];

$revenue_query = "SELECT SUM(total_amount) AS total_revenue FROM bills";
$revenue_result = $conn->query($revenue_query);
$revenue_row = $revenue_result->fetch_assoc();
$total_revenue = $revenue_row['total_revenue'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <!-- Include the header for navigation -->
    <?php include 'templates/header.php'; ?>

    <div class="dashboard-container">
        <h2>Dashboard</h2>

        <div class="dashboard-cards">
            <div class="card">
                <h3>Total Sales</h3>
                <p>$<?php echo htmlspecialchars($total_sales); ?></p>
                <?php
// Set the exchange rate (e.g., 1 USD = 83 INR)
$exchange_rate = 83.00; // Example exchange rate

// Calculate the total sales in INR
$total_sales_inr = $total_sales * $exchange_rate;

// Display the amount in INR
echo '<p>₹' . htmlspecialchars(number_format($total_sales_inr, 2)) . '</p>';
?>


            </div>
            <div class="card">
                <h3>Total Revenue</h3>
                <p>$<?php echo htmlspecialchars(number_format($total_revenue, 2)); ?></p>
<?php
// Set the exchange rate (1 USD = X INR)
$exchange_rate = 83.00; // Example rate

// Calculate the amount in INR
$inr_amount = $total_revenue * $exchange_rate;

// Display the amount in INR
echo '₹' . htmlspecialchars(number_format($inr_amount, 2));
?>

            </div>
        </div>
    </div>

    <script src="js/script.js"></script>
</body>
</html>
