<?php
/**
 * Plugin Name:       File-Preview for Download List Block with Icons
 * Description:       Adds a preview iconset to Download List Block with Icons.
 * Requires at least: 6.0
 * Requires PHP:      8.0
 * Version:           1.0.1
 * Author:            Thomas Zwirner
 * Author URI:        https://www.thomaszwirner.de
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       download-list-preview
 *
 * @package download-list-preview
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// bail if PHP < 8.0 is used.
if ( version_compare( PHP_VERSION, '8.0.0' ) < 0 ) {
    return;
}

use downloadlist_preview\Preview;

// secure plugin name as constant.
const DL_PREVIEW_PLUGIN = __FILE__;

// embed necessary files.
require_once __DIR__ . '/inc/autoload.php';

// run on plugin-activation.
register_activation_hook( DL_PREVIEW_PLUGIN, 'downloadlist\Helper::add_generic_iconsets' );
register_deactivation_hook( DL_PREVIEW_PLUGIN, 'downloadlist_preview_deactivate' );

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

/**
 * Remove our own iconset-taxonomy on deactivation.
 *
 * @return void
 */
function downloadlist_preview_deactivate(): void {
    // delete our own post-type-entries.
    $query = array(
        'post_type' => 'dl_icons',
        'post_status' => array( 'any', 'trash' ),
        'posts_per_page' => -1,
        'fields' => 'ids',
    );
    $posts = new \WP_Query($query);
    foreach( $posts->posts as $post_id ) {
        $delete = false;
        $terms = wp_get_object_terms( $post_id, 'dl_icon_set' );
        foreach( $terms as $term ) {
            if( 'preview' === $term->slug ) {
                $delete = true;
            }
        }
        if( $delete ) {
            wp_delete_post( $post_id );
        }
    }

    // delete entries of our own taxonomy for iconsets.
    $query = array(
        'taxonomy' => 'dl_icon_set',
        'hide_empty' => false,
        'name' => 'preview'
    );
    $icon_set = new \WP_Term_Query($query);
    foreach ($icon_set->get_terms() as $term) {
        wp_delete_term($term->term_id, 'dl_icon_set');
    }
}
