<?=$render('header');?>

<?=$render('jumbotron', [
    'categories' => !empty($categories) ? $categories : '',
    'search_term' => !empty($search_term) ? $search_term : '',
    'category' => !empty($category) ? $category : '',
    'cart_qt' => $cart_qt,
    'cart_subtotal' => $cart_subtotal
]);?>

<?=$render('menu_categories', [
    'categories' => $categories,
    'categorie_filter' => $category_filter
]);?>

<section class="mt-4 border-top border-secondary">
    <div class="container">
    <div class="row">
            <?php if(isset($sidebar)): ?>
                <div class="col-sm-12 col-md-5 col-lg-3">
                    <?=$render('sidebar', [
                        'filters' => $filters,
                        'filters_selected' => $filters_selected,
                        'widget_featured1' => $widget_featured1
                    ]);?>
                </div>
                <div class="col-sm-12 col-md-7 col-lg-9">
                    <div class="row pt-5">
                        <?php foreach($list as $key => $product_item): ?>
                            <div class="col-lg-6 col-xl-4 col-md-12 col-sm-12">
                                <?=$render('product_item', $product_item);?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <ul class="pagination pagination-md mt-2 mb-5">
                        <?php for($q = 1; $q <= $number_of_pages; $q++): ?>
                            <li class="page-item <?=($current_page==$q)?'active':'';?>">
                                <a class="page-link" href="<?=$base;?>/categories/<?=$id_category;?>?page=<?=$q;?>">
                                    <?=$q;?>
                                </a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </div>
            <?php else: ?>
                <div class="col-sm-12">
                    <div class="row pt-5 w-100">
                        <?php foreach($list as $key => $product_item): ?>
                            <div class="col-lg-4 col-xl-3 col-md-12 col-sm-12">
                                <?=$render('product_item', $product_item);?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <ul class="pagination pagination-md mt-2 mb-5">
                        <?php for($q = 1; $q <= $number_of_pages; $q++): ?>
                            <li class="page-item <?=($current_page==$q)?'active':'';?>">
                                <a class="page-link" href="<?=$base;?>/?<?php 
                                        $pag_array = $_GET;
                                        $pag_array['page'] = $q;
                                        echo http_build_query($pag_array);
                                    ?>">
                                    <?=$q;?>
                                </a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?=$render('footer', [
    'maxslider' => $filters['maxslider'],
    'widget_sale' => $widget_sale,
    'widget_featured2' => $widget_featured2,
    'widget_toprated' => $widget_toprated
]);?>