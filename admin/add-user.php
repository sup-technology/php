<?php
session_start();

const BASE_PATH = __DIR__ . '/../';
require BASE_PATH . 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: /auth/login.php');
    exit();
}

$userId = $_SESSION['user_id'];
$stmt = $pdo->prepare('SELECT * FROM users WHERE id = :id');
$stmt->execute([':id' => $userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user['role'] !== 'admin') {
    header('Location: /auth/login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $sql = 'INSERT INTO users (username, email, password, role, created_at, updated_at) VALUES (:username, :email, :password, :role, NOW(), NOW())';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':username' => $username, ':email' => $email, ':password' => $password, ':role' => $role]);

    header('Location: list-users.php');
    exit();
}
?>

<?php require(BASE_PATH . '/partials/header.php') ?>

<?php require(BASE_PATH . '/partials/nav.php') ?>

<div class="container mt-5">
    <h1>Add User</h1>
    <form action="add-user.php" method="post">
        <div class="mb-3">
            <label class="form-label" for="username">Username:</label>
            <input class="form-control" type="text" id="username" name="username" required>
        </div>
        <div class="mb-3">
            <label class="form-label" for="email">Email:</label>
            <input class="form-control" type="email" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label class="form-label" for="password">Password:</label>
            <input class="form-control" type="password" id="password" name="password" required>
        </div>
        <div class="mb-3">
            <label class="form-label" for="role">Role:</label>
            <select class="form-select" id="role" name="role" required>
                <option value="normal">Normal</option>
                <option value="admin">Admin</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Add User</button>
    </form>
</div>

<?php require BASE_PATH . 'partials/footer.php'; ?>