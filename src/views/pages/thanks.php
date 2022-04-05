<?=$render('header');?>

<section>
    <div class="container pt-5 pb-5">
        <h1>Obrigado por comprar conosco!</h1>
        <p>Em breve você receberá a confirmação no seu e-mail!</p>
    </div>
</section>

<?=$render('footer', [
    'maxslider' => $filters['maxslider'] ?? 0,
    'widget_sale' => $widget_sale,
    'widget_featured2' => $widget_featured2,
    'widget_toprated' => $widget_toprated
]);?>