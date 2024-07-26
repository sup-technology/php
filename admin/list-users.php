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


$query = "SELECT * FROM users";
$stmt = $pdo->prepare($query);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

    <?php require(BASE_PATH . '/partials/header.php') ?>
    <?php require BASE_PATH . 'partials/nav.php'; ?>
    <div class="container mt-5">
        <h2>Users List</h2>
        <a href="add-user.php" class="btn btn-success mb-3">Add User</a>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['id']) ?></td>
                        <td><?= htmlspecialchars($user['username']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td><?= htmlspecialchars($user['role']) ?></td>
                        <td>
                            <a href="/admin/view-user.php?id=<?= $user['id'] ?>" class="btn btn-info">View</a>
                            <a href="/admin/edit-user.php?id=<?= $user['id'] ?>" class="btn btn-warning">Edit</a>
                            <a href="/admin/delete-user.php?id=<?= $user['id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php require BASE_PATH . 'partials/footer.php'; ?>
</body>
</html>
