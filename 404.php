<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package mindseyesociety
 */

get_header(); ?>

<main id="main" class="content__site" role="main">

	<section class="error-404 not-found">
		<header class="page__header">
			<h1 class="page__title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'mindseyesociety' ); ?></h1>
		</header><!-- .page__header -->

		<div class="page__content">
			<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'mindseyesociety' ); ?></p>

			<?php get_search_form(); ?>

			<?php the_widget( 'WP_Widget_Recent_Posts' ); ?>

			<?php
				/* translators: %1$s: smiley */
				$archive_content = '<p>' . sprintf( __( 'Try looking in the monthly archives. %1$s', 'mindseyesociety' ), convert_smilies( ':)' ) ) . '</p>';
				the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$archive_content" );
			?>

			<?php the_widget( 'WP_Widget_Tag_Cloud' ); ?>

		</div><!-- .page__content -->
	</section><!-- .error-404 -->

</main><!-- #main -->

<?php
get_footer();
