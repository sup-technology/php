<?php
session_start();
require '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = 'SELECT * FROM users WHERE email = :email LIMIT 1';
    $statement = $connexion->prepare($query);
    $statement->bindValue(':email', $email);
    $statement->execute();

    $user = $statement->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        header('Location: /index.php');
        exit();
    } else {
        $_SESSION['error'] = 'Invalid email or password';
        header('Location: /auth/login.php');
        exit();
    }
}
?>
