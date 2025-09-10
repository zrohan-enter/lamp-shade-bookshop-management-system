<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: login_choice.php"); // Redirect to login choice if not admin
    exit();
}
include('includes/db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_inventory'])) {
    $book_id = $conn->real_escape_string($_POST['book_id']);
    $new_stock = $conn->real_escape_string($_POST['stock_quantity']);
    $sql = "UPDATE books SET stock_quantity = '$new_stock' WHERE book_id = '$book_id'";
    if ($conn->query($sql) === TRUE) {
        $message = "Inventory updated successfully!";
    } else {
        $message = "Error updating inventory: " . $conn->error;
    }
}

// Fetch all books for inventory view
$sql = "SELECT * FROM books";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Inventory</title>
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
            <h1>Manage Inventory</h1>
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
        <h2>Book Inventory</h2>
        <?php if (!empty($message)) echo "<p>$message</p>"; ?>
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Current Stock</th>
                    <th>Update Stock</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['title']); ?></td>
                            <td><?php echo htmlspecialchars($row['stock_quantity']); ?></td>
                            <td>
                                <form action="manage_inventory.php" method="POST">
                                    <input type="hidden" name="book_id" value="<?php echo $row['book_id']; ?>">
                                    <input type="number" name="stock_quantity" value="<?php echo htmlspecialchars($row['stock_quantity']); ?>" min="0">
                                    <button type="submit" name="update_inventory" class="btn">Update</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile;
                } else {
                    echo "<tr><td colspan='3'>No books found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
         </div>
    </div>
</body>
</html>