<?php
require_once '../connessione/Database.php';
require_once '../models/Product.php';

try {
    $product = Product::FindById($_POST['product_id']);
    if (!$product || !$product->edit($_POST))
        throw new Exception("Unable to edit the product");
} catch (Exception $e) {
    echo $e->getMessage();
    exit();
}

header("Location: ../views/admin/index.php");