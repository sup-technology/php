<?php const BASE_PATH = __DIR__ . '/../'; ?>

<?php
session_start();

require BASE_PATH . '/config/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: /auth/login.php');
    exit();
}
$query = 'SELECT * FROM questions where user_id = :user_id ORDER BY id DESC';
$stmt = $pdo->prepare($query);
$stmt->execute([':user_id' => $_SESSION['user_id']]);
$questions = $stmt->fetchAll();
?>

<?php require(BASE_PATH . '/partials/header.php') ?>

<?php require(BASE_PATH . '/partials/nav.php') ?>

<p class="text-center fw-bold fs-2">
Questions Listing
</p>


<div class="row mt-5">
<?php foreach ($questions as $question) { ?>
    <div class="card" style="width: 18rem;">
        <div class="card-body">
            <h5 class="card-title"><?= $question['title'] ?></h5>
            <p class="card-text"><?= $question['content'] ?></p>
            <a href="/questions/edit.php?id=<?= $question['id'] ?>" class="btn btn-primary">Edit</a>
            <a href="/questions/delete.php?id=<?= $question['id'] ?>" class="btn btn-danger">Delete</a>
        </div>
    </div>
<?php } ?>
</div>

<?php require(BASE_PATH . '/partials/footer.php') ?>