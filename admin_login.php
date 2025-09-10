<?php
session_start();
include('includes/db_connect.php');
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email' AND user_type='admin'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['user_type'] = $row['user_type'];
            header("Location: admin_dashboard.php");
            exit();
        } else {
            $message = "Invalid password.";
        }
    } else {
        $message = "Invalid email or you are not an administrator.";
    }
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Admin Login</h1>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <div class="main-content">
        <div class="container">
        <h2>Login to your administrator account</h2>
        <p><?php echo $message; ?></p>
        <form action="admin_login.php" method="post">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit" class="btn">Login</button>
        </form>
        <p>Don't have an admin account? <a href="admin_register.php">Register here</a>.</p>
          </div>
    </div>
</body>
</html>