jQuery(document).ready(function($) {
    // Скрываем детали по умолчанию
    $('.dish-details').hide();
    
    // Обработчик кнопки "Показать детали"
    $('.toggle-details').on('click', function() {
        $('.dish-details').slideToggle(300);
        
        // Меняем текст кнопки
        if ($('.dish-details').is(':visible')) {
            $(this).text(ratatouille_vars.hide_details);
        } else {
            $(this).text(ratatouille_vars.show_details);
        }
    });
});