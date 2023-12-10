<?php
$dsn = "mysql:host=localhost;dbname=flower";
$username = "root";
$password = "";

try {
     $conn = new PDO($dsn, $username, $password);
     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
     echo "Erreur de connexion à la base de données : " . $e->getMessage();
}

if (isset($_GET['q'])) {
     $query = $_GET['q'];

     // Modify the query to include all products if the input is empty
     $sql = empty($query)
          ? "SELECT f.code, f.designation, f.quantite_en_stock, f.prix_unitaire, f.promo, f.code_c, f.image , c.name AS categorie FROM flower2 f LEFT JOIN categorie c ON f.code_c = c.code"
          : "SELECT code, designation FROM flower2 WHERE designation LIKE :query";

     $stmt = $conn->prepare($sql);

     if (!empty($query)) {
          $stmt->bindValue(':query', '%' . $query . '%', PDO::PARAM_STR);
     }

     $stmt->execute();

     if ($stmt->rowCount() > 0) {
          echo "<ul>";
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
               echo "<li><a href='#'>" . $row['designation'] . "</a></li>";
          }
          echo "</ul>";
     } else {
          echo "No results found";
     }
}
