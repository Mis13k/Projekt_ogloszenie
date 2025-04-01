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

// Get the logged-in user's ID
$user_id = $_SESSION['user_id'];

// Fetch announcements for the logged-in user
$sql = "SELECT AnnouncementID, Title, Description, Price FROM Announcements WHERE UserID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moje Ogłoszenia</title>
</head>
<body>
    <h1>Moje Ogłoszenia</h1>
    <table border="1">
        <tr>
            <th>Tytuł</th>
            <th>Opis</th>
            <th>Cena</th>
            <th>Akcje</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['Title']); ?></td>
            <td><?php echo htmlspecialchars($row['Description']); ?></td>
            <td><?php echo htmlspecialchars($row['Price']); ?> PLN</td>
            <td>
                <form action="delete_announcement.php" method="POST" style="display:inline;">
                    <input type="hidden" name="announcement_id" value="<?php echo $row['AnnouncementID']; ?>">
                    <input type="submit" value="Usuń">
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <a href="add_announcement.html">Dodaj nowe ogłoszenie</a>
    <a href="logout.php">Wyloguj się</a>

    <?php
    $stmt->close();
    $conn->close();
    ?>
</body>
</html>