<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
include('includes/db_connect.php');

$message = "";
$user_id = $_SESSION['user_id'];

// Fetch current user data
$sql = "SELECT name, email FROM users WHERE user_id = '$user_id'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

// Handle profile update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    
    $update_sql = "UPDATE users SET name = '$name', email = '$email' WHERE user_id = '$user_id'";
    
    if ($conn->query($update_sql) === TRUE) {
        $message = "Profile updated successfully!";
        // Refresh user data
        $result = $conn->query($sql);
        $user = $result->fetch_assoc();
    } else {
        $message = "Error updating profile: " . $conn->error;
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Profile</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>User Profile</h1>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="cart.php">Shopping Cart</a></li>
                    <li><a href="order_history.php">Order History</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <div class="main-content">
        <div class="container">
        <h2>Update Your Profile</h2>
        <?php if (!empty($message)) echo "<p>$message</p>"; ?>
        <form action="profile.php" method="post">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            <button type="submit" class="btn">Update Profile</button>
        </form>
       </div>
    </div>
</body>
</html>