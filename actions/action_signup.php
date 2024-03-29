<?php
require_once '../models/User.php';
require_once '../models/Cart.php';
require_once '../models/Session.php';

session_start();

$email = $_POST['email'];
$password = hash('sha256', $_POST['password']);
$password_confirmation = hash('sha256', $_POST['password-confirmation']);

//controllo email già esistente
$user = User::FindByEmail($email);
if ($user) {
    header('Location:../views/login.php');
    exit;
}

//password e conferma password non coincidono
if (strcmp($password, $password_confirmation) != 0) {
    header('Location:../views/signup.php');
    exit;
}

$params = array('email' => $email, 'password' => $password);
try {
    $user = User::Create($params);
    $cart = Cart::Create($user);
} catch (Exception $e) {
    echo $e->getMessage();
    exit();
}

header("Location: ./action_login.php?email=" . urlencode($email) . "&password=" . urlencode($password));

exit();