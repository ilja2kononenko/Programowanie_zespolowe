<?php

namespace App\Controllers;

use App\Models\Client;
use App\Models\OrderGroup;
use Core\Controller;
use Core\Utils;

class User {

    private static $loggedUserInstance;
    private static $userIsLoggedIn;
    public $id;
    public $name;
    public $surname;
    public $money;
    public $email;
    public $password;

    public $cart = [];

    public static function getLoggedUserInstance($refresh = false) {
        if (session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (isset($_SESSION['userAccount'])) {
            if ($refresh) {
                $newUser = Client::getClient($_SESSION['userAccount']->id);
                User::setLoggedUserInstance($newUser);
            }
            return $_SESSION['userAccount'];
        }
        return null;
    }

    public static function getUserIsLoggedIn() {
        if (session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }
        if (isset($_SESSION['isUserLoggedIn'])) {
            return $_SESSION['isUserLoggedIn'];
        }
        return false;
    }

    public static function setLoggedUserInstance($loggedInUser) {
        if (session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }

        if ($loggedInUser != null) {
            $loggedInUser = (array) $loggedInUser;

            $user = new User();
            $user->id = $loggedInUser['id'];
            $user->name = $loggedInUser['name'];
            $user->surname = $loggedInUser['surname'];
            $user->money = $loggedInUser['money'];
            $user->email = $loggedInUser['email'];
            $user->password = $loggedInUser['password'];

            User::$loggedUserInstance = $user;
            User::$userIsLoggedIn = true;

            $_SESSION['userAccount'] = $user;
            $_SESSION['isUserLoggedIn'] = true;
        } else {
            $_SESSION['userAccount'] = null;
            $_SESSION['isUserLoggedIn'] = false;
        }
    }

    public static function getUserCart () {
        if (session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }
        if (isset($_SESSION['userCart'])) {
            return $_SESSION['userCart'];
        } else return null;
    }

    public static function getUserOrderGroups () {
        if (session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }

        $user = self::getLoggedUserInstance();
        if ($user != null) {
            $orderGroups = OrderGroup::getOrderGroupsByUserId($user->id);

            return $orderGroups;
        } else {
            return null;
        }
    }

    public static function addProductToCart ($id) {
        if (session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }
        if (isset($_SESSION['isUserLoggedIn'])) {

            $_SESSION['userCart'][] = $id;

            return true;
        } else {
            return false;
        }
    }

    public static function clearUserCart () {
        if (session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }
        if (isset($_SESSION['userCart'])) {
            $_SESSION['userCart'] = null;
        }
    }

}