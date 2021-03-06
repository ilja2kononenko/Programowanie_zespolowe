<?php

namespace App\Controllers;

use App\Models\Product;
use Core\Utils;
use \Core\View;

/**
 * Home controller
 *
 * PHP version 5.4
 */
class Home extends \Core\Controller {

    /**
     * Before filter
     *
     * @return void
     */
    protected function before() {
        parent::before();
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
    public function indexAction() {
        /*
        View::render('Home/index.php', [
            'name'    => 'Dave',
            'colours' => ['red', 'green', 'blue']
        ]);
        */

        $products = Product::getAll();

        //Utils::custom_var_dump($_SESSION);

        View::renderTemplate('Home/index.html', [
            'products' => $products
        ]);
    }
}
