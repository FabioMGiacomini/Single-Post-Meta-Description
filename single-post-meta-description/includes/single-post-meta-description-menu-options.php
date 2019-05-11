<?php
/**
 * Menu opzioni plugin nel backend
 * Menu Page - single-post-meta-description-menu-options.
 *
 * @package Single_Post_Meta_Description
 */

defined( 'ABSPATH' ) || die( 'Accesso diretto negato' );

add_action( 'admin_head', 'single_post_meta_description_admin_enqueue_stylesheet' );
/**
 * Foglio di style
 */
function single_post_meta_description_admin_enqueue_stylesheet() {
	wp_enqueue_style( 'spmd-style', plugins_url( 'admin/css/mtd-style.css', dirname( __FILE__ ) ), '', 1, '' );
}

add_action( 'admin_menu', 'single_post_meta_description_menu_page' );
/**
 * Menu principale
 */
function single_post_meta_description_menu_page() {

	add_menu_page(
		__( 'Single Post Meta Description Options Page', 'viarete-single-post-meta-description' ), // attributo title della pagina.
		'@ S.P.M.D.', // Nome del menu.
		'manage_options', // capability.
		'single_post_meta_plugin_page', // unico per identificare questo menu.
		'single_post_meta_description_options_page', // callback per il contenuto.
		'dashicons-edit', // icona.
		66 // posizione nel menu.
	);

	add_submenu_page(
		'single_post_meta_plugin_page', // slug del menu principale.
		'Pagina Opzioni Aggiuntive', // titolo pagina.
		'About', // voce menu.
		'manage_options', // capability.
		'credits_opzioni', // identificatore del submenu.
		'single_post_meta_description_credits_page', // optional - callback.
		'' // optional url dell'icona.
	);

}

/**
 * Testo principale della pagina opzioni e form che viene popolato più avanti
 */
function single_post_meta_description_options_page() {
	$logourl = plugins_url( 'admin/images/viarete.png', dirname( __FILE__ ) );
	?>

<img src="<?php echo esc_url( $logourl ); ?>" width='150'>
	<div class="mtd_wrap">
		<h1>Single Post Meta Description</h1>
		<hr>
		<h3>Come personalizzare l'attributo <code>content</code> del tag HTML <code> &lt;meta name="description"&gt;</code></h3>
		<p>La descrizione inserita qui è quella di default e viene copiata nel tag HTML <code> &lt;meta name="description"&gt;</code>. Quando crei un nuovo articolo, sarà presente un campo aggiuntivo SPMD dove si può inserire la descrizione relativa a quell'articolo, che ha la precedenza su quella inserita qui. Se la descrizione non viene inserita né qui né nell'articolo, verrà visualizzato un estratto del singolo articolo. </p>
		<hr>
		<?php settings_errors(); ?>

		<div class="mtd_opzioni">

			<form method="post" action="options.php">

				<?php settings_fields( 'single_post_meta_description_options_group' ); ?>
				<?php do_settings_sections( 'single_post_meta_description_options_group' ); ?>
				<?php submit_button(); ?>
			</form>
		</div>
	</div>

	<?php
}


add_action( 'admin_init', 'single_post_meta_description_registro_opzioni' );
/**
 * Funzione che inizializza e registra le sezioni e i campi della pagina opzioni
 */
function single_post_meta_description_registro_opzioni() {

	if ( false === get_option( 'single_post_meta_description_options_group' ) ) {
		add_option( 'single_post_meta_description_options_group' );
	}

		add_settings_section(
			'single_post_meta_main_section', // slug uguale al register setting.
			'Basic settings',       // title.
			'single_post_meta_description_section_content',      // callback.
			'single_post_meta_description_options_group'        // page slug.
		);
		add_settings_field(
			'single_post_meta_default_description_box', // setting field slug uguale al register setting.
			'Descrizione di default',             // title.
			'single_post_meta_description_form',    // callback.
			'single_post_meta_description_options_group',      // page slug.
			'single_post_meta_main_section' // section slug this field belongs.
		);
		register_setting(
			'single_post_meta_description_options_group', // option group.
			'single_post_meta_description_options_group', // option name.
			'single_post_meta_description_sanitize_opzioni' // funzione di controllo sull'input.
		);

				/** Single_post_meta_description_sanitize_opzioni
				 *
				 * @param string $input  descrizione di default.
				 */
			function single_post_meta_description_sanitize_opzioni( $input ) {
				// array per le opzioni aggiornate.
				$output = array();

				// controllo tutte le opzioni e sanitizzo.
				foreach ( $input as $key => $value ) {
					if ( isset( $input[ key ] ) ) {
						// strip_tags function is native to PHP, for removing all HTML and PHP tags.
						// stripslashes function is native PHP function, which will properly handle quotation marks around a string.
						$output[ key ] = sanitize_textarea_field( stripslashes( $input[ key ] ) );
					}
				} // end foreach
				return apply_filters( 'single_post_meta_description_sanitize_opzioni', $output, $input );
			}

		} // fine single_post_meta_description_registro_opzioni.

/**
 * Per mostrare eventuali messaggi nella pagina delle opzioni
 */
function single_post_meta_description_section_content() {
	echo ' ';
	}

/**
 * Creo il form nella pagina delle opzioni per la descrizione di default
 */
function single_post_meta_description_form(){

	$options = get_option( 'single_post_meta_description_options_group' );

	// the name attribute of the element should match the one in add_settings_field.
	// In questo caso essendoci un gruppo di opzioni devo mettere anche quelle, che poi richiamo nella funzione single_post_meta_description_get_current_text()
	echo '<textarea name="single_post_meta_description_options_group[single_post_meta_default_description_box]" id="single_post_meta_default_description_box" rows="5" cols="50" maxlength="160"/>' . esc_attr( $options['single_post_meta_default_description_box'] ) . '</textarea><br/>';
	echo '<label>Sono permessi al massimo 160 caratteri</label>';

	}



/**
 * Questa mostra solo il titolo
 */
function single_post_meta_description_advanced_settings_callback() {
	echo '<p>Opzioni avanzate</p>';
	}


/**
 * Pagina chi siamo
 */
function single_post_meta_description_credits_page() {
	$viaretecontatto = 'https://viarete.it/#contatto';
	$viaretemail     = 'mailto://info@viarete.it';
	$fggithub        = 'https://github.com/FabioMGiacomini';
	$facebook        = 'https://www.facebook.com/siti.ecommerce.roma/';
	$logourl         = plugins_url( 'admin/images/viarete.png', dirname( __FILE__ ) );

	echo '<img src=' . esc_url( $logourl ) . 'width="150">';
	echo '<h1>Single Post Meta Description</h1>';
	echo '<hr>';
	echo "<h4>Sviluppato da <a href='" . esc_url( $fggithub ) . "' target='_blank'>Fabio Giacomini</a></h4>";
	echo "<h4>Se hai bisogno di aiuto mandaci una <a href='" . esc_url( $viaretemail ) . "' target='_blank'>mail</a> oppure scrivici tramite il form di <a href='" . esc_url( $viaretecontatto ) . "' target='_blank'>contatto</a></h4>";
	echo "<h5><a href='" . esc_url( $facebook ) . "' target='_blank'>Facebook</a></h5>";
	}
