<?php
/**
 * Minimal Site Footer Template
 * A clean, modern, and simplified footer design
 * 
 * @package Bo-prime
 * @since 2.0.0
 */

// Get customizer settings
$show_logo = get_theme_mod('footer_show_logo', true);
$footer_bg_color = get_theme_mod('footer_bg_color', '#ffffff');
$footer_text_color = get_theme_mod('footer_text_color', '#64748b');
?>

<footer class="site-footer-minimal" role="contentinfo" itemscope itemtype="https://schema.org/WPFooter">
    <div class="footer-content">
        <div class="container">
            
            <?php if ($show_logo): ?>
                <div class="footer-logo-minimal">
                    <?php 
                    // Check for custom footer logo first
                    $footer_logo_id = get_theme_mod('footer_logo');
                    
                    if ($footer_logo_id) {
                        // Use custom footer logo
                        $logo_url = wp_get_attachment_image_url($footer_logo_id, 'full');
                        $logo_alt = get_post_meta($footer_logo_id, '_wp_attachment_image_alt', true);
                        ?>
                        <a href="<?php echo esc_url(home_url('/')); ?>" rel="home" aria-label="<?php bloginfo('name'); ?>">
                            <img src="<?php echo esc_url($logo_url); ?>" 
                                 alt="<?php echo esc_attr($logo_alt ? $logo_alt : get_bloginfo('name')); ?>"
                                 loading="lazy">
                        </a>
                        <?php
                    } elseif (has_custom_logo()) {
                        // Use main site logo
                        the_custom_logo();
                    } else {
                        // Fallback to site title
                        ?>
                        <div class="footer-logo-text">
                            <h2>
                                <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                                    <?php bloginfo('name'); ?>
                                </a>
                            </h2>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            <?php endif; ?>
            
            <p class="footer-description-minimal">
                <?php 
                $footer_description = get_theme_mod('footer_description', 'Your trusted source for quality products and exceptional service.');
                echo wp_kses_post($footer_description); 
                ?>
            </p>
            
            <div class="footer-copyright-minimal">
                <p>
                    <?php 
                    $copyright = get_theme_mod('footer_copyright_text', sprintf(__('© %s {sitename}. All rights reserved.', 'Bo-prime'), '{year}'));
                    $copyright = str_replace('{year}', date('Y'), $copyright);
                    $copyright = str_replace('{sitename}', get_bloginfo('name'), $copyright);
                    echo wp_kses_post($copyright);
                    ?>
                </p>
            </div>
            
        </div>
    </div>
    
    <!-- Back to Top Button -->
    <button class="back-to-top" 
            aria-label="<?php esc_attr_e('Back to top', 'Bo-prime'); ?>"
            title="<?php esc_attr_e('Scroll to top', 'Bo-prime'); ?>">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="18 15 12 9 6 15"></polyline>
        </svg>
    </button>
    
</footer>