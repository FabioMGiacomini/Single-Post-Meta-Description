<?php
/**
 * Menu opzioni plugin nel backend
 * Options Admin menu
 */

 defined( 'ABSPATH' ) or die( 'Accesso diretto negato' );

// creo la pagina di amministrazione
// https://developer.wordpress.org/reference/functions/add_menu_page/
// https://developer.wordpress.org/resource/dashicons/#edit


// includo il foglio di style
add_action( 'admin_head', 'mtd_admin_enqueue_stylesheet' );
function mtd_admin_enqueue_stylesheet(){
  wp_enqueue_style( 'mtd-style', plugins_url( 'css/mtd-style.css', __FILE__  ) );
}


add_action('admin_menu', 'viarete_mtd_menu');
function viarete_mtd_menu(){

  add_menu_page(
    __('Single Post Meta Description Options Page', 'viarete_mtd'), // attributo title della pagina
      'SP Meta Desc', // Nome del menu
      'manage_options', // capability
      'viarete_mtd_plugin_page', // unico per identificare questo menu
      'viarete_mtd_options_page', // callback per il contenuto
      'dashicons-edit', // icona
      66 // posizione nel menu
    );

  add_submenu_page(
    'viarete_mtd_plugin_page', // slug del menu principale
    'Pagina Opzioni Aggiuntive', // titolo pagina
    'About', // voce menu
    'manage_options', // capability
    'credits_opzioni ', // identificatore del submenu
    'viarete_mtd_credits_page', // optional - callback
    '' // optional url dell'icona
  );

}


// form nel backend chiamato da add menu page
function viarete_mtd_options_page( $active_tab = '' ){
?>

<img src="<?php echo plugins_url('/images/viarete.png', __FILE__) ?>" width='150'>
      <div class="mtd_wrap">
      <h1>Single Post Meta Description</h1>
      <hr>
      <h3>Come funziona il plugin</h3>
      <p>La descrizione inserita qui è quella di default e viene copiata nel tag HTML <code> &lt;meta name="description"&gt;</code>. Quando crei un nuovo articolo, sarà presente un campo aggiuntivo SPMD dove si può inserire la descrizione relativa a quell'articolo, che ha la precedenza su quella inserita qui. Se la descrizione non viene inserita né qui né nell'articolo, verrà visualizzato un estratto del singolo articolo. </p>
      <hr>
      <?php settings_errors(); ?>

      <div class="mtd_opzioni">

        <form method="post" action="options.php">

            <?php settings_fields('viarete_mtd_gruppo_opzioni'); ?>
            <?php do_settings_sections('viarete_mtd_gruppo_opzioni'); ?>

              <?php submit_button(); ?>
        </form>
      </div>
    </div><!-- /.wrap -->
<?php  } // fine options page function



    // inizializzo le opzioni del form
add_action('admin_init', 'viarete_mtd_registro_opzioni');
function viarete_mtd_registro_opzioni(){

  if (false == get_option( 'viarete_mtd_gruppo_opzioni' )) {
    add_option( 'viarete_mtd_gruppo_opzioni' );
  }

  //section name, display name, callback to print description of section, page to which section is attached.
    add_settings_section(
      "viarete_mtd_main_section", // slug uguale al register setting
      "Basic settings",       // title
      "mtd_section_content",      // callback
      "viarete_mtd_gruppo_opzioni"        // page slug
    );
    add_settings_field(
      "mtd_main_description", // setting field slug uguale al register setting
      "Descrizione di default",             // title
      "mtd_descrizione_form",    // callback
      "viarete_mtd_gruppo_opzioni",      // page slug
      "viarete_mtd_main_section" // section slug this field belongs
    );
    register_setting(
      "viarete_mtd_gruppo_opzioni", //  option group
      "viarete_mtd_gruppo_opzioni", // option name
      "viarete_mtd_sanitize_opzioni" // funzione di controllo sull'input
    );



function viarete_mtd_sanitize_opzioni($input){
      // array per le opzioni aggiornate
      $output = array();

      // controllo tutte le opzioni e sanitizzo
      foreach ($input as $key => $value) {

        if ( isset( $input[key] ) ) {
          // strip_tags function is native to PHP, for removing all HTML and PHP tags
          // stripslashes function is native PHP function, which will properly handle quotation marks around a string.
          $output[key] = strip_tags(stripslashes($input[key]));
        }
      } // end foreach
      return apply_filters('viarete_mtd_sanitize_opzioni', $output, $input);
    }

} // fine inizializzazione

// section callbacks
   function mtd_section_content(){
     echo " ";
    }

// field callbacks
   function mtd_descrizione_form(){

    $options = get_option( 'viarete_mtd_gruppo_opzioni' );

   // the ID and the name attribute of the element should match that of the ID in the call to add_settings_field
    echo '<textarea name="viarete_mtd_gruppo_opzioni[mtd_main_description]" id="mtd_main_description" rows="5" cols="50"/>' . $options['mtd_main_description'] . '</textarea><br/>';
    echo'<label>Si consigliano al massimo 160 caratteri</label>';

 } // fine descrizione form

    function mtd_advanced_settings_callback(){
        echo "<p>Opzioni avanzate</p>";
    }




function viarete_mtd_credits_page(){
  echo "<img src=" .  plugins_url('/images/viarete.png', __FILE__) . " width='150'>";
  echo "<h1>Single Post Meta Description</h1>";
  echo "<hr>";
  echo "<h4>Sviluppato da <a href='https://github.com/FabioMGiacomini' target='_blank'>Fabio Giacomini</a></h4>";
  echo "<h4>Se hai bisogno di aiuto mandaci una <a href='mailto:info@viarete.it' target='_blank'>mail</a> oppure scrivici tramite il form di <a href='https://viarete.it/#contatto' target='_blank'>contatto</a></h4>";
  echo "<h5><a href='https://www.facebook.com/siti.ecommerce.roma/' target='_blank'>Facebook</a></h5>";
}

 ?>
