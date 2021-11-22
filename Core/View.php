<?php

namespace Core;

use App\Controllers\User;

/**
 * View
 *
 * PHP version 5.4
 */
class View
{

    /**
     * Render a view file
     *
     * @param string $view  The view file
     * @param array $args  Associative array of data to display in the view (optional)
     *
     * @return void
     */
    public static function render($view, $args = []) {
        extract($args, EXTR_SKIP);

        $file = "../App/Views/$view";  // relative to Core directory

        if (is_readable($file)) {
            require $file;
        } else {
            throw new \Exception("$file not found");
        }
    }

    /**
     * Render a view template using Twig
     *
     * @param string $template  The template file
     * @param array $args  Associative array of data to display in the view (optional)
     *
     * @return void
     */
    public static function renderTemplate($template, $args = []) {
        static $twig = null;

        if ($twig === null) {
            $loader = new \Twig_Loader_Filesystem('../App/Views');
            $twig = new \Twig_Environment($loader);
        }

        $loggedUser = User::getLoggedUserInstance();
        $isUserLogged = User::getUserIsLoggedIn();

        if ($isUserLogged) {
            $args["loggedUserData"] = array(
                "name" => $loggedUser['name'],
                "surname" => $loggedUser['surname'],
                "money" => $loggedUser['money'],
                "email" => $loggedUser['email'],
                "password" => $loggedUser['password'],
            );
        }

        $args["isUserLoggedIn"] = $isUserLogged;

        echo $twig->render($template, $args);
    }
}
