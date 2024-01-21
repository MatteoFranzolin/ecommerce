<?php

class User
{
    public $id, $email, $role_id;

    public function getEmail()
    {
        return $this->email;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getRoleId()
    {
        return $this->role_id;
    }

    public static function Create($params)
    {
        $pdo = self::connectToDatabase();
        $stmt = $pdo->prepare("insert into ecommerce.users (email, password, role_id) values (:email, :password, 1)");
        $stmt->bindParam(":email", $params['email']);
        $stmt->bindParam(":password", $params['password']);
        if (!$stmt->execute()) {
            return false;
        }
        return self::getLastInsert();
    }

    public static function getLastInsert()
    {
        $pdo = self::connectToDatabase();
        $stmt = $pdo->prepare("select id, email, role_id from ecommerce.users order by id desc limit 1");
        if (!$stmt->execute()) {
            return false;
        }
        return $stmt->fetchObject("User");
    }

    public static function Find($params)
    {
        $pdo = self::connectToDatabase();
        $stmt = $pdo->prepare("select id, email, role_id from ecommerce.users where email = :email and password = :password limit 1");
        $stmt->bindParam(":email", $params['email']);
        $stmt->bindParam(":password", $params['password']);
        if (!$stmt->execute()) {
            return false;
        }
        return $stmt->fetchObject('User');
    }

    public static function FindById($id)
    {
        $pdo = self::connectToDatabase();
        $stmt = $pdo->prepare("select id, email, role_id from ecommerce.users where id = :id limit 1");
        $stmt->bindParam(":id", $id);
        if (!$stmt->execute()) {
            return false;
        }
        return $stmt->fetchObject('User');
    }

    private static function connectToDatabase()
    {
        $database = new Database("localhost", "root", "");
        return $database->connect("ecommerce");
    }
}