<?php
/**
 * Hero section component with image slideshow OR video background
 */
if (!get_theme_mod('show_hero', true)) {
    return;
}

// Get media type (image or video)
$hero_media_type = get_theme_mod('hero_media_type', 'image');

// Get video settings
$video_id = get_theme_mod('hero_video_webm', '');
$video_fallback_id = get_theme_mod('hero_video_fallback', '');
$video_loop = get_theme_mod('hero_video_loop', true);
$video_mute = get_theme_mod('hero_video_mute', true);
$video_mobile_fallback = get_theme_mod('hero_video_mobile_fallback', true);

// Get slideshow settings
$enable_slideshow = get_theme_mod('hero_enable_slideshow', true);
$hero_slide_1 = get_theme_mod('hero_slide_1');
$hero_slide_2 = get_theme_mod('hero_slide_2');
$hero_slide_3 = get_theme_mod('hero_slide_3');
$hero_slide_4 = get_theme_mod('hero_slide_4');
$slideshow_speed = get_theme_mod('hero_slideshow_speed', 5000);

// Get content settings
$badge_text = get_theme_mod('hero_badge_text', '🐾 Quality Pet & Animal Supplies');
$hero_title = get_theme_mod('hero_title', 'Premium Feed & Supplies');
$hero_title_highlight = get_theme_mod('hero_title_highlight', 'For Your Beloved Pets & Livestock');
$hero_subtitle = get_theme_mod('hero_subtitle', 'Your trusted local supplier for premium pet food, animal feed, farm supplies, and everything your animals need. From dogs and cats to horses, poultry, and livestock.');
$primary_btn_text = get_theme_mod('hero_primary_button_text', 'Shop All Products');
$primary_btn_link = get_theme_mod('hero_primary_button_link', '/shop');
$secondary_btn_text = get_theme_mod('hero_secondary_button_text', 'About Our Store');
$secondary_btn_link = get_theme_mod('hero_secondary_button_link', '/about');
$trust_1_number = get_theme_mod('hero_trust_1_number', '1000+');
$trust_1_label = get_theme_mod('hero_trust_1_label', 'Products');
$trust_2_number = get_theme_mod('hero_trust_2_number', '100%');
$trust_2_label = get_theme_mod('hero_trust_2_label', 'Quality Assured');
$trust_3_number = get_theme_mod('hero_trust_3_number', 'Local');
$trust_3_label = get_theme_mod('hero_trust_3_label', 'Family Owned');

// Default fallback images
$default_images = array(
    'https://images.unsplash.com/photo-1587300003388-59208cc962cb?w=1920&q=80',
    'https://images.unsplash.com/photo-1553284965-83fd3e82fa5a?w=1920&q=80',
    'https://images.unsplash.com/photo-1601758228041-f3b2795255f1?w=1920&q=80',
    'https://images.unsplash.com/photo-1500595046743-cd271d694d30?w=1920&q=80',
);

// Build CSS class
$hero_class = 'hero-section';
if ($hero_media_type === 'video') {
    $hero_class .= ' hero-video';
} elseif (!$enable_slideshow) {
    $hero_class .= ' hero-static';
}

// Check if mobile and video mobile fallback is enabled
$is_mobile = wp_is_mobile();
$use_video = ($hero_media_type === 'video' && $video_id && (!$is_mobile || !$video_mobile_fallback));
?>

