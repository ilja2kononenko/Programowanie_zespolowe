<?php

namespace App\Controllers\Admin;

use Core\Controller;
use Core\Utils;
use Core\View;

class amain extends Controller {

    /**
     * Before filter
     *
     * @return void
     */
    protected function before() {

    }

    public function indexAction(){
        if (!Backenduser::getUserIsLoggedIn()) {
            header("Location: http://localhost/admin");
            return;
        }

        View::renderTemplate('Admin/amain.html', [
            "itemactive" => 0
        ]);
    }

}