<?php 
const BASE_PATH = __DIR__ . '/../'; 
?>

<?php
session_start();

require BASE_PATH . '/config/db.php';
require BASE_PATH . '/config/Validator.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: /auth/login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];

    $title = $_POST['title'];
    $content = $_POST['content'];
    $category_id = $_POST['category_id'];

    $validator = new Validator();

    $validator->name('title')->value($title)->min(1)->required();
    $validator->name('content')->value($content)->min(1)->required();
    $validator->name('category_id')->value($category_id)->required();

    if (!$validator->passes()) {
        $errors = $validator->getErrors();
    } else {
        $sql = 'INSERT INTO questions (title, content, category_id, user_id) VALUES (:title, :content, :category_id, :user_id)';
        $stmt = $pdo->prepare($sql);

        $data = [
            ':title' => $title, 
            ':content' => $content, 
            ':category_id' => $category_id,
            ':user_id' => $_SESSION['user_id']
        ];

        if ($stmt->execute($data)) {
            header('Location: /questions');
            exit();
        } else {
            echo 'Something went wrong. Please try again.';
        }
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
        <span class="text-danger"><?= $errors['title'] ?? '' ?></span>
    </div>
    <div class="mb-3">
        <label for="content" class="form-label">Content</label>
        <textarea class="form-control" name="content" id="content" rows="5"></textarea>
        <span class="text-danger"><?= $errors['content'] ?? '' ?></span>
    </div>
    <div class="mb-3">
        <label for="category" class="form-label">Category</label>
        <select id="category" name="category_id" class="form-select">
            <?php foreach ($categories as $category) { ?>
                <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
            <?php } ?>
        </select>
        <span class="text-danger"><?= $errors['category_id'] ?? '' ?></span>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

<?php require(BASE_PATH . '/partials/footer.php') ?>