<?php

namespace App\Controllers;

use App\Models\Client;
use App\Models\OrderGroup;
use App\Models\Product;
use Core\Controller;
use Core\View;

class UserPanel extends Controller {

    public function indexAction() {

        if (!User::getUserIsLoggedIn()) {
            header("Location: http://localhost/authorization/login");
            return;
        }

        $userOrderGroups = User::getUserOrderGroups();

        $boughtItems = [];
        foreach ($userOrderGroups as $orderGroup) {
            $boughtItems = array_merge($boughtItems, $orderGroup->order_items);
        }

        View::renderTemplate('UserPanel/purchaseHistory.html', [
            'orderGroups' => (array) $userOrderGroups,
            'boughtItems' => $boughtItems,
        ]);
    }

}