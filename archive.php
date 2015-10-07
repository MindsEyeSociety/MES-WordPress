<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package mindseyesociety
 */

get_header(); ?>

<main id="main" class="content__main" role="main">

	<?php if ( have_posts() ) : ?>

		<header class="page__header">
			<h1 class="page__title">
				<?php
				if ( is_category() ) :
					single_cat_title();

				elseif ( is_tag() ) :
					single_tag_title();

				elseif ( is_author() ) :
					printf(
						'%s <span class="vcard">%s</span>',
						esc_html__( 'Author:', 'mindseyesociety' ),
						esc_html( get_the_author() )
					);

				elseif ( is_day() ) :
					printf(
						esc_html__( 'Day: %s', 'mindseyesociety' ),
						get_the_date()
					);

				elseif ( is_month() ) :
					printf(
						esc_html__( 'Month: %s', 'mindseyesociety' ),
						get_the_date( _x( 'F Y', 'monthly archives date format', 'mindseyesociety' ) )
					);

				elseif ( is_year() ) :
					printf(
						esc_html__( 'Year: %s', 'mindseyesociety' ),
						get_the_date( _x( 'Y', 'yearly archives date format', 'mindseyesociety' ) )
					);

				elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :
					esc_html_e( 'Asides', 'mindseyesociety' );

				elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) :
					esc_html_e( 'Galleries', 'mindseyesociety' );

				elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
					esc_html_e( 'Images', 'mindseyesociety' );

				elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
					esc_html_e( 'Videos', 'mindseyesociety' );

				elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
					esc_html_e( 'Quotes', 'mindseyesociety' );

				elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
					esc_html_e( 'Links', 'mindseyesociety' );

				elseif ( is_tax( 'post_format', 'post-format-status' ) ) :
					esc_html_e( 'Statuses', 'mindseyesociety' );

				elseif ( is_tax( 'post_format', 'post-format-audio' ) ) :
					esc_html_e( 'Audios', 'mindseyesociety' );

				elseif ( is_tax( 'post_format', 'post-format-chat' ) ) :
					esc_html_e( 'Chats', 'mindseyesociety' );

				else :
					esc_html_e( 'Archives', 'mindseyesociety' );

				endif;
				?>
			</h1>

		</header><!-- .page__header -->

		<?php
		// Start the Loop.
		while ( have_posts() ) {
			the_post();
			get_template_part( 'content' );
		}
		?>

		<?php mindseyesociety_paging_nav(); ?>

	<?php else : ?>

		<?php get_template_part( 'content', 'none' ); ?>

	<?php endif; ?>

</main><!-- #main -->

<?php
get_sidebar();
get_footer();
