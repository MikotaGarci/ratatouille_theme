jQuery(document).ready(function($) {
    // Функція для перемикання відображення інгредієнтів
    function toggleIngredients(button) {
        const content = $(button).next('.ingredients-content');
        
        if (content.hasClass('active')) {
            content.removeClass('active');
            $(button).text('Показати склад');
        } else {
            content.addClass('active');
            $(button).text('Приховати склад');
        }
    }

    // Додаємо обробник для всіх кнопок інгредієнтів
    $('.ingredients-btn').on('click', function() {
        toggleIngredients(this);
    });

    // Робимо функцію доступною глобально
    window.toggleIngredients = toggleIngredients;
});
