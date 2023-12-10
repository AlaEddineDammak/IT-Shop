<script>
  function showResult(str) {
    if (str.length == 0) {
      fetchAllProducts();
    } else {
      filterTable(str);
    }
  }

  function fetchAllProducts() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("productTableBody").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("GET", "fetch_all_products.php", true);
    xmlhttp.send();
  }

  function filterTable(query) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("productTableBody").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("GET", "filter_products.php?q=" + query, true);
    xmlhttp.send();
  }
</script>
<main>
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
    
  ?>
    <!-- Table -->
    <div class="container-xl">
      <div class="table-responsive">
        <div class="table-wrapper">
          <div class="table-title">
            <div class="row">
              <div class="col-sm-6">
                <h2>Gestion <b>Produit</b></h2>
              </div>
              <div class="col-sm-6">
                <a href="#addEmployeeModal" class="btn btn-success" data-toggle="modal"><i class="material-icons">&#xE147;</i>
                  <span>Ajouter model</span></a>
                <form>
                  <input type="text" size="30" onkeyup="showResult(this.value)" placeholder="Rechercher Produit...">

                  <div id="livesearch"></div>
                </form>
                <form action="add_categorie.php" method="post">
    <label for="name">Category Name:</label>
    <input type="text" name="name" required>
    <input type="submit" name="add_categorie" value="Add Category">
</form>


                     <a href="homePage.php" class="btn btn-primary"><i class="material-icons">&#xE88A;</i><span>Vue Client</span></a>
 <!-- Display Categories -->
                    <div class="categories-list">
                        <h3>Categories</h3>
                        <ul>
                       <?php
      $categorySql = "SELECT * FROM categorie";
      $categoryStmt = $conn->prepare($categorySql);
      $categoryStmt->execute();

      while ($categoryRow = $categoryStmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<li>";
        echo $categoryRow['name'];
        echo " - <a href='delete_category.php?code=" . $categoryRow['code'] . "'>Delete</a>";
        echo "</li>";
      }
      ?>
    </ul>
                  </div>
                </div>
              </div>
              <table class="table table-striped table-hover">
                <thead>
                  <tr>
                    <th>Code</th>
                    <th>Designation</th>
                    <th>Categorie</th>
                    <th>Quantite en stock</th>
                    <th>Prix unitaire</th>
                    <th>Promo</th>
                    <th>image</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody id="productTableBody">
              <?php
              $sql = "SELECT f.code, f.designation, f.quantite_en_stock, f.prix_unitaire, f.promo, f.code_c, f.image , c.name AS categorie FROM flower2 f
                      LEFT JOIN categorie c ON f.code_c = c.code";
              $stmt = $conn->prepare($sql);
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
                }
              } else {
                echo "<tr><td colspan='7'>No records found</td></tr>";
              }

              ?>
            </tbody>
          </table>
        </div>
        <!-- ADD Modal HTML -->
        <div id="addEmployeeModal" class="modal fade">
          <div class="modal-dialog">
            <div class="modal-content">
              <form action="add_product.php" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                  <h4 class="modal-title">Add New Product</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                  </button>
                </div>
                <div class="modal-body">
                  <div class="form-group">
                    <label>Designation</label>
                    <input type="text" name="designation" class="form-control" required />
                  </div>
                  <div class="form-group">
                    <label>Categorie</label>
                    <select class="form-control" name="categorie" required>
                      <?php
                      // Fetch categories from the database
                      $categorySql = "SELECT * FROM categorie";
                      $categoryStmt = $conn->prepare($categorySql);
                      $categoryStmt->execute();

                      while ($categoryRow = $categoryStmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='" . $categoryRow['name'] . "'>" . $categoryRow['name'] . "</option>";
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Quantite en stock</label>
                    <input type="text" name="quantite_en_stock" class="form-control" required />
                  </div>
                  <div class="form-group">
                    <label>Prix unitaire</label>
                    <input type="text" name="prix_unitaire" class="form-control" required />
                  </div>
                  <div class="form-group">
                    <label>Promo</label>
                    <input type="text" name="promo" class="form-control" required />
                  </div>
                  <div class="form-group">
                    <label>Product Image</label>
                    <input type="file" name="product_image" class="form-control" />
                  </div>
                </div>
                <div class="modal-footer">
                  <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel" />
                  <input type="submit" class="btn btn-success" value="Add Product" name="add_product" />
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php
      include 'footer.php';
      ?>
  <?php
  } else {
     header("Location: login.php");

  }
  ?>
</main>

