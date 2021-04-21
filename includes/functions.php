<?php

/**
 * Access capability for this plugin
 *
 * @since 1.0.0
 */
function wp_slideshow_access_capability() {
    return apply_filters( 'wp_slideshow_access_capability', 'manage_options' );
}
