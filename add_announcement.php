<?php
session_start();
require 'db.php';

$categoriesStmt = $pdo->query("SELECT CategoryID, CategoryName FROM Categories ORDER BY CategoryName");
$categories = $categoriesStmt->fetchAll();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $categoryId = $_POST['category_id'];
    $userId = $_SESSION['user_id'];

    $stmt = $pdo->prepare("INSERT INTO Announcements (UserID, CategoryID, Title, Description, Price) VALUES (?, ?, ?, ?, ?)");

    if ($stmt->execute([$userId, $categoryId, $title, $description, $price])) {
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
    <title>Mission: Affordable - Dodaj Ogłoszenie</title>
    <link rel="stylesheet" href="auth.css" />
</head>

<body>
    <header>
        <div class="left-header">
            <div class="logo">
                <a href="index.php"><img src="logo.png" alt="logo" /></a>
            </div>
            <div class="page-name">
                Mission: Affordable
            </div>
        </div>
        <div class="auth-buttons">
            <a href="logout.php" class="small-ui">Logout</a>
        </div>
    </header>

    <main>
        <section class="content">
            <h2>Dodaj Ogłoszenie</h2>
            <?php if (isset($_SESSION['error'])): ?>
                <p><?php echo $_SESSION['error'];
                unset($_SESSION['error']); ?></p>
            <?php endif; ?>
            <form action="add_announcement.php" method="POST">
                <div class="form-group">
                    <label for="title">Tytuł:</label>
                    <input type="text" id="title" name="title" required />
                </div>
                <div class="form-group">
                    <label for="category_id">Kategoria:</label>
                    <select id="category_id" name="category_id" required>
                        <option value="">-- Wybierz kategorię --</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo $category['CategoryID']; ?>">
                                <?php echo htmlspecialchars($category['CategoryName']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="description">Opis:</label>
                    <textarea id="description" name="description" required></textarea>
                </div>
                <div class="form-group">
                    <label for="price">Cena:</label>
                    <input type="number" id="price" name="price" step="0.01" required />
                </div>
                <div class="add-ui">
                    <button type="submit" class="add-button">Dodaj Ogłoszenie</button>
                </div>
            </form>
        </section>
    </main>
    <footer>
        <p>Maciej Korowacki, Wiktoria Kruk, Michal Bujak</p>
    </footer>
    <script>
        const textarea = document.getElementById('description');

        textarea.addEventListener('input', () => {
            textarea.style.height = 'auto'; // Reset height
            textarea.style.height = textarea.scrollHeight + 'px'; // Set new height
        });

        // Optional: trigger once in case there's pre-filled text
        window.addEventListener('load', () => {
            textarea.style.height = 'auto';
            textarea.style.height = textarea.scrollHeight + 'px';
        });
    </script>
</body>

</html>