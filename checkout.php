<?php
include "header.php";

$dsn = "mysql:host=localhost;dbname=flower";
$username = "root";
$password = "";

try {
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
}

// Initialize the $products array
$products = array();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
</head>

<body>
    <h2>Checkout</h2>

    <ul>
        <?php
        $totalAmount = 0;

        foreach ($_SESSION['cart'] as $productId => $quantity) {
            $stmt = $conn->prepare("SELECT * FROM flower2 WHERE code = :code");
            $stmt->bindParam(":code", $productId);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                $products[$row["code"]] = $row;
                $subtotal = $quantity * $row['prix_unitaire'] * (1 - $row['promo'] / 100);
                $totalAmount += $subtotal;

                ?>
                <li>
                    <?php echo $row['designation']; ?> - Price:
                    <?php echo $row['prix_unitaire']; ?> - Promo:
                    <?php echo $row['promo']; ?>% - Quantity:
                    <?php echo $quantity; ?> - Subtotal:
                    <?php echo $subtotal; ?>
                </li>
                <?php
            }
        }
        ?>
    </ul>

    <h3>Total Amount:
        <?php echo $totalAmount; ?>
    </h3>

    Purchase successful!

</body>

<?php include "footer.php"; ?>

</html>