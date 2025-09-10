<?php
// This is the new PHP file that will handle the auto-suggest backend.
// It queries the database and returns a JSON array of matching book titles.
include('includes/db_connect.php');

// Get the search query from the GET request
if (isset($_GET['q'])) {
    $search_query = $conn->real_escape_string($_GET['q']);

    // Check if the query is not empty before searching
    if (!empty($search_query)) {
        // Prepare a SQL query to find titles that start with the search term
        // Using LIKE with a wildcard at the end is more efficient for this use case
        // and provides a better user experience for suggestions.
        $sql = "SELECT title FROM books WHERE title LIKE '{$search_query}%' ORDER BY title ASC LIMIT 10";
        $result = $conn->query($sql);

        $suggestions = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $suggestions[] = $row['title'];
            }
        }
        
        // Return the results as a JSON array
        header('Content-Type: application/json');
        echo json_encode($suggestions);
    } else {
        // Return an empty JSON array if the query is empty
        header('Content-Type: application/json');
        echo json_encode([]);
    }
}
$conn->close();
?>
