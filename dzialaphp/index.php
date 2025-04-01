<?php
session_start();
require 'db.php';

$stmt = $pdo->query("SELECT a.AnnouncementID, a.Title, a.Description, a.Price, a.DateOfCreation, u.Username FROM Announcements a JOIN Users u ON a.UserID = u.UserID ORDER BY a.DateOfCreation DESC");
$announcements = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Ogłoszenia - Strona Główna</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <header>
        <div class="logo">
            <a href="index.php"><img src="logo.png" alt="logo" /></a>
        </div>
        <input class="search-bar" type="text" placeholder="WYSZUKIWARKA" />
        <div class="auth-buttons">
            <a href="login.php" class="login">Login</a>
            <a href="register.php" class="register">Register</a>
        </div>
    </header>
    <main>
        <section class="content">
            <h2>OSTATNIO DODANE OGŁOSZENIA</h2>
            <?php foreach ($announcements as $announcement): ?>
                <div class="announcement-card">
                    <h4><?php echo htmlspecialchars($announcement['Title']); ?></h4>
                    <p><?php echo htmlspecialchars($announcement['Description']); ?></p>
                    <p><strong>Cena:</strong> <?php echo htmlspecialchars($announcement['Price']); ?> PLN</p>
                    <p><em>Dodane przez: <?php echo htmlspecialchars($announcement['Username']); ?>, <?php echo $announcement['DateOfCreation']; ?></em></p>
                </div>
            <?php endforeach; ?>
        </section>
    </main>
    <footer>
        <p>Maciej Korowacki, Wiktoria Kruk, Michal Bujak</p>
    </footer>
</body>
</html>