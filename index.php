<?php
session_start();
include('includes/db_connect.php');

// Handle search and filter
$search_query = "";
$filter_query = "";
if (isset($_GET['search'])) {
    $search_query = $conn->real_escape_string($_GET['search']);
}
if (isset($_GET['genre']) && !empty($_GET['genre'])) {
    $filter_query = " WHERE genre = '" . $conn->real_escape_string($_GET['genre']) . "'";
}

// Handle sorting
$sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : '';
$order_by_clause = "title ASC"; // Default sort order

switch ($sort_by) {
    case 'alphabetical':
        $order_by_clause = "title ASC";
        break;
    case 'most_selling':
        // This requires a more complex query, assuming 'sales_count' column exists.
        // For this example, we'll order by a hypothetical column.
        $order_by_clause = "stock_quantity ASC"; // Placeholder for 'most selling'
        break;
    case 'price_low_to_high':
        $order_by_clause = "price ASC";
        break;
    case 'newly_added':
        // Assuming there is a 'publication_date' or 'book_id' that indicates when a book was added.
        $order_by_clause = "book_id DESC";
        break;
}

$sql = "SELECT * FROM books" . $filter_query;
if (!empty($search_query)) {
    if (empty($filter_query)) {
        $sql .= " WHERE";
    } else {
        $sql .= " AND";
    }
    $sql .= " (title LIKE '%$search_query%' OR author LIKE '%$search_query%' OR ISBN LIKE '%$search_query%')";
}

