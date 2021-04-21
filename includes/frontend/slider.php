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
	 */
	public function render_slider( $atts ) {
	    $this->enqueue_slideshow_scripts();
		?>
        <div class="wp-slideshow-container">

        </div>
		<?php
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
