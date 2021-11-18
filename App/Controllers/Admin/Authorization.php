<?php

namespace App\Controllers\Admin;

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
        // Make sure an admin user is logged in for example
        // return false;
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
        View::renderTemplate('Admin/Authorization.html', []);
    }

    public function loginToSystemAction () {
        if ($_POST != null) {

            $postValues = $_POST;
            $loginValues = AdminModel::getLoginAdminData()[0];

            Utils::custom_var_dump($postValues);
            Utils::custom_var_dump($loginValues);

            if ($postValues['login'] === $loginValues['login'] && $postValues['password'] === $loginValues['password']) {
                header("Location: http://localhost/Admin/amain");
            }
        }
        //View::renderTemplate('AdminModel/Authorization.html', []);
    }
}
