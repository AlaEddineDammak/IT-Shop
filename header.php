<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Your IT-Shop</title>
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
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>

  <header class="container-fluid bg-dark py-4 mb-4 wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-4">
      <h2 class="display-4 text-white animated slideInDown">IT-Shop</h2>
    </div>
    <nav class="navbar navbar-expand-lg sticky-top px-4 px-lg-5">
      <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
      </button>

      <?php
      session_start();

      if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
      } else {
        $username = "you should be logged in";
      }

      if (isset($_POST['logout'])) {
        session_unset();
        session_destroy();

        header('Location: crudProduit.php');
        exit();
      }
      ?>

      <form method="POST" action="">
        <div class="collapse navbar-collapse" id="navbarCollapse">
          <div class="d-flex flex-column align-items-start">
            <div class="">
              <h4 class="breadcrumb-item text-white">Welcome, <?php echo $username; ?></h4>
            </div>
            <div>
              <?php if ($username != "you should be logged in") : ?>
                <button type="submit" class="btn btn-primary w-100 py-2 text-white me-2" name="logout">
                  <i class="fa fa-sign-out fa-lg" aria-hidden="true"></i>
                  <span class="logout-text">Logout</span>
                </button>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </form>


    </nav>
  </header>