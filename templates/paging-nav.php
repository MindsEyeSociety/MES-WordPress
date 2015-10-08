<nav class="pagination" role="navigation">

    <?php if ( get_next_posts_link() ) : ?>
        <div class="pagination__prev pagination__wrap">
            <?php next_posts_link( __( 'Older posts', 'mindseyesociety' ) ); ?>
        </div>
    <?php endif; ?>

    <?php if ( get_previous_posts_link() ) : ?>
        <div class="pagination__next pagination__wrap">
            <?php previous_posts_link( __( 'Newer posts', 'mindseyesociety' ) ); ?>
        </div>
    <?php endif; ?>

</nav><!-- .pagination -->
