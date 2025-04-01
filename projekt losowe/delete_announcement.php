<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

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

// Get the announcement ID to delete
$announcement_id = $_POST['announcement_id'];

// Prepare and execute the delete statement
$sql = "DELETE FROM Announcements WHERE AnnouncementID = ? AND UserID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $announcement_id, $_SESSION['user_id']);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "Ogłoszenie zostało usunięte pomyślnie!";
} else {
    echo "Błąd: Nie udało się usunąć ogłoszenia.";
}

$stmt->close();
$conn->close();

// Redirect back to the announcements page
header("Location: user_announcements.php");
exit();
?>