<?php
session_start();

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

// Get the submitted username and password
$username = $_POST['username'];
$password = $_POST['password'];

// Prepare and execute the SQL statement
$sql = "SELECT UserID, Password FROM Users WHERE Username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // Compare the plain text password
    if ($password === $row['Password']) {
        // Password is correct, set session variables
        $_SESSION['user_id'] = $row['User ID'];
        header("Location: user_announcements.php"); // Redirect to announcements page
        exit();
    } else {
        echo "Błędne hasło.";
    }
} else {
    echo "Błędna nazwa użytkownika.";
}

$stmt->close();
$conn->close();
?>