<?php
/**
 * Product Categories Section
 *
 * Displays product categories with custom ordering from drag-and-drop control.
 * UPDATED: Modern geometric style variant.
 *
 * @package Macedon_Ranges
 */

// Get customizer settings
$title             = get_theme_mod( 'categories_title', 'Shop by Category' );
$subtitle          = get_theme_mod( 'categories_subtitle', 'Quality feed and supplies for all your pets and livestock needs' );
$selected_categories = get_theme_mod( 'selected_categories', '' );
$categories_count  = get_theme_mod( 'categories_count', 6 );

// Get product categories
if ( ! empty( $selected_categories ) ) {
	$category_ids = array_filter( array_map( 'intval', explode( ',', $selected_categories ) ) );

	if ( ! empty( $category_ids ) ) {
		$all_categories = get_terms( array(
			'taxonomy'   => 'product_cat',
			'include'    => $category_ids,
			'hide_empty' => false,
		) );

		$categories_by_id = array();
		foreach ( $all_categories as $cat ) {
			$categories_by_id[ $cat->term_id ] = $cat;
		}

		$categories = array();
		foreach ( $category_ids as $cat_id ) {
			if ( isset( $categories_by_id[ $cat_id ] ) ) {
				$categories[] = $categories_by_id[ $cat_id ];
			}
		}
	} else {
		$categories = array();
	}
} else {
	$categories = get_terms( array(
		'taxonomy'   => 'product_cat',
		'hide_empty' => true,
		'number'     => $categories_count,
		'orderby'    => 'count',
		'order'      => 'DESC',
	) );
}

if ( empty( $categories ) || is_wp_error( $categories ) ) {
	return;
}
?>

<section class="product-categories section" id="categories" aria-labelledby="categories-heading">
	<div class="container">

		<!-- Section Header -->
		<div class="section-header"
			data-animate="fade-up"
			data-animate-delay="100">
			<div class="section-header__eyebrow" aria-hidden="true">
				<span class="eyebrow-line"></span>
				<span class="eyebrow-text"><?php esc_html_e( 'Collections', 'macedon-ranges' ); ?></span>
				<span class="eyebrow-line"></span>
			</div>
			<h2 id="categories-heading" class="section-title">
				<?php echo esc_html( $title ); ?>
			</h2>
			<?php if ( ! empty( $subtitle ) ) : ?>
				<p class="section-subtitle">
					<?php echo esc_html( $subtitle ); ?>
				</p>
			<?php endif; ?>
		</div>

		<!-- Categories Grid -->
		<div class="categories-grid">
			<?php
			$delay = 150;
			foreach ( $categories as $index => $category ) :
				$thumbnail_id = get_term_meta( $category->term_id, 'thumbnail_id', true );
				$image        = $thumbnail_id ? wp_get_attachment_image_url( $thumbnail_id, 'full' ) : wc_placeholder_img_src();

				$description = $category->description
					? $category->description
					: sprintf( __( 'Browse our selection of %s', 'macedon-ranges' ), strtolower( $category->name ) );

				if ( strlen( $description ) > 90 ) {
					$description = substr( $description, 0, 90 ) . '…';
				}

				$product_count = $category->count;
				$count_text    = sprintf(
					_n( '%s product', '%s products', $product_count, 'macedon-ranges' ),
					number_format_i18n( $product_count )
				);

				// Alternate card accent position for geometric variety
				$accent_class = ( $index % 2 === 0 ) ? 'category-card--accent-left' : 'category-card--accent-right';
			?>
				<a href="<?php echo esc_url( get_term_link( $category ) ); ?>"
				   class="category-card <?php echo esc_attr( $accent_class ); ?>"
				   data-animate="fade-up"
				   data-animate-delay="<?php echo esc_attr( $delay ); ?>"
				   aria-label="<?php echo esc_attr( sprintf( __( 'Shop %s', 'macedon-ranges' ), $category->name ) ); ?>">

					<!-- Image layer -->
					<div class="category-card__media">
						<img
							src="<?php echo esc_url( $image ); ?>"
							alt=""
							class="category-card__image"
							loading="lazy"
						>
					</div>

					<!-- Geometric corner accent -->
					<span class="category-card__corner" aria-hidden="true"></span>

					<!-- Overlay + Content -->
					<div class="category-card__overlay">
						<div class="category-card__content">
							<span class="category-card__count"><?php echo esc_html( $count_text ); ?></span>
							<h3 class="category-card__name"><?php echo esc_html( $category->name ); ?></h3>
							<p class="category-card__description"><?php echo esc_html( $description ); ?></p>
							<span class="category-card__button" aria-hidden="true">
								<?php esc_html_e( 'Shop Now', 'macedon-ranges' ); ?>
								<svg class="category-card__arrow" viewBox="0 0 16 16" fill="none" aria-hidden="true">
									<path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>
							</span>
						</div>
					</div>

				</a>
			<?php
				$delay += 80;
			endforeach;
			?>
		</div>

	</div>
</section>