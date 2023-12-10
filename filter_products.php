<?php

$dsn = "mysql:host=localhost;dbname=flower";
$username = "root";
$password = "";

try {
     $conn = new PDO($dsn, $username, $password);
     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

     $q = $_GET['q'];

     $sql = "SELECT f.code, f.designation, f.quantite_en_stock, f.prix_unitaire, f.promo, f.code_c, f.image , c.name AS categorie 
            FROM flower2 f
            LEFT JOIN categorie c ON f.code_c = c.code
            WHERE f.designation LIKE :q";

     $stmt = $conn->prepare($sql);
     $stmt->bindValue(':q', '%' . $q . '%', PDO::PARAM_STR);
     $stmt->execute();

     if ($stmt->rowCount() > 0) {
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
               echo "<tr>";
               echo "<td>" . $row["code"] . "</td>";
               echo "<td>" . $row["designation"] . "</td>";
               echo "<td>" . $row["categorie"] . "</td>";
               echo "<td>" . $row["quantite_en_stock"] . "</td>";
               echo "<td>" . $row["prix_unitaire"] . "</td>";
               echo "<td>" . $row["promo"] . "</td>";
               echo "<td><img src='uploads/" . $row["image"] . "' alt='Product Image' style='max-width: 100px; max-height: 100px;'></td>";
               echo "<td>
                <a href='edit_product.php?code=" . $row['code'] . "'><i class='material-icons'>&#xE254;</i></a>
                <a href='delete_product.php?code=" . $row['code'] . "'><i class='material-icons'>&#xE872;</i></a>
                </td>";
               echo "</tr>";
          }
     } else {
          echo "<tr><td colspan='7'>No matching products found</td></tr>";
     }
} catch (PDOException $e) {
     echo "Connection failed: " . $e->getMessage();
}
