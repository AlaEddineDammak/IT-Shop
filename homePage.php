<?php
include "header.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$dsn = "mysql:host=localhost;dbname=flower";
$username = "root";
$password = "";

try {
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
}

// Check if the toggle button is clicked
if (isset($_POST['toggle_promo'])) {
    // Toggle the session variable to control the view
    $_SESSION['show_promo_only'] = !isset($_SESSION['show_promo_only']) || !$_SESSION['show_promo_only'];
}

// Modify the SQL query based on the toggle status
$sql = "SELECT f.code, f.designation, f.quantite_en_stock, f.prix_unitaire, f.promo, f.code_c, f.image, c.name AS categorie FROM flower2 f
        LEFT JOIN categorie c ON f.code_c = c.code";
if (isset($_SESSION['show_promo_only']) && $_SESSION['show_promo_only']) {
    $sql .= " WHERE f.promo <> 0";
}
$stmt = $conn->prepare($sql);
$stmt->execute();

// Initialize the $products array
$products = array();

if ($stmt->rowCount() > 0) {
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>Designation</th>";
    echo "<th>Categorie</th>";
    echo "<th>Quantite en Stock</th>";
    echo "<th>Prix Unitaire</th>";
    echo "<th>Promo</th>";
    echo "<th>Image</th>";
    echo "<th>Action</th>";
    echo "<th>Add to Cart</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $products[$row["code"]] = $row;  // Add the product to the $products array
        echo "<tr>";
        echo "<td>" . $row["designation"] . "</td>";
        echo "<td>" . $row["categorie"] . "</td>";
        echo "<td>" . $row["quantite_en_stock"] . "</td>";
        echo "<td>" . $row["prix_unitaire"] . "</td>";
        echo "<td>" . $row["promo"] . "</td>";
        echo "<td><img src='uploads/" . $row["image"] . "' alt='Product Image' style='max-width: 100px; max-height: 100px;'></td>";

        // Add "Consult Details" button
        echo "<td><a href='productDetails.php?code=" . $row["code"] . "'>Consult Details</a></td>";

        // Add "Add to Cart" button with quantity input
        echo "<td>";
        echo "<form action='homePage.php' method='post'>";
        echo "<input type='hidden' name='product_id' value='" . $row["code"] . "'>";
        echo "<input type='number' name='quantity' value='1' min='1' style='width: 40px;'>";
        echo "<button type='submit' name='add_to_cart'>Add to Cart</button>";
        echo "</form>";
        echo "</td>";

        echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";
} else {
    echo "<p>No records found</p>";
}

// Initialize the session

// Check if the cart is not initialized, initialize it
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Function to add a product to the cart with quantity
function addToCart($productId, $quantity)
{
    if (isset($_SESSION['cart'][$productId])) {
        // Product already exists in the cart, update the quantity
        $_SESSION['cart'][$productId] += $quantity;
    } else {
        // Product doesn't exist in the cart, add it with the quantity
        $_SESSION['cart'][$productId] = $quantity;
    }
}

// Function to remove a product from the cart
function removeFromCart($productId)
{
    unset($_SESSION['cart'][$productId]);
}

// Handle add to cart request
if (isset($_POST['add_to_cart']) && isset($_POST['product_id']) && isset($_POST['quantity'])) {
    addToCart($_POST['product_id'], $_POST['quantity']);
}

// Handle remove from cart request
if (isset($_POST['remove_from_cart']) && isset($_POST['product_id'])) {
    removeFromCart($_POST['product_id']);
}
?>
<!-- Add a button to toggle between showing all products and only promo products -->
<form action="homePage.php" method="post">
    <button type="submit" name="toggle_promo">Toggle Promo Products</button>
</form>
<!-- Redirect to Cart Button -->
<form action="cart.php" method="get">
    <button type="submit">Go to Cart</button>
</form>


<?php include "footer.php"; ?>