<?php

namespace App\Models\AdminModels;

use Core\Model;
use Core\Controller;
use App\Config;
use PDO;

class AdminModel extends Model {

    public static $loggedUser;

    /**
     * Get all the posts as an associative array
     *
     * @return array
     */
    public static function getLoginAdminData() {

        try {
            $db = static::getDB();

            $stmt = $db->query('SELECT * FROM admin');
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }



}