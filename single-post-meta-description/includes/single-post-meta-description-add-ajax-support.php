<?php
/**
 * Uso le API Ajax di Wordpress per passare variabili a javascript
 */
 defined( 'ABSPATH' ) or die( 'Accesso diretto negato' );


add_action( 'wp_enqueue_scripts', 'single_post_meta_description_add_ajax_support' );
function single_post_meta_description_add_ajax_support() {

 wp_enqueue_script( 'ajax-script', plugins_url( 'admin/js/single-post-meta-description-ajax-script.js', dirname(__FILE__) ), '', '', true );

// passo le variabili php a javascript
 wp_localize_script(
   'ajax-script',
   'single_post_meta_description_script',
   array(
     'ajaxurl' => admin_url( 'admin-ajax.php' ),
     'nonce'     => wp_create_nonce( 'add-post-rating-nonce' ),
     'omy' => get_the_ID()
     )
    );
  }


add_action( 'wp_ajax_get_single_post_meta_description', 'single_post_meta_description_get_current_text' );
add_action( 'wp_ajax_nopriv_get_single_post_meta_description', 'single_post_meta_description_get_current_text' );

function single_post_meta_description_get_current_text() {
   if ( ! wp_verify_nonce( $_REQUEST['_nonce'], 'add-post-rating-nonce' ) )
        die ( 'Non autorizzato!');

     $mypostid = $_REQUEST['mypid'];
     // questo è l'ID del post, vedi sopra e script.js

      $options = get_option( 'viarete_mtd_gruppo_opzioni' );
      $article_descr = get_post_meta($mypostid, 'mtd_description_field', true);

      if ($article_descr) {
        echo $article_descr;
       } elseif ( $options['mtd_main_description'] ){
         echo sanitize_text_field( $options['mtd_main_description'] );
       } else {
        echo " ";
       }

       die();
 }


 ?>
