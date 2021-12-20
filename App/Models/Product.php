<?php

namespace App\Models;

use Core\Utils;
use PDO;

class Product extends \Core\Model {

    public $id;
    public $title;
    public $price;
    public $description;

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

            $product = new Product();

            $stmt = $db->query('SELECT * FROM products where id = '.$id.';');
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $product_result = $results[0];

            $product->id = $product_result['id'];
            $product->title = $product_result['title'];
            $product->price = $product_result['price'];
            $product->description = $product_result['description'];

            return $product;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function changeProduct($id, $title, $price, $description) {
        try {
            $db = static::getDB();

            $stmt = $db->prepare("UPDATE products set title = ?, price = ?, description = ? where id = ?;");
            $stmt->execute( array($title, $price, $description, $id));

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function addProduct($title, $price, $description) {
        try {
            $db = static::getDB();

            $stmt = $db->prepare("INSERT INTO products (title, price, description) VALUES (?, ?, ?);");
            $stmt->execute( array($title, $price, $description));

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function deleteProduct ($id) {
        try {
            $db = static::getDB();

            $stmt = $db->prepare("DELETE FROM products where id = ?;");
            $stmt->execute(array($id));

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

}