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
  include 'header.php';
  session_start();

  $users = array(
    'Mahdiii' => '12345',
  );

  $username = "";
  $password = "";
  $username2 = "";
  $password2 = "";
  $message = "";
  $rememberMeValue = false;

  if (isset($_COOKIE['username2']) && isset($_COOKIE['password2'])) {
    $username2 = $_COOKIE['username2'];
    $password2 = $_COOKIE['password2'];
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    if (array_key_exists($username, $users) && $users[$username] == $password) {
      $_SESSION['username'] = $username;

      if (isset($_POST['remember_me']) && $_POST['remember_me'] == 'remember-me') {
        $rememberMeValue = true;
        $username2 = $_POST["username"];
        $password2 = $_POST["password"];

        setcookie('username2', $username, time() + 3600);
        setcookie('password2', $password, time() + 3600);
      } else {
        setcookie("username2", "", time() - 3600, "/");
        setcookie("password2", "", time() - 3600, "/");
      }

      header("Location: crudProduit3.php");
      exit();
    } else {
      $message = "Invalid username or password. Please try again.";
    }
  }
  ?>

  <body>
    <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
      <main class="form-signin" style=" width: 40%;">
        <form method="POST" action="">
          <h1 class="h3 mb-3 fw-normal">Sign in</h1>
          <?php
          if (!empty($message)) {
            echo '<div class="alert alert-danger" role="alert">' . $message . '</div>';
          }
          ?>
          <div class="form-floating">
            <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?php echo htmlspecialchars($rememberMeValue ? $username2 : ''); ?>">
            <label for="username">Username</label>
          </div>
          <div class="form-floating">
            <input type="password" class="form-control" id="password" name="password" placeholder="Password" value="<?php echo htmlspecialchars($rememberMeValue ? $password2 : ''); ?>">
            <label for="password">Password</label>
          </div>
          <div class="form-check text-start my-3">
            <input class="form-check-input" type="checkbox" value="remember-me" id="flexCheckDefault" name="remember_me" <?php if ($rememberMeValue) echo 'checked'; ?>>
            <label class="form-check-label" for="flexCheckDefault">
              Remember me
            </label>
          </div>
          <button class="btn btn-primary w-100 py-2" type="submit">Sign in</button>
        </form>
      </main>
    </div>


    <?php
    include 'footer.php';
    ?>
  </body>

</html>

</html>