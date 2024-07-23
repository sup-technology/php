<?php
const BASE_PATH = __DIR__ . '/../';

require BASE_PATH . '/config/db.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $sql = 'SELECT * FROM users WHERE email = :email';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header('Location: /index.php');
        } else {
            $errors['email'] = 'Invalid email or password.';
        }
}

?>

<?php require(BASE_PATH . '/partials/header.php') ?>

<link rel="stylesheet" href="/css/login.css">


<div class="login-container">
    <h2>Login</h2>
    <form action="login.php" method="post">
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <span class="text-danger"><?php echo $errors['email'] ?? '' ?></span>
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>

    </form>

</div>

<?php require(BASE_PATH . '/partials/footer.php') ?>