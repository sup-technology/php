<?php
const BASE_PATH = __DIR__ . '/../';

require BASE_PATH . '/config/db.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Set the role to admin
    $role = 'admin';

    $sql = 'INSERT INTO users (username, email, password, created_at, updated_at, role) VALUES (:username, :email, :password, NOW(), NOW(), :role)';
    $stmt = $connexion->prepare($sql);
    
    try {
        $stmt->execute([':username' => $username, ':email' => $email, ':password' => $password, ':role' => $role]);
        echo 'Registration successful. Please log in.';
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            echo 'Username or email already exists. Please try again.';
        } else {
            echo 'An error occurred: ' . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/register.css">
    <link rel="stylesheet" href="/css/main.css">
</head>
<body>
<?php require(BASE_PATH . '/partials/header.php'); ?>

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow-sm" style="width: 400px;">
        <h3 class="card-title text-center">Register</h3>
        <form action="register.php" method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Username:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Register</button>
            </div>
        </form>
    </div>
</div>

<?php require(BASE_PATH . '/partials/footer.php'); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
