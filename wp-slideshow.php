<?php
/**
 * Plugin Name:         WP Slideshow
 * Plugin URI:          https://mahbub.me/
 * Description:         WordPress Slideshow Plugin for rtCamp
 * Author:              Mahbubur Rahman
 * Author URI:          https://mahbub.me/
 *
 * Version:             1.0.0
 * Requires at least:   5.2
 * Requires PHP:        5.6.20
 *
 * License:             GPL v3
 *
 * Text Domain:         wp-slideshow
 * Domain Path:         /languages
 *
 * WP Slideshow
 * Copyright (C) 2021, Mahbubur Rahman, mail@mahbub.me
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @category            Plugin
 * @copyright           Copyright © 2021 Mahbubur Rahman
 * @author              Mahbubur Rahman
 * @package             WPSlideshow
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WP_Slideshow class
 *
 * @class WP_Slideshow The class that holds the entire WP_Slideshow plugin
 */
final class WP_Slideshow {

    /**
     * Plugin admin slug
     *
     * @var string
     */
    public $slug = 'wp-slideshow';

    /**
     * Plugin version
     *
     * @var string
     */
    public $version = '1.0.0';

    /**
     * Holds various class instances
     *
     * @var array
     */
    private $container = array();

    /**
     * Constructor for the WP_Slideshow class
     *
     * Sets up all the appropriate hooks and actions
     * within our plugin.
     */
    public function __construct() {
        $this->define_constants();

        register_activation_hook( __FILE__, array( $this, 'activate' ) );
        register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );

        add_action( 'plugins_loaded', array( $this, 'init_plugin' ) );
    }

    /**
     * Initializes the WP_Slideshow() class
     *
     * Checks for an existing WP_Slideshow() instance
     * and if it doesn't find one, creates it.
     */
    public static function init() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new WP_Slideshow();
        }

        return $instance;
    }

    /**
     * Magic getter to bypass referencing plugin.
     *
     * @param $prop
     *
     * @return mixed
     */
    public function __get( $prop ) {
        if ( array_key_exists( $prop, $this->container ) ) {
            return $this->container[ $prop ];
        }

        return $this->{$prop};
    }

    /**
     * Magic isset to bypass referencing plugin.
     *
     * @param $prop
     *
     * @return mixed
     */
    public function __isset( $prop ) {
        return isset( $this->{$prop} ) || isset( $this->container[ $prop ] );
    }

    /**
     * Define the constants
     *
     * @return void
     */
    public function define_constants() {
        define( 'WP_SLIDESHOW_SLUG', $this->slug );
        define( 'WP_SLIDESHOW_VERSION', $this->version );
        define( 'WP_SLIDESHOW_FILE', __FILE__ );
        define( 'WP_SLIDESHOW_PATH', dirname( WP_SLIDESHOW_FILE ) );
        define( 'WP_SLIDESHOW_INCLUDES', WP_SLIDESHOW_PATH . '/includes' );
        define( 'WP_SLIDESHOW_URL', plugins_url( '', WP_SLIDESHOW_FILE ) );
        define( 'WP_SLIDESHOW_ASSETS', WP_SLIDESHOW_URL . '/assets' );
        define( 'WP_SLIDESHOW_OPTION_NAME', 'wp_slideshow_option' );
    }

    /**
     * Load the plugin after all plugins are loaded
     *
     * @return void
     */
    public function init_plugin() {
        $this->includes();
        $this->init_hooks();
    }

    /**
     * Placeholder for activation function
     *
     * Nothing being called here yet.
     */
    public function activate() {
        $installed = get_option( 'wp_slideshow_installed' );

        if ( ! $installed ) {
            $this->insert_default_options();
            update_option( 'wp_slideshow_installed', time() );
        }

        update_option( 'wp_slideshow_version', WP_SLIDESHOW_VERSION );
    }

    public function insert_default_options() {
        $default_options = array();

        update_option( WP_SLIDESHOW_OPTION_NAME, $default_options );
    }

    /**
     * Placeholder for deactivation function
     *
     * Nothing being called here yet.
     */
    public function deactivate() {
        //
    }

    /**
     * Include the required files
     *
     * @return void
     */
    public function includes() {
        // prepare the environment
        require_once WP_SLIDESHOW_INCLUDES . '/functions.php';
        require_once WP_SLIDESHOW_INCLUDES . '/class-assets.php';

        if ( $this->is_request( 'admin' ) ) {
            require_once WP_SLIDESHOW_INCLUDES . '/admin/admin.php';
        }

	    if ( $this->is_request( 'frontend' ) || $this->is_request( 'ajax' ) ) {
		    require_once WP_SLIDESHOW_INCLUDES . '/frontend/slider.php';
	    }

        if ( $this->is_request( 'ajax' ) ) {
            require_once WP_SLIDESHOW_INCLUDES . '/class-ajax.php';
        }
    }

    /**
     * Initialize the hooks
     *
     * @return void
     */
    public function init_hooks() {
        add_action( 'init', array( $this, 'init_classes' ) );

        // Localize our plugin
        add_action( 'init', array( $this, 'localization_setup' ) );
    }

    /**
     * Instantiate the required classes
     *
     * @return void
     */
    public function init_classes() {
        if ( $this->is_request( 'admin' ) ) {
            $this->container['admin'] = new WPSlideshow\Admin();
        }

	    if ( $this->is_request( 'frontend' ) || $this->is_request( 'ajax' ) ) {
		    $this->container['slider'] = new WPSlideshow\Frontend\Slider();
	    }

        if ( $this->is_request( 'ajax' ) ) {
            $this->container['ajax'] = new WPSlideshow\Ajax();
        }

	    $this->container['assets'] = new WPSlideshow\Assets();
    }

    /**
     * Initialize plugin for localization
     *
     * @uses load_plugin_textdomain()
     */
    public function localization_setup() {
        load_plugin_textdomain( 'wp-slideshow', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
    }

    /**
     * What type of request is this?
     *
     * @param  string $type admin, ajax, cron or frontend.
     *
     * @return bool
     */
    private function is_request( $type ) {
        switch ( $type ) {
            case 'admin' :
                return is_admin();

            case 'ajax' :
                return defined( 'DOING_AJAX' );

	        case 'frontend':
		        return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' );
        }
    }

} // WP_Slideshow

/**
 * Initialize the plugin
 *
 * @return WP_Slideshow
 */
function wp_slideshow() {
	return WP_Slideshow::init();
}

// kick-off
wp_slideshow();
