<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: /auth/login.php');
    exit();
}

const BASE_PATH = __DIR__ . '/';
require BASE_PATH . 'config/db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="stylesheet" href="/css/main.css">
</head>
<body>
    <?php require(BASE_PATH . '/partials/header.php'); ?>
    <div class="container mt-5">
        <h1>Welcome to the Admin Page</h1>
        <p>Only users with the admin role can access this page.</p>
        <!-- Admin functionalities here -->
    </div>
    <?php require(BASE_PATH . '/partials/footer.php'); ?>
</body>
</html>
