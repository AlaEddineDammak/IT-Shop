<?php
session_start();

$dsn = "mysql:host=localhost;dbname=flower";
$username = "root";
$password = "";

try {
     $conn = new PDO($dsn, $username, $password);
     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
     echo "Erreur de connexion à la base de données : " . $e->getMessage();
}

if (isset($_GET['code'])) {
     $code = $_GET['code'];

     try {
          $sql = "DELETE FROM flower2 WHERE code = :code";
          $stmt = $conn->prepare($sql);
          $stmt->bindParam(':code', $code);
          $stmt->execute();

          if ($stmt->rowCount() > 0) {
               header("Location: crudProduit.php");
               exit();
          } else {
               echo "Error: Product not found or could not be deleted.<br>";
          }
     } catch (PDOException $e) {
          echo "Error: " . $e->getMessage() . "<br>";
     }
} else {
     echo "Error: Product code not provided.<br>";
}
