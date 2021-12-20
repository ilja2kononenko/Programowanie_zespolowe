<?php

namespace App\Models;

use Core\Model;
use Core\Utils;
use PDO;
use PDOException;

class OrderGroup extends Model {

    public $id;
    public $order_items = [];
    public $client;
    public $sum;

    public static function getAllOrderGroups() {

        try {
            $orderGroups = [];
            $db = static::getDB();

            $stmt = $db->query('SELECT * FROM ordergroup;');
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($results as $result) {
                $sum = 0;
                $orderGroup = new OrderGroup();

                $orderGroup->id = $result['id'];

                $orderGroup->client = Client::getClient($result['user_id']);

                $order_items = OrderGroup::getOrderGroupOrders($result['id']);

                foreach ($order_items as $order_item) {
                    $product_id = $order_item['item_id'];
                    $product = Product::getProduct($product_id);
                    $orderGroup->order_items[] = $product;

                    $sum += $product->price;
                }

                $orderGroup->sum = $sum;

                $orderGroups[] = $orderGroup;
            }

            return $orderGroups;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function getOrderGroupById($id) {

        try {
            $db = static::getDB();

            $stmt = $db->query('SELECT * FROM ordergroup where id ='.$id.';');
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $orderGroup_result = $results[0];

            $sum = 0;
            $orderGroup = new OrderGroup();

            $orderGroup->id = $orderGroup_result['id'];

            $orderGroup->client = Client::getClient($orderGroup_result['user_id']);

            $order_items = OrderGroup::getOrderGroupOrders($orderGroup_result['id']);

            foreach ($order_items as $order_item) {
                $product_id = $order_item['item_id'];
                $product = (array) Product::getProduct($product_id);

                $product['order_item_id'] = $order_item['id'];
                $product['status'] = $order_item['status'];
                $orderGroup->order_items[] = $product;

                $sum += $product['price'];
            }

            $orderGroup->sum = $sum;

            return $orderGroup;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function getOrderGroupsByUserId($user_id) {

        try {
            $db = static::getDB();

            $stmt = $db->query('SELECT * FROM ordergroup where user_id ='.$user_id.';');
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $orderGroups = [];

            foreach ($results as $ordergroup) {
                $sum = 0;
                $orderGroup = new OrderGroup();

                $orderGroup->id = $ordergroup['id'];

                $orderGroup->client = Client::getClient($ordergroup['user_id']);

                $order_items = OrderGroup::getOrderGroupOrders($ordergroup['id']);

                foreach ($order_items as $order_item) {
                    $product_id = $order_item['item_id'];
                    $product = (array) Product::getProduct($product_id);

                    $product['order_item_id'] = $order_item['id'];
                    $product['status'] = $order_item['status'];
                    $orderGroup->order_items[] = $product;

                    $sum += $product['price'];
                }

                $orderGroup->sum = $sum;

                $orderGroups[] = $orderGroup;
            }

            return $orderGroups;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getOrderByOrderItemId($id) {

        try {
            $db = static::getDB();

            $stmt = $db->query('SELECT * FROM order_item where id = '. $id .';');
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results[0];

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function getOrderGroupOrders($order_group_id) {

        try {
            $db = static::getDB();

            $stmt = $db->query('SELECT * FROM order_item where ordergroup_id = '.$order_group_id.';');
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function addNewOrderGroup ($userCart, $userId) {
        try {
            $db = static::getDB();

            $stmt = $db->prepare("INSERT INTO ordergroup (user_id) VALUES (?);");
            $stmt->execute( array($userId));

            $orderGroupId = $db->lastInsertId();

            foreach ($userCart as $item) {
                $stmt = $db->prepare("INSERT INTO order_item (item_id, ordergroup_id) VALUES (?, ?);");
                $stmt->execute( array($item, $orderGroupId));
            }

        } catch (PDOException $e) {
            echo $e->getMessage();
        }

    }

    public function duplicateItem ($item_id) {
        try {
            $db = static::getDB();

            $order_item = $this->getOrderByOrderItemId($item_id);

            $stmt = $db->prepare("INSERT INTO order_item (item_id, ordergroup_id, status) VALUES (?, ?, ?);");
            $stmt->execute( array($order_item['item_id'], $this->id, $order_item['status']));

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function removeItem ($item_id) {
        try {
            $db = static::getDB();

            $stmt = $db->prepare("DELETE FROM order_item WHERE id = ?;");
            $stmt->execute( array($item_id));

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getClient () {
        return $this->client;
    }

    public function changeOrderItemStatus($item_id, $status) {
        try {
            $db = static::getDB();

            $stmt = $db->prepare("UPDATE order_item set status = ? where id = ?;");
            $stmt->execute( array($status, $item_id));

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


}