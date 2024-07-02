<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: /auth/login.php');
    exit();
}
?>

<?php const BASE_PATH = __DIR__ . '/../'; ?>

<?php require(BASE_PATH . '/partials/header.php') ?>


<?php require(BASE_PATH . '/partials/nav.php') ?>

Questions Listing

<?php require(BASE_PATH . '/partials/footer.php') ?>