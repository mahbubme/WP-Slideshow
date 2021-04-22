<?php
namespace WPSlideshow;

/**
 * Admin Pages Handler
 */
class Admin {



	public function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menu_pages' ) );

		add_action( 'admin_menu', array( $this, 'add_settings_sections' ) );
	}

	/**
	 * Register our menu page
	 *
	 * @return void
	 */
	public function admin_menu_pages() {
		global $submenu;

		$capability = wp_slideshow_access_capability();

		$hook = add_menu_page( __( 'WP Slideshow', 'wp-slideshow' ), __( 'WP Slideshow', 'wp-slideshow' ), $capability, WP_SLIDESHOW_SLUG, array( $this, 'plugin_page' ), 'dashicons-text' );

		if ( current_user_can( $capability ) ) {
			$submenu[ WP_SLIDESHOW_SLUG ][] = array( __( 'Slider Settings', 'wp-slideshow' ), $capability, 'admin.php?page=' . WP_SLIDESHOW_SLUG );
		}

		add_action( 'load-' . $hook, array( $this, 'init_hooks') );
	}

	/**
	 * Initialize our hooks for the admin page
	 *
	 * @return void
	 */
	public function init_hooks() {
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	}

	/**
	 * Load scripts and styles for the admin
	 *
	 * @return void
	 */
	public function enqueue_scripts() {
		wp_enqueue_style( 'wp-slideshow-admin' );
		wp_enqueue_script( 'wp-slideshow-admin' );
		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_script( 'wp-slideshow-slider-settings' );

		$localize_script = apply_filters( 'wp_slideshow_admin_localized_script', array(
			'nonce' => wp_create_nonce( 'wp_slideshow_nonce' ),
			'ajax_url' => admin_url( 'admin-ajax.php' ),
		) );

		wp_localize_script( 'wp-slideshow-admin', 'wp_slideshow_admin', $localize_script );

		do_action( 'wp_slideshow_admin_after_scripts_loaded' );
	}

	/**
	 * Render our admin page
	 *
	 * @return void
	 */
	public function plugin_page() {
		include_once 'pages/settings.php';
	}

	/**
	 * Add setting sections under under slider settings page
	 *
	 * @since    1.0.0
	 */
	public function add_settings_sections() {

	    add_settings_section(
			'wp_slideshow_slider_images',
			__( 'Images', 'wp-slideshow' ),
			array( $this, 'display_slider_settings' ),
			WP_SLIDESHOW_SLUG
		);

	}

	/**
	 * Displays slider settings
	 *
	 * @since    1.0.0
	 */
	public function display_slider_settings() {
	    include_once 'partials/slider-settings.php';
	}
}
