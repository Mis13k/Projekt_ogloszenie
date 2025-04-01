<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Ogłoszenia</title>
    <link rel="stylesheet" href="auth.css">
</head>

<body>
    <header>
        <div class="logo">
            <img src="logo.png" alt="logo">
        </div>
        
        <div class="auth-buttons">
            <button class="register">Register</button>
        </div>
    </header>

    <main>
        <section class="content">
            <h2>Logowanie</h2>
            <form action="login_process.php" method="POST">
                <div class="form-group">
                    <label for="username">Nazwa Użytkownika:</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Hasło:</label>
                    <input type="password" id="password" name="password" required>
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