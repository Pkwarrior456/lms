
<?php
// Return Book (return.php)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['return_book'])) {
    include 'db.php'; // Ensure database connection
    $book_id = $_POST['book_id'];
    $query = "UPDATE books SET status='Available' WHERE id=? AND status='Issued'";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        die("<p style='color: red;'>Error preparing statement: " . $conn->error . "</p>");
    }
    $stmt->bind_param("i", $book_id);
    if ($stmt->execute() && $stmt->affected_rows > 0) {
        echo "Book returned successfully!";
    } else {
        echo "Book is already available or not found!";
    }
}
?>

<!-- Return Book Form -->
<form method="POST" action="return.php">
    <label for="book_id">Book ID:</label>
    <input type="number" name="book_id" required><br>
    <button type="submit" name="return_book">Return Book</button>
</form>