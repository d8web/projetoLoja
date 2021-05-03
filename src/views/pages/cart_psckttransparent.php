<?=$render('header');?>

<section>
    <div class="container mt-5 mb-5">
        <h2 class="mb-5">Checkout transparent Pag Seguro</h2>
        <form class="row g-3" method="" action="">
            <div class="col-md-6 col-lg-6">
                <label for="name" class="form-label">Nome</label>
                <input type="text" class="form-control" id="name" name="name"/>
            </div>
            <div class="col-md-6 col-lg-6">
                <label for="cpf" class="form-label">CPF</label>
                <input type="text" class="form-control" id="cpf" name="cpf"/>
            </div>
            <div class="col-md-6 col-lg-6">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email"/>
            </div>
            <div class="col-md-6 col-lg-6">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" autocomplete="on"/>
            </div>

            <h3 class="mt-4">Informações de endereço</h3>

            <div class="col-md-6 col-lg-5">
                <label for="cep" class="form-label">Cep</label>
                <input type="text" class="form-control" id="cep" name="zipcode"/>
            </div>
            <div class="col-md-6 col-lg-5">
                <label for="rua" class="form-label">Rua</label>
                <input type="text" class="form-control" id="rua" name="address"/>
            </div>
            <div class="col-md-6 col-lg-2">
                <label for="numero" class="form-label">Número</label>
                <input type="number" class="form-control" id="numero" name="number"/>
            </div>

            <div class="col-md-6 col-lg-4">
                <label for="complemento" class="form-label">Complemento</label>
                <input type="text" class="form-control" id="complemento" name="complement"/>
            </div>
            <div class="col-md-6 col-lg-4">
                <label for="bairro" class="form-label">Bairro</label>
                <input type="text" class="form-control" id="bairro" name="district"/>
            </div>
            <div class="col-md-6 col-lg-4">
                <label for="city" class="form-label">Cidade</label>
                <select id="city" class="form-select" name="city">
                    <option value="carrancas">Carrancas-MG</option>
                </select>
            </div>

            <h3 class="mt-4">Informações de pagamento</h3>

            <div class="col-md-6 col-lg-4">
                <label for="numbercart" class="form-label">Número do cartão</label>
                <input type="text" class="form-control" id="numbercart" name="numbercart"/>
            </div>
            <div class="col-md-6 col-lg-4">
                <label for="cvv" class="form-label">CVV</label>
                <input type="number" class="form-control" id="cvv" name="cvv"/>
            </div>
            <div class="col-md-12 col-lg-4">
                <div class="row">
                    <div class="col-sm-12 col-md-6 mb-2">
                        <label for="month_expiration" class="form-label">Expira em</label>
                        <select id="month_expiration" class="form-select" name="month_expiration">
                            <?php for($q=1;$q<=12;$q++):?>
                                <option value="<?=$q;?>">
                                    <?php echo($q < 10) ? '0'.$q : $q; ?>
                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <label for="year_expiration" class="form-label">Expira em</label>
                        <select id="year_expiration" class="form-select" name="year_expiration">
                            <?php $ano = intval(date('Y')); ?>
                            <?php for($q=$ano;$q<=$ano+10;$q++):?>
                                <option value="<?=$q;?>">
                                    <?=$q;?>
                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Efetuar compra</button>
            </div>
        </form>
    </div>
</section>

<?=$render('footer', [
    'maxslider' => $filters['maxslider'] ?? 0,
    'widget_sale' => $widget_sale,
    'widget_featured2' => $widget_featured2,
    'widget_toprated' => $widget_toprated
]);?>