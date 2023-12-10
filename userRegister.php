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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST["username"];
  $password = $_POST["password"];

  // Check if the username already exists
  $stmt_check = $conn->prepare("SELECT username FROM users WHERE username = :username");
  $stmt_check->execute(array(':username' => $username));

  if ($stmt_check->fetch(PDO::FETCH_ASSOC)) {
    $message = "Username already exists. Please choose a different username.";
  } else {
    // Insert the new user into the database
    $stmt_insert = $conn->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
    $stmt_insert->execute(array(':username' => $username, ':password' => $password));

    header("Location: login.php");
    exit();
  }
}
?>

<section>
  <div class="container d-flex justify-content-center align-items-center" style="height: 50vh;">
    <main class="form-signin" style="width: 40%;">
      <form method="POST" action="">
        <h1 class="h3 mb-3 fw-normal">Register</h1>
        <?php
        if (!empty($message)) {
          echo '<div class="alert alert-info" role="alert">' . $message . '</div>';
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
        
        <button class="btn btn-primary w-100 py-2" type="submit">Register</button>
      </form>
    </main>
  </div>
</section>
<?php
include 'footer.php';
?>