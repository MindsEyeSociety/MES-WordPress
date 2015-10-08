<?php
/**
 * The main template file.
 *
 * @package mindseyesociety
 */

get_header(); ?>

<main id="main" class="content__main content__main--loop" role="main">

	<?php if ( have_posts() ) : ?>

		<?php
		// Start the Loop.
		while ( have_posts() ) {
			the_post();
			get_template_part( 'templates/content' );
		}

		mindseyesociety_paging_nav();
		?>

	<?php else : ?>

		<?php get_template_part( 'templates/content', 'none' ); ?>

	<?php endif; ?>

</main><!-- #main -->

<?php
get_sidebar();
get_footer();
