<?php
require_once '../models/Cart.php';
require_once '../models/CartProduct.php';
require_once '../models/User.php';

session_start();

$quantita = $_POST['quantita'];
$product_id = $_POST['product_id'];
$user = $_SESSION['current_user'];
$cart = Cart::FindByUserId($user->getId());

$params = ['product_id' => $product_id, 'cart_id' => $cart->getId()];
$itemline = CartProduct::Find($params);


if ($quantita > 0) {
    $itemline->setQuantita($quantita);
    $itemline->save();
} else {
    $itemline->delete();
}

header('Location: ../views/cart/view_cart.php');
exit;
