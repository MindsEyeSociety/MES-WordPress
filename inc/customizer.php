<?php
/**
 * Mind's Eye Society Theme Customizer
 *
 * @package mindseyesociety
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 *
 * @return void
 */
function mindseyesociety_customize_register( WP_Customize_Manager $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';

	// We don't need no stinkin' colors.
	$wp_customize->remove_section( 'colors' );
}
add_action( 'customize_register', 'mindseyesociety_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 *
 * @return void
 */
function mindseyesociety_customize_preview_js() {
	wp_enqueue_script( 'mindseyesociety_customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'mindseyesociety_customize_preview_js' );
