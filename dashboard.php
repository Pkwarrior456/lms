<?php
session_start();
include 'db.php'; // Database connection

// Redirect to login if not logged in
if (!isset($_SESSION['user'])) { 
    header("Location: signin.php"); 
    exit; 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body { text-align: center; font-family: Arial, sans-serif; }
        button { padding: 10px; margin: 5px; cursor: pointer; }
        table { width: 80%; margin: 20px auto; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 10px; text-align: center; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Welcome, <?php echo $_SESSION['user']; ?>!</h2>
    <a href="logout.php"><button>Logout</button></a>
    <br><br>

    <a href="add.php"><button>Add Book</button></a>
    <a href="delete.php"><button>Delete Book</button></a>
    <a href="return.php"><button>Return Book</button></a>
    <a href="take.php"><button>Take Book</button></a>
    <a href="books.php"><button>Show All Books</button></a>

    <h2>All Books</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Author</th>
            <th>Status</th>
        </tr>
        <?php
        $query = "SELECT * FROM books";
        $result = $conn->query($query);
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>{$row['id']}</td><td>{$row['title']}</td><td>{$row['author']}</td><td>{$row['status']}</td></tr>";
        }
        ?>
    </table>
</body>
</html>
