<?php
// Delete Book (delete.php)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_book'])) {
    include 'db.php'; // Ensure database connection
    $book_id = $_POST['book_id'];
    $query = "DELETE FROM books WHERE id=?";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        die("<p style='color: red;'>Error preparing statement: " . $conn->error . "</p>");
    }
    $stmt->bind_param("i", $book_id);
    if ($stmt->execute() && $stmt->affected_rows > 0) {
        echo "Book deleted successfully!";
    } else {
        echo "Book not found!";
    }
}
?>

<!-- Delete Book Form -->
<form method="POST" action="delete.php">
    <label for="book_id">Book ID:</label>
    <input type="number" name="book_id" required><br>
    <button type="submit" name="delete_book">Delete Book</button>
</form>
