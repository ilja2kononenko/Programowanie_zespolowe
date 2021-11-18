<?php

namespace Core;

class Utils {

    public static function custom_var_dump ($variable) {
        echo "<pre>";
        var_dump($variable);
        echo "</pre>";
    }

}