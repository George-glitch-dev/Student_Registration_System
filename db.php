<?php
$host ="127.0.0.1";
$dbname ="school_db";
$username="root";
$password="";

try{
  $conn = new PDO(
    "mysql:host=127.0.0.1;port=3306;dbname=school_db;charset=utf8mb4",
       "root",
  
  );
  $conn->setAttribute(
    PDO::ATTR_ERRMODE,
    PDO::ERRMODE_EXCEPTION
  );

} catch (PDOException $e){
  die("Database connection failed: " . $e->getMessage());
}
?>


