<?php const BASE_PATH = __DIR__ . '/../'; ?>


<?php
session_start();
require BASE_PATH . '/config/db.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: /auth/login.php');
    exit();
}


$questionId = $_GET['id'];
$query = 'DELETE FROM questions WHERE id = :id';
$stmt = $pdo->prepare($query);
$stmt->execute([
    ':id' => $questionId
]);
header('Location: /questions');
exit();
?>