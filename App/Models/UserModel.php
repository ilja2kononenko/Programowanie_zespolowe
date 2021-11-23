<?php

namespace App\Models;

use Core\Model;
use Core\Utils;
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

    public static function deleteUser($id) {
        try {
            $db = static::getDB();

            $stmt = $db->prepare("DELETE FROM users where id = ?;");
            $stmt->execute(array($id));

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function getAllUsers() {

        try {
            $db = static::getDB();

            $stmt = $db->query('SELECT * FROM users;');
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function getUser ($id) {
        try {
            $db = static::getDB();

            $stmt = $db->query('SELECT * FROM users where id = '.$id.';');
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function changeUser($name, $surname, $money, $email, $password, $id){
        try {

            $db = static::getDB();

            $stmt = $db->prepare("UPDATE users set name = ?, surname = ?, money = ?, email = ?, password = ? where id = ?;");
            $stmt->execute( array($name, $surname, $money, $email, $password, $id));

        } catch (PDOException $e) {
            echo $e->getMessage();
        }

    }

    public static function setAmountOfMoney ($amount, $id) {
        try {
            $db = static::getDB();

            $stmt = $db->prepare("UPDATE users set money = ? where id = ?;");
            $stmt->execute( array($amount, $id));

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

}