<?php

class CartProduct
{
    private $cart_id, $product_id, $quantita;

    public function getQuantita()
    {
        return $this->quantita;
    }

    public function setQuantita($quantita): void
    {
        $this->quantita = $quantita;
    }

    public function getProductId()
    {
        return $this->product_id;
    }

    public function setProductId($product_id): void
    {
        $this->product_id = $product_id;
    }

    public function getCartId()
    {
        return $this->cart_id;
    }

    public function setCartId($cart_id): void
    {
        $this->cart_id = $cart_id;
    }

    private static function CheckDuplicates($product_id, $cart_id)
    {
        $conn = self::connectToDatabase();
        $sql = $conn->prepare("SELECT * FROM cart_products WHERE product_id = :product_id AND cart_id = :cart_id");
        $sql->bindParam(":product_id", $product_id);
        $sql->bindParam(":cart_id", $cart_id);
        $sql->execute();
        return $sql->fetchObject('CartProduct');
    }

    public static function Insert($params)
    {
        $duplicate = self::CheckDuplicates($params['product_id'], $params['cart_id']);
        if ($duplicate) {
            $duplicate->setQuantita($duplicate->getQuantita() + $params['quantita']);
            $duplicate->save();
            return true;
        }

        $pdo = self::connectToDatabase();
        $stm = $pdo->prepare("insert into ecommerce.cart_products (cart_id, product_id, quantita) values (:cart_id, :product_id, :quantita)");
        $stm->bindParam(":cart_id", $params['cart_id']);
        $stm->bindParam(":product_id", $params['product_id']);
        $stm->bindParam(":quantita", $params['quantita']);
        if (!$stm->execute()) {
            throw new \Exception("Impossibile creare la relazione carrello-prodotto");
        }
        return true;
    }

    public static function FindAllByCartId($cart_id)
    {
        $pdo = self::connectToDatabase();
        $stmt = $pdo->prepare("select * from ecommerce.cart_products where cart_id= :cart_id");
        $stmt->bindParam(":cart_id", $cart_id);
        if (!$stmt->execute()) {
            return false;
        }
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'CartProduct');
    }

    public static function Find($params)
    {
        $pdo = self::connectToDatabase();
        $stmt = $pdo->prepare("select * from ecommerce.cart_products where cart_id= :cart_id and product_id = :product_id");
        $stmt->bindParam(":cart_id", $params['cart_id']);
        $stmt->bindParam(":product_id", $params['product_id']);
        if (!$stmt->execute()) {
            return false;
        }
        return $stmt->fetchObject('CartProduct');
    }

    public static function DeleteAllByProductId($product_id)
    {
        $pdo = self::connectToDatabase();
        $stmt = $pdo->prepare("delete from ecommerce.cart_products where product_id = :product_id");
        $stmt->bindParam(":product_id", $product_id);
        if (!$stmt->execute()) {
            throw new Exception("Non è stato possibile eliminare il prodotto dai carrelli degli utenti");
        }
        return true;
    }
    public function save()
    {
        $quantita = $this->getQuantita();
        $cart_id = $this->getCartId();
        $product_id = $this->getProductId();

        $pdo = CartProduct::connectToDatabase();
        $sql = $pdo->prepare("update ecommerce.cart_products set quantita =:quantita where cart_id = :cart_id and product_id = :product_id");
        $sql->bindParam(':quantita', $quantita);
        $sql->bindParam(':cart_id', $cart_id);
        $sql->bindParam(':product_id', $product_id);
        return $sql->execute();
    }

    public function delete()
    {
        $cart_id = $this->getCartId();
        $product_id = $this->getProductId();
        $conn = self::connectToDatabase();
        $sql = $conn->prepare("delete from ecommerce.cart_products where cart_id = :cart_id and product_id = :product_id");
        $sql->bindParam(':cart_id', $cart_id);
        $sql->bindParam(':product_id', $product_id);
        return $sql->execute();
    }

    private static function connectToDatabase()
    {
        $database = new Database("localhost", "root", "");
        return $database->connect("ecommerce");
    }
}