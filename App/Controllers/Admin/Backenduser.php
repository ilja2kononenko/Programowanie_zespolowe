<?php

namespace App\Controllers\Admin;

use App\Controllers\User;
use App\Models\Client;
use Core\Model;
use PDO;

/**
 * User admin controller
 *
 * PHP version 5.4
 */
class Backenduser extends Model {

    private static $loggedUserInstance;
    private static $userIsLoggedIn;

    public static function getLoggedUserInstance() {
        if (isset($_SESSION['backendUserAccount'])) {
            return $_SESSION['backendUserAccount'];
        }
    }

    public static function getUserIsLoggedIn() {
        if (session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }
        if (isset($_SESSION['isBackendUserLoggedIn'])) {
            return $_SESSION['isBackendUserLoggedIn'];
        } else return false;
    }

    public static function setLoggedBackendUserInstance($worker) {
        if (session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }

        if ($worker == null) {
            $_SESSION['backendUserAccount'] = null;
            $_SESSION['isBackendUserLoggedIn'] = false;
        } else {
            $_SESSION['backendUserAccount'] = $worker;
            $_SESSION['isBackendUserLoggedIn'] = true;
        }


    }

    public static function getAllWorkers () {
        try {
            $db = static::getDB();

            $stmt = $db->query('SELECT * FROM admin');
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function getWorker ($id) {
        try {
            $db = static::getDB();

            $stmt = $db->query('SELECT * FROM admin where id = '.$id.';');
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results[0];

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function addWorker ($login, $password, $status) {
        try {
            $db = static::getDB();

            $stmt = $db->prepare("INSERT INTO admin (login, password, status) VALUES (?, ?, ?);");
            $stmt->execute( array($login, $password, $status));

            return $db->lastInsertId();

        } catch (PDOException $e) {
            echo $e->getMessage();
        }

    }

    public static function changeWorker($login, $password, $status, $id){
        try {

            $db = static::getDB();

            $stmt = $db->prepare("UPDATE admin set login = ?, password = ?, status = ? where id = ?;");
            $stmt->execute( array($login, $password, $status, $id));

        } catch (PDOException $e) {
            echo $e->getMessage();
        }

    }

    public static function deleteWorker($id) {
        try {
            $db = static::getDB();

            $stmt = $db->prepare("DELETE FROM admin where id = ?;");
            $stmt->execute(array($id));

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


}
