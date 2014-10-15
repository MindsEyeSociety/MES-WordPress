<?php
/**
 * Sample implementation of the Custom Header feature
 * http://codex.wordpress.org/Custom_Headers
 *
 * @package mindseyesociety
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses mindseyesociety_header_style()
 * @uses mindseyesociety_admin_header_style()
 * @uses mindseyesociety_admin_header_image()
 *
 * @return void
 */
function mindseyesociety_custom_header_setup() {
	$args = array(
		'width'       => 1200,
		'height'      => 100,
		'flex-height' => true,
		'flex-width'  => true,
);
	add_theme_support( 'custom-header', $args );
}
add_action( 'after_setup_theme', 'mindseyesociety_custom_header_setup' );