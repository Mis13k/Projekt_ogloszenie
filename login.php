<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM Users WHERE Username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['Password'])) {
        $_SESSION['user_id'] = $user['UserID'];
        $_SESSION['username'] = $user['Username'];
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['error'] = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Mission: Affordable - Login</title>
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
            <a href="register.php" class="small-ui">Register</a>
        </div>
    </header>

    <main>
        <section class="content">
            <h2>Logowanie</h2>
            <?php if (isset($_SESSION['error'])): ?>
                <p><?php echo $_SESSION['error'];
                unset($_SESSION['error']); ?></p>
            <?php endif; ?>
            <form action="login.php" method="POST">
                <div class="form-group">
                    <label for="username">Nazwa Użytkownika:</label>
                    <input type="text" id="username" name="username" required />
                </div>
                <div class="form-group">
                    <label for="password">Hasło:</label>
                    <input type="password" id="password" name="password" required />
                </div>
                <button type="submit" class="login-button">Zaloguj się</button>
            </form>
        </section>
    </main>
    <footer>
        <p>Maciej Korowacki, Wiktoria Kruk, Michal Bujak</p>
    </footer>
</body>

</html>