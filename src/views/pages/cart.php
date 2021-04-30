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
                </table>
            </div>
        </div>

    </div>
</section>

<?=$render('footer', [
    'maxslider' => $filters['maxslider'] ?? 0,
    'widget_sale' => $widget_sale,
    'widget_featured2' => $widget_featured2,
    'widget_toprated' => $widget_toprated
]);?>