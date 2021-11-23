<?php

namespace App\Controllers;

use App\Models\UserModel;
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

    public static function getLoggedUserInstance() {
        if (isset($_SESSION['userAccount'])) {
            return $_SESSION['userAccount'];
        }
        return User::$loggedUserInstance;
    }

    public static function getUserIsLoggedIn() {
        if (isset($_SESSION['isUserLoggedIn'])) {
            return $_SESSION['isUserLoggedIn'];
        }
        return User::$userIsLoggedIn;
    }

    public static function setLoggedUserInstance($loggedInUser) {
        if (session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }

        if ($loggedInUser != null) {
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
            session_unset();
        }
    }

}