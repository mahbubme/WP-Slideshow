<?php
/**
 * WP Slideshow Robo Runner Functions
 *
 * Declares helper functions to use with Robo.
 *
 * @package wp-slideshow
 * @since   1.0.0
 */

// Load the autoload file for composer (so we can access RoboCI).
require_once 'vendor/autoload.php';
use Elephfront\RoboJsMinify\Task\Loader\LoadJsMinifyTasksTrait;

/**
 * WP Slideshow Robo Runner Class
 *
 * This system, built on RoboRunner, allows WP Slideshow plugin to be build easily.
 *
 * @since  1.0.0
 * @access public
 */
class RoboFile extends \Robo\Tasks {

	use LoadJsMinifyTasksTrait;

	/**
	 * Release function
	 *
	 * @param string $version release version.
	 *
	 * @since 1.0.0
	 */
	public function release( $version ) {
		$this->yell( 'Releasing WP Slideshow version: ' . $version );

		$this->yell( 'Minifying JS and CSS' );
		$this->minifyJS();
		$this->minifyCSS();

		$this->yell( 'Making POT file' );
		$this->makePotFile();

		$this->yell( 'Done releasing WP Slideshow version: ' . $version );
	}

	/**
	 * Minify css
	 *
	 * @since 1.0.0
	 */
	public function minifyCSS() {
		// Delete existing minifications.
		foreach ( glob( './assets/css/*.min.css' ) as $filename ) {
			$this->taskExecStack()->stopOnFail()->exec( 'rm -rf ' . $filename )->run();
		}

		foreach ( glob( './assets/css/*.css' ) as $filename ) {
			$new_filename = str_replace( '.css', '.min.css', $filename );
			$this->taskMinify( $filename )->to( $new_filename )->run();
		}
	}

	/**
	 * Minify JS
	 *
	 * @since 1.0.0
	 */
	public function minifyJS() {
		// Delete existing minifications.
		foreach ( glob( './assets/js/*.min.js' ) as $filename ) {
			$this->taskExecStack()->stopOnFail()->exec( 'rm -rf ' . $filename )->run();
		}

		foreach ( glob( './assets/js/*.js' ) as $filename ) {
			$new_filename = str_replace( '.js', '.min.js', $filename );
			$this->taskJsMinify( array( $filename => $new_filename ) )->run();
		}
	}

	/**
	 * Generate pot file
	 *
	 * @since 1.0.0
	 */
	public function makePotFile() {
		$this->yell( 'Generating Pot file' );
		$this->taskExec( './vendor/bin/wp i18n make-pot . languages/wp-slideshow.pot --domain=wp-slideshow --skip-js' )->dir( './' )->run();
	}
}
