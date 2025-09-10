<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    die("Access Denied. You must be logged in as an administrator.");
}

include('includes/db_connect.php');

$books_to_insert = [
    // Textbooks
    ['title' => 'Introduction to Algorithms', 'author' => 'Thomas H. Cormen, Charles E. Leiserson, Ronald L. Rivest, Clifford Stein', 'genre' => 'Textbook', 'ISBN' => '978-0262033848', 'price' => 85.00, 'stock_quantity' => 25, 'cover_image' => 'algorithms_intro.jpg'],
    ['title' => 'The Elements of Style', 'author' => 'William Strunk Jr., E.B. White', 'genre' => 'Textbook', 'ISBN' => '978-0205309023', 'price' => 10.95, 'stock_quantity' => 150, 'cover_image' => 'elements_style.jpg'],
    ['title' => 'Calculus: Early Transcendentals', 'author' => 'James Stewart', 'genre' => 'Textbook', 'ISBN' => '978-1285741550', 'price' => 125.50, 'stock_quantity' => 30, 'cover_image' => 'calculus.jpg'],
    ['title' => 'Organic Chemistry', 'author' => 'Paula Yurkanis Bruice', 'genre' => 'Textbook', 'ISBN' => '978-0321803221', 'price' => 99.99, 'stock_quantity' => 40, 'cover_image' => 'organic_chem.jpg'],
    ['title' => 'Principles of Economics', 'author' => 'N. Gregory Mankiw', 'genre' => 'Textbook', 'ISBN' => '978-1305585126', 'price' => 78.25, 'stock_quantity' => 55, 'cover_image' => 'economics.jpg'],
    // Classics
    ['title' => 'Moby Dick', 'author' => 'Herman Melville', 'genre' => 'Classic', 'ISBN' => '978-0142437247', 'price' => 14.99, 'stock_quantity' => 80, 'cover_image' => 'moby_dick.jpg'],
    ['title' => 'The Great Gatsby', 'author' => 'F. Scott Fitzgerald', 'genre' => 'Classic', 'ISBN' => '978-0743273565', 'price' => 11.50, 'stock_quantity' => 90, 'cover_image' => 'great_gatsby.jpg'],
    ['title' => 'War and Peace', 'author' => 'Leo Tolstoy', 'genre' => 'Classic', 'ISBN' => '978-1400079988', 'price' => 22.00, 'stock_quantity' => 35, 'cover_image' => 'war_and_peace.jpg'],
    ['title' => 'Crime and Punishment', 'author' => 'Fyodor Dostoevsky', 'genre' => 'Classic', 'ISBN' => '978-0486415871', 'price' => 9.95, 'stock_quantity' => 70, 'cover_image' => 'crime_punishment.jpg'],
    ['title' => 'The Odyssey', 'author' => 'Homer', 'genre' => 'Classic', 'ISBN' => '978-0140268867', 'price' => 13.75, 'stock_quantity' => 110, 'cover_image' => 'odyssey.jpg'],
    // Fiction
    ['title' => 'Dune', 'author' => 'Frank Herbert', 'genre' => 'Fiction', 'ISBN' => '978-0441172719', 'price' => 15.99, 'stock_quantity' => 120, 'cover_image' => 'dune.jpg'],
    ['title' => 'The Martian', 'author' => 'Andy Weir', 'genre' => 'Fiction', 'ISBN' => '978-0553418026', 'price' => 14.25, 'stock_quantity' => 95, 'cover_image' => 'the_martian.jpg'],
    ['title' => 'Ready Player One', 'author' => 'Ernest Cline', 'genre' => 'Fiction', 'ISBN' => '978-0307887443', 'price' => 13.50, 'stock_quantity' => 88, 'cover_image' => 'ready_player_one.jpg'],
    ['title' => 'Project Hail Mary', 'author' => 'Andy Weir', 'genre' => 'Fiction', 'ISBN' => '978-0593135204', 'price' => 16.75, 'stock_quantity' => 105, 'cover_image' => 'project_hail_mary.jpg'],
    ['title' => 'The Alchemist', 'author' => 'Paulo Coelho', 'genre' => 'Fiction', 'ISBN' => '978-0061122415', 'price' => 10.50, 'stock_quantity' => 130, 'cover_image' => 'alchemist.jpg'],
    // Novels
    ['title' => 'The Lord of the Rings', 'author' => 'J.R.R. Tolkien', 'genre' => 'Novel', 'ISBN' => '978-0618517657', 'price' => 25.00, 'stock_quantity' => 65, 'cover_image' => 'lotr.jpg'],
    ['title' => 'Harry Potter and the Sorcerer\'s Stone', 'author' => 'J.K. Rowling', 'genre' => 'Novel', 'ISBN' => '978-0590353427', 'price' => 18.99, 'stock_quantity' => 200, 'cover_image' => 'harry_potter.jpg'],
    ['title' => 'A Game of Thrones', 'author' => 'George R.R. Martin', 'genre' => 'Novel', 'ISBN' => '978-0553593716', 'price' => 17.50, 'stock_quantity' => 75, 'cover_image' => 'game_of_thrones.jpg'],
    ['title' => 'The Chronicles of Narnia', 'author' => 'C.S. Lewis', 'genre' => 'Novel', 'ISBN' => '978-0064471190', 'price' => 20.00, 'stock_quantity' => 90, 'cover_image' => 'narnia.jpg'],
    ['title' => 'The Hitchhiker\'s Guide to the Galaxy', 'author' => 'Douglas Adams', 'genre' => 'Novel', 'ISBN' => '978-0345391803', 'price' => 12.00, 'stock_quantity' => 115, 'cover_image' => 'hitchhikers_guide.jpg'],
    // Drama
    ['title' => 'Death of a Salesman', 'author' => 'Arthur Miller', 'genre' => 'Drama', 'ISBN' => '978-0142426371', 'price' => 10.99, 'stock_quantity' => 60, 'cover_image' => 'death_of_salesman.jpg'],
    ['title' => 'Hamlet', 'author' => 'William Shakespeare', 'genre' => 'Drama', 'ISBN' => '978-0743477123', 'price' => 8.50, 'stock_quantity' => 100, 'cover_image' => 'hamlet.jpg'],
    ['title' => 'A Streetcar Named Desire', 'author' => 'Tennessee Williams', 'genre' => 'Drama', 'ISBN' => '978-0811216017', 'price' => 11.25, 'stock_quantity' => 50, 'cover_image' => 'streetcar.jpg'],
    ['title' => 'Waiting for Godot', 'author' => 'Samuel Beckett', 'genre' => 'Drama', 'ISBN' => '978-0802144423', 'price' => 9.75, 'stock_quantity' => 45, 'cover_image' => 'waiting_godot.jpg'],
    ['title' => 'The Importance of Being Earnest', 'author' => 'Oscar Wilde', 'genre' => 'Drama', 'ISBN' => '978-0486264783', 'price' => 7.50, 'stock_quantity' => 70, 'cover_image' => 'earnest.jpg'],
    // Thriller
    ['title' => 'The Girl with the Dragon Tattoo', 'author' => 'Stieg Larsson', 'genre' => 'Thriller', 'ISBN' => '978-0307960305', 'price' => 14.00, 'stock_quantity' => 85, 'cover_image' => 'dragon_tattoo.jpg'],
    ['title' => 'Gone Girl', 'author' => 'Gillian Flynn', 'genre' => 'Thriller', 'ISBN' => '978-0307588371', 'price' => 13.00, 'stock_quantity' => 95, 'cover_image' => 'gone_girl.jpg'],
    ['title' => 'The Silent Patient', 'author' => 'Alex Michaelides', 'genre' => 'Thriller', 'ISBN' => '978-1250301697', 'price' => 15.50, 'stock_quantity' => 110, 'cover_image' => 'silent_patient.jpg'],
    ['title' => 'The Da Vinci Code', 'author' => 'Dan Brown', 'genre' => 'Thriller', 'ISBN' => '978-0307474278', 'price' => 12.99, 'stock_quantity' => 100, 'cover_image' => 'da_vinci_code.jpg'],
    ['title' => 'The Prizoner of Azkaban', 'author' => 'J.K. Rowling', 'genre' => 'Thriller', 'ISBN' => '978-0439655420', 'price' => 16.00, 'stock_quantity' => 125, 'cover_image' => 'azkaban.jpg'],
    // Additional Fictional and Novel books
    ['title' => 'The Nightingale', 'author' => 'Kristin Hannah', 'genre' => 'Historical Fiction', 'ISBN' => '978-1250056193', 'price' => 14.50, 'stock_quantity' => 80, 'cover_image' => 'the_nightingale.jpg'],
    ['title' => 'Where the Crawdads Sing', 'author' => 'Delia Owens', 'genre' => 'Mystery', 'ISBN' => '978-0735219090', 'price' => 15.00, 'stock_quantity' => 150, 'cover_image' => 'crawdads.jpg'],
    ['title' => 'The Midnight Library', 'author' => 'Matt Haig', 'genre' => 'Fantasy', 'ISBN' => '978-0525559474', 'price' => 13.99, 'stock_quantity' => 130, 'cover_image' => 'midnight_library.jpg'],
    ['title' => 'Educated', 'author' => 'Tara Westover', 'genre' => 'Memoir', 'ISBN' => '978-0399590504', 'price' => 16.99, 'stock_quantity' => 90, 'cover_image' => 'educated.jpg'],
];

