<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: login_choice.php"); // Redirect to login choice if not admin
    exit();
}
include('includes/db_connect.php');

$message = "";

// Handle add, update, or delete actions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_book'])) {
        $title = $conn->real_escape_string($_POST['title']);
        $author = $conn->real_escape_string($_POST['author']);
        $genre = $conn->real_escape_string($_POST['genre']);
        $isbn = $conn->real_escape_string($_POST['ISBN']);
        $price = $conn->real_escape_string($_POST['price']);
        $stock_quantity = $conn->real_escape_string($_POST['stock_quantity']);
        $cover_image = '';

        // Handle file upload
        if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] == 0) {
            $target_dir = "images/";
            $target_file = $target_dir . basename($_FILES["cover_image"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $uploadOk = 1;

            // Check if image file is a actual image or fake image
            $check = getimagesize($_FILES["cover_image"]["tmp_name"]);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                $message .= "File is not an image.<br>";
                $uploadOk = 0;
            }

            // Check file size
            if ($_FILES["cover_image"]["size"] > 500000) {
                $message .= "Sorry, your file is too large.<br>";
                $uploadOk = 0;
            }

            // Allow certain file formats
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                $message .= "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br>";
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                $message .= "Sorry, your file was not uploaded.<br>";
            } else {
                if (move_uploaded_file($_FILES["cover_image"]["tmp_name"], $target_file)) {
                    $cover_image = basename($_FILES["cover_image"]["name"]);
                } else {
                    $message .= "Sorry, there was an error uploading your file.<br>";
                }
            }
        }

        if ($uploadOk == 1) {
            $sql = "INSERT INTO books (title, author, genre, ISBN, price, stock_quantity, cover_image) VALUES ('$title', '$author', '$genre', '$isbn', '$price', '$stock_quantity', '$cover_image')";
            if ($conn->query($sql) === TRUE) {
                $message .= "New book added successfully!<br>";
            } else {
                $message .= "Error adding book: " . $conn->error . "<br>";
            }
        }
    } elseif (isset($_POST['update_book'])) {
        $book_id = $conn->real_escape_string($_POST['book_id']);
        $title = $conn->real_escape_string($_POST['title']);
        $author = $conn->real_escape_string($_POST['author']);
        $genre = $conn->real_escape_string($_POST['genre']);
        $isbn = $conn->real_escape_string($_POST['ISBN']);
        $price = $conn->real_escape_string($_POST['price']);
        $stock_quantity = $conn->real_escape_string($_POST['stock_quantity']);
        $cover_image = $conn->real_escape_string($_POST['current_cover']); // Keep current image by default

        // Handle new file upload for update
        if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] == 0) {
            $target_dir = "images/";
            $target_file = $target_dir . basename($_FILES["cover_image"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $uploadOk = 1;

            // Check if image file is a actual image or fake image
            $check = getimagesize($_FILES["cover_image"]["tmp_name"]);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                $message .= "File is not an image.<br>";
                $uploadOk = 0;
            }

            // Check file size
            if ($_FILES["cover_image"]["size"] > 500000) {
                $message .= "Sorry, your file is too large.<br>";
                $uploadOk = 0;
            }

            // Allow certain file formats
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                $message .= "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br>";
                $uploadOk = 0;
            }

            if ($uploadOk == 1) {
                if (move_uploaded_file($_FILES["cover_image"]["tmp_name"], $target_file)) {
                    $cover_image = basename($_FILES["cover_image"]["name"]);
                } else {
                    $message .= "Sorry, there was an error uploading the new file.<br>";
                    $uploadOk = 0;
                }
            }
        }
        
        if ($uploadOk == 1) {
            $sql = "UPDATE books SET title='$title', author='$author', genre='$genre', ISBN='$isbn', price='$price', stock_quantity='$stock_quantity', cover_image='$cover_image' WHERE book_id='$book_id'";
            if ($conn->query($sql) === TRUE) {
                $message .= "Book updated successfully!<br>";
            } else {
                $message .= "Error updating book: " . $conn->error . "<br>";
            }
        }
    } elseif (isset($_GET['delete_id'])) {
        $book_id = $conn->real_escape_string($_GET['delete_id']);
        $sql = "DELETE FROM books WHERE book_id='$book_id'";
        if ($conn->query($sql) === TRUE) {
            $message .= "Book deleted successfully!<br>";
        } else {
            $message .= "Error deleting book: " . $conn->error . "<br>";
        }
    }
}

