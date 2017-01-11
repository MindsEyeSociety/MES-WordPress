<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package mindseyesociety
 */


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
 * Filters classes for menu items.
 * @param  array $classes The classes array.
 * @return array
 */
function mindseyesociety_menu_classes( array $classes ) {
	return array_map( function( $class ) {

		if ( 'menu-item' === $class ) {
			$class = 'nav__item';
		} elseif ( 'menu-item-has-children' === $class ) {
			$class = 'nav__item--children';
		} else {
			$class = str_replace( 'menu-item-type-', 'nav__item--', $class ); // Type.
			$class = preg_replace( '/^menu-item-(\d+)$/', 'nav__item--$1', $class );
		}

		return $class;

	}, $classes );
}
add_filter( 'nav_menu_css_class', 'mindseyesociety_menu_classes' );


/**
 * Filters menu HTML to alter submenu class.
 * @param  string $nav_menu HTML menu.
 * @return string
 */
function mindseyesociety_menu_html( $nav_menu ) {
	$nav_menu = str_replace( 'class="sub-menu"', 'class="nav__submenu"', $nav_menu );
	return $nav_menu;
}
add_filter( 'wp_nav_menu', 'mindseyesociety_menu_html' );


/**
 * Adds class to menu links.
 * @param  array  $attributes Attributes.
 * @param  object $item       Post object.
 * @return array
 */
function mindseyesociety_menu_link_classes( array $attributes, $item ) {
	$attributes['class'] = 'nav__link';

	if ( isset( $item->classes ) && in_array( 'menu-item-has-children', $item->classes ) ) {
		unset( $attributes['href'] );
	}

	return $attributes;
}
add_filter( 'nav_menu_link_attributes', 'mindseyesociety_menu_link_classes', 10, 2 );


/**
 * Alters post classes.
 * @param  array $classes Classes.
 * @return array
 */
function mindseyesociety_post_classes( array $classes ) {
	$classes[] = 'entry';
	unset( $classes['hentry'] );
	return $classes;
}
add_filter( 'post_class', 'mindseyesociety_post_classes' );


/**
 * Adds class to pagination links.
 * @param  string $attr Attributes.
 * @return string
 */
function mindseyesociety_posts_link_class( $attr ) {
	return $attr . ' class="pagination__link"';
}
add_filter( 'previous_posts_link_attributes', 'mindseyesociety_posts_link_class' );
add_filter( 'next_posts_link_attributes', 'mindseyesociety_posts_link_class' );


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


/**
 * Makes search run across entire network.
 * @param  WP_Query $query The query object.
 * @return void
 */
function mindseyesociety_search_multisite( $query ) {
	if ( ! is_admin() && $query->is_main_query() && $query->is_search ) {
		$sites = get_site_option( 'mes-search-sites' );
		if ( ! $sites ) {
			return;
		}

		$sites = explode( ',', $sites );

		if ( ! in_array( (string) get_current_blog_id(), $sites, true ) ) {
			return;
		}
		$query->set( 'multisite', 1 );
		$query->set( 'sites__in', $sites );
	}
}
add_action( 'pre_get_posts', 'mindseyesociety_search_multisite' );


/**
 * Adds a search field to the network admin.
 * @return void
 */
function mindseyesociety_search_site_select() {
	$sites = get_site_option( 'mes-search-sites' );
	echo '<table id="menu" class="form-table"><tr><th scope="row">';
	esc_html_e( 'Enter searchable sites', 'mindseyesociety' );
	echo '</th><td><input name="mes-search-sites" type="text" id="mes-search-sites" class="large-text" value="' . $sites . '" size="45"></td></tr></table>';
}
add_action( 'wpmu_options', 'mindseyesociety_search_site_select' );


/**
 * Saves multisite option for searching multiple sites.
 * @return void
 */
function mindsyesociety_search_site_save() {
	if ( ! is_super_admin() ) {
		return;
	}

	$option = filter_input( INPUT_POST, 'mes-search-sites', FILTER_SANITIZE_STRING );

	if ( null === $option || false === $option ) {
		return;
	}

	$option = array_map( 'trim', explode( ',', $option ) );

	update_site_option( 'mes-search-sites', $option );
}
add_action( 'update_wpmu_options', 'mindsyesociety_search_site_save' );


/**
 * Fixes sender from WordPress.
 * @param  mixed $params Sent object.
 * @return void
 */
function mindseyesociety_fix_mail( $params ) {
	if ( true !== filter_var( $params->Sender, FILTER_VALIDATE_EMAIL ) ) {
		$params->Sender = $params->From;
	}
}
add_action( 'phpmailer_init', 'mindseyesociety_fix_mail' );


/**
 * Filters the sender of mail to be the same.
 * @return string
 */
add_filter( 'wp_mail_from', function() {
	return 'wordpress@mindseyesociety.org';
} );


/**
 * Allows admins to use the autocomplete system for adding users.
 * @see user-new.php
 */
add_filter( 'autocomplete_users_for_site_admins', '__return_true' );
