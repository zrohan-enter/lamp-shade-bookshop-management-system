<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
include('includes/db_connect.php');

$user_id = $_SESSION['user_id'];
$sql = "SELECT o.order_id, o.order_date, o.status, SUM(oi.quantity * oi.price) as total_price
        FROM orders o
        JOIN order_items oi ON o.order_id = oi.order_id
        WHERE o.user_id = '$user_id'
        GROUP BY o.order_id
        ORDER BY o.order_date DESC";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order History</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Order History</h1>
        </div>
   </header>
    <div class="main-content">
        <div class="container">
        <h2>Your Orders</h2>
        <div class="order-history">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($order = $result->fetch_assoc()): ?>
                    <div class="order-item">
                        <h3>Order #<?php echo $order['order_id']; ?></h3>
                        <p>Date: <?php echo $order['order_date']; ?></p>
                        <p>Status: <?php echo $order['status']; ?></p>
                        <p>Total: $<?php echo number_format($order['total_price'], 2); ?></p>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>You have no past orders.</p>
            <?php endif; ?>
           </div>
    </div>
</body>
</html>