$message = "";
$inserted_count = 0;

foreach ($books_to_insert as $book) {
    $title = $conn->real_escape_string($book['title']);
    $author = $conn->real_escape_string($book['author']);
    $genre = $conn->real_escape_string($book['genre']);
    $isbn = $conn->real_escape_string($book['ISBN']);
    $price = $conn->real_escape_string($book['price']);
    $stock_quantity = $conn->real_escape_string($book['stock_quantity']);
    $cover_image = $conn->real_escape_string($book['cover_image']);

    // Check if a book with the same ISBN already exists to prevent duplicates
    $check_sql = "SELECT book_id FROM books WHERE ISBN = '$isbn'";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows == 0) {
        $sql = "INSERT INTO books (title, author, genre, ISBN, price, stock_quantity, cover_image) VALUES ('$title', '$author', '$genre', '$isbn', '$price', '$stock_quantity', '$cover_image')";
        if ($conn->query($sql) === TRUE) {
            $inserted_count++;
        } else {
            $message .= "Error inserting '{$title}': " . $conn->error . "<br>";
        }
    } else {
        $message .= "Skipped '{$title}': Book with ISBN '{$isbn}' already exists.<br>";
    }
}

if ($inserted_count > 0) {
    $message = "Successfully inserted {$inserted_count} new books.<br>" . $message;
} else {
    $message = "No new books were inserted. All books in the list may already exist.<br>" . $message;
}

// Fetch all books to display them
$sql_display = "SELECT * FROM books";
$result = $conn->query($sql_display);
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Insert Books Script</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Insert Books Script</h1>
        </div>
    </header>
    <div class="container">
        <h2>Script Execution Results</h2>
        <p><?php echo $message; ?></p>
        
        <?php if ($result->num_rows > 0): ?>
            <h3>List of All Books in the Database</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Genre</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Image</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['book_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                        <td><?php echo htmlspecialchars($row['author']); ?></td>
                        <td><?php echo htmlspecialchars($row['genre']); ?></td>
                        <td>$<?php echo number_format($row['price'], 2); ?></td>
                        <td><?php echo htmlspecialchars($row['stock_quantity']); ?></td>
                        <td><img src="images/<?php echo htmlspecialchars($row['cover_image']); ?>" alt="Cover" style="width: 50px;"></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No books found in the database.</p>
        <?php endif; ?>
    </div>
</body>
</html>