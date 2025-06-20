/**
 * Ratatouille Restaurant Loading Animation
 */
jQuery(document).ready(function($) {
    console.log('Loading animation script initialized');
    
    // Create and show loading screen
    function showLoadingScreen() {
        const loadingHTML = `
            <div class="ratatouille-loader" id="ratatouille-loader">
                <!-- Floating spices background -->
                <div class="spices">
                    <div class="spice"></div>
                    <div class="spice"></div>
                    <div class="spice"></div>
                    <div class="spice"></div>
                    <div class="spice"></div>
                    <div class="spice"></div>
                    <div class="spice"></div>
                    <div class="spice"></div>
                    <div class="spice"></div>
                </div>
                
                <!-- Chef hat -->
                <div class="chef-hat">
                    <div class="hat-top"></div>
                    <div class="hat-band"></div>
                </div>
                
                <!-- Vegetables falling -->
                <div class="vegetables">
                    <div class="vegetable tomato"></div>
                    <div class="vegetable carrot"></div>
                    <div class="vegetable onion"></div>
                    <div class="vegetable pepper"></div>
                </div>
                
                <!-- Main cooking pot -->
                <div class="cooking-pot">
                    <div class="steam">
                        <div class="steam-line"></div>
                        <div class="steam-line"></div>
                        <div class="steam-line"></div>
                    </div>
                    <div class="pot-lid">
                        <div class="pot-knob"></div>
                    </div>
                    <div class="pot-body">
                        <div class="pot-handle left"></div>
                        <div class="pot-handle right"></div>
                    </div>
                </div>
                
                <!-- Loading text -->
                <div class="loading-text">Рататуй</div>
                <div class="loading-subtitle">Готуємо для вас щось особливе...</div>
                
                <!-- Progress bar -->
                <div class="progress-container">
                    <div class="progress-bar" id="progress-bar"></div>
                </div>
            </div>
        `;
        
        $('body').prepend(loadingHTML);
        
        // Animate progress bar
        setTimeout(function() {
            $('#progress-bar').css('width', '100%');
        }, 500);
    }
    
    // Hide loading screen
    function hideLoadingScreen() {
        const $loader = $('#ratatouille-loader');
        if ($loader.length) {
            $loader.addClass('fade-out');
            setTimeout(function() {
                $loader.remove();
                $('body').removeClass('loading');
            }, 800);
        }
    }
    
    // Check if we should show loading screen
    function shouldShowLoading() {
        // Don't show on admin pages
        if ($('body').hasClass('wp-admin')) {
            return false;
        }
        
        // Don't show if already loaded (for AJAX requests)
        if (sessionStorage.getItem('ratatouille_loaded')) {
            return false;
        }
        
        return true;
    }
    
    // Initialize loading screen
    if (shouldShowLoading()) {
        console.log('Showing loading screen');
        $('body').addClass('loading');
        showLoadingScreen();
        
        // Hide loading screen when page is fully loaded
        $(window).on('load', function() {
            console.log('Page fully loaded, hiding loading screen');
            setTimeout(function() {
                hideLoadingScreen();
                sessionStorage.setItem('ratatouille_loaded', 'true');
            }, 2000); // Show for at least 2 seconds
        });
        
        // Fallback: hide after maximum time
        setTimeout(function() {
            console.log('Fallback: hiding loading screen after timeout');
            hideLoadingScreen();
            sessionStorage.setItem('ratatouille_loaded', 'true');
        }, 8000); // Maximum 8 seconds
    }
    
    // Clear session storage on page unload (for fresh loading on new visits)
    $(window).on('beforeunload', function() {
        // Only clear if navigating to a different domain
        if (document.activeElement && document.activeElement.href && 
            !document.activeElement.href.includes(window.location.hostname)) {
            sessionStorage.removeItem('ratatouille_loaded');
        }
    });
    
    // Handle AJAX page loads (if using AJAX navigation)
    $(document).on('ajaxStart', function() {
        if (!$('#ratatouille-loader').length && !sessionStorage.getItem('ratatouille_loaded')) {
            showLoadingScreen();
        }
    });
    
    $(document).on('ajaxComplete', function() {
        setTimeout(function() {
            hideLoadingScreen();
        }, 1000);
    });
    
    // Special handling for form submissions
    $('form').on('submit', function() {
        if (!$(this).hasClass('no-loading')) {
            showLoadingScreen();
        }
    });
    
    // Handle back/forward navigation
    $(window).on('pageshow', function(event) {
        if (event.originalEvent.persisted) {
            // Page was loaded from cache
            hideLoadingScreen();
        }
    });
    
    // Debug information
    console.log('Ratatouille loading animation ready');
    console.log('Session storage loaded flag:', sessionStorage.getItem('ratatouille_loaded'));
});

// Additional loading states for specific actions
window.RatatouilleLoader = {
    show: function(message) {
        const $loader = $('#ratatouille-loader');
        if ($loader.length) {
            $loader.find('.loading-subtitle').text(message || 'Готуємо для вас щось особливе...');
            $loader.removeClass('fade-out');
        } else {
            jQuery('body').addClass('loading');
            // Create new loader with custom message
            const loadingHTML = `
                <div class="ratatouille-loader" id="ratatouille-loader">
                    <div class="spices">
                        <div class="spice"></div>
                        <div class="spice"></div>
                        <div class="spice"></div>
                        <div class="spice"></div>
                        <div class="spice"></div>
                        <div class="spice"></div>
                        <div class="spice"></div>
                        <div class="spice"></div>
                        <div class="spice"></div>
                    </div>
                    <div class="chef-hat">
                        <div class="hat-top"></div>
                        <div class="hat-band"></div>
                    </div>
                    <div class="vegetables">
                        <div class="vegetable tomato"></div>
                        <div class="vegetable carrot"></div>
                        <div class="vegetable onion"></div>
                        <div class="vegetable pepper"></div>
                    </div>
                    <div class="cooking-pot">
                        <div class="steam">
                            <div class="steam-line"></div>
                            <div class="steam-line"></div>
                            <div class="steam-line"></div>
                        </div>
                        <div class="pot-lid">
                            <div class="pot-knob"></div>
                        </div>
                        <div class="pot-body">
                            <div class="pot-handle left"></div>
                            <div class="pot-handle right"></div>
                        </div>
                    </div>
                    <div class="loading-text">Рататуй</div>
                    <div class="loading-subtitle">${message || 'Готуємо для вас щось особливе...'}</div>
                    <div class="progress-container">
                        <div class="progress-bar"></div>
                    </div>
                </div>
            `;
            jQuery('body').prepend(loadingHTML);
        }
    },
    
    hide: function() {
        const $loader = jQuery('#ratatouille-loader');
        if ($loader.length) {
            $loader.addClass('fade-out');
            setTimeout(function() {
                $loader.remove();
                jQuery('body').removeClass('loading');
            }, 800);
        }
    },
    
    updateMessage: function(message) {
        jQuery('#ratatouille-loader .loading-subtitle').text(message);
    }
};