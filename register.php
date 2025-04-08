<?php
session_start();
require 'db.php'; // Ensure you have the database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect and sanitize user input
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];

    // Check if passwords match
    if ($password === $confirm_password) {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare the SQL statement to insert the user
        $stmt = $pdo->prepare("INSERT INTO Users (Username, Email, Password) VALUES (?, ?, ?)");

        // Execute the statement and check for success
        if ($stmt->execute([$username, $email, $hashed_password])) {
            $_SESSION['message'] = "Registration successful!";
            header("Location: login.php?registration=success"); // Redirect to login page
            exit();
        } else {
            $_SESSION['error'] = "Registration failed! Please try again.";
        }
    } else {
        $_SESSION['error'] = "Passwords do not match!";
    }
}
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Mission: Affordable - Register</title>
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
            <a href="login.php" class="small-ui">Login</a>
        </div>
    </header>

    <main>
        <section class="content">
            <h2>Rejestracja</h2>
            <?php if (isset($_SESSION['error'])): ?>
                <p><?php echo $_SESSION['error'];
                unset($_SESSION['error']); ?></p>
            <?php endif; ?>
            <form action="register.php" method="POST">
                <div class="form-group">
                    <label for="username">Nazwa Użytkownika:</label>
                    <input type="text" id="username" name="username" required />
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required />
                </div>
                <div class="form-group">
                    <label for="password">Hasło:</label>
                    <input type="password" id="password" name="password" required />
                </div>
                <div class="form-group">
                    <label for="confirm-password">Potwierdź Hasło:</label>
                    <input type="password" id="confirm-password" name="confirm-password" required />
                </div>
                <button type="submit" class="register-button">Zarejestruj się</button>
            </form>
        </section>
    </main>
    <footer>
        <p>Maciej Korowacki, Wiktoria Kruk, Michal Bujak</p>
    </footer>
</body>

</html>