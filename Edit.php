<?php
require_once 'db.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($id === false || $id === null) {
    die('Invalid student ID.');
}

$stmt = $conn->prepare('SELECT * FROM students WHERE student_id = :id');
$stmt->execute([':id' => $id]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$student) {
    die('Student not found.');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <link rel="stylesheet" href="SR.CSS">
</head>
<body>

    <header>
        <nav>
            <div class="logo">STUDENT REGISTRATION SYSTEM</div>
            <a href="index.html">Register</a>
            <a href="view.php" class="active">Students</a>
        </nav>
    </header>

    <main class="container">
        <section class="form-section">
            <h1>Edit Student</h1>
            <p>Update the student's details below.</p>

            <form action="process_update.php" method="POST">
                <input type="hidden" name="student_id" value="<?= htmlspecialchars((string)$student['student_id']) ?>">

                <label for="name">Student Name</label>
                <input type="text" id="name" name="name" value="<?= htmlspecialchars($student['name']) ?>" required>

                <label for="course">Course</label>
                <input type="text" id="course" name="course" value="<?= htmlspecialchars($student['course']) ?>" required>

                <label for="age">Age</label>
                <input type="number" id="age" name="age" min="5" max="100" value="<?= htmlspecialchars((string)$student['age']) ?>" required>

                <button type="submit">Update Student</button>
            </form>

            <div class="links">
                <a href="view.php">Back to students</a>
            </div>
        </section>
    </main>

</body>
</html>