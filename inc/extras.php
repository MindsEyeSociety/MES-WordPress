<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package mindseyesociety
 */


/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 *
 * @return array
 */
function mindseyesociety_body_classes( array $classes ) {
	return $classes;
}
add_filter( 'body_class', 'mindseyesociety_body_classes' );


/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 *
 * @param string $title Default title text for current view.
 * @param string $sep   Optional separator.
 *
 * @return string The filtered title.
 */
function mindseyesociety_wp_title( $title, $sep ) {
	if ( is_feed() ) {
		return $title;
	}

	global $page, $paged;

	// Add the blog name.
	$title .= get_bloginfo( 'name', 'display' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title .= " $sep $site_description";
	}

	// Add a page number if necessary.
	if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
		$title .= " $sep " . sprintf( __( 'Page %s', 'mindseyesociety' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'mindseyesociety_wp_title', 10, 2 );


/**
 * Removes W3TC dashboard for non-super admins.
 * @return void
 */
function mindseyesociety_remove_w3tc() {
	if ( ! current_user_can( 'manage_network' ) ) {
		remove_menu_page( 'w3tc_dashboard' );
	}
}
add_action( 'admin_menu', 'mindseyesociety_remove_w3tc', 11 );
