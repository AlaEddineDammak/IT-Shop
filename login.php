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

$username = "";
$password = "";
$message = "";

if (isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
  $username = $_COOKIE['username'];
  $password = $_COOKIE['password'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST["username"];
  $password = $_POST["password"];

  try {
    $stmt = $conn->prepare("SELECT username, admin FROM users WHERE username = :username AND password = :password");
    $stmt->execute(array(':username' => $username, ':password' => $password));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
      if (isset($_POST['remember_me'])) {
        setcookie('username', $username, time() + 86400);
        setcookie('password', $password, time() + 86400);
      } else {
        setcookie('username', '', time() - 3600);
        setcookie('password', '', time() - 3600);
      }

      $_SESSION['username'] = $username;

      if ($row['admin'] == 1) {
        // Redirect to crudProduit.php if the user is an admin
        header("Location: crudProduit.php");
        exit();
      } else {
        // Redirect to homePage.php for non-admin users
        header("Location: homePage.php");
        exit();
      }
    } else {
      echo "Invalid username or password. Please try again.";
      setcookie('username', '', time() - 3600);
      setcookie('password', '', time() - 3600);
      $message = "Invalid username or password. Please try again.";
    }
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
}

?>

<section>
  <div class="container d-flex justify-content-center align-items-center" style="height: 50vh;">
    <main class="form-signin" style="width: 40%;">
      <form method="POST" action="">
        <h1 class="h3 mb-3 fw-normal">Sign in</h1>
        <?php
        if (!empty($message)) {
          echo '<div class="alert alert-danger" role="alert">' . $message . '</div>';
        }
        ?>
        <div class="form-floating">
          <input type="text" class="form-control" id="username" name="username" placeholder="Username"
            value="<?php echo $username ?>">
          <label for="username">Username</label>
        </div>
        <div class="form-floating">
          <input type="password" class="form-control" id="password" name="password" placeholder="Password"
            value="<?php echo $password ?>">
          <label for="password">Password</label>
        </div>
        <div class="form-check text-start my-3">
          <input class="form-check-input" type="checkbox" value="remember-me" id="flexCheckDefault" name="remember_me">
          <label class="form-check-label" for="flexCheckDefault">
            Remember me
          </label>
        </div>
        <button class="btn btn-primary w-100 py-2" type="submit">Sign in</button>
      </form>
    </main>
  </div>
</section>
<?php
include 'footer.php';
?>