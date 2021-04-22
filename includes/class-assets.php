<?php
namespace WPSlideshow;

/**
 * Scripts and Styles Class
 */
class Assets {

    function __construct() {

        if ( is_admin() ) {
            add_action( 'admin_enqueue_scripts', array( $this, 'register' ), 5 );
        } else {
            add_action( 'wp_enqueue_scripts', array( $this, 'register' ), 5 );
        }

    }

    /**
     * Register required scripts and styles
     *
     * @return void
     */
    public function register() {
        $this->register_scripts( $this->get_scripts() );
        $this->register_styles( $this->get_styles() );
    }

    /**
     * Register scripts
     *
     * @param  array $scripts
     *
     * @return void
     */
    private function register_scripts( $scripts ) {
        foreach ( $scripts as $handle => $script ) {
            $deps      = isset( $script['deps'] ) ? $script['deps'] : false;
            $in_footer = isset( $script['in_footer'] ) ? $script['in_footer'] : false;
            $version   = isset( $script['version'] ) ? $script['version'] : WP_SLIDESHOW_VERSION;

            wp_register_script( $handle, $script['src'], $deps, $version, $in_footer );
        }
    }

    /**
     * Register styles
     *
     * @param  array $styles
     *
     * @return void
     */
    public function register_styles( $styles ) {
        foreach ( $styles as $handle => $style ) {
            $deps = isset( $style['deps'] ) ? $style['deps'] : false;

            wp_register_style( $handle, $style['src'], $deps, WP_SLIDESHOW_VERSION );
        }
    }

	/**
	 * Get file prefix
	 *
	 * @return string
	 */
	public function get_prefix() {
		$prefix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

		return $prefix;
	}

    /**
     * Get all registered scripts
     *
     * @return array
     */
    public function get_scripts() {
	    $prefix = $this->get_prefix();

        $scripts = array(
            'wp-slideshow-admin' => array(
                'src'       => WP_SLIDESHOW_ASSETS . '/js/admin' . $prefix . '.js',
                'version'   => filemtime( WP_SLIDESHOW_PATH . '/assets/js/admin' . $prefix . '.js' ),
                'deps'      => array( 'jquery' ),
                'in_footer' => true
            ),
            'wp-slideshow-slider-settings' => array(
	            'src'       => WP_SLIDESHOW_ASSETS . '/js/slider-settings' . $prefix . '.js',
	            'version'   => filemtime( WP_SLIDESHOW_PATH . '/assets/js/slider-settings' . $prefix . '.js' ),
	            'deps'      => array( 'jquery' ),
	            'in_footer' => true
            ),
            'wp-slideshow-frontend' => array(
                'src'       => WP_SLIDESHOW_ASSETS . '/js/frontend-slider' . $prefix . '.js',
                'version'   => filemtime( WP_SLIDESHOW_PATH . '/assets/js/frontend-slider' . $prefix . '.js' ),
                'deps'      => array( 'jquery' ),
                'in_footer' => true
            )
        );

        return $scripts;
    }

    /**
     * Get registered styles
     *
     * @return array
     */
    public function get_styles() {
	    $prefix = $this->get_prefix();

        $styles = array(
            'wp-slideshow-admin' => array(
                'src'       =>  WP_SLIDESHOW_ASSETS . '/css/admin' . $prefix . '.css',
            ),
            'wp-slideshow-frontend' => array(
                'src'       =>  WP_SLIDESHOW_ASSETS . '/css/frontend-slider' . $prefix . '.css',
            ),
        );

        return $styles;
    }

}
