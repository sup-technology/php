<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: /auth/login.php');
    exit();
}
?>

<?php require('partials/header.php') ?>
<?php require('partials/nav.php') ?>

Home Page

<?php require('partials/footer.php') ?>