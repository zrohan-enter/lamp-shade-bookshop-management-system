<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: login_choice.php"); // Redirect to login choice if not admin
    exit();
}
include('includes/db_connect.php');

if (!isset($_GET['order_id'])) {
    die("No order specified.");
}

$order_id = $conn->real_escape_string($_GET['order_id']);

// Fetch order details
$sql = "SELECT o.*, u.name, u.email FROM orders o JOIN users u ON o.user_id = u.user_id WHERE o.order_id = '$order_id'";
$order_result = $conn->query($sql);
$order = $order_result->fetch_assoc();

if (!$order) {
    die("Order not found.");
}

// Fetch order items
$items_sql = "SELECT oi.*, b.title FROM order_items oi JOIN books b ON oi.book_id = b.book_id WHERE oi.order_id = '$order_id'";
$items_result = $conn->query($items_sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sales Receipt</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Special styles for printing */
        @media print {
            body {
                background: none;
                font-size: 12pt;
            }
            .no-print {
                display: none;
            }
        }
        .receipt {
            border: 1px solid #000;
            padding: 20px;
            margin: 20px;
            background: #fff;
        }
        .receipt table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .receipt th, .receipt td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .receipt th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <header class="no-print">
        <div class="container">
            <h1>Sales Receipt</h1>
            <nav>
                <ul>
                    <li><a href="admin_dashboard.php">Dashboard</a></li> <li><a href="manage_orders.php">Back to Orders</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <div class="main-content">
        <div class="container no-print">
            <button onclick="window.print()" class="btn">Print Receipt</button>
        </div>
        <div class="receipt container">
            <h2>Sales Receipt</h2>
            <p><strong>Order ID:</strong> <?php echo htmlspecialchars($order['order_id']); ?></p>
            <p><strong>Date:</strong> <?php echo htmlspecialchars($order['order_date']); ?></p>
            <p><strong>Customer:</strong> <?php echo htmlspecialchars($order['name']); ?> (<?php echo htmlspecialchars($order['email']); ?>)</p>
            <hr>
            <h3>Order Items</h3>
            <table>
                <thead>
                    <tr>
                        <th>Book Title</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $total = 0; while ($item = $items_result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['title']); ?></td>
                            <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                            <td>$<?php echo number_format($item['price'], 2); ?></td>
                            <td>$<?php echo number_format($item['quantity'] * $item['price'], 2); ?></td>
                        </tr>
                    <?php $total += $item['quantity'] * $item['price']; endwhile; ?>
                </tbody>
            </table>
            <hr>
            <h3>Total Cost: $<?php echo number_format($total, 2); ?></h3>
        </div>
    </div>
</body>
</html>