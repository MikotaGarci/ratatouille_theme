jQuery(document).ready(function($) {
    console.log('Special offers script loaded');
    
    // Спеціальна логіка для сторінки спеціальних пропозицій
    
    // Анімація появи елементів
    function animateElements() {
        $('.fade-in-up').each(function(index) {
            const $element = $(this);
            const delay = $element.data('delay') || (index * 200);
            
            setTimeout(function() {
                $element.addClass('visible');
            }, delay);
        });
    }

    // Ініціалізуємо анімації
    animateElements();

    // Обробка кнопок інгредієнтів для спеціальних пропозицій
    $('.ingredients-btn').on('click', function(e) {
        e.preventDefault();
        console.log('Ingredients button clicked');
        
        const $button = $(this);
        const dishId = $button.attr('data-dish');
        const $ingredientsContent = $('#' + dishId);
        
        console.log('Dish ID:', dishId);
        console.log('Ingredients content found:', $ingredientsContent.length);
        
        if ($ingredientsContent.length > 0) {
            if ($ingredientsContent.hasClass('active')) {
                // Приховуємо інгредієнти
                $ingredientsContent.removeClass('active');
                $button.text('Показати склад');
                console.log('Hiding ingredients');
            } else {
                // Показуємо інгредієнти
                $ingredientsContent.addClass('active');
                $button.text('Приховати склад');
                console.log('Showing ingredients');
                
                // Додаємо анімацію для інгредієнтів
                $ingredientsContent.find('.ingredient-item').each(function(index) {
                    $(this).css('animation-delay', (index * 0.1) + 's');
                });
            }
        } else {
            console.log('Ingredients content not found for dish:', dishId);
        }
    });

    // Smooth scroll для навігації
    $('a[href^="#"]').on('click', function(e) {
        const target = $(this.getAttribute('href'));
        if (target.length) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: target.offset().top - 100
            }, 800);
        }
    });

    // Додаткова анімація для карточок
    function addCardAnimations() {
        $('.menu-item').each(function(index) {
            $(this).css({
                'animation-delay': (index * 0.1) + 's'
            });
        });
    }

    addCardAnimations();

    // Hover ефекти для карточок
    $('.menu-item').hover(
        function() {
            $(this).addClass('hovered');
        },
        function() {
            $(this).removeClass('hovered');
        }
    );

    console.log('Special offers script initialization complete');
});