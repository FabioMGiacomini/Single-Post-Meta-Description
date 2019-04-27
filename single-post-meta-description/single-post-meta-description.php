<?php
/**
 * Plugin Name: Single Post Meta Description
 * Plugin Uri: https://github.com/FabioMGiacomini/Single-Post-Meta-Description
 * Description: Crea un campo custom nei post, dove inserire la descrizione della pagina che apparirà nel tag html <code>meta name="description"</code> Aiuta a migliorare i risultati su Google, la descrizione appare nella SERP. 
 * Version: 1.0.0
 * Author: Fabio Giacomini
 * Author Uri: <a href="https://github.com/FabioMGiacomini" target=_blank"">Fabio Giacomini</a>
 * Version: 1.0.0
 * License: GPLv2 or later
 * License Uri: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: viarete-spmd
 * Domain Path: /languages
 * Simple Post Meta Description is free software: you can redistribute it
 * and/or modify it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * Simple Post Meta Description is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Simple Post Meta Description. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
 */

 defined( 'ABSPATH' ) or die( 'Accesso diretto negato' );

// menu opzioni nel backend dove viene scritta la descrizione di default
include 'mtd-menu-options.php';

// metabox presente in ogni articolo che sovrascrive la descrizione di default
include 'mtd_meta_box.php';

// inclusione ajax php
include 'mtd_add_ajax_support.php';


// mostro la descrizione di default se presente nel meta tag description
function mtd_default_description(){

  $options = get_option( 'viarete_mtd_gruppo_opzioni' );
  $article_descr = get_post_meta(get_the_ID(), 'mtd_description_field', true);

  if ( is_singular() && $article_descr ) {
            echo $article_descr;
        } elseif ( $options['mtd_main_description'] ){
      echo sanitize_text_field( $options['mtd_main_description'] );
    } else {
          set_meta_description();
        }
}

 ?>
