<?php

/**
 * Integration for Event Manager.
 */

add_filter( 'em_widget_events_get_args', function( $instance ) {
	$instance['blog'] = get_site_option( 'mes-event-site', 1 );
	return $instance;
} );


/**
 * Hides the Event Manager admin if not the main site.
 * @return void
 */
function mindsyesociety_event_admin() {
	if ( ! is_admin() ) {
		return;
	}

	$main_site = get_site_option( 'mes-event-site', 1 );
	if ( get_current_blog_id() === absint( $main_site ) ) {
		return;
	}

	remove_action( 'admin_menu',    'em_admin_menu' );
	remove_action( 'admin_head',    'em_admin_dashicon' );
	remove_action( 'admin_notices', 'em_admin_warnings', 100 );
	add_action( 'admin_menu', function() {
		remove_menu_page( 'edit.php?post_type=' . EM_POST_TYPE_EVENT );
	} );
}
add_action( 'init', 'mindsyesociety_event_admin' );


/**
 * Inserts multisite option for Event Manager main site.
 * @return void
 */
function mindsyesociety_wpmu_event_site() {
	if ( ! defined( 'EM_VERSION' ) ) {
		return;
	}

	$sites = wp_get_sites( array(
		'public'   => 1,
		'archived' => 0,
	) );

	if ( empty( $sites ) ) {
		return;
	}

	$site_opts    = wp_list_pluck( $sites, 'domain', 'blog_id' );
	$site_current = get_site_option( 'mes-event-site', 1 );

	echo '<table id="menu" class="form-table"><tr><th scope="row">';
	esc_html_e( 'Select event site', 'mindseyesociety' );
	echo '</th><td><select name="mes-event-site" id="mes-event-site">';

	foreach ( $site_opts as $id => $domain ) {
		printf(
			'<option value="%s" %s>%s</option>',
			absint( $id ),
			selected( $id, $site_current, false ),
			esc_html( $domain )
		);
	}

	echo '</select></td></tr></table>';
}
add_action( 'wpmu_options', 'mindsyesociety_wpmu_event_site' );


/**
 * Saves multisite option for Event Manager.
 * @return void
 */
function mindsyesociety_wpmu_event_site_save() {
	if ( ! defined( 'EM_VERSION' ) || ! is_super_admin() ) {
		return;
	}

	$option = filter_input( INPUT_POST, 'mes-event-site', FILTER_SANITIZE_NUMBER_INT );

	if ( null === $option || false === $option ) {
		return;
	}

	update_site_option( 'mes-event-site', absint( $option ) );
}
add_action( 'update_wpmu_options', 'mindsyesociety_wpmu_event_site_save' );