<section class="<?php echo esc_attr($hero_class); ?>">
    
    <?php if ($use_video) : ?>
        <!-- Video Background -->
        <div class="hero-video-background">
            <video 
                class="hero-video-element"
                autoplay
                <?php echo $video_mute ? 'muted' : ''; ?>
                <?php echo $video_loop ? 'loop' : ''; ?>
                playsinline
                preload="auto"
                poster="<?php echo $video_fallback_id ? esc_url(wp_get_attachment_image_url($video_fallback_id, 'full')) : ''; ?>"
            >
                <source src="<?php echo esc_url(wp_get_attachment_url($video_id)); ?>" type="video/webm">
                <?php if ($video_fallback_id) : ?>
                    <!-- Fallback image shown if video can't play -->
                    <?php echo wp_get_attachment_image($video_fallback_id, 'full', false, array(
                        'class' => 'hero-video-fallback-image',
                        'alt' => esc_attr($hero_title)
                    )); ?>
                <?php endif; ?>
            </video>
            <div class="slide-overlay"></div>
        </div>
        
    <?php elseif ($hero_media_type === 'image' && $enable_slideshow) : ?>
        <!-- Image Slideshow -->
        <div class="hero-slider" 
             data-autoplay="true" 
             data-delay="<?php echo esc_attr($slideshow_speed); ?>"
             data-pause-hover="true"
             data-keyboard="true"
             data-dots="false"
             data-arrows="false"
             data-loop="true">
            <div class="hero-slides">
                <?php 
                $slides = array($hero_slide_1, $hero_slide_2, $hero_slide_3, $hero_slide_4);
                foreach ($slides as $index => $slide_id) : 
                ?>
                    <div class="hero-slide">
                        <?php if ($slide_id) : ?>
                            <?php echo wp_get_attachment_image($slide_id, 'full', false, array('alt' => esc_attr($hero_title))); ?>
                        <?php else : ?>
                            <img src="<?php echo esc_url($default_images[$index]); ?>" alt="<?php echo esc_attr($hero_title); ?>">
                        <?php endif; ?>
                        <div class="slide-overlay"></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        
    <?php else : ?>
        <!-- Static Background (single image or video fallback on mobile) -->
        <div class="hero-static-background">
            <?php 
            // If video mode but mobile fallback is enabled, show fallback image
            if ($hero_media_type === 'video' && $is_mobile && $video_mobile_fallback && $video_fallback_id) {
                echo wp_get_attachment_image($video_fallback_id, 'full', false, array(
                    'alt' => esc_attr($hero_title),
                    'class' => 'hero-static-image'
                ));
            } elseif ($hero_slide_1) {
                echo wp_get_attachment_image($hero_slide_1, 'full', false, array(
                    'alt' => esc_attr($hero_title),
                    'class' => 'hero-static-image'
                ));
            } else {
                echo '<img src="' . esc_url($default_images[0]) . '" alt="' . esc_attr($hero_title) . '" class="hero-static-image">';
            }
            ?>
            <div class="slide-overlay"></div>
        </div>
    <?php endif; ?>

    <!-- Hero Content -->
    <div class="hero-content-container">
        <div class="hero-content">
            <?php if ($badge_text) : ?>
            <div class="hero-badge-wrapper" 
                 data-animate="fade-down" 
                 data-animate-delay="100">
                <span class="hero-badge">
                    <?php echo esc_html($badge_text); ?>
                </span>
            </div>
            <?php endif; ?>
            
            <h1 class="hero-title" 
                data-animate="fade-up" 
                data-animate-delay="200">
                <?php echo esc_html($hero_title); ?>
                <?php if ($hero_title_highlight) : ?>
                <span class="hero-title-highlight"><?php echo esc_html($hero_title_highlight); ?></span>
                <?php endif; ?>
            </h1>
            
            <p class="hero-subtitle" 
               data-animate="fade-up" 
               data-animate-delay="300">
                <?php echo esc_html($hero_subtitle); ?>
            </p>

            <div class="hero-buttons" 
                 data-animate="fade-up" 
                 data-animate-delay="400">
                <?php if ($primary_btn_text) : ?>
                    <a href="<?php echo esc_url($primary_btn_link); ?>" class="hero-btn hero-btn-primary">
                        <?php echo esc_html($primary_btn_text); ?>
                        <svg class="hero-btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                <?php endif; ?>

                <?php if ($secondary_btn_text) : ?>
                    <a href="<?php echo esc_url($secondary_btn_link); ?>" class="hero-btn hero-btn-secondary">
                        <?php echo esc_html($secondary_btn_text); ?>
                        <svg class="hero-btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </a>
                <?php endif; ?>
            </div>
            
            <!-- Trust Indicators -->
            <div class="hero-trust-indicators" 
                 data-animate="fade-up" 
                 data-animate-delay="500">
                <div class="trust-item">
                    <div class="trust-number"><?php echo esc_html($trust_1_number); ?></div>
                    <div class="trust-label"><?php echo esc_html($trust_1_label); ?></div>
                </div>
                <div class="trust-item">
                    <div class="trust-number"><?php echo esc_html($trust_2_number); ?></div>
                    <div class="trust-label"><?php echo esc_html($trust_2_label); ?></div>
                </div>
                <div class="trust-item">
                    <div class="trust-number"><?php echo esc_html($trust_3_number); ?></div>
                    <div class="trust-label"><?php echo esc_html($trust_3_label); ?></div>
                </div>
            </div>
        </div>
    </div>
</section>