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

    $questionId = $_POST['id'];
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
        $sql = '
        Update questions
        set title = :title, content = :content, category_id = :category_id
        where id = :id
        ';
        $stmt = $pdo->prepare($sql);

        $data = [
            ':title' => $title,
            ':content' => $content,
            ':category_id' => $category_id,
            ':id' => $questionId
        ];

        if ($stmt->execute($data)) {
            header('Location: /questions/view.php?id=' . $questionId);
            exit();
        } else {
            echo 'Something went wrong. Please try again.';
        }
    }
}

$questionId = $_GET['id'];
$query = 'SELECT * FROM questions where questions.id = :id';
$stmt = $pdo->prepare($query);
$stmt->execute([
    ':id' => $questionId
]);
$question = $stmt->fetch();

$categories = $pdo->query('SELECT * FROM categories')->fetchAll();

?>

<?php require(BASE_PATH . '/partials/header.php') ?>

<?php require(BASE_PATH . '/partials/nav.php') ?>

<form method="POST" action="/questions/update.php?id=<?= $question['id'] ?>">
    <input type="text" hidden name="id" value="<?= $question['id'] ?>">
    <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="title" class="form-control" name="title" id="title" value="<?= $question['title'] ?>">
        <span class="text-danger"><?= $errors['title'] ?? '' ?></span>
    </div>
    <div class="mb-3">
        <label for="content" class="form-label">Content</label>
        <div id="editor">
          <?= $question['content'] ?>
        </div>
        <input type="hidden" name="content" id="content">
        <span class="text-danger"><?= $errors['content'] ?? '' ?></span>
    </div>
    <div class="mb-3">
        <label for="category" class="form-label">Category</label>
        <select id="category" name="category_id" class="form-select">
            <?php foreach ($categories as $category) { ?>
                <option value="<?= $category['id'] ?>" <?php if ($category['id'] === $question['category_id']) { ?> selected <?php } ?>><?= $category['name'] ?></option>
            <?php } ?>
        </select>
        <span class="text-danger"><?= $errors['category_id'] ?? '' ?></span>
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
</form>

<script type="module">
    import {
        ClassicEditor,
        Essentials,
        Paragraph,
        Bold,
        Italic,
        Font,
        CodeBlock
    } from 'ckeditor5';

    ClassicEditor
        .create(document.querySelector('#editor'), {
            plugins: [Essentials, Paragraph, Bold, Italic, Font, CodeBlock],
            toolbar: [
                'undo', 'redo', '|', 'bold', 'italic', '|',
                'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'codeBlock'
            ]
        })
        .then(editor => {
            window.editor = editor;
            document.querySelector('form').addEventListener('submit', () => {
                document.querySelector('#content').value = editor.getData();
            });
        })
        .catch(error => {
            console.error(error);
        });
</script>

<?php require(BASE_PATH . '/partials/footer.php') ?>