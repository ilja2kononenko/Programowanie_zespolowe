<?php

namespace App\Controllers\Admin;

use App\Models\Product;
use App\Models\UserModel;
use Core\Controller;
use Core\Utils;
use Core\View;

class acustomers extends Controller {

    /**
     * Before filter
     *
     * @return void
     */
    protected function before() {
        if (!Backenduser::getUserIsLoggedIn()) {
            header("Location: http://localhost/admin");
        }
    }

    public function indexAction() {
        if (!Backenduser::getUserIsLoggedIn()) {
            header("Location: http://localhost/admin");
            return;
        }

        View::renderTemplate('Admin/acustomers.html', [
            "itemactive" => 3,
            'users' => UserModel::getAllUsers()
        ]);
    }

    public function addAction () {
        if ($_POST != null) {

            $postValues = $_POST;

            UserModel::registerNewUser($postValues['name'], $postValues['surname'], $postValues['email'], $postValues['password']);

            header("Location: http://localhost/admin/acustomers");

        } else {

            View::renderTemplate('Admin/acustomerchange.html', [
                'itemactive' => 3,
            ]);
        }

    }

    public function editAction ($id) {
        if ($_POST != null) {

            $postValues = $_POST;

            UserModel::changeUser($postValues['name'], $postValues['surname'], $postValues['money'], $postValues['email'], $postValues['password'], $id);

            header("Location: http://localhost/admin/acustomers");

        } else {
            $this->user = \App\Models\UserModel::getUser($id)[0];

            //Utils::custom_var_dump($product);

            View::renderTemplate('Admin/acustomerchange.html', [
                'itemactive' => 3,
                'user' => $this->user
            ]);
        }

    }

    public function deleteAction ($id) {

        UserModel::deleteUser($id);

        header("Location: http://localhost/admin/acustomers");

    }
}