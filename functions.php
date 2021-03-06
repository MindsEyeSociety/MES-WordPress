<?php
/**
 * Mind's Eye Society functions and definitions
 *
 * @package mindseyesociety
 */

namespace MindsEyeSociety;

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 660; // Pixels.
}

/**
 * Main theme class.
 */
class Main {

	/**
	 * Constructor.
	 */
	public function __construct() {
		// Set up permissions after theme activation and deactivation.
		add_action( 'after_switch_theme', array( $this, 'activate' ) );
		add_action( 'switch_theme',       array( $this, 'deactivate' ) );

		// Set up everything.
		add_action( 'after_setup_theme',  array( $this, 'setup' ) );

		// Loads the libraries.
		add_action( 'init',               array( $this, 'init' ) );

		// Initializes the widgets.
		add_action( 'widgets_init',       array( $this, 'widgets_init' ) );

		// Enqueues the scripts.
		add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ) );

		// Wraps scripts in IE conditionals.
		add_filter( 'script_loader_tag',  array( $this, 'script_tag' ), 10, 2 );

		// Customizes excerpt.
		add_filter( 'excerpt_more',       array( $this, 'excerpt_more' ) );
	}


	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 *
	 * @return void
	 */
	public function setup() {
		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		// Removes featured image support, as we don't use it.
		remove_theme_support( 'post-thumbnails' );

		// Adds custom headers.
		$args = array(
			'width'       => 1200,
			'height'      => 100,
			'flex-height' => true,
			'flex-width'  => false,
		);
		add_theme_support( 'custom-header', $args );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary' => __( 'Primary Menu', 'mindseyesociety' ),
		) );

		// Switch default core markup for search form, comment form, and comments to output valid HTML5.
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Enables title tag.
		add_theme_support( 'title-tag' );
		add_filter( 'document_title_separator', function() {
			return '|';
		} );

	}


	/**
	 * Loads libraries and other init functions.
	 * @return void
	 */
	public function init() {

		$lib_root = get_template_directory() . '/lib/';

		if ( file_exists( $lib_root . '/multisite-query/index.php' ) ) {
			require_once $lib_root . '/multisite-query/index.php';
		}

	}


	/**
	 * Register widget area.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
	 *
	 * @return void
	 */
	public function widgets_init() {
		register_sidebar( array(
			'name'          => __( 'Sidebar', 'mindseyesociety' ),
			'id'            => 'sidebar-1',
			'description'   => 'Main right sidebar.',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h1 class="widget__title">',
			'after_title'   => '</h1>',
		) );
	}


	/**
	 * Enqueue scripts and styles.
	 * @return void
	 */
	public function scripts() {
		// Loads the Google Fonts we want.
		wp_enqueue_style( 'mindseyesociety-fonts', '//fonts.googleapis.com/css?family=PT+Serif:700|Merriweather:400,400italic,700italic,700|IM+Fell+English' );

		// Sets root path.
		$root = get_template_directory_uri() . '/assets/';
		if ( class_exists( '\Roots_Rewrites' ) ) {
			$root = '/assets/';
		}

		// Main stylesheet.
		wp_enqueue_style( 'mindseyesociety-style', $root . 'css/theme.css', array( 'mindseyesociety-fonts' ) );

		// IE Compatibility.
		wp_enqueue_script( 'shim-event-listeners', 'https://cdnjs.cloudflare.com/ajax/libs/ie8/0.2.9/ie8.js', array(), '' );
		wp_enqueue_script( 'shim-html5', 'https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js', array(), '' );
		wp_enqueue_script( 'shim-class-list', 'https://cdnjs.cloudflare.com/ajax/libs/classlist/2014.01.31/classList.min.js', array(), '' );

		wp_enqueue_script( 'mindseyesociety-navigation', $root . 'js/navigation.js', array(), '20120206', true );

		wp_enqueue_script( 'mindseyesociety-skip-link-focus-fix', $root . 'js/skip-link-focus-fix.js', array(), '20130115', true );

		// Loads comment script.
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}


	/**
	 * Wraps script tags with IE conditionals.
	 * @param  string $tag    The script HTML.
	 * @param  string $handle Script handle.
	 * @return string
	 */
	public function script_tag( $tag, $handle ) {

		if ( 0 === strpos( $handle, 'shim' ) ) {
			$tag = sprintf( '<!--[if IE]>%s<![endif]-->', $tag );
		}

		return $tag;

	}


	/**
	 * Sets the excerpt.
	 * @return string
	 */
	public function excerpt_more() {
		return '&hellip; <a class="entry-more" href="' . esc_url( get_the_permalink() ) . '">Read more</a>';
	}


	/**
	 * Sets permissions after theme activation.
	 * @return void
	 */
	public function activate() {

		$role = get_role( 'administrator' );
		$role->remove_cap( 'activate_plugins' );
		$role->remove_cap( 'switch_themes' );
		$role->add_cap( 'manage_network_users' );

	}


	/**
	 * Sets permissions after theme deactivation.
	 * @return void
	 */
	public function deactivate() {

		$role = get_role( 'administrator' );
		$role->add_cap( 'activate_plugins' );
		$role->add_cap( 'switch_themes' );
		$role->remove_cap( 'manage_network_users' );

	}
}

// Custom template tags for this theme.
require get_template_directory() . '/inc/template-tags.php';

// Custom functions that act independently of the theme templates.
require get_template_directory() . '/inc/extras.php';

// Customizer additions.
require get_template_directory() . '/inc/customizer.php';

// Optional carousel module.
require get_template_directory() . '/inc/carousel.php';

// Multi-site events widget.
require get_template_directory() . '/inc/events.php';

// Multi-site analytics logic.
require get_template_directory() . '/inc/analytics.php';

// Start the magic!
new Main();
