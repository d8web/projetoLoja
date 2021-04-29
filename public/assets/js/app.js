$( function() {
    $( "#slider-range" ).slider({
      range: true,
      min: 0,
      max: maxslider,
      values: [ $("#slider0").val(), $("#slider1").val() ],
      slide: function( event, ui ) {
        $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
      },
      change: function(event, ui) {
        $("#slider"+ui.handleIndex).val(ui.value)
        $('#filter-area form').submit()
      }
    });

    $( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) + " - $" + $( "#slider-range" ).slider( "values", 1 ) );

    $("#filter-area").find('input').on('change', function() {
      $('#filter-area form').submit()
    })

    $("#addtocart button").on('click', function(e) {
      e.preventDefault();

      var qt = parseInt($(".addtocart_qt").val())
      var action = $(this).attr('data-action')

      if(action == 'decrease') {
        qt --;
        if(qt <= 0) {
          qt = 1;
        }
      } else if(action == 'increase') {
        qt ++;
      }

      $(".addtocart_qt").val(qt)
      
    });

});

$(".my-images").on('click', function() {
  var url = $(this).attr('src')
  $('.main-photo').attr('src', url)
});