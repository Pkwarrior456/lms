<?php
session_start();
include 'db.php'; // Include database connection

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: signin.php");
    exit;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_book'])) {
    $title = $_POST['title'];
    $author = $_POST['author'];

    $query = "INSERT INTO books (title, author) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $title, $author);

    if ($stmt->execute()) {
        echo "<p style='color: green;'>Book added successfully!</p>";
    } else {
        echo "<p style='color: red;'>Error adding book: " . $stmt->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Book</title>
    <style>
        body { text-align: center; font-family: Arial, sans-serif; }
        form { display: inline-block; margin-top: 20px; }
        input, button { margin: 10px; padding: 10px; }
    </style>
</head>
<body>
    <h2>Add a New Book</h2>
    <form method="POST" action="add.php">
        <label for="title">Book Title:</label>
        <input type="text" name="title" required><br>
        <label for="author">Author:</label>
        <input type="text" name="author" required><br>
        <button type="submit" name="add_book">Add Book</button>
    </form>
    <br><br>
    <a href="dashboard.php"><button>Back to Dashboard</button></a>
</body>
</html>
