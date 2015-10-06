<?php
/**
 * Main content type.
 * @package mindseyesociety
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry__header">
		<?php the_title( sprintf( '<h1 class="entry__title"><a href="%s" rel="bookmark" class="entry__link">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>

		<?php if ( 'post' === get_post_type() ) : ?>
		<div class="entry__meta">
			<?php mindseyesociety_posted_on(); ?>
		</div><!-- .entry__meta -->
		<?php endif; ?>
	</header><!-- .entry__header -->

	<div class="entry__content">
		<?php the_content(); ?>
	</div><!-- .entry__content -->

	<footer class="entry__footer">
		<?php mindseyesociety_entry_footer(); ?>
	</footer><!-- .entry__footer -->
</article><!-- #post-## -->
