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

// Handle remove from cart action
if (isset($_POST['remove_from_cart'])) {
    $productId = $_POST['product_id'];
    if (isset($_SESSION['cart'][$productId])) {
        unset($_SESSION['cart'][$productId]);
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
</head>

<body>
    <h2>Shopping Cart</h2>

    <ul>
        <?php
        foreach ($_SESSION['cart'] as $productId => $quantity) {
            $stmt = $conn->prepare("SELECT * FROM flower2 WHERE code = :code");
            $stmt->bindParam(":code", $productId);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                $products[$row["code"]] = $row;
                ?>
                <li>
                    <?php echo $row['designation']; ?> (Quantity:
                    <?php echo $quantity; ?>)
                    <form method="post" style="display: inline-block;">
                        <input type="hidden" name="product_id" value="<?php echo $productId; ?>">
                        <button type="submit" name="remove_from_cart">Remove from Cart</button>
                    </form>
                </li>
                <?php
            }
        }
        ?>
    </ul>

    <!-- Add to Cart Modal Overlay -->
    <div class="modal-overlay" id="modalOverlay" onclick="closeModal()"></div>

    <!-- Add to Cart Modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">View Cart</h4>
                <span class="close" onclick="closeModal()">&times;</span>
            </div>
            <div class="modal-body">
                <ul>
                    <?php
                    foreach ($_SESSION['cart'] as $productId => $quantity) {
                        $stmt = $conn->prepare("SELECT * FROM flower2 WHERE code = :code");
                        $stmt->bindParam(":code", $productId);
                        $stmt->execute();
                        $row = $stmt->fetch(PDO::FETCH_ASSOC);

                        if ($row) {
                            $products[$row["code"]] = $row;
                            ?>
                            <li>
                                <?php echo $row['designation']; ?> -
                                <?php echo $row['prix_unitaire']; ?> -
                                <?php echo $row['promo']; ?> (Quantity:
                                <?php echo $quantity; ?>)
                                <form method="post" style="display: inline-block;">
                                    <input type="hidden" name="product_id" value="<?php echo $productId; ?>">
                                    <button type="submit" name="remove_from_cart">Remove from Cart</button>
                                </form>
                            </li>
                            <?php
                        }
                    }
                    ?>
                </ul>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" onclick="closeModal()">Close</button>
                <a class="btn btn-success" href="checkout.php">Checkout</a>
            </div>
        </div>
    </div>

    <!-- View Cart Button -->
    <button class="view-cart-button" onclick="openModal()">View Cart</button>

    <!-- JavaScript for the Modal -->
    <script>
        function openModal() {
            var modalOverlay = document.getElementById("modalOverlay");
            var modal = document.getElementById("myModal");
            modalOverlay.style.display = "block";
            modal.style.display = "block";
        }

        function closeModal() {
            var modalOverlay = document.getElementById("modalOverlay");
            var modal = document.getElementById("myModal");
            modalOverlay.style.display = "none";
            modal.style.display = "none";
        }
    </script>
</body>

<?php include "footer.php"; ?>

</html>