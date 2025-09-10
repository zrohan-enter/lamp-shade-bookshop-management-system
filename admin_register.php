<?php
include('includes/db_connect.php');
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

    // Insert user with 'admin' user_type
    $sql = "INSERT INTO users (name, email, password, user_type) VALUES ('$name', '$email', '$password', 'admin')";

    if ($conn->query($sql) === TRUE) {
        $message = "Admin registration successful! You can now log in as an admin.";
    } else {
        // Check for duplicate email error
        if ($conn->errno == 1062) { // MySQL error code for duplicate entry
            $message = "Error: This email is already registered.";
        } else {
            $message = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Register</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Admin Registration</h1>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="admin_login.php">Admin Login</a></li>
                </ul>
            </nav>
        </div>
    <</header>
    <div class="main-content">
        <div class="container">
        <h2>Register a New Administrator Account</h2>
        <p><?php echo $message; ?></p>
        <form action="admin_register.php" method="post">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit" class="btn">Register Admin</button>
        </form>
        <p>Already have an admin account? <a href="admin_login.php">Login here</a>.</p>
           </div>
    </div>
</body>
</html>