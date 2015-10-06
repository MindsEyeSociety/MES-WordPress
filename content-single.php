<?php
/**
 * Single content page.
 * @package mindseyesociety
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry__header">
		<?php the_title( '<h1 class="entry__title">', '</h1>' ); ?>

		<div class="entry__meta">
			<?php mindseyesociety_posted_on(); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry__content">
		<?php the_content(); ?>
	</div><!-- .entry-content -->

	<footer class="entry__footer">
		<?php mindseyesociety_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
