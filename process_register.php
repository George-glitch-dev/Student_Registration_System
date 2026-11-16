<?php
require_once 'db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
  $name = trim($_POST['name'] ?? "");
  $course = trim($_POST['course'] ?? "");
  $age = trim($_POST['age'] ?? "");
  if ($name === "" || $course === "" || $age === ""){
    die("All fields are required.");
  }
  if (filter_var ($age, FILTER_VALIDATE_INT) === false ||
   (int)$age < 5 || (int)$age > 100){
    die("Age must be a positive integer.");
  }
  try{
    $stmt = $conn->prepare("INSERT INTO students (name, course, age) VALUES (:name, :course, :age)");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':course', $course);
    $stmt->bindParam(':age', $age);
    $stmt->execute();
    header('Location: view.php');
    exit;
  } catch (PDOException $e){
    die("Error registering student: " . $e->getMessage());
  }

}else{
  die("Invalid request method.");
}
?>