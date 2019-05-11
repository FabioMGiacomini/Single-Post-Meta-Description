<?php
/**
 * Single Post Meta Description
 *
 * @package Single_Post_Meta_Description
 * @author Fabio Giacomini <info@viarete.it>
 * @license   GPL-2.0+
 * @link https://github.com/FabioMGiacomini/Single-Post-Meta-Description
 * @version 1.0.0
 */

/**
 * Plugin Name: Single Post Meta Description
 * Plugin Uri: https://github.com/FabioMGiacomini/Single-Post-Meta-Description
 * Description: Crea un campo custom nei post, dove inserire la descrizione della pagina che apparirà nel tag html <code>meta name="description"</code> Aiuta a migliorare i risultati su Google, la descrizione appare nella SERP.
 * Version: 1.0.0
 * Author: Fabio Giacomini
 * Author Uri: https://github.com/FabioMGiacomini
 * Text Domain: viarete-single-post-meta-description
 * License: GPL-2.0+
 * License Uri: https://www.gnu.org/licenses/gpl-2.0.html
 * Domain Path: /languages
 * GitHub Plugin URI: https://github.com/FabioMGiacomini/Single-Post-Meta-Description
 * GitHub Branch: master
 *
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


defined( 'ABSPATH' ) || die( 'Accesso diretto negato' );

define( 'SINGLE_POST_META_DESCRIPTION_VERSION', '1.0.0' );
define( 'SINGLE_POST_META_DESCRIPTION_DIR', plugin_dir_path( __FILE__ ) );


// menu opzioni nel backend dove viene scritta la descrizione di default.
require SINGLE_POST_META_DESCRIPTION_DIR . 'includes/single-post-meta-description-menu-options.php';

// metabox presente in ogni articolo che sovrascrive la descrizione di default.
require SINGLE_POST_META_DESCRIPTION_DIR . 'includes/single-post-meta-description-meta-box.php';

// inclusione ajax php.
require SINGLE_POST_META_DESCRIPTION_DIR . 'includes/single-post-meta-description-add-ajax-support.php';
