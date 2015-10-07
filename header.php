<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package mindseyesociety
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<header id="masthead" class="header" role="banner">
	<div class="header__branding">
		<?php if ( get_header_image() ) : ?>

			<h1 class="header__title">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="header__link">
					<img src="<?php header_image(); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="<?php bloginfo( 'name' ); ?>" class="header__logo">
				</a>
			</h1>

		<?php else : ?>

			<h1 class="header__title">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="header__link"><?php bloginfo( 'name' ); ?></a>
			</h1>
			<h2 class="header__description"><?php bloginfo( 'description' ); ?></h2>

		<?php endif; // End header image check. ?>
	</div>

	<nav id="site-navigation" class="nav" role="navigation">
		<button class="nav__toggle"><?php esc_html_e( 'Primary Menu', 'mindseyesociety' ); ?></button>
		<?php mindseyesociety_navigation(); ?>
	</nav><!-- #site-navigation -->
</header><!-- #masthead -->

<div id="content" class="content">
