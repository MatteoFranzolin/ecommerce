<?php
require_once '../connessione/Database.php';
require_once '../models/Product.php';
require_once '../models/CartProduct.php';

try {
    $product_id = $_POST['product_id'];
    $product = Product::FindById($product_id);
    CartProduct::DeleteAllByProductId($product_id);
    if (!$product->delete($_POST)) {
        throw new Exception("Impossibile eliminare il prodotto del listino");
    }
} catch (Exception $e) {
    echo $e->getMessage();
    exit();
}
header("Location: ../views/admin/index.php");