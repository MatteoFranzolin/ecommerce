<?php
require_once 'Product.php';
require_once __DIR__ . '/../connessione/Database.php';

class Cart
{
    private $id, $user_id;

    public function getId()
    {
        return $this->id;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    private function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    private function setId($id)
    {
        $this->id = $id;
    }


    public static function Create($user)
    {
        $pdo = self::connectToDatabase();
        if (!$checkUser = User::FindById($user->getId())) {
            throw new \Exception("Utente inesistente");
        }

        $userId = $checkUser->getId();
        $stm = $pdo->prepare("insert into ecommerce.carts (user_id) values (:user_id)");
        $stm->bindParam(":user_id", $userId);
        if (!$stm->execute()) {
            throw new \Exception("Impossibile creare il carrello");
        }
        return self::lastCart();
    }


    private static function lastCart()
    {
        $pdo = self::connectToDatabase();
        $stm = $pdo->prepare("select * from ecommerce.carts order by id desc limit 1");
        $last = $stm->fetchObject("Cart");
        return $last;
    }

    public static function FindByUserId($user_id)
    {
        $pdo = self::connectToDatabase();
        $stm = $pdo->prepare("select * from ecommerce.carts where user_id = :user_id");
        $stm->bindParam(":user_id", $user_id);
        if (!$stm->execute()) {
            throw new \Exception("Impossibile trovare il carrello associato all'utente");
        }
        return $stm->fetchObject('Cart');
    }

    public static function fetchAll($user)
    {
        $user_id = $user->getId();
        $cart = self::FindByUserId($user_id);
        $cart_id = $cart->getId();
        return CartProduct::FindAllByCartId($cart_id);
    }


    private static function connectToDatabase()
    {
        $database = new Database("localhost", "root", "");
        return $database->connect("ecommerce");
    }
}