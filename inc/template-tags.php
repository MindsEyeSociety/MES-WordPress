<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
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
		esc_html( $time_string )
	);

}


/**
 * Prints HTML with meta information for the categories, tags and comments.
 *
 * @return void
 */
function mindseyesociety_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		// Translators: used between list items, there is a space after the comma.
		$categories_list = get_the_category_list( __( ', ', 'mindseyesociety' ) );
		if ( $categories_list ) {
			printf(
				'<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'mindseyesociety' ) . '</span>',
				$categories_list // @codingStandardsIgnoreLine
			);
		}

		// Translators: used between list items, there is a space after the comma.
		$tags_list = get_the_tag_list( '', __( ', ', 'mindseyesociety' ) );
		if ( $tags_list ) {
			printf(
				'<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'mindseyesociety' ) . '</span>',
				$tags_list // @codingStandardsIgnoreLine
			);
		}
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( __( 'Leave a comment', 'mindseyesociety' ), __( '1 Comment', 'mindseyesociety' ), __( '% Comments', 'mindseyesociety' ) );
		echo '</span>';
	}

	edit_post_link( __( 'Edit', 'mindseyesociety' ), '<span class="edit-link">', '</span>' );
}
