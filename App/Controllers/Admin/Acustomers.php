<?php

namespace App\Controllers\Admin;

use App\Models\Product;
use App\Models\Client;
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
            'users' => Client::getAllUsers()
        ]);
    }

    public function addAction () {
        if ($_POST != null) {

            $postValues = $_POST;

            Client::registerNewUser($postValues['name'], $postValues['surname'], $postValues['email'], $postValues['password']);

            header("Location: http://localhost/admin/acustomers");

            unset($_POST);

        } else {

            View::renderTemplate('Admin/acustomerchange.html', [
                'itemactive' => 3,
            ]);
        }

    }

    public function editAction ($id) {
        if ($_POST != null) {

            $postValues = $_POST;

            Client::changeUser($postValues['name'], $postValues['surname'], $postValues['money'], $postValues['email'], $postValues['password'], $id);

            header("Location: http://localhost/admin/acustomers");

            unset($_POST);

        } else {
            $this->user = \App\Models\Client::getClient($id);

            //Utils::custom_var_dump($product);

            View::renderTemplate('Admin/acustomerchange.html', [
                'itemactive' => 3,
                'user' => (array) $this->user
            ]);
        }

    }

    public function deleteAction ($id) {

        Client::deleteUser($id);

        header("Location: http://localhost/admin/acustomers");

    }
}