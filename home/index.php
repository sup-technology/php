<?php const BASE_PATH = __DIR__ . '/../'; ?>

<?php
session_start();
require BASE_PATH . '/config/db.php';

$search = isset($_GET['search']) ? $_GET['search'] : '';
$categories = isset($_GET['categories']) ? $_GET['categories'] : [];

$query = 'SELECT questions.*, users.username FROM questions inner join users on questions.user_id = users.id WHERE (title LIKE :search OR content LIKE :search)';
$params = [':search' => '%' . $search . '%'];

if (!empty($categories)) {
    $placeholders = [];
    foreach ($categories as $index => $category) {
        $placeholders[] = ':category_' . $index;
        $params[':category_' . $index] = $category;
    }
    $query .= ' AND questions.category_id IN (' . implode(',', $placeholders) . ')';
}

$query .= ' ORDER BY id DESC ';

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

        <div class="row mt-5">
            <?php if (!count($questions)) { ?>
                <p class="text-center text-secondary fw-bold fs-4">No questions found!</p>
            <?php } else { ?>
                <?php foreach ($questions as $question) { ?>
                    <div class="col-md-4 mb-2">
                    <div class="card" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title"><?= $question['title'] ?></h5>
                            <p class="card-text"><?= $question['content'] ?></p>
                        </div>
                        <div class="card-footer">
                            Created by <a href="#">@<?= $question['username'] ?></a>
                        </div>
                    </div>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
</div>

<?php require('partials/footer.php') ?>