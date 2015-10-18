<div class="carousel">
	<div class="carousel__wrapper">
		<?php foreach ( $items as $index => $item ) : ?>

			<a
				class="carousel__item carousel__item--num-<?php echo absint( $index ); ?>"
				href="<?php echo esc_url( $item['link'] ); ?>"
				target="<?php echo esc_attr( $item['target'] ); ?>"
			>
				<?php echo wp_get_attachment_image( $item['image'], 'full', false, array( 'class' => 'carousel__image' ) ); ?>
			</a>

		<?php endforeach; ?>
	</div>
</div>
