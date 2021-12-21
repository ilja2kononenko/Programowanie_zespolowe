<?php

namespace App\Controllers\Admin;

use App\Models\Client;
use App\Models\Product;
use Core\Controller;
use Core\Utils;
use Core\View;

class Aworkers extends Controller {

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

        $workers = Backenduser::getAllWorkers();

        View::renderTemplate('Admin/aworkers.html', [
            'itemactive' => 4,
            'workers' => $workers
        ]);
    }

    public function addAction () {
        if ($_POST != null) {

            $postValues = $_POST;

            Backenduser::addWorker($postValues['login'], $postValues['password'], $postValues['status']);

            header("Location: http://localhost/admin/aworkers");

            unset($_POST);

        } else {

            View::renderTemplate('Admin/aworkerchange.html', [
                'itemactive' => 4,
            ]);
        }

    }

    public function editAction ($id) {
        if ($_POST != null) {

            $postValues = $_POST;

            Backenduser::changeWorker($postValues['login'], $postValues['password'], $postValues['status'], $id);

            header("Location: http://localhost/admin/aworkers");

            unset($_POST);

        } else {
            $worker = Backenduser::getWorker($id);

            //Utils::custom_var_dump($product);

            View::renderTemplate('Admin/aworkerchange.html', [
                'itemactive' => 4,
                'worker' => (array) $worker
            ]);
        }

    }

    public function deleteAction ($id) {

        Backenduser::deleteWorker($id);

        header("Location: http://localhost/admin/aworkers");

    }

}