<?php
/**
 * Provide admin area view for slider settings
 *
 * @since 1.0.0
 * @package wp-slideshow
 */

?>
<div class="wp-slideshow-settings-slider">
	<div class="description" id="wp-slideshow-upload-image-description">
		<?php esc_html_e( 'Add/remove images from the slider. Upload high resolution images for better quality.', 'wp-slideshow' ); ?>
	</div>
	<?php
	$slider_images = get_option( WP_SLIDESHOW_OPTION_IMAGES, array() );

	$output = '<ul id="sortable" class="wp-slideshow-uploaded-images">';

	if ( is_array( $slider_images ) && ! empty( $slider_images ) ) {
		foreach ( $slider_images as $image ) {
			$thumb_url = wp_get_attachment_thumb_url( $image );

			$output .= '<li class="ui-state-default" data-id="' . wp_kses_post( $image ) . '">';
			$output .= '<img src="' . esc_url( $thumb_url ) . '" >';
			$output .= '<div class="wp-slideshow-remove-image" data-id="' . wp_kses_post( $image ) . '"><span class="dashicons dashicons-no-alt"></span></div>';
			$output .= '</li>';
		}
	}
	$output .= '</ul>';

	echo wp_kses_post( $output );
	?>
	<!--Don't change the id here, if you do so then make sure to change the id in upload.js file -->
	<div id="wp-slideshow-upload-image" class="wp-slideshow-upload-image">
		<div class="wp-slideshow-upload-image-action">
			<span class="dashicons dashicons-plus-alt"></span><br>
			<span><?php esc_html_e( 'Add Image', 'wp-slideshow' ); ?></span>
		</div>
	</div>
</div>
