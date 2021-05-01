<?=$render('header');?>

<section>
    <div class="container mt-5 mb-5">
        <h2 class="m-0">Checkout transparent Pag Seguro</h2>
    </div>
</section>

<?=$render('footer', [
    'maxslider' => $filters['maxslider'] ?? 0,
    'widget_sale' => $widget_sale,
    'widget_featured2' => $widget_featured2,
    'widget_toprated' => $widget_toprated
]);?>