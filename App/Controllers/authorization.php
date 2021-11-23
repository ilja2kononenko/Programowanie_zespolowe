<?php

namespace App\Controllers;

use App\Models\AdminModels\AdminModel;
use App\Models\UserModel;
use Core\Controller;
use Core\Utils;
use Core\View;

class authorization extends Controller {

    public function loginAction() {
        if ($_POST != null) {

            $postValues = $_POST;
            $users = UserModel::getLoginUsersData();

//            Utils::custom_var_dump($postValues);
//            Utils::custom_var_dump($users);

            foreach ($users as $user) {
                if ($postValues['email'] === $user['email'] && $postValues['password'] === $user['password']) {

                    User::setLoggedUserInstance($user);

                    header("Location: http://localhost");
                }
            }

            View::renderTemplate('authorization/login.html', [
                "post" => $_POST,
                "error" => "Wrong email or password!"
            ]);

        } else {
            View::renderTemplate('authorization/login.html', []);
        }

    }

    public function registerAction () {
        if ($_POST != null) {

            $postValues = $_POST;

            //Utils::custom_var_dump($postValues);

            $users = UserModel::getLoginUsersData();

            foreach ($users as $user) {
                if ($postValues['email'] === $user['email']) {

                    View::renderTemplate('authorization/register.html', [
                        "post" => $_POST,
                        "error" => "User with given email already exists!"
                    ]);
                    return;
                }
            }

            if ($postValues['password'] !== $postValues['confirm_password']) {
                View::renderTemplate('authorization/register.html', [
                    "post" => $_POST,
                    "error" => "Passwords are not same!"
                ]);
                return;
            }

            $results = UserModel::registerNewUser($postValues['name'], $postValues['surname'], $postValues['email'], $postValues['password']);

            if ($results != null && $results != "") {
                header("Location: http://localhost");
            }

        } else {
            View::renderTemplate('authorization/register.html', []);
        }


    }

    public function logOutAction () {
        User::setLoggedUserInstance(null);

        header("Location: http://localhost");
    }

    public function registerToShopAction () {

        //View::renderTemplate('AdminModel/Authorization.html', []);
    }

}