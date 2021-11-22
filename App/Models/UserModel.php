<?php

namespace App\Models;

use Core\Model;
use PDO;
use PDOException;

class UserModel extends Model{

    public static function getLoginUsersData() {

        try {
            $db = static::getDB();

            $stmt = $db->query('SELECT * FROM users');
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function registerNewUser ($name, $surname, $e_mail, $password) {
        try {
            $db = static::getDB();

            $stmt = $db->prepare("INSERT INTO users (name, surname, money, email, password) VALUES (?, ?, ?, ?, ?);");
            $stmt->execute( array($name, $surname, 1000, $e_mail, $password));

            return $db->lastInsertId();

        } catch (PDOException $e) {
            echo $e->getMessage();
        }


    }

}