<?php

namespace App\Controllers;

use App\Models\OrderGroup;
use App\Models\Product;
use App\Models\Client;
use Core\Controller;
use Core\Utils;
use Core\View;

class Cart extends Controller {

    public function indexAction() {

        if (!User::getUserIsLoggedIn()) {
            header("Location: http://localhost/authorization/login");
            return;
        }

        $productIdsInUserCart = User::getUserCart();
        $userCart = [];
        $sum = 0;

        if ($productIdsInUserCart != null) {
            foreach ($productIdsInUserCart as $productId) {
                $product = Product::getProduct($productId);
                $userCart[] = (array) $product;
                $sum += $product->price;
            }
        }

        View::renderTemplate('Cart/index.html', [
            'userCart' => $userCart,
            'summary' => $sum
        ]);
    }

    public function submitPurchase () {
        if (!User::getUserIsLoggedIn()) {
            header("Location: http://localhost/authorization/login");
            return;
        }

        $productIdsInUserCart = User::getUserCart();

        if ($productIdsInUserCart == null || sizeof($productIdsInUserCart) == 0) {
            header("Location: http://localhost/cart");
            return;
        }

        $userCart = [];
        $sum = 0;

        if ($productIdsInUserCart != null) {
            foreach ($productIdsInUserCart as $productId) {
                $product = Product::getProduct($productId);
                $userCart[] = (array) $product;
                $sum += $product->price;
            }
        }

        $userInstance = User::getLoggedUserInstance(true);

        //Utils::custom_var_dump($userInstance); exit;

        if ($sum < $userInstance->money) {
            OrderGroup::addNewOrderGroup($productIdsInUserCart, $userInstance->id);

            $newAmountOfMoney = $userInstance->money - $sum;

            Client::setAmountOfMoney($newAmountOfMoney, $userInstance->id);

            User::clearUserCart();

            View::renderTemplate('Cart/thanks.html', [

            ]);
            return;
        } else {
            View::renderTemplate('Cart/index.html', [
                'userCart' => $userCart,
                'summary' => $sum,
                'error' => 'You do not have enough money!',
                'amountOfMoney' => $userInstance->money
            ]);
            return;
        }

    }

}