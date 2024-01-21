<?php
include '../models/Cart.php';
include '../models/CartProduct.php';

$cart = Cart::FindByUserId($_POST['user_id']);
$params = ['cart_id' => $cart->getId(), 'product_id' => $_POST['product_id'], 'quantita' => $_POST['quantita']];
try {
    if (!$_POST['quantita'] > 0 || !CartProduct::Insert($params)) {
        throw new Exception("Non è stato possibile aggiungere i prodotti al carrello");
    }
} catch (Exception $e) {
    header('Location: ../views/products/index.php');
    exit();
}

header('Location: ../views/cart/view_cart.php');