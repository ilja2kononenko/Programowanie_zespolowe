<?php

namespace App\Controllers;

use App\Models\UserModel;
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

    public static function getLoggedUserInstance() {
        return User::$loggedUserInstance;
    }

    public static function getUserIsLoggedIn() {
        return User::$userIsLoggedIn;
    }

    public static function setLoggedUserInstance($loggedInUser) {
        $user = new User();
        $user->id = $loggedInUser['id'];
        $user->name = $loggedInUser['name'];
        $user->surname = $loggedInUser['surname'];
        $user->money = $loggedInUser['money'];
        $user->email = $loggedInUser['email'];
        $user->password = $loggedInUser['password'];

        User::$loggedUserInstance = $user;
        User::$userIsLoggedIn = true;
    }

}