<?php
include "header.php";

// Check if the product code is provided in the URL
if (isset($_GET['code'])) {
    $productCode = $_GET['code'];

    // Database connection
    $dsn = "mysql:host=localhost;dbname=flower";
    $username = "root";
    $password = "";

    try {
        $conn = new PDO($dsn, $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Erreur de connexion à la base de données : " . $e->getMessage();
    }

    // Query to retrieve product details
    $sql = "SELECT * FROM flower2 WHERE code = :code";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':code', $productCode);
    $stmt->execute();

    // Fetch product details
    $productDetails = $stmt->fetch(PDO::FETCH_ASSOC);

    // Display product details
    if ($productDetails) {
        echo "<h1>Product Details</h1>";
        echo "<p><strong>Designation:</strong> " . $productDetails['designation'] . "</p>";
        echo "<p><strong>Categorie:</strong> " . $productDetails['code_c'] . "</p>";
        echo "<p><strong>Quantite en Stock:</strong> " . $productDetails['quantite_en_stock'] . "</p>";
        echo "<p><strong>Prix Unitaire:</strong> " . $productDetails['prix_unitaire'] . "</p>";
        echo "<p><strong>Promo:</strong> " . $productDetails['promo'] . "</p>";
        echo "<p><strong>Image:</strong> <img src='uploads/" . $productDetails['image'] . "' alt='Product Image' style='max-width: 200px; max-height: 200px;'></p>";
    } else {
        echo "<p>Product not found</p>";
    }
} else {
    echo "<p>Product code not provided</p>";
}

include "footer.php";
?>