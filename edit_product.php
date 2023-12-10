<?php


include 'header.php';

$dsn = "mysql:host=localhost;dbname=flower";
$username = "root";
$password = "";

try {
     $conn = new PDO($dsn, $username, $password);
     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
     echo "Erreur de connexion à la base de données : " . $e->getMessage();
}

if (isset($_SESSION['username'])) {
     if (isset($_GET['code'])) {
          $productCode = $_GET['code'];

          // Fetch the product details from the database
          $sql = "SELECT * FROM flower2 WHERE code = :code";
          $stmt = $conn->prepare($sql);
          $stmt->bindParam(':code', $productCode);
          $stmt->execute();

          if ($stmt->rowCount() > 0) {
               $product = $stmt->fetch(PDO::FETCH_ASSOC);

               // Handle the form submission to update the product
               if (isset($_POST['update_product'])) {
                    $designation = $_POST['designation'];
                    $categorie = $_POST['categorie'];
                    $quantite_en_stock = $_POST['quantite_en_stock'];
                    $prix_unitaire = $_POST['prix_unitaire'];
                    $promo = $_POST['promo'];

                    // Update the product in the database
                    $updateSql = "UPDATE flower2 SET designation = :designation, code_c = :categorie, quantite_en_stock = :quantite_en_stock, prix_unitaire = :prix_unitaire, promo = :promo WHERE code = :code";
                    $updateStmt = $conn->prepare($updateSql);
                    $updateStmt->bindParam(':designation', $designation);
                    $updateStmt->bindParam(':categorie', $categorie);
                    $updateStmt->bindParam(':quantite_en_stock', $quantite_en_stock);
                    $updateStmt->bindParam(':prix_unitaire', $prix_unitaire);
                    $updateStmt->bindParam(':promo', $promo);
                    $updateStmt->bindParam(':code', $productCode);

                    if ($updateStmt->execute()) {
                         echo "Product updated successfully!";

                         // Handle image update
                         if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === 0) {
                              $uploadDir = 'uploads/';
                              $uploadFile = $uploadDir . basename($_FILES['product_image']['name']);

                              // Check if the file has a valid image extension
                              $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
                              $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif');

                              if (in_array($imageFileType, $allowedExtensions)) {
                                   if (move_uploaded_file($_FILES['product_image']['tmp_name'], $uploadFile)) {
                                        echo 'Image uploaded successfully.<br>';

                                        // Update the image file name in the database
                                        $updateImageSql = "UPDATE flower2 SET image = :image WHERE code = :code";
                                        $updateImageStmt = $conn->prepare($updateImageSql);
                                        $updateImageStmt->bindParam(':image', $_FILES['product_image']['name']);
                                        $updateImageStmt->bindParam(':code', $productCode);

                                        if ($updateImageStmt->execute()) {
                                             echo 'Image updated successfully.<br>';
                                        } else {
                                             echo 'Error updating image.<br>';
                                        }
                                   } else {
                                        echo 'Error uploading image.<br>';
                                   }
                              } else {
                                   echo 'Invalid image format. Allowed formats: jpg, jpeg, png, gif.<br>';
                              }
                         }
                    } else {
                         echo "Error updating product.";
                    }
               }
?>
               <div class="container px-5">
                    <h2>Edit Product</h2>
                    <form action="edit_product.php?code=<?php echo $productCode; ?>" method="post" enctype="multipart/form-data">
                         <div class="form-group">
                              <label for="designation">Designation:</label>
                              <input type="text" class="form-control" name="designation" value="<?php echo $product['designation']; ?>" required>
                         </div>
                         <div class="form-group">
                              <label for="categorie">Category:</label>
                              <select class="form-control" name="categorie" required>
                                   <?php
                                   // Fetch categories from the database
                                   $categorySql = "SELECT * FROM categorie";
                                   $categoryStmt = $conn->prepare($categorySql);
                                   $categoryStmt->execute();

                                   while ($categoryRow = $categoryStmt->fetch(PDO::FETCH_ASSOC)) {
                                        $selected = ($product['code_c'] == $categoryRow['code']) ? 'selected' : '';
                                        echo "<option value='" . $categoryRow['code'] . "' $selected>" . $categoryRow['name'] . "</option>";
                                   }
                                   ?>
                              </select>
                         </div>
                         <div class="form-group">
                              <label for="quantite_en_stock">Quantite en stock:</label>
                              <input type="text" class="form-control" name="quantite_en_stock" value="<?php echo $product['quantite_en_stock']; ?>" required>
                         </div>
                         <div class="form-group">
                              <label for="prix_unitaire">Prix unitaire:</label>
                              <input type="text" class="form-control" name="prix_unitaire" value="<?php echo $product['prix_unitaire']; ?>" required>
                         </div>
                         <div class="form-group">
                              <label for="promo">Promo:</label>
                              <input type="text" class="form-control" name="promo" value="<?php echo $product['promo']; ?>" required>
                         </div>
                         <div class="form-group">
                              <label for="product_image">Product Image:</label>
                              <input type="file" class="form-control" name="product_image">
                         </div>
                         <button type="submit" class="btn btn-primary" name="update_product">Update Product</button>
                         <a href="crudProduit.php" class="btn btn-secondary">Back to Products</a>
                    </form>
               </div>
<?php
          } else {
               echo "Product not found.";
          }
     } else {
          echo "Product code not provided.";
     }
} else {
     include "login.php";
}

include 'footer.php';
?>