<?php
require_once '../models/Cart.php';
require_once '../models/CartProduct.php';
require_once '../models/User.php';

session_start();

if (isset($_POST['quantita']) && isset($_POST['product_id'])) {
    $quantita = $_POST['quantita'];
    $product_id = $_POST['product_id'];

    $user = $_SESSION['current_user'];
    try {
        $cart = Cart::FindByUserId($user->getId());
    } catch (Exception $e) {
        echo $e->getMessage();
        exit();
    }

    $params = ['product_id' => $product_id, 'cart_id' => $cart->getId()];
    $cart_product = CartProduct::Find($params);

    if ($cart_product) {
        if ($quantita > 0) {
            $cart_product->setQuantita($quantita);
            $cart_product->save();
        } else {
            $cart_product->delete();
        }

        header('Content-Type: application/json');
        echo json_encode(['quantita' => $quantita]);
        exit();
    } else {
        echo "CartProduct non trovato.";
    }
} else {
    exit();
}