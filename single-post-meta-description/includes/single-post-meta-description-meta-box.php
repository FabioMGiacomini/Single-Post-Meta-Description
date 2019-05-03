<?php
/**
 * creo la meta box per i post presente in ogni articolo
 * metabox in every post page
 */


add_action( 'add_meta_boxes', 'single_post_meta_description_meta_box_add' );
function single_post_meta_description_meta_box_add(){

    add_meta_box(
        'mtd-meta-box-id',     // id
        'SPMD - Single Post Meta Description Field',  // title
        'single_post_meta_description_meta_box_cback',     // callback
        'post',               // page
        'normal',             // context
        'high'                // priority
        );
}


  function single_post_meta_description_meta_box_cback(){
      global $post;
      $values = get_post_custom( $post->ID );
      $text = isset( $values['mtd_description_field'] ) ?  sanitize_text_field( $values['mtd_description_field'][0] ) : '' ;

      wp_nonce_field( 'mtd_nonce_action', 'meta_box_nonce_name' );
?>
      <label for="mtd_description_field">Descrizione</label>
      <input type="text" name="mtd_description_field" id="mtd_description_field" value="<?php echo esc_attr( $text ); ?>" maxlength="160"/>

  <?php    }


  add_action( 'save_post', 'single_post_meta_description_meta_box_save' );
  function single_post_meta_description_meta_box_save( $post_id ){

    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
      return $post_id;
    }

    if( ! isset( $_POST['meta_box_nonce_name'] )
    || ! wp_verify_nonce( $_POST['meta_box_nonce_name'], 'mtd_nonce_action' ) ){
       return $post_id;
     }

    if( !current_user_can( 'edit_post' ) ){
      return $post_id;
    }

    if (isset( $_POST['mtd_description_field'] ) ) {
      update_post_meta( $post_id, 'mtd_description_field', sanitize_text_field( $_POST['mtd_description_field'] ) );
    }
}

function show_mtd_post_description(){
  if (isset( $_POST['mtd_description_field'] ) ) {
        echo sanitize_text_field( get_post_meta( get_the_ID(), 'mtd_description_field', true ) );
    }
  }
?>
