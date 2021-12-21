<?php

namespace App\Controllers\Admin;

use App\Controllers\User;
use App\Models\AdminModels\AdminModel;
use App\Models\Post;
use Core\View;
use Core\Controller;
use Core\Utils;

/**
 * User admin controller
 *
 * PHP version 5.4
 */
class Authorization extends Controller {

    /**
     * Before filter
     *
     * @return void
     */
    protected function before() {

    }

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction(){
        echo 'Authorization index';
    }

    public function loginAction () {
        if (Backenduser::getUserIsLoggedIn()) {
            header("Location: http://localhost/admin/amain");
        }
        View::renderTemplate('Admin/Authorization.html', []);
    }

    public function loginToSystemAction () {

        if ($_POST != null) {

            $postValues = $_POST;
            $workers = Backenduser::getAllWorkers();

//            Utils::custom_var_dump($postValues);
//            Utils::custom_var_dump($users);

            foreach ($workers as $worker) {
                if ($postValues['login'] === $worker['login'] && $postValues['password'] === $worker['password']) {

                    Backenduser::setLoggedBackendUserInstance($worker);

                    header("Location: http://localhost/Admin/amain");
                }
            }

            View::renderTemplate('admin/Authorization.html', [
                "post" => $_POST,
                "error" => "Wrong login or password!"
            ]);

            unset($_POST);

        } else {
            View::renderTemplate('admin/Authorization.html', []);
        }

    }

    public function signOutAction () {

        Backenduser::setLoggedBackendUserInstance(null);

        header("Location: http://localhost/Admin/amain");
    }
}
