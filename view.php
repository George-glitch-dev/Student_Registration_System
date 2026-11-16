<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "db.php";

try {
    $sql = "SELECT * FROM students ORDER BY student_id DESC";
    $stmt = $conn->query($sql);
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registered Students</title>
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
    <section class="form-section students-section">
        <h1>Registered Students</h1>

        <?php if (($_GET['status'] ?? '') === 'deleted'): ?>
            <p class="registration-success" role="status">Student deleted successfully.</p>
        <?php elseif (($_GET['status'] ?? '') === 'not-found'): ?>
            <p class="registration-message" role="status">That student was not found.</p>
        <?php endif; ?>

        <div class="table-wrap">
            <table class="student-table">
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Name</th>
                        <th>Course</th>
                        <th>Age</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($students as $student): ?>
                    <tr>
                        <td><?= htmlspecialchars((string)$student['student_id']) ?></td>
                        <td><?= htmlspecialchars($student['name']) ?></td>
                        <td><?= htmlspecialchars($student['course']) ?></td>
                        <td><?= htmlspecialchars((string)$student['age']) ?></td>
                        <td>
                            <div class="table-actions">
                                <a class="table-action" href="edit.php?id=<?= urlencode((string)$student['student_id']) ?>">Edit</a>
                                <form class="delete-form" action="delete.php" method="POST" onsubmit="return confirm('Delete this student record? This cannot be undone.');">
                                    <input type="hidden" name="student_id" value="<?= htmlspecialchars((string)$student['student_id']) ?>">
                                    <button class="delete-action" type="submit">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
</main>

</body>
</html>