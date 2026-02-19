<?php
/**
 * The Template for displaying product archives
 * WITH ENHANCED HEADER & CATEGORY FILTER
 *
 * @package Bo_Prime
 * @version 3.0.1
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

/**
 * Hook: woocommerce_before_main_content.
 */
do_action( 'woocommerce_before_main_content' );

// Sidebar
$show_sidebar    = get_theme_mod( 'show_shop_sidebar', false ) && is_active_sidebar( 'shop-sidebar' );
$container_class = $show_sidebar ? 'has-sidebar' : 'no-sidebar';

// Category filter
$show_category_filter = get_theme_mod( 'enable_category_filter', true );

// Shop header customizer settings
$header_bg_image = Bo_get_shop_header_bg_image();
$header_title    = get_theme_mod( 'shop_header_title', 'Shop' );
$header_subtitle = get_theme_mod( 'shop_header_subtitle', 'Evoke emotion, highlight artisan quality, create a unique experience.' );
?>

<div class="shop-page-wrapper <?php echo esc_attr( $container_class ); ?>">
    <div class="container-wide">
        <div class="shop-content-area">

            <!-- Main Shop Content -->
            <div class="shop-main-content">

                <?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
                    <header class="woocommerce-products-header <?php echo ! empty( $header_bg_image ) ? 'has-background-image' : ''; ?>"
                            <?php if ( ! empty( $header_bg_image ) ) : ?>
                                style="--shop-header-bg-image: url('<?php echo esc_url( $header_bg_image ); ?>');"
                            <?php endif; ?>>

                        <div class="woocommerce-products-header__inner">

                            <!-- Eyebrow -->
                            <div class="shop-header-eyebrow" aria-hidden="true">
                                <span class="shop-header-eyebrow__line"></span>
                                <span class="shop-header-eyebrow__text"><?php esc_html_e( 'Our Store', 'Bo-prime' ); ?></span>
                                <span class="shop-header-eyebrow__line"></span>
                            </div>

                            <h1 class="woocommerce-products-header__title page-title">
                                <?php echo esc_html( $header_title ); ?>
                            </h1>

                            <?php if ( ! empty( $header_subtitle ) ) : ?>
                                <div class="woocommerce-archive-description">
                                    <p><?php echo wp_kses_post( $header_subtitle ); ?></p>
                                </div>
                            <?php endif; ?>

                        </div>

                    </header>
                <?php endif; ?>

                <?php if ( woocommerce_product_loop() ) : ?>

                    <!-- Shop Toolbar -->
                    <div class="shop-toolbar">
                        <div class="shop-toolbar__left">
                            <div class="woocommerce-result-count">
                                <?php
                                $total = wc_get_loop_prop( 'total' );
                                printf(
                                    esc_html__( 'Showing all %d results', 'Bo-prime' ),
                                    $total
                                );
                                ?>
                            </div>
                        </div>
                        <div class="shop-toolbar__right">
                            <?php woocommerce_catalog_ordering(); ?>
                        </div>
                    </div>

                    <?php
                    // Category Filter
                    if ( $show_category_filter && ( is_shop() || is_product_category() ) ) {
                        Bo_render_category_filter();
                    }

                    woocommerce_product_loop_start();

                    if ( wc_get_loop_prop( 'total' ) ) {
                        while ( have_posts() ) {
                            the_post();
                            do_action( 'woocommerce_shop_loop' );
                            wc_get_template_part( 'content', 'product' );
                        }
                    }

                    woocommerce_product_loop_end();

                    do_action( 'woocommerce_after_shop_loop' );

                else :

                    do_action( 'woocommerce_no_products_found' );

                endif;

                do_action( 'woocommerce_after_main_content' );
                ?>

            </div><!-- .shop-main-content -->

            <!-- Sidebar (Conditional) -->
            <?php if ( $show_sidebar ) : ?>
                <aside class="shop-sidebar" role="complementary" aria-label="<?php esc_attr_e( 'Shop Sidebar', 'Bo-prime' ); ?>">
                    <?php dynamic_sidebar( 'shop-sidebar' ); ?>
                </aside>
            <?php endif; ?>

        </div><!-- .shop-content-area -->
    </div><!-- .container-wide -->
</div><!-- .shop-page-wrapper -->

<!-- Apply customizer column setting -->
<script>
(function() {
    'use strict';
    var columns = '<?php echo esc_js( get_theme_mod( 'products_per_row', '3' ) ); ?>';
    var productsGrid = document.querySelector('.woocommerce ul.products, .woocommerce-page ul.products');
    if (productsGrid) {
        productsGrid.setAttribute('data-columns', columns);
    }
})();
</script>

<?php get_footer( 'shop' );