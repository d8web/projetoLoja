    <footer>
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 p-4">
                    <h2 class="fs-4 mb-4 text-responsive-footer">
                        <?=$this->lang->get("FEATUREDPRODUCTS");?>
                    </h2>
                    <div class="d-flex flex-column">
                        <?=$render('widget', [
                            'list' => $widget_featured2
                        ]);?>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 p-4">
                    <h2 class="fs-4 mb-4 text-responsive-footer">
                        <?=$this->lang->get("ONSALEPRODUCTS");?>
                    </h2>
                    <div class="d-flex flex-column">
                        <?=$render('widget', [
                            'list' => $widget_sale
                        ]);?>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 p-4">
                    <h2 class="fs-4 mb-4 text-responsive-footer">
                        <?=$this->lang->get("TOPRATEDPRODUCTS");?>
                    </h2>
                    <div class="d-flex flex-column">
                        <?=$render('widget', [
                            'list' => $widget_toprated
                        ]);?>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 p-4">
                    <h2 class="fs-4 mb-4 text-responsive-footer">
                        <?=$this->lang->get("NEWPRODUCTS");?>
                    </h2>
                    <div class="d-flex flex-column">
                        <?=$render('widget', [
                            'list' => $widget_toprated
                        ]);?>
                    </div>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-sm-12 col-md-8 col-ls-7 col-xl-6 align-self-center m-auto">
                    
                    <!-- Begin Mailchimp Signup Form -->
                    <form
                        action="https://gmail.us1.list-manage.com/subscribe/post?u=c8a61506e6121a4b59a6f9b2c&amp;id=619357e020"
                        method="post"
                        id="mc-embedded-subscribe-form"
                        name="mc-embedded-subscribe-form"
                        class="validate"
                        novalidate
                    >
                        <div class="input-group mt-5 mb-4">
                        <input
                            type="email"
                            value=""
                            name="EMAIL"
                            class="required email form-control my-padding-input"
                            placeholder="<?=$this->lang->get("SUBSCRIBETEXT");?>"
                            id="mce-EMAIL"
                        >
                        <input
                            type="hidden"
                            name="b_c8a61506e6121a4b59a6f9b2c_619357e020"
                            tabindex="-1"
                            value=""
                        >
                        <input
                            type="submit"
                            value="<?=$this->lang->get("SUBSCRIBEBUTTON");?>"
                            name="subscribe"
                            id="mc-embedded-subscribe"
                            class="button btn bg-color-default my-padding-input"
                        >
                        </div>
                    </form>
                    <!--End mc_embed_signup-->
                    
                </div>
            </div>

            <div class="w-100 mt-5 mb-4">
                <div class="row">
                    <div class="col-md-6 col-lg-3 mt-5 mb-3 d-flex align-items-center">
                        <a href="<?=$base;?>" class="fs-1 m-0 default-color fw-bold">
                            <h2>Ecommerce</h2>
                        </a>
                    </div>
                    <div class="col-md-6 col-lg-3 d-flex flex-column text-center mt-5">
                        <h4>Menu</h4>
                        <ul class="p-0">
                            <li class="mt-2 mb-2">
                                <a href="">Information</a>
                            </li>
                            <li class="mt-2 mb-2">
                                <a href="">Information</a>
                            </li>
                            <li class="mt-2 mb-2">
                                <a href="">Information</a>
                            </li>
                            <li class="mt-2 mb-2">
                                <a href="">Information</a>
                            </li>
                            <li class="mt-2 mb-2">
                                <a href="">Information</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6 col-lg-3 d-flex flex-column text-center mt-5">
                        <h4>Menu</h4>
                        <ul class="p-0">
                            <li class="mt-2 mb-2">
                                <a href="">Information</a>
                            </li>
                            <li class="mt-2 mb-2">
                                <a href="">Information</a>
                            </li>
                            <li class="mt-2 mb-2">
                                <a href="">Information</a>
                            </li>
                            <li class="mt-2 mb-2">
                                <a href="">Information</a>
                            </li>
                            <li class="mt-2 mb-2">
                                <a href="">Information</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6 col-lg-3 d-flex flex-column text-center mt-5">
                        <h4>Menu</h4>
                        <ul class="p-0">
                            <li class="mt-2 mb-2">
                                <a href="">Information</a>
                            </li>
                            <li class="mt-2 mb-2">
                                <a href="">Information</a>
                            </li>
                            <li class="mt-2 mb-2">
                                <a href="">Information</a>
                            </li>
                            <li class="mt-2 mb-2">
                                <a href="">Information</a>
                            </li>
                            <li class="mt-2 mb-2">
                                <a href="">Information</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="footer-end mt-5 border-top border-secondary pt-3 pb-3">
                <div class="row">
                    <div class="col-sm-6 d-flex align-items-center">
                        <h6 class="fs-6 mb-1 mt-1 text-responsive">
                            <?=$this->lang->get("ALLRIGHTRESERVED");?>
                        </h6>
                    </div>
                    <div class="col-sm-6 text-end mb-1 mt-1">
                        <div class="row">
                            <div class="col-3 p-0">
                                <img src="<?=$base;?>/assets/images/visa.png" width="50"/>
                            </div>
                            <div class="col-3 p-0">
                                <img src="<?=$base;?>/assets/images/visa.png" width="50"/>
                            </div>
                            <div class="col-3 p-0">
                                <img src="<?=$base;?>/assets/images/visa.png" width="50"/>
                            </div>
                            <div class="col-3 p-0">
                                <img src="<?=$base;?>/assets/images/visa.png" width="50"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script>
        let BASE_URL = '<?=$base;?>';
        let maxslider = '<?=!empty($maxslider) ? $maxslider : 0;?>';
    </script>
    <script src="<?=$base;?>/assets/js/jquery-3.6.0.min.js"></script>
    <script src="<?=$base;?>/assets/js/jquery-ui.min.js"></script>
    <script src="<?=$base;?>/assets/js/bootstrap.bundle.min.js"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.15.3/js/all.js"></script>
    <script src="<?=$base;?>/assets/js/app.js"></script>
</body>
</html>