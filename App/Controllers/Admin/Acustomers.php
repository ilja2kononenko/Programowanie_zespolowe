<?php

namespace App\Controllers\Admin;

use Core\Controller;
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
        }

        View::renderTemplate('Admin/acustomers.html', [
            "itemactive" => 3
        ]);
    }
}