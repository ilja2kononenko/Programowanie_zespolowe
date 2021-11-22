<?php

namespace App\Models;

use PDO;

class Product extends \Core\Model {

    /**
     * Get all the posts as an associative array
     *
     * @return array
     */
    public static function getAll() {

        try {
            $db = static::getDB();

            $stmt = $db->query('SELECT * FROM products;');
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function getProduct ($id) {
        try {
            $db = static::getDB();

            $stmt = $db->query('SELECT * FROM products where id = '.$id.';');
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

}