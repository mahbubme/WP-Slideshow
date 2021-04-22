<?php
namespace WPSlideshow;

/**
 * The ajax handler class
 */
class Ajax {

    public function __construct() {

	    add_action( 'wp_ajax_wp_slideshow_update_slider', array( $this, 'update_slider' ) );

	    add_action( 'wp_ajax_wp_slideshow_update_slider', array( $this, 'update_slider' ) );

    }

	/**
	 * handle ajax request to update slider
	 *
	 * @since    1.0.0
	 */
	public function update_slider() {
		check_ajax_referer( 'wp_slideshow_nonce','nonce' );

		if ( ! current_user_can( wp_slideshow_access_capability() ) ) {
			wp_send_json_error( array(
				'message' => __( 'You have no access to update the settings', 'wp-slideshow' ),
				'success' => false,
			) );
		}

		$new_images = array();

		if ( isset( $_POST['images'] ) && 'array' === gettype( $new_images ) && ! empty( $_POST['images'] ) ) {
			$new_images = $_POST['images'];
		}

		if ( $this->is_validated( $new_images ) ) {
			update_option( WP_SLIDESHOW_OPTION_IMAGES, $new_images );

			$response = apply_filters( 'wp_slideshow_update_slider_ajax_response', array(
				'success' => true,
				'message' => __( 'Slider images have been updated', 'wp-slideshow' )
			) );

			wp_send_json_success( $response, 200 );
		}

		wp_send_json_error( array(
			'message' => __( 'Settings cannot be updated', 'wp-slideshow' ),
			'success' => false,
		) );
	}

	/**
	 * Validate array items
	 *
	 * @since    1.0.0
	 */
	private function is_validated( $items ) {
		foreach ( $items as $item ) {
			if ( ! intval( $item ) ) {
				return false;
			}
		}
		return true;
	}
}
