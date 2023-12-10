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

if (isset($_POST['add_product'])) {
     $designation = $_POST['designation'];
     $categorie = $_POST['categorie'];
     $quantite_en_stock = $_POST['quantite_en_stock'];
     $prix_unitaire = $_POST['prix_unitaire'];
     $promo = $_POST['promo'];

     // Retrieve the category ID based on the selected category name
     $sql2 = "SELECT code FROM categorie WHERE name = :name";
     $stmt2 = $conn->prepare($sql2);
     $stmt2->execute(array(':name' => $categorie));

     // Check if the fetch operation was successful
     $categoryRow = $stmt2->fetch(PDO::FETCH_ASSOC);
     if (!$categoryRow) {
          echo "Error: Category not found!<br>";
          // Handle the error as needed, e.g., exit the script or redirect
     } else {
          $code_c = $categoryRow['code'];

          // Handle image upload
          if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === 0) {
               $uploadDir = 'uploads/';
               $uploadFile = $uploadDir . basename($_FILES['product_image']['name']);

               // Check if the file has a valid image extension
               $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
               $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif');

               if (in_array($imageFileType, $allowedExtensions)) {
                    if (move_uploaded_file($_FILES['product_image']['tmp_name'], $uploadFile)) {
                         echo 'Image uploaded successfully.<br>';
                    } else {
                         echo 'Error uploading image.<br>';
                    }
               } else {
                    echo 'Invalid image format. Allowed formats: jpg, jpeg, png, gif.<br>';
               }
          }

          $imageFileName = isset($_FILES['product_image']) ? basename($_FILES['product_image']['name']) : null;

          // Insert into the database
          $sql = "INSERT INTO flower2 (designation, quantite_en_stock, prix_unitaire, promo, code_c, image) 
            VALUES (:designation, :quantite_en_stock, :prix_unitaire, :promo, :code_c, :image)";
          $stmt = $conn->prepare($sql);

          $stmt->bindParam(':image', $imageFileName, PDO::PARAM_STR);
          $stmt->execute(array(
               ':designation' => $designation,
               ':quantite_en_stock' => $quantite_en_stock,
               ':prix_unitaire' => $prix_unitaire,
               ':promo' => $promo,
               ':code_c' => $code_c,
               ':image' => $imageFileName,
          ));

          if ($stmt->rowCount() > 0) {
               header("Location: crudProduit.php");
               exit();
               echo "Product inserted successfully!<br>";
          } else {
               echo "Error: " . $stmt->errorInfo() . "<br>";
          }
     }
}
