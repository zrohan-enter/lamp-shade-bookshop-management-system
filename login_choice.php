<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .login-choice-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            margin-top: 50px;
        }
        .login-choice-container a {
            flex: 1;
            max-width: 200px;
            text-align: center;
            padding: 20px;
            border: 1px solid #ccc;
            background: #fff;
            text-decoration: none;
            color: #333;
        }
        .login-choice-container a:hover {
            background: #eee;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <h1>Login</h1>
        </div>
   </header>
    <div class="main-content">
        <div class="container">
        <h2>Choose your login type</h2>
        <div class="login-choice-container">
            <a href="login.php" class="btn">Customer Login</a>
            <a href="admin_login.php" class="btn">Admin Login</a>
        <</div>
    </div>
</body>
</html>