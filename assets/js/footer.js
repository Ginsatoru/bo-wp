/**
 * Footer Minimal Customizer Preview
 * Live preview for footer customizer settings
 * 
 * @package Bo-prime
 * @since 2.0.0
 */

(function($) {
    'use strict';

    // Footer Description
    wp.customize('footer_description', function(value) {
        value.bind(function(newval) {
            $('.footer-description-minimal').html(newval);
        });
    });

    // Copyright Text
    wp.customize('footer_copyright_text', function(value) {
        value.bind(function(newval) {
            // Replace placeholders
            var year = new Date().getFullYear();
            var sitename = wp.customize('blogname')();
            
            newval = newval.replace('{year}', year);
            newval = newval.replace('{sitename}', sitename);
            
            $('.footer-copyright-minimal p').html(newval);
        });
    });

    // Background Color
    wp.customize('footer_bg_color', function(value) {
        value.bind(function(newval) {
            $('.site-footer-minimal').css('background-color', newval);
        });
    });

    // Text Color
    wp.customize('footer_text_color', function(value) {
        value.bind(function(newval) {
            $('style#footer-text-color').remove();
            $('head').append('<style id="footer-text-color">:root { --footer-minimal-text: ' + newval + '; }</style>');
        });
    });

    // Logo Size
    wp.customize('footer_logo_size', function(value) {
        value.bind(function(newval) {
            $('style#footer-logo-size').remove();
            var css = '.footer-logo-minimal img { max-width: ' + newval + 'px !important; height: auto !important; }';
            css += '.footer-logo-minimal .custom-logo { max-width: ' + newval + 'px !important; height: auto !important; }';
            css += '.footer-logo-minimal .custom-logo-link img { max-width: ' + newval + 'px !important; height: auto !important; }';
            css += '.footer-logo-minimal a img { max-width: ' + newval + 'px !important; height: auto !important; }';
            $('head').append('<style id="footer-logo-size">' + css + '</style>');
        });
    });

    // Site Name (Blogname)
    wp.customize('blogname', function(value) {
        value.bind(function(newval) {
            $('.footer-logo-text h2 a').text(newval);
            
            // Update copyright if it uses {sitename}
            var copyright = wp.customize('footer_copyright_text')();
            if (copyright.indexOf('{sitename}') !== -1) {
                var year = new Date().getFullYear();
                copyright = copyright.replace('{year}', year);
                copyright = copyright.replace('{sitename}', newval);
                $('.footer-copyright-minimal p').html(copyright);
            }
        });
    });

})(jQuery);