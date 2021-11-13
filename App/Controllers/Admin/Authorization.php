<?php

namespace App\Controllers\Admin;

use Core\View;

/**
 * User admin controller
 *
 * PHP version 5.4
 */
class Authorization extends \Core\Controller {

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
}