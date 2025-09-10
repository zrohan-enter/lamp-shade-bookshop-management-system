<?php
session_start();
// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: login_choice.php");
    exit();
}

// Database connection
include('includes/db_connect.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get date range filter
$date_from = $_GET['date_from'] ?? date('Y-m-01'); // Default to first day of current month
$date_to = $_GET['date_to'] ?? date('Y-m-d'); // Default to today

// Total sales summary
$date_from_safe = $conn->real_escape_string($date_from);
$date_to_safe = $conn->real_escape_string($date_to);

$total_sales_query = "SELECT 
    COUNT(DISTINCT o.order_id) as total_orders,
    COUNT(DISTINCT o.user_id) as total_customers,
    SUM(oi.quantity * oi.price) as total_revenue,
    AVG(order_total.total_amount) as average_order_value
    FROM orders o 
    JOIN order_items oi ON o.order_id = oi.order_id
    JOIN (
        SELECT order_id, SUM(quantity * price) AS total_amount
        FROM order_items
        GROUP BY order_id
    ) AS order_total ON o.order_id = order_total.order_id
    WHERE DATE(o.order_date) BETWEEN '$date_from_safe' AND '$date_to_safe'";
$sales_summary_result = $conn->query($total_sales_query);
$sales_summary = $sales_summary_result->fetch_assoc();

// Top selling books
$top_books_query = "SELECT 
    b.title,
    b.author,
    b.price,
    SUM(oi.quantity) as total_sold,
    SUM(oi.quantity * oi.price) as revenue
    FROM order_items oi
    JOIN books b ON oi.book_id = b.book_id
    JOIN orders o ON oi.order_id = o.order_id
    WHERE DATE(o.order_date) BETWEEN '$date_from_safe' AND '$date_to_safe'
    GROUP BY b.book_id
    ORDER BY total_sold DESC
    LIMIT 10";
$top_books_result = $conn->query($top_books_query);
$top_books = $top_books_result->fetch_all(MYSQLI_ASSOC);

// Recent orders with customer details
$recent_orders_query = "SELECT 
    o.order_id,
    o.order_date,
    o.status,
    u.name as customer_name,
    u.email as customer_email,
    COUNT(oi.order_item_id) as items_count,
    SUM(oi.quantity * oi.price) as total_amount
    FROM orders o
    JOIN users u ON o.user_id = u.user_id
    JOIN order_items oi ON o.order_id = oi.order_id
    WHERE DATE(o.order_date) BETWEEN '$date_from_safe' AND '$date_to_safe'
    GROUP BY o.order_id
    ORDER BY o.order_date DESC
    LIMIT 20";
$recent_orders_result = $conn->query($recent_orders_query);
$recent_orders = $recent_orders_result->fetch_all(MYSQLI_ASSOC);

// Monthly sales trend (last 6 months)
$monthly_sales_query = "SELECT 
    DATE_FORMAT(o.order_date, '%Y-%m') as month,
    COUNT(DISTINCT o.order_id) as orders_count,
    SUM(oi.quantity * oi.price) as monthly_revenue
    FROM orders o
    JOIN order_items oi ON o.order_id = oi.order_id
    WHERE o.order_date >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
    GROUP BY month
    ORDER BY month ASC";
$monthly_sales_result = $conn->query($monthly_sales_query);
$monthly_sales = $monthly_sales_result->fetch_all(MYSQLI_ASSOC);

// Top customers
$top_customers_query = "SELECT 
    u.name,
    u.email,
    COUNT(o.order_id) as total_orders,
    SUM(oi.quantity * oi.price) as total_spent
    FROM users u
    JOIN orders o ON u.user_id = o.user_id
    JOIN order_items oi ON o.order_id = oi.order_id
    WHERE u.user_type = 'customer' AND DATE(o.order_date) BETWEEN '$date_from_safe' AND '$date_to_safe'
    GROUP BY u.user_id
    ORDER BY total_spent DESC
    LIMIT 10";
$top_customers_result = $conn->query($top_customers_query);
$top_customers = $top_customers_result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Analytics - Bookstore</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
            color: #333;
        }
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
        }
        .nav-links {
            margin-top: 20px;
        }
        .nav-links a {
            color: white;
            text-decoration: none;
            background: rgba(255,255,255,0.2);
            padding: 10px 20px;
            border-radius: 5px;
            margin-right: 10px;
            display: inline-block;
            transition: all 0.3s ease;
        }
        .nav-links a:hover {
            background: rgba(255,255,255,0.3);
            transform: translateY(-2px);
        }
        .date-filter {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .date-filter form {
            display: flex;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
        }
        .date-filter input, .date-filter button {
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }
        .date-filter button {
            background: #667eea;
            color: white;
            border: none;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        .date-filter button:hover {
            background: #5a67d8;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
        .stat-value {
            font-size: 2.5em;
            font-weight: bold;
            color: #667eea;
            margin-bottom: 10px;
        }
        .stat-label {
            color: #666;
            font-size: 1.1em;
        }
        .content-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }
        .card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .card-header {
            background: #667eea;
            color: white;
            padding: 20px;
            font-size: 1.3em;
            font-weight: bold;
        }
        .card-content {
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        th {
            background: #f8f9ff;
            font-weight: bold;
            color: #667eea;
        }
        tr:hover {
            background: #f8f9ff;
        }
        .status-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
        }
        .status-pending {
            background: #fef3cd;
            color: #856404;
        }
        .status-shipped {
            background: #d1ecf1;
            color: #0c5460;
        }
        .status-delivered {
            background: #d4edda;
            color: #155724;
        }
        .full-width {
            grid-column: 1 / -1;
        }
        .no-data {
            text-align: center;
            color: #666;
            font-style: italic;
            padding: 40px;
        }
        @media (max-width: 768px) {
            .content-grid {
                grid-template-columns: 1fr;
            }
            .date-filter form {
                flex-direction: column;
                align-items: stretch;
            }
            .container {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📊 Admin Analytics Dashboard</h1>
            <p>Comprehensive sales and customer analytics for your bookstore</p>
            <div class="nav-links">
                <a href="admin_dashboard.php">← Back to Dashboard</a>
                <a href="manage_books.php">Manage Books</a>
                <a href="manage_orders.php">Manage Orders</a>
                <a href="logout.php">Logout</a>
            </div>
        </div>
        <div class="date-filter">
            <form method="GET">
                <label>From:</label>
                <input type="date" name="date_from" value="<?php echo htmlspecialchars($date_from); ?>">
                <label>To:</label>
                <input type="date" name="date_to" value="<?php echo htmlspecialchars($date_to); ?>">
                <button type="submit">Filter Results</button>
            </form>
        </div>
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-value"><?php echo number_format($sales_summary['total_orders'] ?? 0); ?></div>
                <div class="stat-label">Total Orders</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">$<?php echo number_format($sales_summary['total_revenue'] ?? 0, 2); ?></div>
                <div class="stat-label">Total Revenue</div>
            </div>
            <div class="stat-card">
                <div class="stat-value"><?php echo number_format($sales_summary['total_customers'] ?? 0); ?></div>
                <div class="stat-label">Unique Customers</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">$<?php echo number_format($sales_summary['average_order_value'] ?? 0, 2); ?></div>
                <div class="stat-label">Avg Order Value</div>
            </div>
        </div>
        <div class="content-grid">
            <div class="card">
                <div class="card-header">🏆 Top Selling Books</div>
                <div class="card-content">
                    <?php if (!empty($top_books)): ?>
                        <table>
                            <thead>
                                <tr>
                                    <th>Book</th>
                                    <th>Units Sold</th>
                                    <th>Revenue</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($top_books as $book): ?>
                                    <tr>
                                        <td>
                                            <strong><?php echo htmlspecialchars($book['title']); ?></strong><br>
                                            <small>by <?php echo htmlspecialchars($book['author']); ?></small>
                                        </td>
                                        <td><?php echo number_format($book['total_sold']); ?></td>
                                        <td>$<?php echo number_format($book['revenue'], 2); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="no-data">No sales data available for the selected period.</div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="card">
                <div class="card-header">💎 Top Customers</div>
                <div class="card-content">
                    <?php if (!empty($top_customers)): ?>
                        <table>
                            <thead>
                                <tr>
                                    <th>Customer</th>
                                    <th>Orders</th>
                                    <th>Total Spent</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($top_customers as $customer): ?>
                                    <tr>
                                        <td>
                                            <strong><?php echo htmlspecialchars($customer['name']); ?></strong><br>
                                            <small><?php echo htmlspecialchars($customer['email']); ?></small>
                                        </td>
                                        <td><?php echo number_format($customer['total_orders']); ?></td>
                                        <td>$<?php echo number_format($customer['total_spent'], 2); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="no-data">No customer data available for the selected period.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="card full-width">
            <div class="card-header">📈 Recent Orders</div>
            <div class="card-content">
                <?php if (!empty($recent_orders)): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Date</th>
                                <th>Items</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recent_orders as $order): ?>
                                <tr>
                                    <td>#<?php echo $order['order_id']; ?></td>
                                    <td>
                                        <strong><?php echo htmlspecialchars($order['customer_name']); ?></strong><br>
                                        <small><?php echo htmlspecialchars($order['customer_email']); ?></small>
                                    </td>
                                    <td><?php echo date('M j, Y', strtotime($order['order_date'])); ?></td>
                                    <td><?php echo $order['items_count']; ?> items</td>
                                    <td>$<?php echo number_format($order['total_amount'], 2); ?></td>
                                    <td>
                                        <span class="status-badge status-<?php echo $order['status']; ?>">
                                            <?php echo ucfirst($order['status']); ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="no-data">No orders found for the selected period.</div>
                <?php endif; ?>
            </div>
        </div>
        <?php if (!empty($monthly_sales)): ?>
            <div class="card full-width">
                <div class="card-header">📊 Monthly Sales Trend (Last 6 Months)</div>
                <div class="card-content">
                    <table>
                        <thead>
                            <tr>
                                <th>Month</th>
                                <th>Orders</th>
                                <th>Revenue</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($monthly_sales as $month_data): ?>
                                <tr>
                                    <td><?php echo date('F Y', strtotime($month_data['month'] . '-01')); ?></td>
                                    <td><?php echo number_format($month_data['orders_count']); ?></td>
                                    <td>$<?php echo number_format($month_data['monthly_revenue'], 2); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>