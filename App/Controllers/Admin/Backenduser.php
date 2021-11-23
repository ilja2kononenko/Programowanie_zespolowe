<?php

namespace App\Controllers\Admin;

use App\Controllers\User;

/**
 * User admin controller
 *
 * PHP version 5.4
 */
class Backenduser {

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

    public static function setLoggedBackendUserInstance() {
        if (session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }

        //$_SESSION['backendUserAccount'] = $user;
        $_SESSION['isBackendUserLoggedIn'] = true;
    }


}
