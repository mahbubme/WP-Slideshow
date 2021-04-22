<?php
namespace WPSlideshow\Frontend;

/**
 * Frontend slider class
 */
class Slider {

	public function __construct() {

	    add_shortcode( 'wp_slideshow', array( $this, 'render_shortcode' ) );

	}

	/**
	 * Render slider shortcode
	 *
	 * @param array  $atts
	 * @param string $contents
	 *
	 * @return string
	 */
	public function render_shortcode( $atts, $content = '' ) {
	    ob_start();

		$this->render_slider( $atts );

		return ob_get_clean();
	}

	/**
	 * Render the slider
	 *
	 * @param $atts shortcode attributes
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function render_slider( $atts ) {
		$this->enqueue_slideshow_scripts();

		$slider_images = get_option( WP_SLIDESHOW_OPTION_IMAGES, array() );

		$output = '<div class="wp-slideshow-slide-wrap">';
		$output .= '<div class="wp-slideshow-slide-mask">';
		$output .= '<ul class="wp-slideshow-slide-group">';

		if ( is_array( $slider_images ) && ! empty( $slider_images ) ) {
			foreach ( $slider_images as $image_id ) {
				$image_url = wp_get_attachment_url( $image_id );

				$output .= '<li class="wp-slideshow-slide"><img src="' . wp_kses_post( $image_url ) . '" ></li>';
			}
		}

		$output .= '</ul>';
		$output .= '</div>';
		$output .= '<div class="wp-slideshow-slide-nav">';
		$output .= '<ul>';

		if ( is_array( $slider_images ) && ! empty( $slider_images ) ) {
			foreach ( $slider_images as $image_id ) {
				$output .= '<li class="wp-slideshow-slide-bullet"></li>';
			}
		}

		$output .= '</ul>';
		$output .= '</div>';
		$output .= '</div>';

		echo $output;
	}

	/**
	 * Enqueue slideshow specific registered assets
	 *
	 */
	public function enqueue_slideshow_scripts() {
		wp_enqueue_style( 'wp-slideshow-frontend' );
		wp_enqueue_script( 'wp-slideshow-frontend' );

		$wp_slideshow_scripts = apply_filters( 'wp_slideshow_localized_script', array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'nonce'    => wp_create_nonce( 'wp_slideshow_nonce' ),
		) );

		wp_localize_script( 'wp-slideshow', 'wp_slideshow', $wp_slideshow_scripts );

		do_action( 'wp_slideshow_after_scripts_loaded' );
	}
}
