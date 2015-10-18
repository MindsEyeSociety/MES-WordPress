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

		add_action( 'page_before_loop',   array( $this, 'display' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ) );

		// Sets admin up.
		fm_register_submenu_page( self::OPTION, 'themes.php', 'Carousel' );
		add_action( 'fm_submenu_' . self::OPTION, array( $this, 'settings' ) );

	}


	/**
	 * Displays the carousel.
	 * @return void
	 */
	public function display() {

		if ( ! $this->is_active() ) {
			return;
		}

		$items = get_option( self::OPTION );

		// Map the target type.
		$items = array_map( function( $item ) {
			$item['target'] = isset( $item['external'] ) ? '_blank' : '_current';
			return $item;
		}, $items );

		// Gets the carousel template.
		require get_template_directory() . '/templates/carousel.php';

	}


	/**
	 * Loads the styles and scripts.
	 * @return void
	 */
	public function scripts() {

		if ( ! $this->is_active() ) {
			return;
		}

		$root = get_template_directory_uri() . '/assets/';
		if ( class_exists( '\Roots_Rewrites' ) ) {
			$root = '/assets/';
		}

		wp_enqueue_style( 'mindseyesociety-carousel', $root . 'css/carousel.css', array( 'mindseyesociety-style' ) );

		wp_enqueue_script( 'mindseyesociety-carousel', $root . 'js/carousel.js', array(), '20151018', true );

	}


	/**
	 * Returns true if the carousel should be displayed.
	 * @return boolean
	 */
	protected function is_active() {

		$items = get_option( self::OPTION );

		if ( $items && is_front_page() ) {
			return true;
		}

		return false;

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
