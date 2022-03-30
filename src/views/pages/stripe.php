<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Pagamento</title>
    <meta name="description" content="A demo of a payment on Stripe" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="<?=$base;?>/assets/css/checkout.css" />
    <link rel="icon" type="image/x-icon" href="assets/images/favicon.png">
    <script src="https://js.stripe.com/v3/"></script>
    <script src="<?=$base;?>/assets/js/checkout.js" defer></script>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>

    <div class="container">
        <div class="row mt-5">
            <div class="col-md-8">

                <table class="table">
                    <thead>
                        <tr>
                            <th>Imagem</th>
                            <th>Nome</th>
                            <th>Preço</th>
                            <th class="text-end">Quantidade</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($products as $item): ?>
                            <tr class="align-middle">
                                <td class="align-middle">
                                    <img
                                        width="100"
                                        class="img-fluid"
                                        src="<?=$base?>/media/products/<?=$item["image"]?>"
                                        alt=""
                                    />
                                </td>
                                <td><?=$item["name"]?></td>
                                <td>R$ <?=number_format($item["price"], 2, ".", ".")?></td>
                                <td class="text-end"><?=$item["qt"]?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>

                <div class="mt-4">
                    <p class="fw-bold">
                        Frete: <span class="fw-normal"><?=number_format($frete, 2, ",", ".")?></span>
                    </p>
                    <p class="fw-bold">
                        Total: <span class="fw-normal"><?=number_format($total, 2, ",", ".")?></span>
                    </p>
                </div>
    
            </div>
            <div class="col-md-4">
                <!-- Display a payment form -->
                <form id="payment-form">
                    <div id="payment-element">
                        <!--Stripe.js injects the Payment Element-->
                    </div>
                    <button id="submit">
                        <div class="spinner hidden" id="spinner"></div>
                        <span id="button-text">Pagar</span>
                    </button>
                    <div id="payment-message" class="hidden"></div>
                </form>
            </div>
        </div>
    </div>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>