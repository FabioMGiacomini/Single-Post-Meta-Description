<?php
/**
 * Uso le API Ajax di WordPress per passare variabili a javascript
 *
 * @package Single_Post_Meta_Description
 */

defined( 'ABSPATH' ) || die( 'Accesso diretto negato' );

 add_action( 'wp_enqueue_scripts', 'single_post_meta_description_add_ajax_support' );
 /**
  * Passo le variabili a jQuery da php
  */
function single_post_meta_description_add_ajax_support() {

	wp_enqueue_script( 'ajax-script', plugins_url( 'admin/js/single-post-meta-description-ajax-script.js', dirname( __FILE__ ) ), '', '1.0.0', true );

	// passo le variabili php a javascript
	wp_localize_script(
		'ajax-script', // slug uguale a wp_enqueue_scripts().
		'single_post_meta_description_script',
		array(
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'nonce'   => wp_create_nonce( 'add-post-rating-nonce' ),
			'omy'     => get_the_ID(),
		)
	);
}


	add_action( 'wp_ajax_get_single_post_meta_description', 'single_post_meta_description_get_current_text' );
	add_action( 'wp_ajax_nopriv_get_single_post_meta_description', 'single_post_meta_description_get_current_text' );
/**
 * Se nel campo descrizione del post c'è del testo lo inserisco nel tag meta.
 * Se manca inserisco quello presente nella descrizione di default.
 *
 * $_POST['mypid']  E' l'id del post preso con jQuery, passato da wp_localize_script
 * $_POST['_nonce']  E' il nonce preso con jQuery, passato da wp_localize_script
 */
	function single_post_meta_description_get_current_text() {
		if ( empty( $_POST['_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['_nonce'] ), 'add-post-rating-nonce' ) ) {
			die( 'Non autorizzato!' ); }

		if ( isset( $_POST['mypid'] ) ) {
			$mypostid = intval( $_POST['mypid'] );
		}
		// questo è l'ID del post, vedi sopra e script.js

		$options       = get_option( 'single_post_meta_description_options_group' );
		$article_descr = get_post_meta( $mypostid, 'single_post_meta_custom_field', true );

		if ( $article_descr ) {
			echo esc_attr( $article_descr );
		} elseif ( $options['single_post_meta_default_description_box'] ) {
			echo esc_attr( $options['single_post_meta_default_description_box'] );
		} else {
			echo ' ';
		}
		die();
	}
