<?php
/**
 * Mind's Eye Society Carousel
 *
 * @package mindseyesociety
 */

namespace MindsEyeSociety;

class Carousel {

	protected static $instance;

	const OPTION = 'carousel_settings';

	/**
	 * Constructor.
	 * @return void
	 */
	public function __construct() {

		// Exit if the carousel isn't enabled.
		if ( ! get_theme_mod( 'show_carousel', false ) ) {
			return;
		}

		// Exit if Fieldmanager isn't installed.
		if ( ! defined( 'FM_VERSION' ) ) {
			return;
		}

		add_action( 'page_before_loop', array( $this, 'display' ) );

		fm_register_submenu_page( self::OPTION, 'themes.php', 'Carousel' );
		add_action( 'fm_submenu_' . self::OPTION, array( $this, 'settings' ) );

	}


	/**
	 * Displays the carousel.
	 * @return void
	 */
	public function display() {

		// On front page only, please.
		if ( ! is_front_page() ) {
			return;
		}

		$items = get_option( self::OPTION );

		// Bail if there's no items.
		if ( ! $items ) {
			return;
		}

		// Map the target type.
		$items = array_map( function( $item ) {
			$item['target'] = isset( $item['external'] ) ? '_blank' : '_current';
			return $item;
		}, $items );

		// Gets the carousel template.
		require get_template_directory() . '/templates/carousel.php';

	}


	/**
	 * Sets up admin page.
	 * @return void
	 */
	public function settings() {
		$fm = new \Fieldmanager_Group( array(
			'name'           => self::OPTION,
			'limit'          => 10,
			'add_more_label' => __( 'Add another item', 'mindseyesociety' ),
			'sortable'       => true,
			'label'          => __( 'Carousel Item', 'mindseyesociety' ),
			'children'       => array(
				'image'    => new \Fieldmanager_Media( array(
					'label'        => __( 'Image', 'mindseyesociety' ),
					'preview_size' => 'thumbnail',
				) ),
				'link'     => new \Fieldmanager_Link( array(
					'label'        => __( 'URL', 'mindseyesociety' ),
				 	'inline_label' => true,
				) ),
				'external' => new \Fieldmanager_Checkbox( array(
					'label'        => __( 'Open in new window', 'mindseyesociety' ),
					'inline_label' => true,
				) ),
			),
		) );
		$fm->activate_submenu_page();
	}


	/**
	 * Singleton method.
	 * @return Carousel Self.
	 */
	public static function instance() {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

}

Carousel::instance();
