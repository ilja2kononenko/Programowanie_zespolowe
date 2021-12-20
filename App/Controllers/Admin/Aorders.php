<?php

namespace App\Controllers\Admin;

use App\Models\OrderGroup;
use Core\Controller;
use Core\Utils;
use Core\View;

class aorders extends Controller {

    /**
     * Before filter
     *
     * @return void
     */
    protected function before() {
        if (!Backenduser::getUserIsLoggedIn()) {
            header("Location: http://localhost/admin");
            return;
        }
    }

    public function indexAction() {
        if (!Backenduser::getUserIsLoggedIn()) {
            header("Location: http://localhost/admin");
            return;
        }

        $orderGroups = OrderGroup::getAllOrderGroups();

        $rows = [];

        foreach ($orderGroups as $orderGroup) {
            $row = [];
            $row['id'] = $orderGroup->id;
            $row['client'] = $orderGroup->client->name . " " . $orderGroup->client->surname . ", " . $orderGroup->client->email;
            $row['sum'] = $orderGroup->sum;

            $rows[] = $row;
        }

        View::renderTemplate('Admin/aorders.html', [
            "itemactive" => 1,
            "orderGroups" => $rows
        ]);
    }

    public function showAction ($id) {
        if ($_POST != null) {

            $postValues = $_POST;

            Product::changeProduct($id, $postValues['title'], $postValues['price'], $postValues['description']);

            header("Location: http://localhost/admin/aproducts");

        } else {

            $orderGroup = OrderGroup::getOrderGroupById($id);
            $products = $orderGroup->order_items;

            $client = $orderGroup->client;

            //Utils::custom_var_dump($product);

            View::renderTemplate('Admin/aordergroup.html', [
                'itemactive' => 2,
                'orderGroupId' => $id,
                'products' => $products,
                'client' => (array) $client
            ]);
        }

    }

    public function deleteAction ($id) {

        Product::deleteProduct($id);

        header("Location: http://localhost/admin/aproducts");

    }

}