<?=$render('header');?>

<section class="mt-4 mb-5 pb-3">
    <div class="container">
        
        <h2 class="mb-5">Carrinho</h2>
        <div class="row">
            <div class="col-sm-12 col-md-9 col-lg-9 col-xl-9">
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th width="180">Imagem</th>
                            <th>Nome</th>
                            <th width="80" class="text-center">QT</th>
                            <th width="200" class="text-center">Preço</th>
                            <th width="50"></th>
                        </tr>
                        <?php $subtotal = 0; ?>
                        <?php foreach($list as $item): ?>
                            <?php $subtotal += (floatval($item['price']) * intval($item['qt'])); ?>
                            <tr class="align-middle">
                                <td class="no-border">
                                    <img src="<?=$base;?>/media/products/<?=$item['image'];?>" width="80px" />
                                </td>
                                <td class="no-border"><?=$item['name'];?></td>
                                <td class="text-center no-border"><?=$item['qt'];?></td>
                                <td class="text-center no-border">
                                    <?=number_format($item['price'], 2, ',', '.');?>
                                </td>
                                <td class="no-border">
                                    <a href="<?=$base;?>/cart/del/<?=$item['id'];?>" class="text-danger fs-5">
                                        <i class="fas fa-times"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
            <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 p-3">
                <div class="mb-4">
                    <span>
                        Subtotal:
                        <strong class="default-color">
                        <?=number_format($subtotal, 2, ',', '.');?>
                        </strong>
                    </span>
                </div>
                <div>
                    <?php if(isset($shipping['price'])): ?>
                        <strong class="default-color">
                            <?='R$ '.$shipping['price'];?>
                        </strong>
                        <span>(Prazo: <?=$shipping['date'];?> dia<?=$shipping['date'] == '1' ? '' : 's';?>)</span>
                    <?php else: ?>
                        <span>Digite seu cep:</span>
                        <form method="POST" action="<?=$base;?>/cart" class="w-100">
                            <div class="form-group col-md-3 w-100">
                                <input type="text" class="form-control mb-2" name="cep" id="cep"/>
                                <input type="submit" value="Calcular" class="btn btn-primary"/>
                            </div>
                        </form>
                    <?php endif; ?>
                </div>
                <?php if(isset($shipping['price'])): ?>
                    <a href="<?=$base;?>/clean">Limpar Frete</a>
                <?php endif; ?>
                <div class="mt-4">
                    <span>Total:</span>&nbsp;
                    <strong class="default-color">
                        <?php
                            $frete = isset($shipping['price']) ? floatval(str_replace(',', '.', $shipping['price'])) : 0;
                            $total = $subtotal + $frete;
                            echo number_format($total, 2, ',', '.');
                        ?>
                    </strong>
                </div>
                <?php if($frete > 0): ?>
                    <div class="mt-4">
                        <form action="<?=$base;?>/payment_redirect" method="post">
                            <div class="form-group mb-2">
                                <select name="payment_type" class="form-select">
                                    <option value="checkout_transparent">Pagseguro Checkout Tranparente</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="submit" value="Finalizar compra" class="btn btn-success"/>
                            </div>
                        </form>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<script src="https://unpkg.com/imask"></script>
<script>
    let cepInput = document.getElementById('cep');
    if(cepInput) {
        IMask(
            document.getElementById('cep'),
            {
                mask: '00000000'
            }
        );
    }
</script>

<?=$render('footer', [
    'maxslider' => $filters['maxslider'] ?? 0,
    'widget_sale' => $widget_sale,
    'widget_featured2' => $widget_featured2,
    'widget_toprated' => $widget_toprated
]);?>