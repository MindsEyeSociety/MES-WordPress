<?php
/**
 * The template for displaying all pages.
 *
 * @package mindseyesociety
 */

get_header(); ?>

<main id="main" class="content__main" role="main">

	<?php do_action( 'page_before_loop' ); ?>

	<?php
	while ( have_posts() ) {
		the_post();
		get_template_part( 'templates/content', 'single' );
	}
	?>

</main><!-- #main -->

<?php
get_sidebar();
get_footer();
