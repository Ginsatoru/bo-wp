/**
 * Header Scroll Behavior - CONDITIONAL OVERLAY VERSION
 * Handles transparent overlay header ONLY on pages with has-transparent-header class
 * Keeps solid background on all other pages
 * Properly handles admin bar positioning
 */

(function() {
    'use strict';

    document.addEventListener('DOMContentLoaded', function() {
        
        const body = document.body;
        const header = document.querySelector('.site-header');
        const isAdminBar = body.classList.contains('admin-bar');
        const hasTransparentHeader = body.classList.contains('has-transparent-header');
        
        if (!header) return;
        
        let lastScrollTop = 0;
        let ticking = false;
        
        function updateHeader(scrollTop) {
            const isMobile = window.innerWidth < 782;
            
            // Only add/remove scrolled class on pages with transparent header
            if (hasTransparentHeader) {
                // Add scrolled class after 50px
                if (scrollTop > 50) {
                    body.classList.add('scrolled');
                    header.classList.add('is-sticky');
                } else {
                    // AT TOP OF PAGE - transparent header
                    body.classList.remove('scrolled');
                    header.classList.remove('is-sticky');
                }
            } else {
                // For pages WITHOUT transparent header, always keep solid background
                // Remove scrolled class but keep is-sticky for positioning
                body.classList.remove('scrolled');
                header.classList.add('is-sticky');
            }
            
            // Handle admin bar positioning
            if (isAdminBar) {
                if (isMobile) {
                    // Mobile with admin bar (screens < 782px)
                    header.style.top = '46px';
                } else {
                    // Desktop with admin bar (screens >= 782px)
                    header.style.top = '32px';
                }
            } else {
                // No admin bar - header at top
                header.style.top = '0';
            }
            
            lastScrollTop = scrollTop;
        }
        
        function onScroll() {
            lastScrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
            if (!ticking) {
                window.requestAnimationFrame(function() {
                    updateHeader(lastScrollTop);
                    ticking = false;
                });
                
                ticking = true;
            }
        }
        
        function onResize() {
            // Recalculate header position on resize
            if (!ticking) {
                window.requestAnimationFrame(function() {
                    updateHeader(lastScrollTop);
                    ticking = false;
                });
                
                ticking = true;
            }
        }
        
        // Listen to scroll events
        window.addEventListener('scroll', onScroll, { passive: true });
        
        // Listen to resize events (for responsive adjustments)
        window.addEventListener('resize', onResize, { passive: true });
        
        // Check initial state on page load
        updateHeader(window.pageYOffset || document.documentElement.scrollTop);
        
    });
    
})();