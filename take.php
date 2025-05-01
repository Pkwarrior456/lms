<?php
session_start();
include 'db.php'; // Ensure database connection

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: signin.php");
    exit;
}

// Handle book take request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['take_book'])) {
    $book_id = $_POST['book_id'];

    // Check if the book is available
    $check_query = "SELECT status FROM books WHERE id=?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("i", $book_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if ($row['status'] == 'Available') {
            // Update book status to "Issued"
            $update_query = "UPDATE books SET status='Issued' WHERE id=?";
            $update_stmt = $conn->prepare($update_query);
            $update_stmt->bind_param("i", $book_id);

            if ($update_stmt->execute()) {
                echo "<p style='color: green;'>Book taken successfully!</p>";
            } else {
                echo "<p style='color: red;'>Error updating book status: " . $update_stmt->error . "</p>";
            }
        } else {
            echo "<p style='color: red;'>Book is already issued!</p>";
        }
    } else {
        echo "<p style='color: red;'>Book not found!</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Take Book</title>
    <style>
        body { text-align: center; font-family: Arial, sans-serif; }
        form { display: inline-block; margin-top: 20px; }
        input, button { margin: 10px; padding: 10px; }
    </style>
</head>
<body>
    <h2>Take a Book</h2>
    <form method="POST" action="take.php">
        <label for="book_id">Book ID:</label>
        <input type="number" name="book_id" required><br>
        <button type="submit" name="take_book">Take Book</button>
    </form>
    <br><br>
    <a href="dashboard.php"><button>Back to Dashboard</button></a>
</body>
</html>
