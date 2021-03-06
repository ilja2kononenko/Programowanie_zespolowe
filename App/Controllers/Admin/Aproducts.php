<?php

namespace App\Controllers\Admin;

use App\Models\Product;
use App\Models\Client;
use Core\Controller;
use Core\View;

class aproducts extends Controller {

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

        View::renderTemplate('Admin/aproducts.html', [
            'itemactive' => 2,
            'products' => Product::getAll()
        ]);
    }

    public function addAction () {
        if ($_POST != null) {

            $postValues = $_POST;

            Product::addProduct($postValues['title'], $postValues['price'], $postValues['description']);

            header("Location: http://localhost/admin/aproducts");

            unset($_POST);

        } else {

            View::renderTemplate('Admin/aproductchange.html', [
                'itemactive' => 2,
            ]);
        }

    }

    public function editAction ($id) {
        if ($_POST != null) {

            $postValues = $_POST;

            Product::changeProduct($id, $postValues['title'], $postValues['price'], $postValues['description']);

            header("Location: http://localhost/admin/aproducts");

            unset($_POST);

        } else {
            $this->product = \App\Models\Product::getProduct($id);

            //Utils::custom_var_dump($product);

            View::renderTemplate('Admin/aproductchange.html', [
                'itemactive' => 2,
                'product' => (array) $this->product
            ]);
        }

    }

    public function deleteAction ($id) {

        Product::deleteProduct($id);

        header("Location: http://localhost/admin/aproducts");

    }

}