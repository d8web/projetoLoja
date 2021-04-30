<?=$render('header');?>

<section class="mt-4 border-bottom border-secondary mb-5 pb-3">
    <div class="container">
        
        <h2>Carrinho</h2>
        <div class="row">
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th width="180">Imagem</th>
                        <th>Nome</th>
                        <th width="50" class="text-center">QT</th>
                        <th width="200" class="text-center">Preço</th>
                        <th width="50"></th>
                    </tr>
                    <?php $subtotal = 0; ?>
                    <?php foreach($list as $item): ?>
                        <?php $subtotal += (floatval($item['price']) * intval($item['qt'])); ?>
                        <tr class="align-middle">
                            <td>
                                <img src="<?=$base;?>/media/products/<?=$item['image'];?>" width="80px" />
                            </td>
                            <td><?=$item['name'];?></td>
                            <td class="text-center"><?=$item['qt'];?></td>
                            <td class="text-center">
                                <?=number_format($item['price'], 2, ',', '.');?>
                            </td>
                            <td>
                                <a href="<?=$base;?>/cart/del/<?=$item['id'];?>" class="text-danger fs-5">
                                    <i class="fas fa-times"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="3" align="right">Subtotal:</td>
                        <td class="default-color fw-bold">
                            <?=number_format($subtotal, 2, ',', '.');?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" align="right">Frete:</td>
                        <td>
                            <?php if(isset($shipping['price'])): ?>
                                <strong>
                                    <?='R$ '.$shipping['price'];?>
                                </strong>
                                <span>(Prazo: <?=$shipping['date'];?> dia<?=$shipping['date'] == '1' ? '' : 's';?>)</span>
                            <?php else: ?>
                                <span class="fw-bold mb-2">Digite seu cep</span>
                                <form method="POST" action="<?=$base;?>/cart">
                                    <div class="form-group col-md-3 w-100">
                                        <input type="text" class="form-control mb-2" name="cep" id="cep"/>
                                        <input type="submit" value="Calcular" class="btn btn-primary"/>
                                    </div>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php if(isset($shipping['price'])): ?>
                        <tr>
                            <td colspan="3" align="right"></td>
                            <td>
                                <a href="<?=$base;?>/clean">Limpar Frete</a>
                            </td>
                        </tr>
                    <?php endif; ?>
                    <tr>
                        <td colspan="3" align="right">Total:</td>
                        <td class="default-color fw-bold">
                            <?php
                                $frete = isset($shipping['price']) ? floatval(str_replace(',', '.', $shipping['price'])) : 0;
                                $total = $subtotal + $frete;
                                echo number_format($total, 2, ',', '.');
                            ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</section>

<script src="https://unpkg.com/imask"></script>
<script>
    IMask(
        document.getElementById('cep'),
        {
            mask: '00000000'
        }
    );
</script>

<?=$render('footer', [
    'maxslider' => $filters['maxslider'] ?? 0,
    'widget_sale' => $widget_sale,
    'widget_featured2' => $widget_featured2,
    'widget_toprated' => $widget_toprated
]);?>