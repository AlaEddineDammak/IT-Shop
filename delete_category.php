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
        // Check if the category is associated with any products before deleting
        $checkProductsQuery = "SELECT * FROM flower2 WHERE code_c = :code";
        $checkProductsStmt = $conn->prepare($checkProductsQuery);
        $checkProductsStmt->bindParam(':code', $code);
        $checkProductsStmt->execute();

        if ($checkProductsStmt->rowCount() > 0) {
            echo "Error: Cannot delete category with associated products.<br>";
            // Handle the error as needed, e.g., exit the script or redirect
        } else {
            // Delete the category
            $deleteCategoryQuery = "DELETE FROM categorie WHERE code = :code";
            $deleteCategoryStmt = $conn->prepare($deleteCategoryQuery);
            $deleteCategoryStmt->bindParam(':code', $code);
            $deleteCategoryStmt->execute();

            if ($deleteCategoryStmt->rowCount() > 0) {
                header("Location: crudProduit.php");
                exit();
            } else {
                echo "Error: Category not found or could not be deleted.<br>";
            }
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage() . "<br>";
    }
} else {
    echo "Error: Category code not provided.<br>";
}
?>