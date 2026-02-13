<?php
/**
 * Hero section customizer settings with single WebM video support
 */
function mr_hero_customizer($wp_customize) {
    // Hero Section
    $wp_customize->add_section('mr_hero', array(
        'title' => __('Hero Section', 'Bo'),
        'priority' => 40,
    ));

    // Show Hero Section
    $wp_customize->add_setting('show_hero', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport' => 'postMessage',
    ));

    $wp_customize->add_control('show_hero', array(
        'label' => __('Show Hero Section', 'Bo'),
        'section' => 'mr_hero',
        'type' => 'checkbox',
        'priority' => 10,
    ));

    // === HERO MEDIA TYPE (Image Slideshow OR Single Video) ===
    $wp_customize->add_setting('hero_media_type', array(
        'default' => 'image',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control('hero_media_type', array(
        'label' => __('Hero Background Type', 'Bo'),
        'section' => 'mr_hero',
        'type' => 'select',
        'choices' => array(
            'image' => __('Image Slideshow', 'Bo'),
            'video' => __('Single Video Background', 'Bo'),
        ),
        'priority' => 15,
    ));

    // === VIDEO SETTINGS (Only shown when video type is selected) ===
    // Hero Video (WebM only)
    $wp_customize->add_setting('hero_video_webm', array(
        'default' => '',
        'sanitize_callback' => 'absint',
        'transport' => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'hero_video_webm', array(
        'label' => __('Hero Background Video (WebM)', 'Bo'),
        'description' => __('Upload WebM video file. This will replace the image slideshow. Recommended: VP8/VP9 codec, max 15MB.', 'Bo'),
        'section' => 'mr_hero',
        'mime_type' => 'video/webm',
        'active_callback' => function() {
            return get_theme_mod('hero_media_type', 'image') === 'video';
        },
        'priority' => 20,
    )));

    // Video Fallback Image
    $wp_customize->add_setting('hero_video_fallback', array(
        'default' => '',
        'sanitize_callback' => 'absint',
        'transport' => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'hero_video_fallback', array(
        'label' => __('Video Fallback Image', 'Bo'),
        'description' => __('Image shown while video loads or if video cannot play. Also used on mobile devices.', 'Bo'),
        'section' => 'mr_hero',
        'mime_type' => 'image',
        'active_callback' => function() {
            return get_theme_mod('hero_media_type', 'image') === 'video';
        },
        'priority' => 25,
    )));

    // Video Loop
    $wp_customize->add_setting('hero_video_loop', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport' => 'postMessage',
    ));

    $wp_customize->add_control('hero_video_loop', array(
        'label' => __('Loop Video', 'Bo'),
        'section' => 'mr_hero',
        'type' => 'checkbox',
        'active_callback' => function() {
            return get_theme_mod('hero_media_type', 'image') === 'video';
        },
        'priority' => 30,
    ));

    // Video Mute
    $wp_customize->add_setting('hero_video_mute', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport' => 'postMessage',
    ));

    $wp_customize->add_control('hero_video_mute', array(
        'label' => __('Mute Video', 'Bo'),
        'description' => __('Video is muted by default for autoplay compatibility.', 'Bo'),
        'section' => 'mr_hero',
        'type' => 'checkbox',
        'active_callback' => function() {
            return get_theme_mod('hero_media_type', 'image') === 'video';
        },
        'priority' => 35,
    ));

    // Video Mobile Fallback
    $wp_customize->add_setting('hero_video_mobile_fallback', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport' => 'postMessage',
    ));

    $wp_customize->add_control('hero_video_mobile_fallback', array(
        'label' => __('Use Image Fallback on Mobile', 'Bo'),
        'description' => __('On mobile devices, show image instead of video for better performance.', 'Bo'),
        'section' => 'mr_hero',
        'type' => 'checkbox',
        'active_callback' => function() {
            return get_theme_mod('hero_media_type', 'image') === 'video';
        },
        'priority' => 40,
    ));

    // === IMAGE SLIDESHOW SETTINGS (Only shown when image type is selected) ===
    // Enable Slideshow
    $wp_customize->add_setting('hero_enable_slideshow', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control('hero_enable_slideshow', array(
        'label' => __('Enable Image Slideshow', 'Bo'),
        'description' => __('When disabled, only the first slide image will be displayed as a static background.', 'Bo'),
        'section' => 'mr_hero',
        'type' => 'checkbox',
        'active_callback' => function() {
            return get_theme_mod('hero_media_type', 'image') === 'image';
        },
        'priority' => 45,
    ));

    // Hero Slide 1 Image
    $wp_customize->add_setting('hero_slide_1', array(
        'default' => '',
        'sanitize_callback' => 'absint',
        'transport' => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'hero_slide_1', array(
        'label' => __('Slide 1 Image (Primary/Static)', 'Bo'),
        'description' => __('This image is used as the static background when slideshow is disabled.', 'Bo'),
        'section' => 'mr_hero',
        'mime_type' => 'image',
        'active_callback' => function() {
            return get_theme_mod('hero_media_type', 'image') === 'image';
        },
        'priority' => 50,
    )));

    // Hero Slide 2 Image
    $wp_customize->add_setting('hero_slide_2', array(
        'default' => '',
        'sanitize_callback' => 'absint',
        'transport' => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'hero_slide_2', array(
        'label' => __('Slide 2 Image', 'Bo'),
        'section' => 'mr_hero',
        'mime_type' => 'image',
        'active_callback' => function() {
            return get_theme_mod('hero_media_type', 'image') === 'image';
        },
        'priority' => 60,
    )));

    // Hero Slide 3 Image
    $wp_customize->add_setting('hero_slide_3', array(
        'default' => '',
        'sanitize_callback' => 'absint',
        'transport' => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'hero_slide_3', array(
        'label' => __('Slide 3 Image', 'Bo'),
        'section' => 'mr_hero',
        'mime_type' => 'image',
        'active_callback' => function() {
            return get_theme_mod('hero_media_type', 'image') === 'image';
        },
        'priority' => 70,
    )));

    // Hero Slide 4 Image
    $wp_customize->add_setting('hero_slide_4', array(
        'default' => '',
        'sanitize_callback' => 'absint',
        'transport' => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'hero_slide_4', array(
        'label' => __('Slide 4 Image', 'Bo'),
        'section' => 'mr_hero',
        'mime_type' => 'image',
        'active_callback' => function() {
            return get_theme_mod('hero_media_type', 'image') === 'image';
        },
        'priority' => 80,
    )));

    // Slideshow Speed
    $wp_customize->add_setting('hero_slideshow_speed', array(
        'default' => 5000,
        'sanitize_callback' => 'absint',
        'transport' => 'postMessage',
    ));

    $wp_customize->add_control('hero_slideshow_speed', array(
        'label' => __('Slideshow Speed (ms)', 'Bo'),
        'description' => __('Time between slide transitions in milliseconds.', 'Bo'),
        'section' => 'mr_hero',
        'type' => 'number',
        'input_attrs' => array(
            'min' => 2000,
            'max' => 10000,
            'step' => 500,
        ),
        'active_callback' => function() {
            return get_theme_mod('hero_media_type', 'image') === 'image';
        },
        'priority' => 90,
    ));

    // === HERO CONTENT SETTINGS (Always shown) ===
    // Badge Text
    $wp_customize->add_setting('hero_badge_text', array(
        'default' => 'Kinglou - Story of Quality',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));

    $wp_customize->add_control('hero_badge_text', array(
        'label' => __('Badge Text', 'Bo'),
        'section' => 'mr_hero',
        'type' => 'text',
        'priority' => 100,
    ));

    // Hero Title
    $wp_customize->add_setting('hero_title', array(
        'default' => 'Premium Feed & Supplies',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));

    $wp_customize->add_control('hero_title', array(
        'label' => __('Hero Title', 'Bo'),
        'section' => 'mr_hero',
        'type' => 'text',
        'priority' => 110,
    ));

    // Hero Title Highlight
    $wp_customize->add_setting('hero_title_highlight', array(
        'default' => 'For Your Beloved Pets & Livestock',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));

    $wp_customize->add_control('hero_title_highlight', array(
        'label' => __('Hero Title Highlight', 'Bo'),
        'section' => 'mr_hero',
        'type' => 'text',
        'priority' => 120,
    ));

    // Hero Subtitle
    $wp_customize->add_setting('hero_subtitle', array(
        'default' => 'Your trusted local supplier for premium pet food, animal feed, farm supplies, and everything your animals need. From dogs and cats to horses, poultry, and livestock.',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'postMessage',
    ));

    $wp_customize->add_control('hero_subtitle', array(
        'label' => __('Hero Subtitle', 'Bo'),
        'section' => 'mr_hero',
        'type' => 'textarea',
        'priority' => 130,
    ));

    // Primary Button Text
    $wp_customize->add_setting('hero_primary_button_text', array(
        'default' => 'Shop All Products',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));

    $wp_customize->add_control('hero_primary_button_text', array(
        'label' => __('Primary Button Text', 'Bo'),
        'section' => 'mr_hero',
        'type' => 'text',
        'priority' => 140,
    ));

    // Primary Button Link
    $wp_customize->add_setting('hero_primary_button_link', array(
        'default' => '/shop',
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'postMessage',
    ));

    $wp_customize->add_control('hero_primary_button_link', array(
        'label' => __('Primary Button Link', 'Bo'),
        'section' => 'mr_hero',
        'type' => 'url',
        'priority' => 150,
    ));

    // Secondary Button Text
    $wp_customize->add_setting('hero_secondary_button_text', array(
        'default' => 'About Our Store',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));

    $wp_customize->add_control('hero_secondary_button_text', array(
        'label' => __('Secondary Button Text', 'Bo'),
        'section' => 'mr_hero',
        'type' => 'text',
        'priority' => 160,
    ));

    // Secondary Button Link
    $wp_customize->add_setting('hero_secondary_button_link', array(
        'default' => '/about',
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'postMessage',
    ));

    $wp_customize->add_control('hero_secondary_button_link', array(
        'label' => __('Secondary Button Link', 'Bo'),
        'section' => 'mr_hero',
        'type' => 'url',
        'priority' => 170,
    ));

    // Video Format Note
    $wp_customize->add_setting('hero_video_note', array(
        'default' => '',
        'sanitize_callback' => 'wp_kses_post',
    ));

    $wp_customize->add_control('hero_video_note', array(
        'label' => __('Video Format Information', 'Bo'),
        'description' => __('<strong>WebM Format Required:</strong><br>• Use .webm extension only<br>• Better compression than MP4<br>• Max recommended size: 15MB<br>• Modern browser compatibility', 'Bo'),
        'section' => 'mr_hero',
        'type' => 'hidden',
        'active_callback' => function() {
            return get_theme_mod('hero_media_type', 'image') === 'video';
        },
        'priority' => 200,
    ));
}
add_action('customize_register', 'mr_hero_customizer');