<!doctype html>
<html lang="en" data-bs-theme="auto">

<head>
  <meta charset="utf-8" />
  <title>Login</title>
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
  <?php
  session_start();

  $db_server = "localhost";
  $db_user = "root";
  $db_pass = "";
  $db_name = "flower";

  $conn = new mysqli($db_server, $db_user, $db_pass, $db_name);

  $username = "";
  $password = "";
  $message = "";

  if (isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
    $username = $_COOKIE['username'];
    $password = $_COOKIE['password'];
  }

  $sql = "SELECT * FROM users";
  $result = $conn->query($sql);

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        if ($row["username"] === $username && $row["password"] === $password) {
          $_SESSION['username'] = $username;

          setcookie('username', $username, time() + 3600);
          setcookie('password', $password, time() + 3600);

          header("Location: crudProduit.php");
          $conn->close();
          exit();
        }
      }
    } else {
      $message = "Invalid username or password. Please try again.";
    }
  }
  ?>


  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
  </head>

  <body>
    <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
      <main class="form-signin" style=" width: 40%;">
        <form method="POST" action="">
          <h1 class="h3 mb-3 fw-normal">Sign in</h1>
          <?php if (!empty($message)) { ?>
            <div class="alert alert-danger" role="alert">
              <?php echo $message; ?>
            </div>
          <?php } ?>
          <div class="form-floating">
            <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?php echo $username; ?>">
            <label for="username">Username</label>
          </div>
          <div class="form-floating">
            <input type="password" class="form-control" id="password" name="password" placeholder="Password" value="<?php echo $username; ?>">
            <label for="password">Password</label>
          </div>
          <div class="form-check text-start my-3">
            <input class="form-check-input" type="checkbox" value="remember-me" id="flexCheckDefault">
            <label class="form-check-label" for="flexCheckDefault">
              Remember me
            </label>
          </div>
          <button class="btn btn-primary w-100 py-2" type="submit">Sign in</button>
        </form>
        <div class="py-2">
          <a href="sign-up-base.php"><button class="btn btn-primary w-100 py-2" type="submit">Sign up</button></a>
        </div>
      </main>
    </div>
  </body>

  </html>

</html>