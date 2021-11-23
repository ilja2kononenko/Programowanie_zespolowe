<?php

namespace App\Controllers\Admin;

use Core\Controller;
use Core\View;

class aorders extends Controller {

    /**
     * Before filter
     *
     * @return void
     */
    protected function before() {
        // Make sure an admin user is logged in for example
        // return false;
    }

    public function indexAction() {
        View::renderTemplate('Admin/aorders.html', [
            "itemactive" => 1
        ]);
    }

}