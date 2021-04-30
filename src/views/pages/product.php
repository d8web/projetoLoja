<?=$render('header');?>

<section class="mt-5 pb-5 border-bottom border-secondary">
    <div class="container">
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="p-5 d-block transition">
                    <img src="<?=$base;?>/media/products/<?=$images[0]['url'];?>" class="img-fluid main-photo"/>
                </div>
                <div class="d-flex justify-content-center align-items-center">
                    <?php foreach($images as $img): ?>
                        <div class="p-3">
                            <img src="<?=$base;?>/media/products/<?=$img['url'];?>" class="my-images"/>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="col-md-6 d-flex flex-column justify-content-center align-items-center">
                <div>
                    <h2 class="m-0 fs-1">
                        <?=$info['name'];?>
                    </h2>
                    <small class="d-block mb-1 fw-bold"><?=$info['brand_name'];?></small>

                    <?php if($info['rating'] != '0'): ?>
                        <div class="d-flex">
                            <?php for($q = 0; $q < intval($info['rating']); $q++): ?>
                                <i class="fas fa-star warning yellow"></i>
                            <?php endfor; ?>
                        </div>
                    <?php endif; ?>

                    <p class="mt-3 mb-5 w-75">
                        <?=$info['description'];?>
                    </p>
                    
                    <span class="text-secondary d-block">
                        De <?=number_format($info['price_from'], 2, ',', '.');?>
                    </span>
                    <span>
                        Por apenas
                        <span class="fw-bold fs-3 default-color">
                            <?=number_format($info['price'], 2, ',', '.');?>
                        </span>
                    </span>
                    
                    <form action="<?=$base;?>/cart/add" method="post" class="mt-4 addtocart" id="addtocart">
                        <input type="hidden" name="id_product" value="<?=$info['id'];?>"/>
                        <input type="hidden" name="qt_product" value="1"/>
                        <button data-action="decrease" class="border border-secondary">
                            <i class="fas fa-minus"></i>
                        </button>
                        <input type="text" name="qt" value="1" class="addtocart_qt" disabled/>
                        <button data-action="increase" class="border border-secondary">
                            <i class="fas fa-plus"></i>
                        </button>
                        <input type="submit" class="mybtn" value="<?=$this->lang->get("ADDCART");?>">
                    </form>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <h2 class="fs-3 mt-5 mb-5"><?=$this->lang->get("TESTIMONIALS");?></h2>
                <?php foreach($products_rates as $item): ?>
                    <div class="w-75">
                        <strong class="default-color d-block"><?=$item['user_name'];?></strong>
                        <?php for($q = 0; $q < intval($item['points']); $q++): ?>
                            <i class="fas fa-star warning yellow"></i>
                        <?php endfor; ?>
                        <p class="mt-1">"<?=$item['comment'];?>"</p>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="col-md-6">
                <h2 class="fs-3 mt-5 mb-5"><?=$this->lang->get("SPECIFICATIONS");?></h2>
                <?php if(!empty($product_options)): ?>
                    <?php foreach($product_options as $op): ?>
                        <div class="d-flex">
                            <div class="default-color fs-6">
                                <?=$op['name'];?>:
                            </div>
                            <p class="ms-1 fs-6"><?=$op['value'];?></p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

    </div>
    </div>
</section>

<?=$render('footer', [
    'widget_sale' => $widget_sale,
    'widget_featured2' => $widget_featured2,
    'widget_toprated' => $widget_toprated
]);?>