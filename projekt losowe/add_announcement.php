<?php
$servername = "localhost"; // Change if your database server is different
$username = "your_username"; // Your database username
$password = "your_password"; // Your database password
$dbname = "AnnouncementService"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$user_id = $_POST['user_id'];
$category_id = $_POST['category_id'];
$title = $_POST['title'];
$description = $_POST['description'];
$price = $_POST['price'];

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO Announcements (User ID, CategoryID, Title, Description, Price) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("iissd", $user_id, $category_id, $title, $description, $price);

// Execute the statement
if ($stmt->execute()) {
    echo "Ogłoszenie zostało dodane pomyślnie!";
} else {
    echo "Błąd: " . $stmt->error;
}

// Close connections
$stmt->close();
$conn->close();
?>