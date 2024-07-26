<?php const BASE_PATH = __DIR__ . '/../'; ?>

<?php
session_start();
require BASE_PATH . '/config/db.php';
$search = isset($_GET['search']) ? $_GET['search'] : '';
$categories = isset($_GET['categories']) ? $_GET['categories'] : [];

$query = '
SELECT questions.*, users.username, categories.name as category_name, count(likes.id) as likes_count 
FROM questions 
inner join users on questions.user_id = users.id 
inner join categories on questions.category_id = categories.id 
left join likes on questions.id = likes.question_id 
WHERE (title LIKE :search OR content LIKE :search)';

$params = [':search' => '%' . $search . '%'];

if (!empty($categories)) {
    $placeholders = [];
    foreach ($categories as $index => $category) {
        $placeholders[] = ':category_' . $index;
        $params[':category_' . $index] = $category;
    }
    $query .= ' AND questions.category_id IN (' . implode(',', $placeholders) . ')';
}

$query .= ' 
group by questions.id, users.username, categories.name  
ORDER BY id DESC';

$stmt = $pdo->prepare($query);
$stmt->execute($params);

$questions = $stmt->fetchAll();
$categories = $pdo->query('SELECT * FROM categories')->fetchAll();

?>

<?php require('partials/header.php') ?>
<?php require('partials/nav.php') ?>

<p class="text-center fw-bold fs-2">
    Home
</p>


<?php if (isset($_SESSION['message'])) { ?>
    <div class="alert alert-success" role="alert">
        <?= $_SESSION['message'] ?>
    </div>
<?php unset($_SESSION['message']);
} ?>

<div class="d-flex justify-content-between">
    <div class="col-4">
        <div class="card" style="width: 24rem;">
            <div class="card-body">
                <h5 class="card-title">Filter By Categories</h5>
                <p class="card-text">
                <div class="categories">
                    <form action="/" method="GET">
                        <?php foreach ($categories as $category) { ?>
                            <div class="col-md-auto">
                                <div class="form-check">
                                    <input class="form-check-input" id="<?= $category['id'] ?>" type="checkbox" name="categories[]" value="<?= $category['id'] ?>" <?= in_array($category['id'], $_GET['categories'] ?? []) ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="<?= $category['id'] ?>">
                                        <?= $category['name'] ?>
                                    </label>
                                </div>
                            </div>
                        <?php } ?>
                        <button type="submit" class="btn btn-primary mt-3">
                            Filter
                        </button>
                    </form>
                </div>
                </p>
            </div>
        </div>
    </div>
    <div class="col-8 side-2">
        <div>
            <form action="/" method="GET">
                <div class="d-flex justify-content-center">
                    <input type="text" value="<?= $search ?>" name="search" placeholder="Search" class="form-control">
                    <button type="submit" class="btn btn-primary ms-2">Search</button>
                </div>
            </form>
        </div>
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
                            <div class="card-footer">
                                Created by <a href="#">@<?= $question['username'] ?></a>
                                <span class="text-muted">
                                    Created at <?= $question['created_at'] ?>
                                </span>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
</div>

<?php require('partials/footer.php') ?>