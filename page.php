<?php
/**
 * The template for displaying all pages.
 *
 * @package mindseyesociety
 */

get_header(); ?>

<main id="main" class="content__main" role="main">

	<?php
	while ( have_posts() ) {
		the_post();
		get_template_part( 'content', 'single' );
	}
	?>

</main><!-- #main -->

<?php
get_sidebar();
get_footer();