$sql .= " ORDER BY " . $order_by_clause;

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lamp Shade Stories</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* CSS for the auto-suggest dropdown */
        .autocomplete-container {
            position: relative;
            width: 100%;
        }
        .autocomplete-items {
            position: absolute;
            border: 1px solid #d4d4d4;
            border-bottom: none;
            border-top: none;
            z-index: 99;
            top: 100%;
            left: 0;
            right: 0;
            max-height: 200px;
            overflow-y: auto;
            background-color: #fff;
        }
        .autocomplete-items div {
            padding: 10px;
            cursor: pointer;
            background-color: #fff;
            border-bottom: 1px solid #d4d4d4;
        }
        .autocomplete-items div:hover {
            background-color: #e9e9e9;
        }
        .autocomplete-active {
            background-color: DodgerBlue !important;
            color: #ffffff;
        }
        
        /* Search and sorting layout */
        .search-section {
            margin-bottom: 20px;
        }
        
        .search-form {
            display: flex;
            gap: 15px;
            align-items: center;
            margin-bottom: 15px;
            flex-wrap: wrap;
        }
        
        .sort-container {
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }
        
        .sort-form {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .sort-form label {
            font-size: 12px;
            color: #666;
            white-space: nowrap;
        }
        
        .search-form input[type="text"] {
            flex: 1;
            min-width: 250px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }
        
        .search-form select {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 14px;
            background-color: white;
            cursor: pointer;
            min-width: 120px;
        }
        
        .sort-form select {
            padding: 6px 8px;
            border-radius: 4px;
            border: 1px solid #ccc;
            font-size: 12px;
            background-color: white;
            cursor: pointer;
            min-width: 140px;
        }
        
        .search-form .btn {
            padding: 10px 30px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            white-space: nowrap;
            min-width: 180px;
            width: auto;
        }
        
        .search-form .btn:hover {
            background-color: #0056b3;
        }
        
        /* Simple smooth transitions - no JS needed */
        body {
            transition: opacity 0.2s ease;
        }
        
        .book-list {
            transition: opacity 0.15s ease;
        }
        
        .sort-form select {
            transition: border-color 0.2s ease;
        }
        
        .sort-form select:focus {
            border-color: #007bff;
        }
        
        /* Responsive design */
        @media (max-width: 768px) {
            .search-form {
                flex-direction: column;
                gap: 10px;
            }
            
            .search-form input[type="text"] {
                min-width: unset;
            }
            
            .sort-container {
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <h1>Lamp Shade Stories</h1>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="cart.php">Shopping Cart</a></li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li><a href="profile.php">Profile</a></li>
                        <li><a href="order_history.php">Order History</a></li>
                        <li><a href="logout.php">Logout</a></li>
                    <?php else: ?>
                        <li><a href="login_choice.php">Login</a></li>
                        <li><a href="register.php">Register</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
    <div class="container">
        <h2>Browse Books</h2>
        <div class="search-section">
            <!-- Search bar on top -->
            <form action="index.php" method="GET" class="search-form">
                <div class="autocomplete-container">
                    <input type="text" id="myInput" name="search" placeholder="Search for books..." value="<?php echo htmlspecialchars($search_query); ?>">
                    <div id="autocomplete-list" class="autocomplete-items"></div>
                </div>
                
                <?php
                // Fetch genres for the filter dropdown
                $genre_sql = "SELECT DISTINCT genre FROM books";
                $genre_result = $conn->query($genre_sql);
                ?>
                <select name="genre">
                    <option value="">All Genres</option>
                    <?php
                    if ($genre_result->num_rows > 0) {
                        while ($genre = $genre_result->fetch_assoc()) {
                            $selected = ($_GET['genre'] == $genre['genre']) ? 'selected' : '';
                            echo "<option value='{$genre['genre']}' {$selected}>{$genre['genre']}</option>";
                        }
                    }
                    ?>
                </select>
                <button type="submit" class="btn">Search & Filter</button>
            </form>

            <!-- Small sort dropdown in the right corner -->
            <div class="sort-container">
                <form action="index.php" method="GET" class="sort-form">
                    <input type="hidden" name="search" value="<?php echo htmlspecialchars($search_query); ?>">
                    <input type="hidden" name="genre" value="<?php echo htmlspecialchars($_GET['genre'] ?? ''); ?>">
                    <label for="sort_by">Sort by:</label>
                    <select name="sort_by" id="sort_by" onchange="this.form.submit()">
                        <option value="alphabetical" <?php echo ($sort_by == 'alphabetical' || empty($sort_by)) ? 'selected' : ''; ?>>Alphabetical (A-Z)</option>
                        <option value="most_selling" <?php echo ($sort_by == 'most_selling') ? 'selected' : ''; ?>>Most Selling</option>
                        <option value="price_low_to_high" <?php echo ($sort_by == 'price_low_to_high') ? 'selected' : ''; ?>>Price (Low to High)</option>
                        <option value="newly_added" <?php echo ($sort_by == 'newly_added') ? 'selected' : ''; ?>>Newly Added</option>
                    </select>
                </form>
            </div>
        </div>
        
        <div class="book-list">
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<div class='book-card'>";
                    echo "<img src='images/{$row['cover_image']}' alt='Book Cover'>";
                    echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
                    echo "<p>Author: " . htmlspecialchars($row['author']) . "</p>";
                    echo "<p>Genre: " . htmlspecialchars($row['genre']) . "</p>";
                    echo "<p>Price: $" . number_format($row['price'], 2) . "</p>";
                    echo "<p>Stock: " . htmlspecialchars($row['stock_quantity']) . "</p>";
                    if ($row['stock_quantity'] > 0) {
                        echo "<form action='cart.php' method='POST'>";
                        echo "<input type='hidden' name='book_id' value='{$row['book_id']}'>";
                        echo "<button type='submit' name='add_to_cart' class='btn'>Add to Cart</button>";
                        echo "</form>";
                    } else {
                        echo "<p>Out of Stock</p>";
                    }
                    echo "</div>";
                }
            } else {
                echo "0 results found.";
            }
            $conn->close();
            ?>
        </div>
    </div>
    <script>
        const searchInput = document.getElementById('myInput');
        const autocompleteList = document.getElementById('autocomplete-list');
        let currentFocus;

        // Fetch suggestions from the server
        async function fetchSuggestions(query) {
            if (query.length < 2) {
                closeAllLists();
                return;
            }
            try {
                const response = await fetch(`search_suggest.php?q=${encodeURIComponent(query)}`);
                const data = await response.json();
                displaySuggestions(data);
            } catch (error) {
                console.error('Error fetching suggestions:', error);
            }
        }

        // Display suggestions in the dropdown
        function displaySuggestions(suggestions) {
            closeAllLists();
            if (!suggestions || suggestions.length === 0) {
                return;
            }

            suggestions.forEach(item => {
                const div = document.createElement('div');
                div.innerHTML = `<strong>${item.substr(0, searchInput.value.length)}</strong>`;
                div.innerHTML += item.substr(searchInput.value.length);
                div.innerHTML += `<input type='hidden' value='${item}'>`;
                div.addEventListener('click', function() {
                    searchInput.value = this.getElementsByTagName('input')[0].value;
                    closeAllLists();
                    // Optional: submit the form after selection
                    // searchInput.closest('form').submit();
                });
                autocompleteList.appendChild(div);
            });
        }

        // Close all autocomplete lists except the current one
        function closeAllLists(elmnt) {
            const items = document.getElementsByClassName('autocomplete-items');
            for (let i = 0; i < items.length; i++) {
                if (elmnt != items[i] && elmnt != searchInput) {
                    items[i].innerHTML = '';
                }
            }
        }

        // Handle keyboard navigation (up, down, enter)
        function addActive(x) {
            if (!x) return false;
            removeActive(x);
            if (currentFocus >= x.length) currentFocus = 0;
            if (currentFocus < 0) currentFocus = (x.length - 1);
            x[currentFocus].classList.add('autocomplete-active');
        }

        function removeActive(x) {
            for (let i = 0; i < x.length; i++) {
                x[i].classList.remove('autocomplete-active');
            }
        }

        // Event listeners
        searchInput.addEventListener('input', function() {
            fetchSuggestions(this.value);
        });

        searchInput.addEventListener('keydown', function(e) {
            let x = autocompleteList.getElementsByTagName('div');
            if (e.keyCode == 40) { // Down key
                currentFocus++;
                addActive(x);
            } else if (e.keyCode == 38) { // Up key
                currentFocus--;
                addActive(x);
            } else if (e.keyCode == 13) { // Enter key
                e.preventDefault();
                if (currentFocus > -1) {
                    if (x) x[currentFocus].click();
                }
            }
        });

        // Close the dropdown when clicking outside of it
        document.addEventListener('click', function (e) {
            closeAllLists(e.target);
        });
    </script>
</body>
</html>