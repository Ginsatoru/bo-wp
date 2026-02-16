<?php
/**
 * Hero section component - Redesigned Clean & Minimal
 * Supports image slideshow OR video background
 */
if (!get_theme_mod('show_hero', true)) {
    return;
}

// Get media type
$hero_media_type = get_theme_mod('hero_media_type', 'image');

// Video settings
$video_id = get_theme_mod('hero_video_webm', '');
$video_fallback_id = get_theme_mod('hero_video_fallback', '');
$video_loop = get_theme_mod('hero_video_loop', true);
$video_mute = get_theme_mod('hero_video_mute', true);
$video_mobile_fallback = get_theme_mod('hero_video_mobile_fallback', true);

// Slideshow settings
$enable_slideshow = get_theme_mod('hero_enable_slideshow', true);
$hero_slide_1 = get_theme_mod('hero_slide_1');
$hero_slide_2 = get_theme_mod('hero_slide_2');
$hero_slide_3 = get_theme_mod('hero_slide_3');
$hero_slide_4 = get_theme_mod('hero_slide_4');
$slideshow_speed = get_theme_mod('hero_slideshow_speed', 5000);

// Content settings
$badge_text = get_theme_mod('hero_badge_text', 'Premium Quality');
$hero_title = get_theme_mod('hero_title', 'Everything Your Animals Need');
$hero_title_highlight = get_theme_mod('hero_title_highlight', 'From Farm to Family');
$hero_subtitle = get_theme_mod('hero_subtitle', 'Your trusted local supplier for premium pet food, animal feed, farm supplies, and everything your animals need to thrive.');
$primary_btn_text = get_theme_mod('hero_primary_button_text', 'Shop Now');
$primary_btn_link = get_theme_mod('hero_primary_button_link', '/shop');
$secondary_btn_text = get_theme_mod('hero_secondary_button_text', 'Learn More');
$secondary_btn_link = get_theme_mod('hero_secondary_button_link', '/about');

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

// Check mobile
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
                            <img src="<?php echo esc_url($default_images[$index]); ?>" alt="<?php echo esc_attr($hero_title); ?>" loading="eager">
                        <?php endif; ?>
                        <div class="slide-overlay"></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        
    <?php else : ?>
        <!-- Static Background -->
        <div class="hero-static-background">
            <?php 
            if ($hero_media_type === 'video' && $is_mobile && $video_mobile_fallback && $video_fallback_id) {
                echo wp_get_attachment_image($video_fallback_id, 'full', false, array(
                    'alt' => esc_attr($hero_title),
                    'class' => 'hero-static-image',
                    'loading' => 'eager'
                ));
            } elseif ($hero_slide_1) {
                echo wp_get_attachment_image($hero_slide_1, 'full', false, array(
                    'alt' => esc_attr($hero_title),
                    'class' => 'hero-static-image',
                    'loading' => 'eager'
                ));
            } else {
                echo '<img src="' . esc_url($default_images[0]) . '" alt="' . esc_attr($hero_title) . '" class="hero-static-image" loading="eager">';
            }
            ?>
            <div class="slide-overlay"></div>
        </div>
    <?php endif; ?>

    <!-- Hero Content -->
    <div class="hero-content-container">
        <div class="hero-content">
            
            <?php if ($badge_text) : ?>
            <div class="hero-badge-wrapper" data-animate="fade-down" data-animate-delay="100">
                <span class="hero-badge"><?php echo esc_html($badge_text); ?></span>
            </div>
            <?php endif; ?>
            
            <h1 class="hero-title" data-animate="fade-up" data-animate-delay="200">
                <?php echo esc_html($hero_title); ?>
                <?php if ($hero_title_highlight) : ?>
                <span class="hero-title-highlight"><?php echo esc_html($hero_title_highlight); ?></span>
                <?php endif; ?>
            </h1>
            
            <p class="hero-subtitle" data-animate="fade-up" data-animate-delay="300">
                <?php echo esc_html($hero_subtitle); ?>
            </p>

            <div class="hero-buttons" data-animate="fade-up" data-animate-delay="400">
                <?php if ($primary_btn_text) : ?>
                    <a href="<?php echo esc_url($primary_btn_link); ?>" class="hero-btn hero-btn-primary" aria-label="<?php echo esc_attr($primary_btn_text); ?>">
                        <?php echo esc_html($primary_btn_text); ?>
                        <svg class="hero-btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                <?php endif; ?>

                <?php if ($secondary_btn_text) : ?>
                    <a href="<?php echo esc_url($secondary_btn_link); ?>" class="hero-btn hero-btn-secondary" aria-label="<?php echo esc_attr($secondary_btn_text); ?>">
                        <?php echo esc_html($secondary_btn_text); ?>
                        <svg class="hero-btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </a>
                <?php endif; ?>
            </div> 
        </div>
    </div>
</section>