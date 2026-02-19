<?php
/**
 * Shop breadcrumb
 *
 * CUSTOM: Arrow-style breadcrumbs with home icon.
 * Works on ALL WooCommerce pages EXCEPT cart page.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Hide on cart page
if ( is_cart() ) {
    return;
}

if ( ! empty( $breadcrumb ) ) {

    $separator = ''; // CSS arrows handle separators

    echo $args['wrap_before'];

    foreach ( $breadcrumb as $key => $crumb ) {

        echo $args['before'];

        $is_last = ( sizeof( $breadcrumb ) === $key + 1 );

        if ( ! empty( $crumb[1] ) && ! $is_last ) {

            if ( $key === 0 ) {
                // First item — home icon
                echo '<a href="' . esc_url( $crumb[1] ) . '" aria-label="' . esc_attr__( 'Home', 'Bo-prime' ) . '">';
                echo '<svg class="breadcrumb-home-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">';
                echo '<path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>';
                echo '<polyline points="9 22 9 12 15 12 15 22"/>';
                echo '</svg>';
                echo '</a>';
            } else {
                // Linked crumb
                echo '<a href="' . esc_url( $crumb[1] ) . '">' . esc_html( $crumb[0] ) . '</a>';
            }

        } else {
            // Current page — last item
            echo '<span class="breadcrumb-current">' . esc_html( $crumb[0] ) . '</span>';
        }

        echo $args['after'];

        if ( ! $is_last ) {
            echo $separator;
        }
    }

    echo $args['wrap_after'];
}