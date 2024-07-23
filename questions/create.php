<?php const BASE_PATH = __DIR__ . '/../'; ?>

<?php
session_start();

require BASE_PATH . '/config/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: /auth/login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category_id = $_POST['category_id'];

    $sql = 'INSERT INTO questions (title, content, category_id) VALUES (:title, :content, :category_id)';
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute([':title' => $title, ':content' => $content, ':category_id' => $category_id])) {
        header('Location: /questions');
        exit();
    } else {
        echo 'Something went wrong. Please try again.';
    }
}

$categories = $pdo->query('SELECT * FROM categories')->fetchAll();

?>

<?php require(BASE_PATH . '/partials/header.php') ?>

<?php require(BASE_PATH . '/partials/nav.php') ?>

<form method="POST" action="/questions/create.php">
    <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="title" class="form-control" name="title" id="title">
    </div>
    <div class="mb-3">
        <label for="content" class="form-label">Content</label>
        <input type="content" class="form-control" name="content" id="content">
    </div>
    <div class="mb-3">
        <label for="category" class="form-label">Category</label>
        <select id="category" name="category_id" class="form-select">
            <?php foreach ($categories as $category) { ?>
                <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
            <?php } ?>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

<?php require(BASE_PATH . '/partials/footer.php') ?>