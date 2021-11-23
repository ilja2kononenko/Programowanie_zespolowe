<?php

namespace App\Controllers\Admin;

use App\Models\Product;
use App\Models\UserModel;
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

        } else {
            $this->product = \App\Models\Product::getProduct($id)[0];

            //Utils::custom_var_dump($product);

            View::renderTemplate('Admin/aproductchange.html', [
                'itemactive' => 2,
                'product' => $this->product
            ]);
        }

    }

    public function deleteAction ($id) {

        Product::deleteProduct($id);

        header("Location: http://localhost/admin/aproducts");

    }

}