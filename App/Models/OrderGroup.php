<?php

namespace App\Models;

use Core\Model;
use Core\Utils;

class OrderGroup extends Model {

    public static function getAllOrderGroups() {

        try {
            $db = static::getDB();

            $stmt = $db->query('SELECT * FROM ordergroup;');
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function getOrder() {

        try {
            $db = static::getDB();

            $stmt = $db->query('SELECT * FROM order_item;');
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



}