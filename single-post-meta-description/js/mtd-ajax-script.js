// mtd plugin

jQuery(document).ready(function($){
    $( window ).on( "load", function() {

       $.ajax({
           type: "POST",
           url: mtd_script.ajaxurl,
           data: {
             action: 'get_desc',
             _nonce : mtd_script.nonce,
             mypid: mtd_script.omy

            },
            success:function(data) {
              $('meta[name="description"]').attr('content', data);
            },
            error: function(error) {
                console.log('qualcosa non va bene');
              }

            });

          });

});
