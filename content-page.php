<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package mindseyesociety
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry__header">
		<?php the_title( '<h1 class="entry__title">', '</h1>' ); ?>
	</header><!-- .entry-header -->

	<div class="entry__content">
		<?php the_content(); ?>
	</div><!-- .entry-content -->

	<footer class="entry__footer">
		<?php edit_post_link( __( 'Edit', 'mindseyesociety' ), '<span class="edit__link">', '</span>' ); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
