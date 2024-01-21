<?php
include '../../models/CartProduct.php';
include '../../models/Cart.php';
include '../../models/User.php';

session_start();

if (isset($_SESSION['current_user'])) {
    $current_user = $_SESSION['current_user'];
} else {
    header("HTTP/1.1 401 Unauthorized");
    exit("Not Authorized");
}

$line_items = Cart::fetchAll($current_user);
$totale = 0;
?>

<html>
<head>
    <title>Carrello</title>
    <link rel="stylesheet" href="../styles/index_styles.css">
</head>

<body>

<?php include '../partial/navbar.php'; ?>
<div class="products">
    <?php foreach ($line_items

                   as $line) {
        $product_id = $line->getProductId();
        $product = Product::FindById($product_id);
        $quantita = $line->getQuantita();
        $prezzo = $product->getPrezzo();
        $prezzo_totale = $quantita * $prezzo; ?>

        <div class="product-item">
            <ul>
                <li>
                    <?php echo "Marca: " . $product->getMarca() . "<br>";
                    echo "Nome: " . $product->getNome() . "<br>";
                    echo "Prezzo: " . $prezzo . "€" . "<br>";
                    echo "Quantità: " . $quantita . "<br>";
                    echo "Prezzo totale: " . $prezzo_totale . "€" . "<br>";
                    $totale += $prezzo_totale; ?>
                </li>
                <li>
                    <form action="../../actions/edit_cart.php" method="POST">
                        <input type="number" name="quantita" min='0' value="<?php echo $quantita; ?>">
                        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                        <input type="submit" value="Modifica quantità">
                    </form>
                </li>
            </ul>
        </div>
    <?php } ?>
</div>

<p class="product-item" style="margin-left: 20px; padding-top: 25px; padding-bottom: 25px">Totale
    carrello: <?php echo $totale; ?>€</p>

</body>

</html>