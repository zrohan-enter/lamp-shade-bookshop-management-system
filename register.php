<?php
include('includes/db_connect.php');
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Insert user with 'customer' user_type
    $sql = "INSERT INTO users (name, email, password, user_type) VALUES ('$name', '$email', '$password', 'customer')";

    if ($conn->query($sql) === TRUE) {
        $message = "Registration successful! You can now log in.";
    } else {
        // Check for duplicate email error
        if ($conn->errno == 1062) { // MySQL error code for duplicate entry
            $message = "Error: This email is already registered. Please use a different one.";
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
    <title>Register</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Register</h1>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <div class="container">
        <h2>Create an Account</h2>
        <p><?php echo $message; ?></p>
        <form action="register.php" method="post">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit" class="btn">Register</button>
        </form>
        <p>Already have an account? <a href="login_choice.php">Login here</a>.</p>
    </div>
</body>
</html>