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

if (isset($_POST['add_categorie'])) {
    $name = $_POST['name'];

    // Check if the category with the same name already exists
    $checkCategoryQuery = "SELECT * FROM categorie WHERE name = :name";
    $checkCategoryStmt = $conn->prepare($checkCategoryQuery);
    $checkCategoryStmt->bindParam(':name', $name);
    $checkCategoryStmt->execute();

    if ($checkCategoryStmt->rowCount() > 0) {
        echo "Error: Category with the same name already exists!<br>";
        // Handle the error as needed, e.g., exit the script or redirect
    } else {
        // Insert into the database
        $insertCategoryQuery = "INSERT INTO categorie (name) VALUES (:name)";
        $insertCategoryStmt = $conn->prepare($insertCategoryQuery);
        $insertCategoryStmt->bindParam(':name', $name);

        if ($insertCategoryStmt->execute()) {
            header("Location: crudProduit.php");
            exit();
            echo "Category inserted successfully!<br>";
        } else {
            echo "Error: " . $insertCategoryStmt->errorInfo() . "<br>";
        }
    }
}
?>