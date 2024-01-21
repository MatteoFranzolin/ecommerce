<?php

class Product
{
    private $id, $nome, $marca, $prezzo;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    function getMarca()
    {
        return $this->marca;
    }

    public function setMarca($marca): void
    {
        $this->marca = $marca;
    }

    function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome): void
    {
        $this->nome = $nome;
    }

    function getPrezzo()
    {
        return $this->prezzo;
    }

    public function setPrezzo($prezzo): void
    {
        $this->prezzo = $prezzo;
    }

    public static function Create($params)
    {
        $duplicate = self::CheckDuplicates($params['marca'], $params['nome']);
        if ($duplicate) {
            return false;
        }
        $pdo = self::connectToDatabase();
        $stmt = $pdo->prepare("insert into ecommerce.products (marca, nome, prezzo) values (:marca, :nome, :prezzo)");
        $stmt->bindParam(":marca", $params['marca']);
        $stmt->bindParam(":nome", $params['nome']);
        $stmt->bindParam(":prezzo", $params['prezzo']);
        if (!$stmt->execute()) {
            return false;
        }
        return self::getLastInsert();
    }

    private static function CheckDuplicates($marca, $nome)
    {
        $pdo = self::connectToDatabase();
        $stmt = $pdo->prepare("select * from ecommerce.products where marca=:marca and nome=:nome");
        $stmt->bindParam(":marca", $marca);
        $stmt->bindParam(":nome", $nome);
        if (!$stmt->execute()) {
            return false;
        }
        return $stmt->fetchObject("Product");
    }

    public static function getLastInsert()
    {
        $pdo = self::connectToDatabase();
        $stmt = $pdo->prepare("select * from ecommerce.products order by id desc limit 1");
        if (!$stmt->execute()) {
            return false;
        }
        return $stmt->fetchObject("Product");
    }

    public static function Find($nome, $marca)
    {
        $pdo = self::connectToDatabase();
        $stmt = $pdo->prepare("select * from ecommerce.products where nome = :nome and marca = :marca");
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":marca", $marca);
        if (!$stmt->execute()) {
            return false;
        }
        return $stmt->fetchObject('Product');
    }

    public static function FindById($id)
    {
        $pdo = self::connectToDatabase();
        $stmt = $pdo->prepare("select * from ecommerce.products where id= :id");
        $stmt->bindParam(":id", $id);
        if (!$stmt->execute()) {
            return false;
        }
        return $stmt->fetchObject('Product');
    }

    public static function FetchAll()
    {
        $pdo = self::connectToDatabase();
        $sql = "select * from ecommerce.products";
        return $pdo->query($sql)->fetchAll(PDO::FETCH_CLASS, 'Product');
    }

    public function edit($params)
    {
        $pdo = self::connectToDatabase();
        $stmt = $pdo->prepare("update ecommerce.products set marca=:marca,nome=:nome,prezzo=:prezzo where id=:id");
        $stmt->bindParam(":marca", $params['marca']);
        $stmt->bindParam(":nome", $params['nome']);
        $stmt->bindParam(":prezzo", $params['prezzo']);
        $stmt->bindParam(":id", $params['product_id']);
        if (!$stmt->execute()) {
            return false;
        }
        return Product::FindById($params['product_id']);
    }

    public function delete()
    {
        $id = $this->getId();
        $pdo = self::connectToDatabase();
        $stmt = $pdo->prepare("delete from ecommerce.products where id=:id");
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    private static function connectToDatabase()
    {
        $database = new Database("localhost", "root", "");
        return $database->connect("ecommerce");
    }
}