<?php

/**
 * Integration for Google Universal Analytics.
 */

/**
 * Loads the script on the front end.
 * @return void
 */
function mindsyesociety_ga_script() {
	if ( is_admin() ) {
		return;
	}

	$ga_id = get_site_option( 'mes-ga-id' );
	if ( ! $ga_id ) {
		return;
	}

	echo "<script>
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

	ga('create', " . wp_json_encode( $ga_id ) . ", 'auto');
	ga('send', 'pageview');
	</script>";
}
add_action( 'wp_footer', 'mindsyesociety_ga_script' );


/**
 * Inserts multisite option for GA code.
 * @return void
 */
function mindsyesociety_ga_admin() {

	echo '<table class="form-table"><tbody><tr>';
	printf(
		'<th><label for="%s">%s</label></th>',
		'mes-ga-id',
		esc_html__( 'Universal Analytics ID', 'mindseyesociety' )
	);
	$ga_id = get_site_option( 'mes-ga-id', '' );
	printf(
		'<td><input type="text" id="%1$s" name="%1$s" value="%2$s"></td>',
		'mes-ga-id',
		esc_attr( $ga_id )
	);
	echo '</tr></table>';
}
add_action( 'wpmu_options', 'mindsyesociety_ga_admin' );


/**
 * Saves multisite option for GA.
 * @return void
 */
function mindsyesociety_ga_save() {
	if ( ! is_super_admin() ) {
		return;
	}

	$option = filter_input( INPUT_POST, 'mes-ga-id' );

	if ( null === $option || false === $option ) {
		return;
	}

	update_site_option( 'mes-event-site', sanitize_text_field( $option ) );
}
add_action( 'update_wpmu_options', 'mindsyesociety_ga_save' );
