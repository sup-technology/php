<?php const BASE_PATH = __DIR__ . '/../'; ?>

<?php
session_start();

require BASE_PATH . '/config/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: /auth/login.php');
    exit();
}
$query = '
SELECT questions.*, users.username, categories.name as category_name, count(likes.id) as likes_count 
FROM questions 
inner join users on questions.user_id = users.id 
inner join categories on questions.category_id = categories.id 
left join likes on questions.id = likes.question_id 
where questions.user_id = :user_id
group by questions.id, users.username, categories.name  
ORDER BY id DESC
';
$stmt = $pdo->prepare($query);
$stmt->execute([':user_id' => $_SESSION['user_id']]);
$questions = $stmt->fetchAll();
?>

<?php require(BASE_PATH . '/partials/header.php') ?>

<?php require(BASE_PATH . '/partials/nav.php') ?>

<p class="text-center fw-bold fs-2">
    Questions Listing
</p>

<div class="mt-5">
    <?php if (!count($questions)) { ?>
        <p class="text-center text-secondary fw-bold fs-4">No questions found!</p>
    <?php } else { ?>
        <?php foreach ($questions as $question) { ?>
            <div class="mb-5">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="d-flex">
                                <form action="/questions/likes.php" method="POST">
                                    <input type="hidden" name="question_id" value="<?= $question['id'] ?>">

                                    <button class="btn btn-success position-relative" disabled>
                                        <i class="bi bi-hand-thumbs-up"></i>
                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success">
                                            <?= $question['likes_count'] ?>
                                            <span class="visually-hidden">likes</span>
                                        </span>
                                    </button>
                                </form>
                            </div>
                            <div>
                                <span class="badge bg-secondary">
                                    <?= $question['category_name'] ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <a href="/questions/view.php?id=<?= $question['id'] ?>">
                            <h5 class="card-title"><?= $question['title'] ?></h5>
                        </a>
                        <p class="card-text"><?= $question['content'] ?></p>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <div>
                            Created by <a href="#">@<?= $question['username'] ?></a>
                            <span class="text-muted">
                                Created at <?= $question['created_at'] ?>
                            </span>
                        </div>
                        <?php if ($question['user_id'] === $_SESSION['user_id']) { ?>
                        <div>
                            <a class="btn btn-secondary" href="/questions/update.php?id=<?= $question['id'] ?>">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        <?php } ?>
    <?php } ?>
</div>

<?php require(BASE_PATH . '/partials/footer.php') ?>