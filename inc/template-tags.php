<?php
/**
 * Custom template tags for this theme.
 *
 * @package mindseyesociety
 */

/**
 * Generates the main navigation menu.
 * @return void
 */
function mindseyesociety_navigation() {
	wp_nav_menu( array(
		'theme_location' => 'primary',
		'container'      => false,
		'depth'          => 3,
		'menu_class'     => 'nav__menu',
	) );
}


/**
 * Displays pagination navigation.
 * @return void
 */
function mindseyesociety_paging_nav() {

	// Exit if we only have one page.
	global $wp_query;
	if ( $wp_query->max_num_pages < 2 ) {
		return;
	}

	get_template_part( 'templates/paging-nav' );

}


/**
 * Prints HTML with meta information for the current post-date/time and author.
 *
 * @return void
 */
function mindseyesociety_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		_x( 'Posted on %s', 'post date', 'mindseyesociety' ),
		$time_string
	);

	$byline = sprintf(
		_x( 'by %s', 'post author', 'mindseyesociety' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	printf(
		'<span class="posted-on"><a href="%s" rel="bookmark">%s</a></span>',
		esc_url( get_permalink() ),
		$time_string // @codingStandardsIgnoreLine
	);

}
