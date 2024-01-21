<?php
require '../../connessione/Database.php';
require '../../models/User.php';
require '../../models/Product.php';

if (isset($_SESSION['current_user'])) {
    $user = $_SESSION['current_user'];
    $user_id = $user->getId();
} else {
    header("HTTP/1.1 401 Unauthorized");
    exit("Not Authorized");
}
?>

<html>
<head>
    <title>Admin</title>
    <link rel="stylesheet" href="../styles/index_styles.css">
</head>
<body>
<?php include '../partial/navbar.php'; ?>
<div class="products">
    <?php
    $products = Product::FetchAll();
    foreach ($products as $product) { ?>
        <div class="product-item">
            <form id="<?php echo $product->getId(); ?>" method="POST">
                <ul>
                    <input type="hidden" name="product_id" value="<?php echo $product->getId() ?>"
                    <li>
                        <br>Marca:
                        <input type="text" name="marca" placeholder="Marca"
                               value="<?php echo $product->getMarca(); ?>"
                               required>
                        <br>Nome:
                        <input type="text" name="nome" placeholder="Nome"
                               value="<?php echo $product->getNome(); ?>"
                               required>
                        <br>Prezzo:
                        <input type="number" name="prezzo" placeholder="Prezzo"
                               value="<?php echo $product->getPrezzo(); ?>" min="0" required step="0.01"></li>
                    <li>
                        <button type="submit" form="<?php echo $product->getId(); ?>"
                                formaction="../../actions/edit_product.php">Modifica prodotto
                        </button>
                        <button type="submit" form="<?php echo $product->getId(); ?>"
                                formaction="../../actions/delete_product.php">Rimuovi prodotto
                        </button>
                    </li>
                </ul>
            </form>
        </div>
    <?php } ?>
    <div class="product-item">
        <a class="add_product" href="add_product.php">Aggiungi prodotto</a>
    </div>
</div>
</body>
</html>