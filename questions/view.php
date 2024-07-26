<?php
session_start();
const BASE_PATH = __DIR__ . '/../';

require BASE_PATH . '/config/db.php';
require BASE_PATH . '/config/Validator.php';

$questionId = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user_id'])) {
        header('Location: /auth/login.php');
        exit();
    }
    $errors = [];
    $answer = $_POST['answer'];
    $validator = new Validator();
    $validator->name('answer')->value($answer)->min(1)->required();
    if (!$validator->passes()) {
        $errors = $validator->getErrors();
    } else {
        $sql = 'INSERT INTO comments (question_id, body, user_id) VALUES (:question_id, :body, :user_id)';
        $stmt = $pdo->prepare($sql);
        $data = [
            ':question_id' => $questionId,
            ':body' => $answer,
            ':user_id' => $_SESSION['user_id']
        ];
        if ($stmt->execute($data)) {
            header('Location: /questions/view.php?id=' . $questionId);
            exit();
        } else {
            echo 'Something went wrong. Please try again.';
        }
    }
}

$query = 'SELECT questions.*, users.username, categories.name as category_name, count(likes.id) as likes_count 
FROM questions 
inner join users on questions.user_id = users.id 
inner join categories on questions.category_id = categories.id 
left join likes on questions.id = likes.question_id
where questions.id = :id';

$stmt = $pdo->prepare($query);
$stmt->execute([
    ':id' => $questionId
]);
$question = $stmt->fetch();

$answersQuery = '
SELECT comments.*, users.username as username
FROM comments 
inner join users on comments.user_id = users.id 
WHERE question_id = :id
';
$answers = $pdo->prepare($answersQuery);
$answers->execute([':id' => $questionId]);
$answers = $answers->fetchAll();

?>

<?php require(BASE_PATH . '/partials/header.php') ?>

<?php require(BASE_PATH . '/partials/nav.php') ?>

<div class="mt-5">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="d-flex">
                    <form action="/questions/likes.php" method="POST">
                        <input type="hidden" name="question_id" value="<?= $question['id'] ?>">

                        <button class="btn btn-success position-relative" <?php if (!isset($_SESSION['user_id']) || $question['user_id'] === $_SESSION['user_id']) { ?> disabled <?php   } ?>>
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
            
            <?php if (isset($_SESSION['user_id']) && $question['user_id'] === $_SESSION['user_id']) { ?>
                <div>
                    <a class="btn btn-secondary" href="/questions/update.php?id=<?= $question['id'] ?>">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>

    <h3 class="text-center mt-5 fw-bold fs-3">Answers</h3>

    <div class="mt-5">
        <?php if (!count($answers)) { ?>
            <p class="text-center text-secondary fw-bold fs-4">No answers found!</p>
        <?php } else { ?>
            <?php foreach ($answers as $answer) { ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <p><?= $answer['body'] ?></p>
                    </div>

                    <div class="card-footer">
                        Created by <a href="#">@<?= $answer['username'] ?></a>
                        <span class="text-muted">
                            Created at <?= $answer['created_at'] ?>
                        </span>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>


        <div class="card">
            <div class="card-header text-center fw-bold">
                Submit Answer
            </div>
            <div class="card-body">
                <form action="/questions/view.php?id=<?= $question['id'] ?>" method="POST">
                    <div class="mb-3">
                        <input type="text" hidden name="question_id" value="<?= $question['id'] ?>">
                        <label for="answer" class="form-label">Answer</label>
                        <textarea class="form-control" name="answer" id="answer" rows="5"></textarea>
                        <span class="text-danger"><?= $errors['answer'] ?? '' ?></span>
                    </div>
                    <button type="submit" class="btn btn-secondary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require(BASE_PATH . '/partials/footer.php') ?>