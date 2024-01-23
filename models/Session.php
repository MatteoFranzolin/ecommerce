<?php
require_once __DIR__.'/../connessione/Database.php';
class Session
{

    private $id, $ip, $data_login, $user_id;

    function getId()
    {
        return $this->id;
    }

    public static function Create($params)
    {
        $pdo = self::connectToDatabase();
        $stmt = $pdo->prepare("insert into ecommerce.sessions (ip, data_login, user_id) values (:ip,:data_login, :user_id)");
        $stmt->bindParam(":ip", $params['ip']);
        $stmt->bindParam(":data_login", $params['data_login']);
        $stmt->bindParam(":user_id", $params['user_id']);
        if (!$stmt->execute()) {
            return false;
        }
        return self::getLastInsert();
    }

    public static function getLastInsert()
    {
        $pdo = self::connectToDatabase();
        $stmt = $pdo->prepare("select * from ecommerce.sessions order by id desc limit 1");
        if (!$stmt->execute()) {
            return false;
        }
        return $stmt->fetchObject("Session");
    }

    public function Delete()
    {
        $id = self::getId();
        $pdo = self::connectToDatabase();
        $stmt = $pdo->prepare("delete from ecommerce.sessions where id=:id");
        $stmt->bindParam(":id", $id);
        if (!$stmt->execute()) {
            return false;
        }
    }

    public static function Deactive($session_id)
    {
        $pdo = self::connectToDatabase();
        $stmt = $pdo->prepare("update sessions set active = false where id = :id");
        $stmt->bindParam(":id", $session_id);
        return $stmt->execute();
    }

    private static function connectToDatabase()
    {
        $database = new Database("localhost", "root", "");
        return $database->connect("ecommerce");
    }
}