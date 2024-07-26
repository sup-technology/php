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

$user_id = $_GET['id'] ?? null;
if (!$user_id) {
    header('Location: list-users.php');
    exit();
}

$query = "SELECT * FROM users WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->execute(['id' => $user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : $user['password'];
    $role = $_POST['role'];

    $update_query = "UPDATE users SET username = :username, email = :email, password = :password, role = :role WHERE id = :id";
    $update_stmt = $pdo->prepare($update_query);
    $update_stmt->execute([
        'username' => $username,
        'email' => $email,
        'password' => $password,
        'role' => $role,
        'id' => $user_id
    ]);

    header('Location: list-users.php');
    exit();
}
?>

<?php require BASE_PATH . 'partials/header.php'; ?>
<?php require BASE_PATH . 'partials/nav.php'; ?>
<div class="container mt-5">
    <h2>Edit User</h2>
    <form action="edit-user.php?id=<?= $user['id'] ?>" method="post">
        <div class="mb-3">
            <label for="username" class="form-label">Username:</label>
            <input type="text" id="username" name="username" class="form-control" value="<?= htmlspecialchars($user['username']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" id="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password (leave blank if not changing):</label>
            <input type="password" id="password" name="password" class="form-control">
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Role:</label>
            <select id="role" name="role" class="form-select" required>
                <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>User</option>
                <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</div>
<?php require BASE_PATH . 'partials/footer.php'; ?>