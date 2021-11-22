<?php

namespace App\Controllers;

use Core\Controller;
use Core\Utils;
use Core\View;

class Product extends Controller {

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

        $product = \App\Models\Product::getProduct($id);

        //Utils::custom_var_dump($product);

        View::renderTemplate('Product/index.html', [
            'product' => $product
        ]);
    }

}