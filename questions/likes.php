<?php
session_start();

const BASE_PATH = __DIR__ . '/../';

require BASE_PATH . '/config/db.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql = 'INSERT INTO likes (question_id, user_id) VALUES (:question_id, :user_id)';
    $stmt = $pdo->prepare($sql);

    $questionId = $_POST['question_id'];

    $data = [
        ':question_id' => $questionId,
        ':user_id' => $_SESSION['user_id'],
    ];

    if ($stmt->execute($data)) {
        $_SESSION['message'] = 'Question liked successfully!';
        header('Location: /');
        exit();
    } else {
        echo 'Something went wrong. Please try again.';
    }
}
