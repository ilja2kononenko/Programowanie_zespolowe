<?php

namespace App\Controllers;

use Core\Controller;
use Core\Utils;
use Core\View;

class Product extends Controller {

    public $product;

    /**
     * Before filter
     *
     * @return void
     */
    protected function before() {
        //echo "(before) ";
        //return false;
    }

    /**
     * After filter
     *
     * @return void
     */
    protected function after() {
        //echo " (after)";
    }

    /**
     * Show the index page
     *
     * @return void
     */
    public function showAction($id) {

        $this->product = \App\Models\Product::getProduct($id)[0];

        //Utils::custom_var_dump($product);

        View::renderTemplate('Product/index.html', [
            'product' => $this->product
        ]);
    }

    public function addToCartProductAction () {
        echo "test";
    }

}