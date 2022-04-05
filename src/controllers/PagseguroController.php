<?php
namespace src\controllers;

use Exception;
use src\Config;

use \core\Controller;
use src\handlers\CartHandler;
use src\handlers\Store;
use src\models\Purchases;
use src\models\User;

class PagseguroController extends Controller {

    public function checkoutTransparent() {
        $store = new Store();
        $data = $store->getTemplateData();

        try {
            $sessionCode = \PagSeguro\Services\Session::create(
                \PagSeguro\Configuration\Configure::getAccountCredentials()
            );

            $data["sessionCode"] = $sessionCode->getResult();
        } catch(Exception $e) {
            echo "Erro: ".$e->getMessage();
            exit;
        }

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
        $data["total"] = $total;
        $this->render("pagseguro", $data);
    }

    public function checkoutAjax() {
        $purchases = new Purchases();
        $post = json_decode(file_get_contents("php://input"), true);

        $id = $post["id"];
        $name = $post["name"];
        $cpf = $post["cpf"];
        $phone = $post["phone"];
        $email = $post["email"];
        $password = $post["password"];
        $cep = $post["cep"];
        $address = $post["address"];
        $number = $post["number"];
        $complement = $post["complement"];
        $district = $post["district"];
        $city = $post["city"];
        $state = $post["state"];
        $cardTitular = $post["cardTitular"];
        $cpfTitular = $post["cpfTitular"];
        $cardNumber = $post["cardNumber"];
        $cvv = $post["cvv"];
        $month = $post["month"];
        $year = $post["year"];
        $cardToken = $post["cardToken"];
        $parc = explode(";", $post["parc"]);

        $user = new User();
        if($user->emailExists($email)) {
            // example return $data["token" => 123232434,"id" => 1]
            $userId = $user->validateUser($email, $password);

            if(empty($userId)) {
                $array = [ "error" => true, "message" => "Email e/ou senha incorretos" ];
                echo json_encode($array);
                exit;
            }
        } else {
            $userId = $user->createUser($name, $email, $password);
        }

        // echo json_encode($data["id"]);exit;

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

        // Adicionando compra no banco de dados
        $idPurchase = $purchases->createPurchase(intval($userId), $total, "pagseguro_checkout_transparent");
        foreach($list as $item) {
            $purchases->addItem($idPurchase, $item["id"], $item["qt"], $item["price"]);
        }

        // echo json_encode(["ok" => true]);
        $creditCard = new \PagSeguro\Domains\Requests\DirectPayment\CreditCard();
        $creditCard->setReceiverEmail(Config::PAGSEGURO_SELLER);
        $creditCard->setReference($idPurchase);
        $creditCard->setCurrency("BRL");

        foreach($list as $item) {
            $creditCard->addItems()->withParameters(
                $item["id"],
                $item["name"],
                intval($item["qt"]),
                floatval($total)
            );
        }

        $creditCard->setSender()->setName($name);
        $creditCard->setSender()->setEmail($email);
        $creditCard->setSender()->setDocument()->withParameters("CPF", $cpf);

        $ddd = substr($phone, 0, 2);
        $phone = substr($phone, 2);
        $creditCard->setSender()->setPhone()->withParameters(
            $ddd,
            $phone
        );

        $creditCard->setSender()->setHash($id);

        $ip = $_SERVER["REMOTE_ADDR"];
        if(strlen($ip) < 9) {
            $ip = "127.0.0.1";
        }
        $creditCard->setSender()->setIp($ip);

        $creditCard->setShipping()->setAddress()->withParameters(
            $address,
            $number,
            $district,
            $cep,
            $city,
            $state,
            "BRA",
            $complement
        );

        $creditCard->setBilling()->setAddress()->withParameters(
            $address,
            $number,
            $district,
            $cep,
            $city,
            $state,
            "BRA",
            $complement
        );

        $creditCard->setToken($cardToken);
        $creditCard->setInstallment()->withParameters($parc[0], $parc[1]);
        $creditCard->setHolder()->setName($cardTitular);
        $creditCard->setHolder()->setDocument()->withParameters("CPF", $cpfTitular);

        $creditCard->setMode("DEFAULT");

        // Essa parte só funciona online
        $creditCard->setNotificationUrl(Config::BASE_URL."/public/pagseguro/notification");
        // Fim da parte que só funciona online

        try {
            $result = $creditCard->register(
                \PagSeguro\Configuration\Configure::getAccountCredentials()
            );

            echo json_encode($result);
            exit;
        } catch(Exception $e) {
            echo json_encode([ "error" => true, "message" => $e->getMessage() ]);
            exit;
        }
    }

    public function thanks() {
        unset($_SESSION["cart"]);

        $store = new Store();
        $data = $store->getTemplateData();

        $this->render("thanks", $data);
    }

    public function notification() {

        $purchases = new Purchases();

        try {

            if(\PagSeguro\Helpers\Xhr::hasPost()) {
                $r = \PagSeguro\Services\Transactions\Notification::check(
                    \PagSeguro\Configuration\Configure::getAccountCredentials()
                );

                $ref = $r->getReference();
                $status = $r->getStatus();
                /**
                 * 1 - Aguardando pagamento
                 * 2 - Em análise
                 * 3 - Pago
                 * 4 - Disponível
                 * 5 - Em disputa
                 * 6 - Dinheiro devolvido
                 * 7 - Compra cancelada
                 * 8 - Debitado
                 * 9 - Retenção temporária [Chargeback] 
                */

                if($status == 3) {
                    $purchases->setPaid($ref);
                } elseif($status == 7) {
                    $purchases->setCancelled($ref);
                }
            }

        } catch(Exception $e) {

        }

    }
    
}