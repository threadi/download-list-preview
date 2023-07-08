<?php
/**
 * Plugin Name:       File-Preview for Download List Block with Icons
 * Description:       Adds a preview to Download List Block with Icons.
 * Requires at least: 6.0
 * Requires PHP:      8.0
 * Version:           @@VersionNumber@@
 * Author:            Thomas Zwirner
 * Author URI:        https://www.thomaszwirner.de
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       downloadlist-pdf
 *
 * @package download-list-preview
 */

use downloadlist_preview\Preview;

// secure plugin name as constant.
const DL_PREVIEW_PLUGIN = __FILE__;

// only run our plugin-function if PHP 8.0 or newer is used.
if ( version_compare( PHP_VERSION, '8.0.0' ) >= 0 ) {

    // embed necessary files.
    require_once 'inc/autoload.php';

    // run on plugin-activation.
    register_activation_hook( DL_PREVIEW_PLUGIN, 'downloadlist\Helper::add_generic_iconset' );

    /**
     * Register the preview iconset.
     *
     * @param array $list The list of iconsets.
     * @return array
     */
    function downloadlist_register_preview_iconset( array $list ): array {
        $list[] = Preview::get_instance();
        return $list;
    }
    add_filter( 'downloadlist_register_iconset', 'downloadlist_register_preview_iconset', 10, 1 );
}
