<aside class="p-2 border-end px-4">

    <div class="w-100">
        <h2 class="fs-4 m-0">
            <?=$this->lang->get("FILTER");?>
        </h2>
        <div class="" id="filter-area">
            <form action="" method="get">
                <!-- Filter Box  -->
                <!-- Filter Marcas [Brands]  -->
                <div class="mb-2">
                    <h3 class="fs-5 default-color pb-2 pt-3">
                        <?=$this->lang->get("BRANDS");?>
                    </h3>
                    <div class="mt-2 mb-2">
                        <?php foreach($filters['brands'] as $item): ?>
                            <div class="mt-1">
                                <div class="d-flex justify-content-between">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" <?php echo (isset($filters_selected['brand']) && in_array($item['id'], $filters_selected['brand']))?'checked="checked"':'';?> type="checkbox" name="filter[brand][]" value="<?=$item['id'];?>" id="filter_brand<?=$item['id'];?>">
                                        <label class="form-check-label margin-small" for="filter_brand<?=$item['id'];?>">
                                            <?=$item['name'];?>
                                        </label>
                                    </div>
                                    <div>(<?=$item['count'];?>)</div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <!-- End Filter Box  -->

                <!-- Filter Box  -->
                <!-- Filter Preço [Price]  -->
                <div class="mb-2">
                    <h3 class="fs-5 default-color pb-2 pt-3">
                        <?=$this->lang->get("PRICE");?>
                    </h3>
                    <div class="mt-2 mb-3">
                        <input type="hidden" id="slider0" name="filter[slider0]" value="<?=$filters['slider0'];?>"/>
                        <input type="hidden" id="slider1" name="filter[slider1]" value="<?=$filters['slider1'];?>"/>
                        <input type="text" id="amount" readonly class="border-0 bg-transparent default-color no-outline fs-6 w-100 fw-bold"/>
                        <div id="slider-range" class="m-2"></div>
                    </div>
                </div>
                <!-- End Filter Box  -->

                <!-- Filter Box  -->
                <!-- Filter Estrelas [Rating]  -->
                <div class="mb-2 pb-1">
                    <h3 class="fs-5 default-color pb-2 pt-3">
                        <?=$this->lang->get("RATING");?>
                    </h3>
                    <div class="m-0">
                        <div class="d-flex flex-column">
                            <!-- Zero estrelas -->
                            <div class="d-flex justify-content-between">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" <?php echo (isset($filters_selected['star']) && in_array('0', $filters_selected['star']))?'checked="checked"':'';?> name="filter[star][]" value="0" id="filter_star0">
                                    <label class="form-check-label" for="filter_star0">
                                        <div class="d-flex align-items-center margin-1 pointer">
                                            <?=$this->lang->get("NOSTAR");?>
                                        </div>
                                    </label>
                                </div>
                                <div>(<?=$filters['stars']['0'];?>)</div>
                            </div>
                            <!-- Fim -->
                            <!-- Uma estrela -->
                            <div class="d-flex justify-content-between">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" <?php echo (isset($filters_selected['star']) && in_array('1', $filters_selected['star']))?'checked="checked"':'';?> name="filter[star][]" value="1" id="filter_star1">
                                    <label class="form-check-label" for="filter_star1">
                                        <div class="d-flex align-items-center mt-1 pointer">
                                            <i class="fas fa-star warning yellow"></i>
                                        </div>
                                    </label>
                                </div>
                                <div>(<?=$filters['stars']['1'];?>)</div>
                            </div>
                            <!-- Fim -->
                            <!-- Duas estrelas -->
                            <div class="d-flex justify-content-between">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" <?php echo (isset($filters_selected['star']) && in_array('2', $filters_selected['star']))?'checked="checked"':'';?> name="filter[star][]" value="2" id="filter_star2">
                                    <label class="form-check-label" for="filter_star2">
                                        <div class="d-flex align-items-center mt-1 pointer">
                                            <i class="fas fa-star warning yellow"></i>
                                            <i class="fas fa-star warning yellow"></i>
                                        </div>
                                    </label>
                                </div>
                                <div>(<?=$filters['stars']['2'];?>)</div>
                            </div>
                            <!-- Fim -->
                            <!-- Três estrelas -->
                            <div class="d-flex justify-content-between">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" <?php echo (isset($filters_selected['star']) && in_array('3', $filters_selected['star']))?'checked="checked"':'';?> name="filter[star][]" value="3" id="filter_star3">
                                    <label class="form-check-label" for="filter_star3">
                                        <div class="d-flex align-items-center mt-1 pointer">
                                            <i class="fas fa-star warning yellow"></i>
                                            <i class="fas fa-star warning yellow"></i>
                                            <i class="fas fa-star warning yellow"></i>
                                        </div>
                                    </label>
                                </div>
                                <div>(<?=$filters['stars']['3'];?>)</div>
                            </div>
                            <!-- Fim -->
                            <!-- Quatro estrelas -->
                            <div class="d-flex justify-content-between">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" <?php echo (isset($filters_selected['star']) && in_array('4', $filters_selected['star']))?'checked="checked"':'';?> name="filter[star][]" value="4" id="filter_star4">
                                    <label class="form-check-label" for="filter_star4">
                                        <div class="d-flex align-items-center mt-1 pointer">
                                            <i class="fas fa-star warning yellow"></i>
                                            <i class="fas fa-star warning yellow"></i>
                                            <i class="fas fa-star warning yellow"></i>
                                            <i class="fas fa-star warning yellow"></i>
                                        </div>
                                    </label>
                                </div>
                                <div>(<?=$filters['stars']['4'];?>)</div>
                            </div>
                            <!-- Fim -->
                            <!-- Cinco estrelas -->
                            <div class="d-flex justify-content-between">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" <?php echo (isset($filters_selected['star']) && in_array('5', $filters_selected['star']))?'checked="checked"':'';?> name="filter[star][]" value="5" id="filter_star5">
                                    <label class="form-check-label" for="filter_star5">
                                        <div class="d-flex align-items-center mt-1 pointer">
                                            <i class="fas fa-star warning yellow"></i>
                                            <i class="fas fa-star warning yellow"></i>
                                            <i class="fas fa-star warning yellow"></i>
                                            <i class="fas fa-star warning yellow"></i>
                                            <i class="fas fa-star warning yellow"></i>
                                        </div>
                                    </label>
                                </div>
                                <div>(<?=$filters['stars']['5'];?>)</div>
                            </div>
                            <!-- Fim -->

                        </div>
                    </div>
                </div>
                <!-- End Filter Box  -->

                <!-- Filter Box  -->
                <!-- Filter Promoção [Sale]  -->
                <div class="mb-2">
                    <h3 class="fs-5 default-color pb-2 pt-3">
                        <?=$this->lang->get("SALE");?>
                    </h3>
                    <div class="mt-2 mb-2">
                        <div class="d-flex justify-content-between">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" <?php echo (isset($filters_selected['sale']) && $filters_selected['sale'] == '1')?'checked="checked"':'';?> name="filter[sale]" value="1" id="filter_sale">
                                <label class="form-check-label margin-small" for="filter_sale">
                                    Promoção
                                </label>
                            </div>
                            <div>(<?=$filters['sale'];?>)</div>
                        </div>
                    </div>
                </div>
                <!-- End Filter Box  -->

                <!-- Filter Box  -->
                <!-- Filter Opções [Options]  -->
                <div class="mb-2">
                    <h3 class="fs-5 default-color border-secondary pb-2 pt-3">
                        <?=$this->lang->get("OPTIONS");?>
                    </h3>
                    <div class="mt-2 mb-2">
                        <?php foreach($filters['options'] as $option): ?>
                            <p class="fw-bold mb-2 mt-2"><?=$option['name'];?></p>
                            <?php foreach($option['options'] as $op): ?>
                                <div class="d-flex justify-content-between mb-1">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" <?php echo (isset($filters_selected['options']) && in_array($op['value'], $filters_selected['options']))?'checked="checked"':'';?> name="filter[options][]" value="<?=$op['value'];?>" id="filter_options<?=$op['value'];?>">
                                        <label class="form-check-label margin-small" for="filter_options<?=$op['value'];?>">
                                            <?=$op['value'];?>
                                        </label>
                                    </div>
                                    <div>(<?=$op['count'];?>)</div>
                                </div>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
                <!-- End Filter Box  -->
            </form>
        </div>
    </div>

    <div class="w-100 mt-5">
        <h2 class="fs-4">
            <?=$this->lang->get("FEATUREDPRODUCTS");?>
        </h2>
        <div class="d-flex flex-column">
            <?=$render('widget', [
                'list' => $widget_featured1
            ]);?>
        </div>
    </div>
    
</aside>