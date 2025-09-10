<?php
session_start();
include('includes/db_connect.php');

// Initialize cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Add item to cart
if (isset($_POST['add_to_cart'])) {
    $book_id = $_POST['book_id'];
    if (isset($_SESSION['cart'][$book_id])) {
        $_SESSION['cart'][$book_id]++;
    } else {
        $_SESSION['cart'][$book_id] = 1;
    }
}

// Remove item from cart
if (isset($_POST['remove_from_cart'])) {
    $book_id = $_POST['book_id'];
    unset($_SESSION['cart'][$book_id]);
}

// Update quantity
if (isset($_POST['update_quantity'])) {
    $book_id = $_POST['book_id'];
    $quantity = $_POST['quantity'];
    if ($quantity > 0) {
        $_SESSION['cart'][$book_id] = $quantity;
    } else {
        unset($_SESSION['cart'][$book_id]);
    }
}

// Checkout process
if (isset($_POST['checkout']) && isset($_SESSION['user_id']) && !empty($_SESSION['cart'])) {
    // Start transaction for ACID standards [cite: 17]
    $conn->begin_transaction();
    $user_id = $_SESSION['user_id'];
    $sql = "INSERT INTO orders (user_id) VALUES ('$user_id')";
    
    if ($conn->query($sql) === TRUE) {
        $order_id = $conn->insert_id;
        $all_items_processed = true;
        foreach ($_SESSION['cart'] as $book_id => $quantity) {
            $book_sql = "SELECT price, stock_quantity FROM books WHERE book_id = '$book_id' FOR UPDATE";
            $book_result = $conn->query($book_sql)->fetch_assoc();
            
            if ($book_result && $book_result['stock_quantity'] >= $quantity) {
                $price = $book_result['price'];
                $insert_item_sql = "INSERT INTO order_items (order_id, book_id, quantity, price) VALUES ('$order_id', '$book_id', '$quantity', '$price')";
                $update_stock_sql = "UPDATE books SET stock_quantity = stock_quantity - '$quantity' WHERE book_id = '$book_id'";
                
                if (!$conn->query($insert_item_sql) || !$conn->query($update_stock_sql)) {
                    $all_items_processed = false;
                    break;
                }
            } else {
                $all_items_processed = false;
                break;
            }
        }
        
        if ($all_items_processed) {
            $conn->commit();
            $_SESSION['cart'] = [];
            header("Location: order_confirmation.php?order_id=$order_id");
            exit();
        } else {
            $conn->rollback();
            $message = "Error during checkout or insufficient stock. Please try again.";
        }
    } else {
        $conn->rollback();
        $message = "Error creating order.";
    }
} else if (isset($_POST['checkout']) && !isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$cart_items = [];
$total_price = 0;
if (!empty($_SESSION['cart'])) {
    $book_ids = implode(',', array_keys($_SESSION['cart']));
    $sql = "SELECT book_id, title, price, cover_image FROM books WHERE book_id IN ($book_ids)";
    $result = $conn->query($sql);
    while ($book = $result->fetch_assoc()) {
        $quantity = $_SESSION['cart'][$book['book_id']];
        $book['quantity'] = $quantity;
        $book['total'] = $quantity * $book['price'];
        $total_price += $book['total'];
        $cart_items[] = $book;
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Shopping Cart</h1>
        </div>
    </header>
    <div class="main-content">
        <div class="container">
        <h2>Your Cart</h2>
        <?php if (!empty($message)) echo "<p>$message</p>"; ?>
        <div class="cart-list">
            <?php if (empty($cart_items)): ?>
                <p>Your cart is empty.</p>
            <?php else: ?>
                <?php foreach ($cart_items as $item): ?>
                    <div class="cart-item">
                        <img src="images/<?php echo $item['cover_image']; ?>" alt="Book Cover" style="width: 100px;">
                        <h3><?php echo $item['title']; ?></h3>
                        <p>Price: $<?php echo $item['price']; ?></p>
                        <form action="cart.php" method="POST">
                            <input type="hidden" name="book_id" value="<?php echo $item['book_id']; ?>">
                            <label for="quantity">Quantity:</label>
                            <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1">
                            <button type="submit" name="update_quantity" class="btn">Update</button>
                            <button type="submit" name="remove_from_cart" class="btn">Remove</button>
                        </form>
                    </div>
                <?php endforeach; ?>
                <h3>Total: $<?php echo number_format($total_price, 2); ?></h3>
                <form action="cart.php" method="POST">
                    <button type="submit" name="checkout" class="btn">Proceed to Checkout</button>
                </form>
            <?php endif; ?>
       </div>
    </div>
</body>
</html>