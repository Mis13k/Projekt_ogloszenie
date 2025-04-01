<?php
session_start();
require 'db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $userId = $_SESSION['user_id']; // Get the logged-in user's ID

    $stmt = $pdo->prepare("INSERT INTO Announcements (User ID, Title, Description, Price) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$userId, $title, $description, $price])) {
        $_SESSION['message'] = "Announcement added successfully!";
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['error'] = "Failed to add announcement!";
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dodaj Ogłoszenie</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <header>
        <div class="logo">
            <a href="index.php"><img src="logo.png" alt="logo" /></a>
        </div>
        <div class="auth-buttons">
            <a href="logout.php" class="logout">Logout</a>
        </div>
    </header>
    <main>
        <section class="content">
            <h2>Dodaj Ogłoszenie</h2>
            <?php if (isset($_SESSION['error'])): ?>
                <p><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
            <?php endif; ?>
            <form action="add_announcement.php" method="POST">
                <div class="form-group">
                    <label for="title">Tytuł:</label>
                    <input type="text" id="title" name="title" required />
                </div>
                <div class="form-group">
                    <label for="description">Opis:</label>
                    <textarea id="description" name="description" required></textarea>
                </div>
                <div class="form-group">
                    <label for="price">Cena:</label>
                    <input type="number" id="price" name="price" step="0.01" required />
                </div>
                <button type="submit" class="add-button">Dodaj Ogłoszenie</button>
            </form>
        </section>
    </main>
    <footer>
        <p>Maciej Korowacki, Wiktoria Kruk, Michal Bujak</p>
    </footer>
</body>
</html>