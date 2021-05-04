<section class="jumbotron d-flex align-self-center">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-3 d-flex align-items-center responsive-logo">
                <a href="<?=$base;?>" class="fs-1 m-0 default-color fw-bold">
                    <img src="<?=$base;?>/assets/images/logo.png" alt="logo" class="w-100"/>
                </a>
            </div>
            <div class="col-md-12 col-lg-9 col-xl-6 align-self-center">
                <div class="flex flex-column">
                    <div class="row responsive-form-jumbotron">
                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-7">
                            <i class="fas fa-phone-alt fs-3 default-color my-icon-font-size"></i>
                            (66) 95632-5814
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-5">
                            <i class="fas fa-envelope fs-3 default-color my-icon-font-size"></i>
                            <span class="fs-6">contato@meusite.com</span>
                        </div>
                    </div>
                    <div>
                        <form method="GET" action="<?=$base;?>">
                            <div class="input-group border-2 rounded-1">

                                <input type="search"
                                    name="s"
                                    id="responsive-input"
                                    autocomplete="off"
                                    value="<?php echo !empty($search_term) ? $search_term : ''; ?>" class="form-control p-2 border"
                                />                                
                                <select name="category" class="my-padding-form no-outline border responsive-input">
                                    <option value="">
                                        <?=$this->lang->get("ALLCATEGORIES");?>
                                    </option>
                                    <?php foreach($categories as $item): ?>                                    
                                        <option value="<?=$item['id'];?>" <?php echo ($category==$item['id']?'selected="selected"':'');?>>
                                            <?=$item['name'];?>
                                        </option>
                                        <?php if(count($item['subs']) > 0): ?>
                                            <?=$render('search_subcategory', [
                                                'subs' => $item['subs'],
                                                'level' => 1,
                                                'category' => !empty($category) ? $category : ''
                                            ]);?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>

                                </select>
                                <input type="submit" id="responsive-input" class="btn bg-color-default" value="Pesquisar"/>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-12 col-xl-3 align-self-center d-flex justify-content-end my-flex-jumbotron mt-3">
                <a href="<?=$base;?>/cart" class="row responsive-cart">
                    <div class="col-3 d-flex justify-content-center align-items-center cart-item responsive-cart">
                        <i class="fas fa-shopping-cart fs-1 default-color"></i>
                        <div class="circle-item">
                            <?=$cart_qt;?>
                        </div>
                    </div>
                    <div class="col-9 responsive-cart">
                        <div class="text-dark">
                            <?=$this->lang->get("CART");?>
                        </div>
                        <strong>R$ <?=number_format($cart_subtotal, 2, ',', '.');?></strong>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>