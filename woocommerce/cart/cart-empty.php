<?php
/**
 * Empty cart page
 *
 * @package Macedon_Ranges
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'body_class', function( $classes ) {
	$classes[] = 'cart-is-empty';
	return $classes;
} );
?>

<div class="woocommerce-cart-form">
	<?php if ( wc_get_page_permalink( 'shop' ) ) : ?>

		<div class="cart-empty-wrapper">
			<div class="cart-empty-content">

				<div class="cart-empty-icon">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" fill="none" stroke="currentColor">
						<path d="M8 8h6l8 32h28l6-20H16" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
						<circle cx="26" cy="52" r="4" stroke-width="2"/>
						<circle cx="46" cy="52" r="4" stroke-width="2"/>
						<line x1="24" y1="24" x2="50" y2="24" stroke-width="1.5" stroke-linecap="round" opacity="0.4"/>
						<line x1="24" y1="30" x2="50" y2="30" stroke-width="1.5" stroke-linecap="round" opacity="0.4"/>
						<line x1="24" y1="36" x2="48" y2="36" stroke-width="1.5" stroke-linecap="round" opacity="0.4"/>
						<rect x="28" y="14" width="8" height="8" rx="1" stroke-width="1.5" opacity="0.3"/>
						<rect x="38" y="14" width="8" height="8" rx="1" stroke-width="1.5" opacity="0.3"/>
						<rect x="28" y="6" width="8" height="6" rx="1" stroke-width="1.5" opacity="0.2"/>
					</svg>
				</div>

				<h2 class="cart-empty-title"><?php esc_html_e( 'Your cart is empty', 'macedon-ranges' ); ?></h2>

				<p class="cart-empty-subtitle"><?php esc_html_e( "Looks like you haven't added anything to your cart yet. Start shopping to fill it up!", 'macedon-ranges' ); ?></p>

				<div class="cart-empty-actions">
					<a href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>" class="cart-empty-button">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
							<path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
							<polyline points="9 22 9 12 15 12 15 22"></polyline>
						</svg>
						<?php echo esc_html( apply_filters( 'woocommerce_return_to_shop_text', __( 'Return to Shop', 'macedon-ranges' ) ) ); ?>
					</a>
				</div>

			</div>
		</div>

	<?php endif; ?>
</div>

<?php
if ( function_exists( 'Bo_empty_cart_recommended_products' ) ) {
	Bo_empty_cart_recommended_products();
} else {
	$args = array(
		'post_type'      => 'product',
		'posts_per_page' => 4,
		'post_status'    => 'publish',
		'orderby'        => 'date',
		'order'          => 'DESC',
	);

	$products = new WP_Query( $args );

	if ( $products->have_posts() ) : ?>
		<div class="cart-empty-recommended">
			<div class="container">
				<div class="cart-empty-recommended__header">
					<span class="cart-empty-recommended__badge"><?php esc_html_e( 'START SHOPPING', 'macedon-ranges' ); ?></span>
					<h2 class="cart-empty-recommended__title"><?php esc_html_e( 'Popular Products', 'macedon-ranges' ); ?></h2>
					<p class="cart-empty-recommended__subtitle"><?php esc_html_e( 'Check out our most popular items to get started', 'macedon-ranges' ); ?></p>
				</div>

				<ul class="products columns-4">
					<?php
					while ( $products->have_posts() ) {
						$products->the_post();
						wc_get_template_part( 'content', 'product' );
					}
					?>
				</ul>
			</div>
		</div>
	<?php
	endif;
	wp_reset_postdata();
}
?>