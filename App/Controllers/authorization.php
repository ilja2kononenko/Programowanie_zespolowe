<?php

namespace App\Controllers;

use App\Models\AdminModels\AdminModel;
use App\Models\UserModel;
use Core\Controller;
use Core\Utils;
use Core\View;

class authorization extends Controller {

    public function loginAction() {
        View::renderTemplate('authorization/login.html', []);
    }

    public function registerAction () {
        View::renderTemplate('authorization/register.html', []);
    }

    public function loginToShopAction () {
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


        }
        //View::renderTemplate('AdminModel/Authorization.html', []);
    }

    public function registerToShopAction () {
        if ($_POST != null) {

            $postValues = $_POST;

            //Utils::custom_var_dump($postValues);

            if ($postValues['password'] !== $postValues['confirm_password']) {
                echo "not same password!";
            }

            $users = UserModel::getLoginUsersData();

            foreach ($users as $user) {
                if ($postValues['email'] === $user['email']) {

                    header("Location: http://localhost");
                }
            }

            $results = UserModel::registerNewUser($postValues['name'], $postValues['surname'], $postValues['e-mail'], $postValues['password']);

            if ($results != null && $results != "") {
                header("Location: http://localhost");
            }

        }
        //View::renderTemplate('AdminModel/Authorization.html', []);
    }

}