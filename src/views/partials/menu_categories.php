<section class="mt-4">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-5 col-lg-3">
                <div class="dropdown">
                    <button class="btn bg-color-default dropdown-toggle w-100 p-3" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        <?=$this->lang->get("SELECTCATEGORY");?>
                    </button>
                    <ul class="dropdown-menu w-100" aria-labelledby="dropdownMenuButton1">
                        <?php foreach($categories as $item): ?>
                            <li>
                                <a class="dropdown-item" href="<?=$base;?>/categories/<?=$item['id'];?>">
                                    <?=$item['name'];?>
                                </a>
                            </li>
                            <?php if(count($item['subs']) > 0): ?>
                                <?=$render('menu_subcategory', [
                                    'subs' => $item['subs'],
                                    'level' => 1
                                ]);?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <div class="col-sm-12 col-md-7 col-lg-9">
                <ul class="nav mt-10">
                
                    <?php if(isset($categorie_filter)): ?>
                        <?php foreach($categorie_filter as $item): ?>
                            <li class="nav-item border-end border-secondary">
                                <a class="nav-link my-color" href="<?=$base;?>/categories/<?=$item['id'];?>">
                                    <?=$item['name'];?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>

                </ul>
            </div>
        </div>
    </div>
</section>