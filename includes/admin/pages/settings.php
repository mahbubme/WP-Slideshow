<div class="error hide-if-js">
	<p><?php _e( 'WP Slideshow plugin requires JavaScript. Please enable JavaScript from your browser settings.', 'wp-slideshow' ); ?></p>
</div>
<div class="wrap">
	<h1><?php echo __( 'Slider Settings', 'wp-slideshow' ); ?></h1>
	<?php do_settings_sections( WP_SLIDESHOW_SLUG ); ?>
    <!--Don't change the id here, if you do so then make sure to change the id in admin.js file -->
	<p class="submit"><input type="submit" name="submit" id="wp-slideshow-submit" class="button button-primary" value="Save Changes"></p>
</div>
