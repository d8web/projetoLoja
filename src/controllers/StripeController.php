<?php

namespace src\controllers;

use core\Controller;
use Error;

use src\Config;
use src\handlers\CartHandler;
use src\handlers\Store;

class StripeController extends Controller {

    public function stripe() {

        $store = new Store();
        $data = $store->getTemplateData();
        $list = CartHandler::getList();

        $total = 0;
        foreach($list as $item) {
            $total += (floatval($item["price"]) * intval($item["qt"]));
        }

        $shipping = null;
        if(!empty($_SESSION["shipping"])) {
            $shipping = $_SESSION["shipping"];

            if(isset($shipping["price"])) {
                $frete = floatval(str_replace(",", ".", $shipping["price"]));
            } else {
                $frete = 0;
            }

            $total += $frete;
        }

        $data["products"] = $list;
        $data["total"] = $total;
        $data["frete"] = $frete;

        $this->render('stripe', $data);
    }

    public function paymentStripeRequest() {

        // This is your test secret API key.
        \Stripe\Stripe::setApiKey(Config::STRIPE_KEY);

        function calculateOrderAmount(array $items): int {
            // Replace this constant with a calculation of the order's amount
            // Calculate the order total on the server to prevent
            // people from directly manipulating the amount on the client
            $total = $_SESSION["total"];
            return intval($total);
        }

        header("Content-Type: application/json");

        try {
            // retrieve JSON from POST body
            $jsonStr = file_get_contents("php://input");
            $jsonObj = json_decode($jsonStr);

            // Create a PaymentIntent with amount and currency
            $paymentIntent = \Stripe\PaymentIntent::create([
                "amount" => calculateOrderAmount($jsonObj->items),
                "currency" => "brl",
                "automatic_payment_methods" => [
                    "enabled" => true,
                ],
            ]);

            $output = [
                "clientSecret" => $paymentIntent->client_secret,
            ];

            echo json_encode($output);
        } catch (Error $e) {
            http_response_code(500);
            echo json_encode(["error" => $e->getMessage()]);
        }

    }

}