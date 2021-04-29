<footer class="pt-3">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-4">
                <h2 class="fs-5 mt-2">
                    <?=$this->lang->get("FEATUREDPRODUCTS");?>
                </h2>
                <div class="d-flex flex-column">
                    <?=$render('widget', [
                        'list' => $widget_featured2
                    ]);?>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-4">
                <h2 class="fs-5 mt-2">
                    <?=$this->lang->get("ONSALEPRODUCTS");?>
                </h2>
                <div class="d-flex flex-column">
                    <?=$render('widget', [
                        'list' => $widget_sale
                    ]);?>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-4">
                <h2 class="fs-5 mt-2">
                    <?=$this->lang->get("TOPRATEDPRODUCTS");?>
                </h2>
                <div class="d-flex flex-column">
                    <?=$render('widget', [
                        'list' => $widget_toprated
                    ]);?>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-sm-6 col-md-7 align-self-center m-auto">
                
                <!-- Begin Mailchimp Signup Form -->
                <form action="https://gmail.us1.list-manage.com/subscribe/post?u=c8a61506e6121a4b59a6f9b2c&amp;id=619357e020" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" novalidate>
                    <div class="input-group mt-5 mb-4">                    
                    <input type="email" value="" name="EMAIL" class="required email form-control p-3" placeholder="<?=$this->lang->get("SUBSCRIBETEXT");?>" id="mce-EMAIL">
                    <input type="hidden" name="b_c8a61506e6121a4b59a6f9b2c_619357e020" tabindex="-1" value="">
                    <input type="submit" value="<?=$this->lang->get("SUBSCRIBEBUTTON");?>" name="subscribe" id="mc-embedded-subscribe" class="button btn bg-color-default fs-6">
                    </div>
                </form>

                <!--End mc_embed_signup-->

                
            </div>
        </div>

        <div class="footer-end mt-5 border-top border-secondary pt-3 pb-3">
            <div class="row">
                <div class="col-sm-6">
                    <h6 class="fs-6 m-0">
                        <?=$this->lang->get("ALLRIGHTRESERVED");?>
                    </h6>
                </div>
                <div class="col-sm-6 text-end">
                    <div class="row">
                        <div class="col-3">Card</div>
                        <div class="col-3">Card</div>
                        <div class="col-3">Card</div>
                        <div class="col-3">Card</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

    <script>
        let BASE_URL = '<?=$base;?>';
        let maxslider = '<?=$maxslider;?>';
    </script>
    <script src="<?=$base;?>/assets/js/jquery-3.6.0.min.js"></script>
    <script src="<?=$base;?>/assets/js/jquery-ui.min.js"></script>
    <script src="<?=$base;?>/assets/js/bootstrap.bundle.min.js"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.15.3/js/all.js"></script>
    <script src="<?=$base;?>/assets/js/app.js"></script>
    </body>
</html>