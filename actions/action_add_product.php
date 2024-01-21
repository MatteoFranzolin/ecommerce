<?php
require_once '../connessione/Database.php';
require_once '../models/Product.php';

try {
    $product = Product::Create($_POST);
    if (!$product) {
        throw new Exception("Impossibile aggiungere il prodotto al listino");
    }
} catch (Exception $e) {
    echo $e->getMessage();
    exit();
}
header("Location: ../views/admin/index.php");