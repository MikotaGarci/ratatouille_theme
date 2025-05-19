/**
 * Основні JavaScript функції для теми "Рататуй"
 */

(function($) {
    'use strict';

    // Ініціалізація після завантаження DOM
    $(document).ready(function() {
        // Фіксована шапка при прокрутці
        handleStickyHeader();
        
        // Мобільне меню
        handleMobileMenu();
        
        // Анімація елементів при скролі
        initScrollAnimations();
        
        // Галерея lightbox
        initLightbox();
        
        // Слайдер відгуків
        initTestimonialSlider();
        
        // Слайдер спеціальних пропозицій
        initSpecialtiesSlider();
        
        // Показ/приховання складу страв
        initIngredientsToggle();
        
        // Активація табів меню
        initMenuTabs();
        
        // Валідація та відправка форми бронювання
        initReservationForm();
        
        // Датапікер для вибору дати
        initDatepicker();
    });

    // Функція для фіксованої шапки
    function handleStickyHeader() {
        var header = $('.site-header');
        var headerHeight = header.outerHeight();
        var scrollPosition = $(window).scrollTop();
        
        // Встановлення початкового стану
        if (scrollPosition > 200) {
            header.addClass('scrolled');
        } else {
            header.removeClass('scrolled');
        }
        
        // Обробка скролу
        $(window).scroll(function() {
            scrollPosition = $(window).scrollTop();
            
            if (scrollPosition > 200) {
                header.addClass('scrolled');
            } else {
                header.removeClass('scrolled');
            }
        });
    }

    // Функція для мобільного меню
    function handleMobileMenu() {
        var menuToggle = $('.menu-toggle');
        var mainNavigation = $('.main-navigation');
        
        menuToggle.on('click', function() {
            mainNavigation.toggleClass('active');
            $(this).attr('aria-expanded', mainNavigation.hasClass('active'));
        });
        
        // Закриття меню при кліку поза ним
        $(document).on('click', function(event) {
            if (!$(event.target).closest('.main-navigation, .menu-toggle').length) {
                mainNavigation.removeClass('active');
                menuToggle.attr('aria-expanded', 'false');
            }
        });
    }
  

    

    // Initialize when document is ready
    $(document).ready(function() {
        initGallery();
    });


 document.addEventListener('DOMContentLoaded', function() {
    const fadeElements = document.querySelectorAll('.fade-in-up');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const delay = entry.target.getAttribute('data-delay') || 0;
                setTimeout(() => {
                    entry.target.classList.add('visible');
                }, delay);
            }
        });
    });
    
    fadeElements.forEach(element => {
        observer.observe(element);
    });
 });
    // Функція для анімації елементів при скролі
    function initScrollAnimations() {
        // Підготовка всіх елементів з класом fade-in-up
        $('.fade-in-up').each(function() {
            var element = $(this);
            var delay = element.data('delay') || 0;
            
            element.css({
                'opacity': 0,
                'transform': 'translateY(30px)',
                'transition': 'opacity 0.8s ease, transform 0.8s ease',
                'transition-delay': delay + 'ms'
            });
        });
        
        // Функція для перевірки видимості елемента на екрані
        function isElementInViewport(el) {
            var rect = el.getBoundingClientRect();
            return (
                rect.top <= window.innerHeight * 0.8 &&
                rect.bottom >= 0
            );
        }
        
        // Функція для анімації видимих елементів
        function animateElements() {
            $('.fade-in-up').each(function() {
                if (isElementInViewport(this) && $(this).css('opacity') === '0') {
                    $(this).css({
                        'opacity': 1,
                        'transform': 'translateY(0)'
                    });
                }
            });
        }
        document.addEventListener('DOMContentLoaded', function() {
    // Universal function to toggle ingredients visibility
    function toggleIngredients(button) {
        const content = button.nextElementSibling;
        
        if (content.style.display === 'none' || !content.style.display) {
            content.style.display = 'block';
            button.textContent = 'Приховати склад';
        } else {
            content.style.display = 'none';
            button.textContent = 'Показати склад';
        }
    }
    
    // Attach click event to all ingredients buttons
    const ingredientButtons = document.querySelectorAll('.ingredients-btn');
    
    ingredientButtons.forEach(button => {
        button.addEventListener('click', function() {
            // If the button has data-dish attribute, it uses the old approach
            const dishId = this.getAttribute('data-dish');
            
            if (dishId) {
                // Original approach for buttons with data-dish attribute
                const ingredientsContent = document.getElementById(dishId);
                
                if (ingredientsContent.style.display === 'none' || !ingredientsContent.style.display) {
                    ingredientsContent.style.display = 'block';
                    this.textContent = 'Приховати склад';
                } else {
                    ingredientsContent.style.display = 'none';
                    this.textContent = 'Показати склад';
                }
            } else {
                // New approach for buttons without data-dish (direct nextElementSibling)
                toggleIngredients(this);
            }
        });
    });
    
    // Make the global toggleIngredients function available
    window.toggleIngredients = toggleIngredients;
});
        // Запуск анімації при завантаженні сторінки та при скролі
        animateElements();
        $(window).on('scroll', animateElements);
    }

   

    // Функція для слайдера відгуків
    function initTestimonialSlider() {
        var testimonialSlider = $('.testimonials-slider');
        
        if (testimonialSlider.length === 0) return;
        
        // Індикатор поточного слайда
        var currentSlide = 0;
        var totalSlides = $('.testimonial-item').length;
        
        // Додавання індикаторів
        var indicators = $('<div class="slider-indicators"></div>');
        testimonialSlider.append(indicators);
        
        for (var i = 0; i < totalSlides; i++) {
            indicators.append('<button class="indicator' + (i === 0 ? ' active' : '') + '" data-slide="' + i + '"></button>');
        }
        
        // Функція для перемикання слайдів
        function goToSlide(index) {
            if (index < 0) index = totalSlides - 1;
            if (index >= totalSlides) index = 0;
            
            $('.testimonial-item').removeClass('active');
            $('.testimonial-item').eq(index).addClass('active');
            $('.indicator').removeClass('active');
            $('.indicator').eq(index).addClass('active');
            
            currentSlide = index;
        }
        
        // Ініціалізація першого слайду
        $('.testimonial-item').first().addClass('active');
        
        // Кнопки для перемикання
        $('.indicator').on('click', function() {
            goToSlide($(this).data('slide'));
        });
        
        // Автоматичне перемикання слайдів
        setInterval(function() {
            goToSlide(currentSlide + 1);
        }, 5000);
    }

    // Функція для слайдера спеціальних пропозицій
    function initSpecialtiesSlider() {
        var specialtiesSlider = $('.specialties-slider');
        
        if (specialtiesSlider.length === 0) return;
        
        // Індикатор поточного слайда
        var currentSlide = 0;
        var totalSlides = $('.specialty-item').length;
        
        // Додавання індикаторів
        var indicators = $('<div class="slider-indicators"></div>');
        specialtiesSlider.append(indicators);
        
        for (var i = 0; i < totalSlides; i++) {
            indicators.append('<button class="indicator' + (i === 0 ? ' active' : '') + '" data-slide="' + i + '"></button>');
        }
        
        // Функція для перемикання слайдів
        function goToSlide(index) {
            if (index < 0) index = totalSlides - 1;
            if (index >= totalSlides) index = 0;
            
            $('.specialty-item').removeClass('active');
            $('.specialty-item').eq(index).addClass('active');
            $('.indicator').removeClass('active');
            $('.indicator').eq(index).addClass('active');
            
            currentSlide = index;
        }
        
        // Ініціалізація першого слайду
        $('.specialty-item').first().addClass('active');
        
        // Кнопки для перемикання
        $('.indicator').on('click', function() {
            goToSlide($(this).data('slide'));
        });
        
        // Автоматичне перемикання слайдів
        setInterval(function() {
            goToSlide(currentSlide + 1);
        }, 5000);
    }

    // Функція для показу/приховання складу страв
    function initIngredientsToggle() {
        $('.ingredients-btn').on('click', function() {
            var ingredientsContent = $(this).next('.ingredients-content');
            ingredientsContent.toggleClass('show');
            
            // Зміна тексту кнопки
            if (ingredientsContent.hasClass('show')) {
                $(this).text('Приховати склад');
            } else {
                $(this).text('Показати склад');
            }
        });
    }

    // Функція для активації табів меню
    function initMenuTabs() {
        var menuTabs = $('.menu-tabs');
        
        if (menuTabs.length === 0) return;
        
        $('.menu-tabs-nav a').on('click', function(e) {
            e.preventDefault();
            
            var tabId = $(this).attr('href');
            
            // Зміна активного стану вкладок
            $('.menu-tabs-nav li').removeClass('active');
            $(this).parent().addClass('active');
            
            // Зміна активного стану контенту
            $('.menu-tab').removeClass('active');
            $(tabId).addClass('active');
        });
    }

    // Функція для валідації та відправки форми бронювання
    function initReservationForm() {
        var reservationForm = $('#reservation-form');
        
        if (reservationForm.length === 0) return;
        
        reservationForm.on('submit', function(e) {
            e.preventDefault();
            
            var formData = $(this).serialize();
            var formMessage = $('.form-message');
            
            // Показ повідомлення про завантаження
            formMessage.html('<span class="loader"></span> Надсилання...');
            
            // Імітація AJAX запиту
            setTimeout(function() {
                formMessage.html('<div class="success-message">Дякуємо! Ваше бронювання успішно надіслано. Ми зв\'яжемося з вами для підтвердження.</div>');
                reservationForm[0].reset();
            }, 1500);
        });
    }

    // Функція для ініціалізації датапікера
    function initDatepicker() {
        // Перевірка наявності jQuery UI Datepicker
        if ($.ui && $.ui.datepicker) {
            $('.datepicker').datepicker({
                dateFormat: 'dd.mm.yy',
                minDate: 0,
                firstDay: 1,
                monthNames: ['Січень', 'Лютий', 'Березень', 'Квітень', 'Травень', 'Червень', 'Липень', 'Серпень', 'Вересень', 'Жовтень', 'Листопад', 'Грудень'],
                monthNamesShort: ['Січ', 'Лют', 'Бер', 'Кві', 'Тра', 'Чер', 'Лип', 'Сер', 'Вер', 'Жов', 'Лис', 'Гру'],
                dayNames: ['Неділя', 'Понеділок', 'Вівторок', 'Середа', 'Четвер', 'П\'ятниця', 'Субота'],
                dayNamesShort: ['Нд', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
                dayNamesMin: ['Нд', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб']
            });
        }
    }

})(jQuery);