<?php
session_start();
require 'db.php';

$data = json_decode(file_get_contents("php://input"), true);
$theme = $data['theme'] ?? 'light';

if (isset($_SESSION['user_id']) && in_array($theme, ['light', 'dark'])) {
    $stmt = $pdo->prepare("UPDATE Users SET ThemePreference = ? WHERE UserID = ?");
    $stmt->execute([$theme, $_SESSION['user_id']]);
}
