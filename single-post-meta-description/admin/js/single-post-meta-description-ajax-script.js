// Single_Post_Meta_Description script

jQuery(document).ready(function($){
    $( window ).on( "load", function() {

       $.ajax({
           type: "POST",
           url: single_post_meta_description_script.ajaxurl,
           data: {
             action: 'get_single_post_meta_description',
             _nonce : single_post_meta_description_script.nonce,
             mypid: single_post_meta_description_script.omy
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
