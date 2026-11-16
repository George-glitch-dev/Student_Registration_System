<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    header('Allow: POST');
    exit('Method not allowed.');
}

$id = filter_input(INPUT_POST, 'student_id', FILTER_VALIDATE_INT);
if ($id === false || $id === null || $id < 1) {
    http_response_code(400);
    exit('Invalid student ID.');
}

$stmt = $conn->prepare('DELETE FROM students WHERE student_id = :id');
$stmt->execute([':id' => $id]);

$status = $stmt->rowCount() === 1 ? 'deleted' : 'not-found';
header('Location: view.php?status=' . $status);
exit;
