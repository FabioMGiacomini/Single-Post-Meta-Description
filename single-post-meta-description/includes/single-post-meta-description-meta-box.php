<?php
/**
 * Meta box presente in ogni articolo
 * viarete.it
 *
 * @package Single_Post_Meta_Description
 * @version 1.0.0
 */

/**
 * Creo la meta box presente in ogni articolo
 * metabox in every post page
 */
function single_post_meta_description_meta_box_add() {

	add_meta_box(
		'single_post_meta_description_meta_box_id',     // id
		'SPMD - Single Post Meta Description Field',  // title
		'single_post_meta_description_meta_box_cback',     // callback
		'post',               // page
		'normal',             // context
		'high'                // priority
	);
}
add_action( 'add_meta_boxes', 'single_post_meta_description_meta_box_add' );

/**
 * Campo personalizzato per la descrizione presente in ogni post
 * Custom Field - post page
 */
function single_post_meta_description_meta_box_cback() {
	global $post;
	$values = get_post_custom( $post->ID );
	$text   = isset( $values['single_post_meta_custom_field'] ) ? sanitize_text_field( $values['single_post_meta_custom_field'][0] ) : '';

	wp_nonce_field( 'single_post_meta_description_nonce_action', 'single_post_meta_description_box_nonce_name' );
	?>
	<label for="single_post_meta_custom_field">Descrizione</label>
	<input type="text" name="single_post_meta_custom_field" id="single_post_meta_custom_field" value="<?php echo esc_attr( $text ); ?>" maxlength="160"/>

 	<?php
}


add_action( 'save_post', 'single_post_meta_description_meta_box_save' );
/**
 * Salvo la descrizione personalizzata del post
 *
 * @param int $post_id  ID del post di cui salvo la descrizione.
 */
function single_post_meta_description_meta_box_save( $post_id ) {

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return $post_id;
	}

	if ( ! isset( $_POST['single_post_meta_description_box_nonce_name'] ) || ! wp_verify_nonce( sanitize_key( $_POST['single_post_meta_description_box_nonce_name'] ), 'single_post_meta_description_nonce_action' ) ) {
		return $post_id; // sanitize_key() Lowercase alphanumeric characters
	}

	if ( ! current_user_can( 'edit_post' ) ) {
		return $post_id;
	}

	if ( isset( $_POST['single_post_meta_custom_field'] ) ) {
		update_post_meta( $post_id, 'single_post_meta_custom_field', sanitize_text_field( wp_unslash( $_POST['single_post_meta_custom_field'] ) ) );
	}
}
