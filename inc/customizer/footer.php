<?php
/**
 * Footer Minimal Customizer Settings
 * 
 * @package Bo-prime
 * @since 2.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Footer Minimal Customizer Settings
 */
function bo_footer_minimal_customizer($wp_customize) {
    
    // ===================================================================
    // FOOTER MINIMAL SECTION
    // ===================================================================
    
    $wp_customize->add_section('footer_minimal_section', array(
        'title'       => __('Footer', 'Bo-prime'),
        'priority'    => 80,
        'description' => __('Configure the minimal footer design with logo and description only.', 'Bo-prime'),
    ));
    
    // -------------------------------------------------------------------
    // Show/Hide Logo
    // -------------------------------------------------------------------
    
    $wp_customize->add_setting('footer_show_logo', array(
        'default'           => true,
        'sanitize_callback' => 'bo_sanitize_checkbox',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('footer_show_logo', array(
        'label'       => __('Show Logo', 'Bo-prime'),
        'description' => __('Display logo in footer', 'Bo-prime'),
        'section'     => 'footer_minimal_section',
        'type'        => 'checkbox',
        'priority'    => 10,
    ));
    
    // -------------------------------------------------------------------
    // Footer Logo Upload
    // -------------------------------------------------------------------
    
    $wp_customize->add_setting('footer_logo', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'footer_logo', array(
        'label'       => __('Footer Logo', 'Bo-prime'),
        'description' => __('Upload a custom logo for the footer (optional). If not set, the main site logo will be used.', 'Bo-prime'),
        'section'     => 'footer_minimal_section',
        'mime_type'   => 'image',
        'priority'    => 15,
        'active_callback' => function() {
            return get_theme_mod('footer_show_logo', true);
        },
    )));
    
    // -------------------------------------------------------------------
    // Footer Description
    // -------------------------------------------------------------------
    
    $wp_customize->add_setting('footer_description', array(
        'default'           => __('Your trusted source for quality products and exceptional service.', 'Bo-prime'),
        'sanitize_callback' => 'wp_kses_post',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control('footer_description', array(
        'label'       => __('Footer Description', 'Bo-prime'),
        'description' => __('Short description text (1-2 sentences recommended)', 'Bo-prime'),
        'section'     => 'footer_minimal_section',
        'type'        => 'textarea',
        'priority'    => 20,
    ));
    
    // -------------------------------------------------------------------
    // Copyright Text
    // -------------------------------------------------------------------
    
    $wp_customize->add_setting('footer_copyright_text', array(
        'default'           => sprintf(__('© %s {sitename}. All rights reserved.', 'Bo-prime'), '{year}'),
        'sanitize_callback' => 'wp_kses_post',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control('footer_copyright_text', array(
        'label'       => __('Copyright Text', 'Bo-prime'),
        'description' => __('Use {year} for current year and {sitename} for site name', 'Bo-prime'),
        'section'     => 'footer_minimal_section',
        'type'        => 'text',
        'priority'    => 30,
    ));
    
    // -------------------------------------------------------------------
    // Footer Background Color
    // -------------------------------------------------------------------
    
    $wp_customize->add_setting('footer_bg_color', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'footer_bg_color', array(
        'label'       => __('Background Color', 'Bo-prime'),
        'section'     => 'footer_minimal_section',
        'priority'    => 40,
    )));
    
    // -------------------------------------------------------------------
    // Footer Text Color
    // -------------------------------------------------------------------
    
    $wp_customize->add_setting('footer_text_color', array(
        'default'           => '#64748b',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'footer_text_color', array(
        'label'       => __('Text Color', 'Bo-prime'),
        'section'     => 'footer_minimal_section',
        'priority'    => 50,
    )));
    
    // -------------------------------------------------------------------
    // Logo Size
    // -------------------------------------------------------------------
    
    $wp_customize->add_setting('footer_logo_size', array(
        'default'           => 220,
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control('footer_logo_size', array(
        'label'       => __('Logo Size (px)', 'Bo-prime'),
        'description' => __('Adjust the maximum width of your footer logo', 'Bo-prime'),
        'section'     => 'footer_minimal_section',
        'type'        => 'range',
        'priority'    => 60,
        'input_attrs' => array(
            'min'  => 80,
            'max'  => 400,
            'step' => 10,
        ),
    ));
}
add_action('customize_register', 'bo_footer_minimal_customizer');

/**
 * Sanitize Checkbox
 */
function bo_sanitize_checkbox($checked) {
    return ((isset($checked) && true == $checked) ? true : false);
}

/**
 * Sanitize Select
 */
function bo_sanitize_select($input, $setting) {
    $input = sanitize_key($input);
    $choices = $setting->manager->get_control($setting->id)->choices;
    return (array_key_exists($input, $choices) ? $input : $setting->default);
}

/**
 * Customizer Live Preview JS
 */
function bo_footer_minimal_customizer_preview() {
    wp_enqueue_script(
        'bo-footer-minimal-customizer-preview',
        get_template_directory_uri() . '/assets/js/footer-minimal-customizer-preview.js',
        array('customize-preview', 'jquery'),
        '2.0.0',
        true
    );
}
add_action('customize_preview_init', 'bo_footer_minimal_customizer_preview');

/**
 * Enqueue Back to Top Button JS
 */
function bo_back_to_top_scripts() {
    wp_enqueue_script(
        'bo-back-to-top',
        get_template_directory_uri() . '/assets/js/back-to-top.js',
        array(),
        '2.0.0',
        true
    );
}
add_action('wp_enqueue_scripts', 'bo_back_to_top_scripts');

/**
 * Apply Footer Style Settings via Inline CSS
 */
function bo_footer_minimal_preset_css() {
    $bg_color = get_theme_mod('footer_bg_color', '#ffffff');
    $text_color = get_theme_mod('footer_text_color', '#64748b');
    $logo_size = get_theme_mod('footer_logo_size', 220);
    
    $css = '';
    
    // Background color
    $css .= '.site-footer-minimal { background: ' . esc_attr($bg_color) . ' !important; }';
    
    // Text color - target all text elements
    $css .= '.footer-description-minimal { color: ' . esc_attr($text_color) . ' !important; }';
    $css .= '.footer-copyright-minimal p { color: ' . esc_attr($text_color) . ' !important; }';
    $css .= '.site-footer-minimal { color: ' . esc_attr($text_color) . ' !important; }';
    
    // Logo size - all possible selectors
    $css .= '.footer-logo-minimal img { max-width: ' . esc_attr($logo_size) . 'px !important; height: auto !important; }';
    $css .= '.footer-logo-minimal .custom-logo { max-width: ' . esc_attr($logo_size) . 'px !important; height: auto !important; }';
    $css .= '.footer-logo-minimal .custom-logo-link img { max-width: ' . esc_attr($logo_size) . 'px !important; height: auto !important; }';
    $css .= '.footer-logo-minimal a img { max-width: ' . esc_attr($logo_size) . 'px !important; height: auto !important; }';
    
    // Output inline styles
    wp_register_style('bo-footer-minimal-inline', false);
    wp_enqueue_style('bo-footer-minimal-inline');
    wp_add_inline_style('bo-footer-minimal-inline', $css);
}
add_action('wp_enqueue_scripts', 'bo_footer_minimal_preset_css', 99);