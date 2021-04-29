<div class="w-100 product-item p-3 mb-4">

    <!-- Link page product -->
    <a href="<?=$base;?>/product/<?=$id;?>">
        <div class="product-tags mt-2">
            <?php if($sale == '1'): ?>
                <div class="tag red">
                    <?=$this->lang->get("SALE");?>
                </div>
            <?php endif; ?>
            <?php if($bestseller == '1'): ?>
                <div class="tag green">
                    <?=$this->lang->get("BESTSELLER");?>
                </div>
            <?php endif; ?>
            <?php if($new_product == '1'): ?>
                <div class="tag blue">
                    <?=$this->lang->get("NEW");?>
                </div>
            <?php endif; ?>
        </div>
        <div class="product-image d-flex justify-content-center">
            <img src="<?=$base;?>/media/products/<?=$images[0]['url'];?>" width="70%" alt="">
        </div>
        <div class="product-name"><?=$name;?></div>
        <div class="product-brand"><?=$brand_name;?></div>
        <div class="d-flex justify-content-between pt-3 pb-1">
            <div class="price-from">
                <?php if($price_from != '0'): ?>
                    R$ <?=number_format($price_from, 2, ',', '.');?>
                <?php endif; ?>
            </div>
            <div class="price-actual">
                R$ <?=number_format($price, 2, ',', '.');?>
            </div>
        </div>
    </a>
    
</div>