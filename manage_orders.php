<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: login_choice.php"); // Redirect to login choice if not admin
    exit();
}
include('includes/db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_status'])) {
    $order_id = $conn->real_escape_string($_POST['order_id']);
    $new_status = $conn->real_escape_string($_POST['new_status']);
    $sql = "UPDATE orders SET status = '$new_status' WHERE order_id = '$order_id'";
    if ($conn->query($sql) === TRUE) {
        $message = "Order status updated successfully!";
    } else {
        $message = "Error updating order status: " . $conn->error;
    }
}

// Fetch all orders
$sql = "SELECT o.*, u.name as customer_name FROM orders o JOIN users u ON o.user_id = u.user_id ORDER BY o.order_date DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Orders</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <h1>Manage Orders</h1>
            <nav>
                <ul>
                    <li><a href="admin_dashboard.php">Dashboard</a></li> <!-- Added Dashboard button -->
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <div class="main-content">
        <div class="container">
        <h2>All Orders</h2>
        <?php if (!empty($message)) echo "<p>$message</p>"; ?>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['order_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['customer_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['order_date']); ?></td>
                            <td><?php echo htmlspecialchars($row['status']); ?></td>
                            <td>
                                <form action="manage_orders.php" method="POST" style="display: inline-block;">
                                    <input type="hidden" name="order_id" value="<?php echo $row['order_id']; ?>">
                                    <select name="new_status">
                                        <option value="pending" <?php if ($row['status'] == 'pending') echo 'selected'; ?>>Pending</option>
                                        <option value="shipped" <?php if ($row['status'] == 'shipped') echo 'selected'; ?>>Shipped</option>
                                        <option value="delivered" <?php if ($row['status'] == 'delivered') echo 'selected'; ?>>Delivered</option>
                                    </select>
                                    <button type="submit" name="update_status" class="btn">Update Status</button>
                                </form>
                                <a href="generate_receipt.php?order_id=<?php echo $row['order_id']; ?>" class="btn">Generate Receipt</a>
                            </td>
                        </tr>
                    <?php endwhile;
                } else {
                    echo "<tr><td colspan='5'>No orders found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
       </div>
    </div>
</body>
</html>