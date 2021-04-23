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

		$localize_script = apply_filters( 'wp_slideshow_admin_localized_script', array(
			'nonce'                        => wp_create_nonce( 'wp_slideshow_nonce' ),
			'ajax_url'                     => admin_url( 'admin-ajax.php' ),
			'text_select_image'            => __( 'Select or upload image for slider', 'wp-slideshow' ),
			'text_add_to_slider'           => __( 'Add To Slider', 'wp-slideshow' ),
			'text_update_settings_warning' => __( 'Please click on the button to update the settings', 'wp-slideshow' ),
			'text_dismiss_notice'          => __( 'Dismiss this notice', 'wp-slideshow' ),
			'text_settings_updated'        => __( 'Settings Updated', 'wp-slideshow' ),
			'text_settings_cannot_update'  => __( 'Error: Settings Cannot be Updated', 'wp-slideshow' ),
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
	 * Add settings sections under slider settings page
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
