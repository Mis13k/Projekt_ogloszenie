<?php
session_start();
require 'db.php';
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

if ($search !== '') {
    $stmt = $pdo->prepare("SELECT a.AnnouncementID, a.Title, a.Description, a.Price, a.DateOfCreation, u.Username, c.CategoryName
        FROM Announcements a
        JOIN Users u ON a.UserID = u.UserID
        JOIN Categories c ON a.CategoryID = c.CategoryID
        WHERE a.Title LIKE :search OR a.Description LIKE :search
        ORDER BY a.DateOfCreation DESC");
    $stmt->execute(['search' => '%' . $search . '%']);
} else {
    $stmt = $pdo->query("SELECT a.AnnouncementID, a.Title, a.Description, a.Price, a.DateOfCreation, u.Username, c.CategoryName
        FROM Announcements a
        JOIN Users u ON a.UserID = u.UserID
        JOIN Categories c ON a.CategoryID = c.CategoryID
        ORDER BY a.DateOfCreation DESC");
}


$announcements = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Mission: Affordable - Strona Główna</title>
    <link rel="stylesheet" href="style.css" />
</head>

<body class="<?php echo $themeClass; ?>">
    <header>
        <div class="left-header">
            <div class="logo">
                <a href="index.php"><img src="logo.png" alt="logo" /></a>
            </div>
            <div class="page-name">
                Mission: Affordable
            </div>
            <?php if (isset($_SESSION['user_id'])): ?>
                <span class="welcome-msg">Witaj, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
            <?php endif; ?>
        </div>


        <form method="GET" action="index.php" class="search-form">
            <input class="search-bar" type="text" name="search" placeholder="WYSZUKIWARKA"
                value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" />
        </form>

        <div class="auth-buttons">
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="add_announcement.php" class="small-ui">Dodaj ogłoszenie</a>
                <a href="logout.php" class="small-ui">Logout</a>
            <?php else: ?>
                <a href="login.php" class="small-ui">Login</a>
                <a href="register.php" class="small-ui">Register</a>
            <?php endif; ?>
            <button id="theme-toggle" class="small-ui">Switch to Dark Mode</button>
        </div>
    </header>

    <main>
        <section class="content">
            <h2>OSTATNIO DODANE OGŁOSZENIA</h2>
            <?php foreach ($announcements as $announcement): ?>
                <div class="announcement-card">
                    <h4><?php echo htmlspecialchars($announcement['Title']); ?></h4>
                    <p><strong>Kategoria:</strong> <?php echo htmlspecialchars($announcement['CategoryName']); ?></p>
                    <p><?php echo htmlspecialchars($announcement['Description']); ?></p>
                    <p><strong>Cena:</strong> <?php echo htmlspecialchars($announcement['Price']); ?> PLN</p>
                    <p><em>Dodane przez: <?php echo htmlspecialchars($announcement['Username']); ?>,
                            <?php echo $announcement['DateOfCreation']; ?></em></p>
                </div>
            <?php endforeach; ?>

        </section>
    </main>
    <footer>
        <p>Maciej Korowacki, Wiktoria Kruk, Michal Bujak</p>
    </footer>
    <script>
        const themeToggle = document.getElementById('theme-toggle');
        const body = document.body;

        // Load user's saved theme from localStorage (first visit fallback)
        if (localStorage.getItem('theme') === 'dark') {
            body.classList.add('dark-mode');
            themeToggle.textContent = 'Switch to Light Mode';
        }

        themeToggle.addEventListener('click', () => {
            const isDark = body.classList.toggle('dark-mode');
            const newTheme = isDark ? 'dark' : 'light';

            localStorage.setItem('theme', newTheme);
            themeToggle.textContent = isDark ? 'Switch to Light Mode' : 'Switch to Dark Mode';

            // Save theme on the server
            fetch('save_theme.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ theme: newTheme })
            });
        });
    </script>

</body>

</html>