// Fetch all books for display
$sql_books = "SELECT * FROM books";
$result_books = $conn->query($sql_books);
$edit_book = null;
if (isset($_GET['edit_id'])) {
    $edit_id = $conn->real_escape_string($_GET['edit_id']);
    $sql_edit = "SELECT * FROM books WHERE book_id = '$edit_id'";
    $result_edit = $conn->query($sql_edit);
    if ($result_edit->num_rows > 0) {
        $edit_book = $result_edit->fetch_assoc();
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Books</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .form-container {
            margin-bottom: 30px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .form-container h2 {
            margin-top: 0;
        }
        .form-container input[type="text"],
        .form-container input[type="number"],
        .form-container input[type="file"],
        .form-container textarea,
        .form-container select {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-container button {
            padding: 10px 20px;
            background-color: #333;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .book-actions a {
            margin-right: 5px;
            color: #337ab7;
            text-decoration: none;
        }
        .book-actions a.delete {
            color: #d9534f;
        }
        img.cover-thumb {
            width: 50px;
            height: auto;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <h1>Manage Books</h1>
            <nav>
                <ul>
                    <li><a href="admin_dashboard.php">Dashboard</a></li>
                    <li><a href="manage_inventory.php">Manage Inventory</a></li>
                    <li><a href="manage_orders.php">Manage Orders</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container">
        <h2><?php echo $edit_book ? 'Edit Book' : 'Add New Book'; ?></h2>
        <?php if (!empty($message)) echo "<p>$message</p>"; ?>
        <div class="form-container">
            <form action="manage_books.php" method="post" enctype="multipart/form-data">
                <?php if ($edit_book): ?>
                    <input type="hidden" name="book_id" value="<?php echo htmlspecialchars($edit_book['book_id']); ?>">
                    <input type="hidden" name="current_cover" value="<?php echo htmlspecialchars($edit_book['cover_image']); ?>">
                <?php endif; ?>
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($edit_book['title'] ?? ''); ?>" required>
                <label for="author">Author:</label>
                <input type="text" id="author" name="author" value="<?php echo htmlspecialchars($edit_book['author'] ?? ''); ?>" required>
                <label for="genre">Genre:</label>
                <input type="text" id="genre" name="genre" value="<?php echo htmlspecialchars($edit_book['genre'] ?? ''); ?>">
                <label for="ISBN">ISBN:</label>
                <input type="text" id="ISBN" name="ISBN" value="<?php echo htmlspecialchars($edit_book['ISBN'] ?? ''); ?>">
                <label for="price">Price:</label>
                <input type="number" id="price" name="price" step="0.01" value="<?php echo htmlspecialchars($edit_book['price'] ?? ''); ?>" required>
                <label for="stock_quantity">Stock Quantity:</label>
                <input type="number" id="stock_quantity" name="stock_quantity" value="<?php echo htmlspecialchars($edit_book['stock_quantity'] ?? ''); ?>" required>
                <label for="cover_image">Cover Image (optional):</label>
                <input type="file" id="cover_image" name="cover_image">
                <?php if ($edit_book && !empty($edit_book['cover_image'])): ?>
                    <p>Current Image: <img src="images/<?php echo htmlspecialchars($edit_book['cover_image']); ?>" alt="Current Cover" style="width: 50px; height: auto;"></p>
                <?php endif; ?>
                <button type="submit" name="<?php echo $edit_book ? 'update_book' : 'add_book'; ?>" class="btn"><?php echo $edit_book ? 'Update Book' : 'Add Book'; ?></button>
                <?php if ($edit_book): ?>
                    <a href="manage_books.php" class="btn">Cancel</a>
                <?php endif; ?>
            </form>
        </div>
        
        <h2>Current Books</h2>
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>ISBN</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result_books->num_rows > 0): ?>
                    <?php while ($row = $result_books->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['title']); ?></td>
                            <td><?php echo htmlspecialchars($row['author']); ?></td>
                            <td><?php echo htmlspecialchars($row['ISBN']); ?></td>
                            <td>$<?php echo number_format($row['price'], 2); ?></td>
                            <td><?php echo htmlspecialchars($row['stock_quantity']); ?></td>
                            <td><img src="images/<?php echo htmlspecialchars($row['cover_image']); ?>" alt="Cover" class="cover-thumb"></td>
                            <td class="book-actions">
                                <a href="manage_books.php?edit_id=<?php echo htmlspecialchars($row['book_id']); ?>">Edit</a>
                                <a href="manage_books.php?delete_id=<?php echo htmlspecialchars($row['book_id']); ?>" onclick="return confirm('Are you sure you want to delete this book?');" class="delete">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">No books found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>