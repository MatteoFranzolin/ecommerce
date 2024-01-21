<?php
require_once '../connessione/Database.php';
require_once '../models/Product.php';

$product = Product::FindById($_POST['product_id']);

try {
    if (!$product->edit($_POST)) {
        throw new Exception("Impossibile modificare il prodotto del listino");
    }
} catch (Exception $e) {
    echo $e->getMessage();
    exit();
}
header("Location: ../views/admin/index.php");