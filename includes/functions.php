<?php
/**
 * Public functions for this plugin.
 *
 * @package wp-slideshow
 */

/**
 * Access capability for this plugin
 *
 * @since 1.0.0
 */
function wp_slideshow_access_capability() {
	return apply_filters( 'wp_slideshow_access_capability', 'manage_options' );
}

/**
 * Validate attachments types, and image existence in the database.
 *
 * @param array $items array of attachment ids.
 *
 * @since 1.0.0
 */
function wp_slideshow_is_valid_images( $items ) {
	foreach ( $items as $item ) {
		if ( ! intval( $item ) || 0 > intval( $item ) || ! wp_attachment_is( 'image', intval( $item ) ) ) {
			return false;
		}
	}

	return true;
}
