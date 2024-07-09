<?php
const BASE_PATH = __DIR__ . '/../';

require BASE_PATH . '/config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $sql = 'INSERT INTO users (username, email, password) VALUES (:username, :email, :password)';
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute([':username' => $username, ':email' => $email, ':password' => $password])) {
        echo 'Registration successful!';
        header('Location: /auth/login.php');
        exit();
    } else {
        echo 'Something went wrong. Please try again.';
    }
}
?>
<?php require(BASE_PATH . '/partials/header.php') ?>
<link rel="stylesheet" href="/css/register.css">

<div class="register-container">
    <h2>Register</h2>
    <form action="register.php" method="post">
        <div>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit">Register</button>
    </form>

</div>

    <?php require(BASE_PATH . '/partials/footer.php') ?>
