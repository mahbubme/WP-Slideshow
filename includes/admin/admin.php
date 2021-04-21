<?php
namespace WPSlideshow;

/**
 * Admin Pages Handler
 */
class Admin {

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
	}

	/**
	 * Register our menu page
	 *
	 * @return void
	 */
	public function admin_menu() {
		global $submenu;

		$capability = wp_slideshow_access_capability();
		$slug       = 'wp-slideshow-settings';

		$hook = add_menu_page( __( 'WP Slideshow', 'wp-slideshow' ), __( 'WP Slideshow', 'wp-slideshow' ), $capability, $slug, array( $this, 'plugin_page' ), 'dashicons-text' );

		if ( current_user_can( $capability ) ) {
			$submenu[ $slug ][] = array( __( 'Settings', 'wp-slideshow' ), $capability, 'admin.php?page=' . $slug );
		}

		add_action( 'load-' . $hook, array( $this, 'init_hooks') );
	}

	/**
	 * Initialize our hooks for the admin page
	 *
	 * @return void
	 */
	public function init_hooks() {
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
	}

	/**
	 * Load scripts and styles for the admin
	 *
	 * @return void
	 */
	public function enqueue_scripts() {
		wp_enqueue_style( 'wp-slideshow-admin' );
		wp_enqueue_script( 'wp-slideshow-admin' );

		$localize_script = apply_filters( 'wp_slideshow_admin_localized_script', array(
			'nonce' => wp_create_nonce( 'wp_slideshow_nonce' ),
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
		?>
		<div class="error hide-if-js">
			<p><?php _e( 'WP Slideshow plugin requires JavaScript. Please enable JavaScript from your browser settings.', 'wp-slideshow' ); ?></p>
		</div>

		<?php
		echo '<div class="wrap"><div id="wp-slideshow-admin-page"></div></div>';
	}
}
