<?php
/**
 * Single content page.
 * @package mindseyesociety
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry__header">
		<h1 class="entry__title">
			<?php the_title(); ?>
		</h1>

		<?php if ( 'post' === get_post_type() ) : ?>
			<div class="entry__meta">
				<?php mindseyesociety_posted_on(); ?>
			</div><!-- .entry__meta -->
		<?php endif; ?>

	</header><!-- .entry__header -->

	<div class="entry__content">
		<?php the_content(); ?>
	</div><!-- .entry__content -->

</article><!-- #post-## -->
