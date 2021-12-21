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
        $orderGroup = OrderGroup::getOrderGroupById($id);
        $products = $orderGroup->order_items;

        $client = $orderGroup->client;

        if ($_POST != null) {

            $postValues = $_POST;

            if ($postValues['action'] == 'duplicate') {
                $orderGroup->duplicateItem($postValues['order_item_id']);
            } else if ($postValues['action'] == 'delete') {
                $orderGroup->removeItem($postValues['order_item_id']);
            } else if ($postValues['action'] == 'change_status') {
                $orderGroup->changeOrderItemStatus($postValues['order_item_id'], $postValues['status']);
            }

            unset($_POST);
            header("Location: ".$_SERVER['HTTP_REFERER']);
        }

        View::renderTemplate('Admin/aordergroup.html', [
            'itemactive' => 1,
            'orderGroupId' => $id,
            'products' => $products,
            'client' => (array) $client
        ]);


    }

    public function deleteAction ($id) {

        Product::deleteProduct($id);

        header("Location: http://localhost/admin/aproducts");

    }

}