<?php foreach($list as $item): ?>
    <!-- Link Product -->
    <a href="<?=$base;?>/product/<?=$item['id'];?>" class="d-flex justify-content-between text-dark border-bottom border-secondary p-2 mobile-flex mb-2">
        <div class="d-flex flex-column flex-fill align-self-center">
            <h2 class="fs-6 default-color"><?=$item['name'];?></h2>
            <div class="d-flex">
                <span class="fs-my">R$ <?=number_format($item['price_from'], 2, ',', '.');?></span>
                <span class="ms-2 fw-bold default-color fs-price-widget">R$ <?=number_format($item['price'], 2, ',', '.');?></span>
            </div>
        </div>
        <div class="flex-fill d-flex justify-content-end mobile-margin">
            <img src="<?=$base;?>/media/products/<?=$item['images'][0]['url'];?>" class="img-default-small" alt="">
        </div>
    </a>
<?php endforeach; ?>