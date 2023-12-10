<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Flower</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <meta content="" name="keywords" />
  <meta content="" name="description" />

  <!-- Favicon -->
  <link href="img/favicon.ico" rel="icon" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


  <!-- Google Web Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&family=Poppins:wght@600;700&display=swap" rel="stylesheet" />

  <!-- Icon Font Stylesheet -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

  <!-- Libraries Stylesheet -->
  <link href="lib/animate/animate.min.css" rel="stylesheet" />
  <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet" />

  <!-- Stylesheet -->
  <link href="css/bootstrap.min.css" rel="stylesheet" />
  <link href="css/style.css" rel="stylesheet" />



</head>

<body>

  <?php
  include 'header.php';
  ?>

  <!-- Table  -->
  <?php
  $produits = array(
    array(
      "code" => "FL001",
      "designation" => "Rose Rouge",
      "categorie" => "Fleurs coupées",
      "quantite_en_stock" => 100,
      "prix_unitaire" => 10.99,
      "promo" => "10%"
    ),
    array(
      "code" => "FL002",
      "designation" => "Lys Blanc",
      "categorie" => "Fleurs coupées",
      "quantite_en_stock" => 75,
      "prix_unitaire" => 12.49,
      "promo" => "20%"
    ),
    array(
      "code" => "FL003",
      "designation" => "Tulipe Jaune",
      "categorie" => "Bulbes de fleurs",
      "quantite_en_stock" => 200,
      "prix_unitaire" => 5.99,
      "promo" => "0%"
    ),
    array(
      "code" => "FL004",
      "designation" => "Orchidée Violette",
      "categorie" => "Plantes d'intérieur",
      "quantite_en_stock" => 50,
      "prix_unitaire" => 18.99,
      "promo" => "15%"
    ),
    array(
      "code" => "FL005",
      "designation" => "Muguet Blanc",
      "categorie" => "Bouquets de printemps",
      "quantite_en_stock" => 150,
      "prix_unitaire" => 7.99,
      "promo" => "5%"
    ),
    array(
      "code" => "FL006",
      "designation" => "Dahlia Rouge",
      "categorie" => "Bulbes de fleurs",
      "quantite_en_stock" => 80,
      "prix_unitaire" => 6.49,
      "promo" => "10%"
    )
  );

  ?>
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
                <span>Add New Employee</span></a>
              <a href="#deleteEmployeeModal" class="btn btn-danger" data-toggle="modal"><i class="material-icons">&#xE15C;</i> <span>Delete</span></a>
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
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($produits as $produit) : ?>
              <tr>
                <td><?php echo $produit["code"]; ?></td>
                <td><?php echo $produit["designation"]; ?></td>
                <td><?php echo $produit["categorie"]; ?></td>
                <td><?php echo $produit["quantite_en_stock"]; ?></td>
                <td><?php echo $produit["prix_unitaire"]; ?></td>
                <td><?php echo $produit["promo"]; ?></td>
                <td>
                  <a href="#editEmployeeModal" class="edit" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
                  <a href="#deleteEmployeeModal" class="delete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        <div class="clearfix">
          <div class="hint-text">
            Showing <b>5</b> out of <b>25</b> entries
          </div>
          <ul class="pagination">
            <li class="page-item disabled"><a href="#">Previous</a></li>
            <li class="page-item"><a href="#" class="page-link">1</a></li>
            <li class="page-item"><a href="#" class="page-link">2</a></li>
            <li class="page-item active">
              <a href="#" class="page-link">3</a>
            </li>
            <li class="page-item"><a href="#" class="page-link">4</a></li>
            <li class="page-item"><a href="#" class="page-link">5</a></li>
            <li class="page-item"><a href="#" class="page-link">Next</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <!-- ADD Modal HTML -->
  <div id="addEmployeeModal" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="crudProduit.php" method="get">
          <div class="modal-header">
            <h4 class="modal-title">Add Employee</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
              &times;
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>Code</label>
              <input type="text" name="code" class="form-control" required />
            </div>
            <div class="form-group">
              <label>Designation</label>
              <input type="text" name="designation" class="form-control" required />
            </div>
            <div class="form-group">
              <label>Categorie</label>
              <input type="text" name="categorie" class="form-control" required />
            </div>
            <div class="form-group">
              <label>Quantite en stock</label>
              <input type="text" name="quantite" class="form-control" required />
            </div>
            <div class="form-group">
              <label>Prix unitaire</label>
              <input type="text" name="prix" class="form-control" required />
            </div>
            <div class="form-group">
              <label>Promo</label>
              <input type="text" name="promo" class="form-control" required />
            </div>
          </div>
          <div class="modal-footer">
            <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel" />
            <input type="submit" class="btn btn-success" value="Add" />
          </div>
        </form>
        <?php
        if (isset($_GET['code']) && isset($_GET['designation']) && isset($_GET['categorie']) && isset($_GET['quantite']) && isset($_GET['prix']) && isset($_GET['promo'])) {
          $code = $_GET['code'];
          $designation = $_GET['designation'];
          $categorie = $_GET['categorie'];
          $quantite = $_GET['quantite'];
          $prix = $_GET['prix'];
          $promo = $_GET['promo'];
        }
        $newProduct = array(
          "code" => $code,
          "designation" => $designation,
          "categorie" => $categorie,
          "quantite_en_stock" => $quantite,
          "prix_unitaire" => $prix,
          "promo" => $promo
        );
        $produits[] = $newProduct;
        ?>
      </div>
    </div>
  </div>
  <!-- Edit Modal HTML -->
  <div id="editEmployeeModal" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">
        <form>
          <div class="modal-header">
            <h4 class="modal-title">Edit Employee</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
              &times;
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>Name</label>
              <input type="text" class="form-control" required />
            </div>
            <div class="form-group">
              <label>Email</label>
              <input type="email" class="form-control" required />
            </div>
            <div class="form-group">
              <label>Address</label>
              <textarea class="form-control" required></textarea>
            </div>
            <div class="form-group">
              <label>Phone</label>
              <input type="text" class="form-control" required />
            </div>
          </div>
          <div class="modal-footer">
            <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel" />
            <input type="submit" class="btn btn-info" value="Save" />
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Delete Modal HTML -->
  <div id="deleteEmployeeModal" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="crudProduit.php" method="get">
          <div class="modal-header">
            <h4 class="modal-title">Delete Employee</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
              &times;
            </button>
          </div>
          <div class="modal-body">
            <p>donner le code pour suprimer</p>
            <div class="form-group">
              <label>Code</label>
              <input type="text" name="code" class="form-control" required />
            </div>
          </div>
          <div class="modal-footer">
            <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel" />
            <input type="submit" class="btn btn-danger" value="Delete" />
          </div>
        </form>
        <?php
        if (isset($_GET['code'])) {
          $code = $_GET['code'];
          foreach ($produits as $key => $produit) {
            if ($produit['code'] === $code) {
              unset($produits[$key]);
            }
          }
        }
        $produits = array_values($produits);
        ?>
      </div>
    </div>
  </div>


  <?php
  include 'footer.php';
  ?>

  <!-- Back to Top -->
  <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>

  <!-- JavaScript Libraries -->
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="lib/wow/wow.min.js"></script>
  <script src="lib/easing/easing.min.js"></script>
  <script src="lib/waypoints/waypoints.min.js"></script>
  <script src="lib/owlcarousel/owl.carousel.min.js"></script>

  <!-- Template Javascript -->
  <script src="js/main.js"></script>
</body>

</html>