<?php
require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = filter_var($_POST['student_id'] ?? '', FILTER_VALIDATE_INT);
    $name = trim($_POST['name'] ?? '');
    $course = trim($_POST['course'] ?? '');
    $age = filter_var($_POST['age'] ?? '', FILTER_VALIDATE_INT);

    // Validate student information
    if (!$id || $name === '' || $course === '' ||
        $age === false || $age < 5 || $age > 100) {
        die("Invalid student information.");
    }

    // Update student record
    $sql = "UPDATE students
            SET name = :name, course = :course, age = :age
            WHERE student_id = :id";

    $stmt = $conn->prepare($sql);

    $stmt->execute([
        ':name' => $name,
        ':course' => $course,
        ':age' => $age,
        ':id' => $id
    ]);

    header("Location: view.php");
    exit;
}
?>