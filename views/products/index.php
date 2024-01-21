<?php
require '../../models/Session.php';
require '../../models/Product.php';
require '../../models/User.php';
require '../../connessione/Database.php';


session_start();
if (isset($_SESSION['current_user'])) {
    $user = $_SESSION['current_user'];
    $user_id = $user->getId();
}
?>

<html>
<head>
    <title>Products</title>
    <link rel="stylesheet" href="../styles/index_styles.css">
</head>
<body>
<?php include '../partial/navbar.php'; ?>

<div class="products">
    <?php
    $products = Product::FetchAll();
    foreach ($products

             as $product) { ?>
        <div class="product-item">
            <ul>
                <li>
                    <?php
                    echo "Marca: " . $product->getBrand() . "<br>";
                    echo "Nome: " . $product->getName() . "<br>";
                    echo "Prezzo: " . $product->getPrice() . "€<br>"; ?>
                </li>
                <li>
                    <form action="../../actions/add_to_cart.php" method="POST">
                        <input type="hidden" name="product_id" value="<?php echo $product->getId(); ?>">
                        <?php if (isset($_SESSION['current_user'])) { ?>
                            <input type="number" name="quantita" placeholder="Quantità" min="0">
                            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                            <input type="submit" value="Aggiungi al carrello">
                        <?php } ?>
                    </form>
                </li>
            </ul>
        </div>
    <?php } ?>
</div>
</body>
</html>