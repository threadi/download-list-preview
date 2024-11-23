<?php
/**
 * File for preview iconset.
 *
 * @package download-list-preview
 */

namespace downloadlist_preview;

// prevent direct access.
defined( 'ABSPATH' ) || exit;

use downloadlist\Helper;
use downloadlist\Iconset;
use downloadlist\Iconset_Base;
use WP_Query;
use WP_Term;
use WP_Term_Query;

/**
 * Definition for preview iconset.
 */
class Preview extends Iconset_Base implements Iconset {
    /**
     * Set type of this iconset.
     *
     * @var string
     */
    protected string $type = 'preview';

    /**
     * Set slug of this iconset.
     *
     * @var string
     */
    protected string $slug = 'preview';

    /**
     * This iconset uses generated graphics.
     *
     * @var bool
     */
    protected bool $gfx = true;

    /**
     * Term of this iconset.
     *
     * @var WP_Term|null
     */
    private WP_Term|null $term = null;

    /**
     * Initialize the object.
     *
     * @return void
     */
    public function init(): void {
        $this->label = __( 'Preview Images', 'download-list-preview' );

        // get term of this iconset.
        $query = array(
            'taxonomy'   => 'dl_icon_set',
            'hide_empty' => false,
            'name' => $this->get_slug()
        );
        $results = new WP_Term_Query( $query );
        foreach( $results->get_terms() as $term ) {
            $this->term = $term;
        }
    }

    /**
     * Get style for given file-type.
     *
     * @param int    $post_id ID of the icon-post.
     * @param string $term_slug The slug of the term this iconset is using.
     * @param string $filetype Name for the filetype to add.
     * @return string
     */
    public function get_style_for_filetype( int $post_id, string $term_slug, string $filetype ): string {
        return '';
    }

    /**
     * Return the by iconset supported filetypes.
     *
     * @return array
     */
    public function get_file_types(): array {
        return array_keys(array_flip(helper::get_mime_types()));
    }

    /**
     * Get icons this set is assigned to.
     *
     * @return array The post-IDs of the icons as array.
     */
    public function get_icons(): array {
        $query   = array(
            'post_type'   => 'dl_icons',
            'post_status' => 'any',
            'fields'      => 'ids',
            'tax_query'   => array(
                array(
                    'taxonomy' => 'dl_icon_set',
                    'terms'    => $this->get_slug(),
                    'field'    => 'slug',
                    'operator' => '=',
                ),
            ),
        );
        $results = new WP_Query( $query );

        // return resulting list.
        return $results->posts;
    }

    /**
     * Return style for single file.
     *
     * This is the magic of this iconset: we use a thumbnail of the given file as icon image. WordPress is handling its generation.
     *
     * @param int $attachment_id ID of the attachment.
     * @return string
     */
    public function get_style_for_file( int $attachment_id ): string {
        // get width and height set on term.
        $height = get_term_meta( $this->term->term_id, 'height', 24 );
        $width = get_term_meta( $this->term->term_id, 'width', 24 );

        // get image.
        $image = wp_get_attachment_image_url( $attachment_id, 'downloadlist-icon-'.$this->get_slug() );
        if( !empty($image) ) {
            return '.wp-block-downloadlist-list.iconset-'.$this->get_slug().' .attachment-' . $attachment_id . ':before { content: "";background-image: url(' . $image . ');background-repeat: no-repeat;border: 1px solid #ccc;border-radius: 4px;height: '.$height.'px;width: '.$width.'px; }';
        }
        return '';
    }
}
