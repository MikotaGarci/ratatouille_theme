<?php
/**
 * Template Name: Testimonials Page
 */

get_header(); ?>

<main id="main" class="site-main">
    <section class="testimonials-page">
        <div class="container">
            <h1 class="page-title"><?php the_title(); ?></h1>
            
            <!-- Форма для додавання відгуку -->
            <div class="testimonial-form-section">
                <h2><?php esc_html_e('Залишити відгук', 'ratatouille'); ?></h2>
                <form id="testimonial-form" class="testimonial-form">
                    <?php wp_nonce_field('testimonial_nonce', 'testimonial_nonce'); ?>
                    
                    <div class="form-group">
                        <label for="customer_name"><?php esc_html_e('Ваше ім\'я', 'ratatouille'); ?> *</label>
                        <input type="text" id="customer_name" name="customer_name" class="form-control" required>
                        <div class="field-error" id="name-error" style="display: none;"></div>
                    </div>
                    
                    <div class="form-group">
                        <label for="customer_phone"><?php esc_html_e('Номер телефону', 'ratatouille'); ?> *</label>
                        <input type="tel" id="customer_phone" name="customer_phone" class="form-control" required 
                               placeholder="+38 (XXX) XXX-XX-XX">
                        <div class="field-error" id="phone-error" style="display: none;"></div>
                        <small class="help-text"><?php esc_html_e('Формат: +38 (XXX) XXX-XX-XX', 'ratatouille'); ?></small>
                    </div>
                    
                    <div class="form-group">
                        <label for="customer_email"><?php esc_html_e('Email', 'ratatouille'); ?> *</label>
                        <input type="email" id="customer_email" name="customer_email" class="form-control" required
                               placeholder="example@email.com">
                        <div class="field-error" id="email-error" style="display: none;"></div>
                        <small class="help-text"><?php esc_html_e('Формат: example@email.com', 'ratatouille'); ?></small>
                    </div>
                    
                    <div class="form-group">
                        <label for="rating"><?php esc_html_e('Оцінка', 'ratatouille'); ?> *</label>
                        <div class="rating-input">
                            <input type="hidden" id="rating" name="rating" value="" required>
                            <div class="stars-input">
                                <i class="far fa-star" data-rating="1"></i>
                                <i class="far fa-star" data-rating="2"></i>
                                <i class="far fa-star" data-rating="3"></i>
                                <i class="far fa-star" data-rating="4"></i>
                                <i class="far fa-star" data-rating="5"></i>
                            </div>
                            <span class="rating-text"><?php esc_html_e('Оберіть оцінку', 'ratatouille'); ?></span>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="testimonial_text"><?php esc_html_e('Ваш відгук', 'ratatouille'); ?> *</label>
                        <textarea id="testimonial_text" name="testimonial_text" class="form-control" rows="5" required></textarea>
                        <div class="field-error" id="text-error" style="display: none;"></div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary" id="submit-testimonial-btn" disabled>
                        <?php esc_html_e('Відправити відгук', 'ratatouille'); ?>
                    </button>
                    <div class="form-message"></div>
                </form>
            </div>

            <!-- Відображення схвалених відгуків -->
            <div class="testimonials-display">
                <h2><?php esc_html_e('Відгуки наших клієнтів', 'ratatouille'); ?></h2>
                
                <?php
                $testimonials = new WP_Query(array(
                    'post_type' => 'testimonial',
                    'posts_per_page' => -1,
                    'meta_query' => array(
                        array(
                            'key' => 'testimonial_status',
                            'value' => 'approved',
                            'compare' => '='
                        )
                    ),
                    'orderby' => 'date',
                    'order' => 'DESC'
                ));

                if ($testimonials->have_posts()) : ?>
                    <div class="testimonials-slider-wrapper">
                        <div class="testimonials-slider">
                            <?php while ($testimonials->have_posts()) : $testimonials->the_post();
                                $name = get_field('testimonial_name');
                                $rating = get_field('testimonial_rating');
                                $text = get_field('testimonial_text');
                                $date = get_field('testimonial_date');
                            ?>
                                <div class="testimonial-slide">
                                    <div class="testimonial-content">
                                        <div class="testimonial-stars">
                                            <?php for ($i = 1; $i <= 5; $i++) : ?>
                                                <i class="fas fa-star <?php echo $i <= $rating ? 'active' : ''; ?>"></i>
                                            <?php endfor; ?>
                                        </div>
                                        <div class="testimonial-text">
                                            "<?php echo esc_html($text); ?>"
                                        </div>
                                        <div class="testimonial-author">
                                            <div class="author-name"><?php echo esc_html($name); ?></div>
                                            <div class="testimonial-date"><?php echo esc_html($date); ?></div>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                <?php else : ?>
                    <p class="no-testimonials"><?php esc_html_e('Поки що відгуків немає. Будьте першим!', 'ratatouille'); ?></p>
                <?php endif; 
                wp_reset_postdata(); ?>
            </div>
        </div>
    </section>
</main>

<style>
/* Testimonials Page Styles */
.testimonials-page {
    padding: 80px 0;
    background-color: var(--secondary);
    overflow-x: hidden;
}

.testimonial-form-section {
    background: var(--white);
    padding: 40px;
    border-radius: 15px;
    margin-bottom: 60px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.testimonial-form-section h2 {
    margin-bottom: 30px;
    color: var(--primary);
    text-align: center;
}

.form-group {
    margin-bottom: 25px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: var(--primary);
}

.form-control {
    width: 100%;
    padding: 12px 15px;
    border: 2px solid #e1e5e9;
    border-radius: 8px;
    font-size: 16px;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: var(--accent);
    outline: none;
    box-shadow: 0 0 0 3px rgba(230, 126, 34, 0.1);
}

.form-control.error {
    border-color: #e74c3c;
    background-color: #fdf2f2;
}

.form-control.valid {
    border-color: #27ae60;
    background-color: #f0f9f4;
}

.field-error {
    color: #e74c3c;
    font-size: 14px;
    margin-top: 5px;
    font-weight: 500;
}

.help-text {
    font-size: 14px;
    color: #666;
    margin-top: 5px;
}

.rating-input {
    margin-top: 10px;
}

.stars-input {
    display: flex;
    gap: 5px;
    margin-bottom: 10px;
}

.stars-input i {
    font-size: 24px;
    color: #ddd;
    cursor: pointer;
    transition: all 0.3s ease;
}

.stars-input i:hover {
    color: #ffd700;
    transform: scale(1.1);
}

.stars-input i.active {
    color: #ffd700;
}

.rating-text {
    font-size: 14px;
    color: #666;
    font-style: italic;
}

.testimonials-display h2 {
    text-align: center;
    margin-bottom: 40px;
    color: var(--primary);
}

/* Слайдер відгуків */
.testimonials-slider-wrapper {
    position: relative;
    max-width: 900px;
    margin: 0 auto;
    overflow: hidden;
}

.testimonials-slider {
    position: relative;
}

.testimonial-slide {
    padding: 20px;
    outline: none;
}

.testimonial-content {
    background: var(--white);
    padding: 40px;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    text-align: center;
    margin: 0 10px;
}

.testimonial-stars {
    margin-bottom: 20px;
}

.testimonial-stars i {
    color: #ddd;
    font-size: 20px;
    margin: 0 2px;
}

.testimonial-stars i.active {
    color: #ffd700;
}

.testimonial-text {
    font-size: 18px;
    line-height: 1.6;
    margin-bottom: 25px;
    color: var(--text);
    font-style: italic;
}

.testimonial-author {
    border-top: 1px solid #eee;
    padding-top: 20px;
}

.author-name {
    font-size: 18px;
    font-weight: 600;
    color: var(--primary);
    margin-bottom: 5px;
}

.testimonial-date {
    font-size: 14px;
    color: var(--gray);
}

/* Стилі для Slick слайдера */
.slick-dots {
    position: relative;
    bottom: 0;
    margin-top: 30px;
    text-align: center;
    list-style: none;
    padding: 0;
}

.slick-dots li {
    display: inline-block;
    margin: 0 5px;
}

.slick-dots li button {
    font-size: 0;
    width: 12px;
    height: 12px;
    background: #ddd;
    border: none;
    border-radius: 50%;
    cursor: pointer;
    transition: all 0.3s ease;
}

.slick-dots li.slick-active button {
    background: var(--accent);
    transform: scale(1.2);
}

.slick-prev,
.slick-next {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    z-index: 10;
    width: 50px;
    height: 50px;
    background: rgba(230, 126, 34, 0.9);
    border: none;
    border-radius: 50%;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 0;
}

.slick-prev:hover,
.slick-next:hover {
    background: var(--accent);
    transform: translateY(-50%) scale(1.1);
}

.slick-prev {
    left: -25px;
}

.slick-next {
    right: -25px;
}

.slick-prev:before,
.slick-next:before {
    font-family: 'Font Awesome 5 Free';
    font-weight: 900;
    font-size: 18px;
    color: white;
    line-height: 1;
}

.slick-prev:before {
    content: '\f104';
}

.slick-next:before {
    content: '\f105';
}

.form-message {
    margin-top: 20px;
    padding: 15px;
    border-radius: 8px;
    display: none;
}

.form-message.success {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
    display: block;
}

.form-message.error {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
    display: block;
}

.no-testimonials {
    text-align: center;
    font-size: 18px;
    color: var(--gray);
    padding: 40px;
    background: var(--white);
    border-radius: 15px;
}

.btn:disabled {
    background-color: #6c757d;
    border-color: #6c757d;
    cursor: not-allowed;
    opacity: 0.65;
}

/* Адаптивність */
@media (max-width: 768px) {
    .testimonial-form-section {
        padding: 30px 20px;
    }
    
    .testimonial-content {
        padding: 30px 20px;
        margin: 0 5px;
    }
    
    .testimonial-text {
        font-size: 16px;
    }
    
    .slick-prev {
        left: -15px;
    }
    
    .slick-next {
        right: -15px;
    }
    
    .slick-prev,
    .slick-next {
        width: 40px;
        height: 40px;
    }
    
    .slick-prev:before,
    .slick-next:before {
        font-size: 14px;
    }
}

@media (max-width: 480px) {
    .slick-prev,
    .slick-next {
        display: none !important;
    }
    
    .testimonial-content {
        margin: 0;
    }
}
</style>

<script>
jQuery(document).ready(function($) {
    var selectedRating = 0;
    
    // Validation patterns
    const phonePattern = /^\+38\s?\(\d{3}\)\s?\d{3}-\d{2}-\d{2}$/;
    const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    
    // Phone number formatting - IMPROVED VERSION
    $('#customer_phone').on('input', function() {
        let value = $(this).val();
        
        // Remove all non-digits
        let digits = value.replace(/\D/g, '');
        
        // If starts with 38, remove it (we'll add +38 prefix)
        if (digits.startsWith('38')) {
            digits = digits.substring(2);
        }
        
        // Limit to 10 digits
        if (digits.length > 10) {
            digits = digits.substring(0, 10);
        }
        
        // Format the number
        let formatted = '+38';
        if (digits.length > 0) {
            formatted += ' (' + digits.substring(0, 3);
            if (digits.length >= 3) {
                formatted += ')';
                if (digits.length > 3) {
                    formatted += ' ' + digits.substring(3, 6);
                    if (digits.length > 6) {
                        formatted += '-' + digits.substring(6, 8);
                        if (digits.length > 8) {
                            formatted += '-' + digits.substring(8, 10);
                        }
                    }
                }
            }
        }
        
        $(this).val(formatted);
        validatePhone();
    });

    // Handle backspace and delete keys properly
    $('#customer_phone').on('keydown', function(e) {
        const value = $(this).val();
        const cursorPos = this.selectionStart;
        
        // Allow backspace and delete, but handle formatting
        if (e.key === 'Backspace' || e.key === 'Delete') {
            // If trying to delete the +38 prefix, prevent it
            if (cursorPos <= 3 && e.key === 'Backspace') {
                e.preventDefault();
                return;
            }
        }
    });

    // Set initial value
    if ($('#customer_phone').val() === '') {
        $('#customer_phone').val('+38');
    }

    // Real-time validation functions
    function validatePhone() {
        const phone = $('#customer_phone').val();
        const $phoneField = $('#customer_phone');
        const $phoneError = $('#phone-error');
        
        if (phone === '+38' || phone === '') {
            $phoneField.removeClass('error valid');
            $phoneError.hide();
            return false;
        }
        
        // Check if phone has at least 10 digits after +38
        const digits = phone.replace(/\D/g, '').substring(2); // Remove +38
        
        if (digits.length === 10 && phonePattern.test(phone)) {
            $phoneField.removeClass('error').addClass('valid');
            $phoneError.hide();
            return true;
        } else {
            $phoneField.removeClass('valid').addClass('error');
            if (digits.length < 10) {
                $phoneError.text('Номер телефону неповний. Потрібно 10 цифр після +38').show();
            } else {
                $phoneError.text('Невірний формат номера. Використовуйте: +38 (XXX) XXX-XX-XX').show();
            }
            return false;
        }
    }

    function validateEmail() {
        const email = $('#customer_email').val();
        const $emailField = $('#customer_email');
        const $emailError = $('#email-error');
        
        if (email === '') {
            $emailField.removeClass('error valid');
            $emailError.hide();
            return false;
        }
        
        if (emailPattern.test(email)) {
            $emailField.removeClass('error').addClass('valid');
            $emailError.hide();
            return true;
        } else {
            $emailField.removeClass('valid').addClass('error');
            $emailError.text('Невірний формат email. Використовуйте: example@email.com').show();
            return false;
        }
    }

    function validateName() {
        const name = $('#customer_name').val().trim();
        const $nameField = $('#customer_name');
        const $nameError = $('#name-error');
        
        if (name === '') {
            $nameField.removeClass('error valid');
            $nameError.hide();
            return false;
        }
        
        if (name.length >= 2 && /^[a-zA-Zа-яА-ЯіІїЇєЄ\s]+$/.test(name)) {
            $nameField.removeClass('error').addClass('valid');
            $nameError.hide();
            return true;
        } else {
            $nameField.removeClass('valid').addClass('error');
            $nameError.text('Ім\'я повинно містити мінімум 2 символи і тільки літери').show();
            return false;
        }
    }

    function validateText() {
        const text = $('#testimonial_text').val().trim();
        const $textField = $('#testimonial_text');
        const $textError = $('#text-error');
        
        if (text === '') {
            $textField.removeClass('error valid');
            $textError.hide();
            return false;
        }
        
        if (text.length >= 10) {
            $textField.removeClass('error').addClass('valid');
            $textError.hide();
            return true;
        } else {
            $textField.removeClass('valid').addClass('error');
            $textError.text('Відгук повинен містити мінімум 10 символів').show();
            return false;
        }
    }

    function checkSubmitButtonState() {
        const validPhone = validatePhone();
        const validEmail = validateEmail();
        const validName = validateName();
        const validText = validateText();
        const hasRating = selectedRating > 0;
        
        const allValid = validPhone && validEmail && validName && validText && hasRating;
        
        $('#submit-testimonial-btn').prop('disabled', !allValid);
    }

    // Bind validation events
    $('#customer_phone').on('blur', validatePhone);
    $('#customer_email').on('blur', validateEmail);
    $('#customer_name').on('blur', validateName);
    $('#testimonial_text').on('blur', validateText);
    
    // Bind validation events to check submit button state
    $('#customer_name, #customer_phone, #customer_email, #testimonial_text').on('input blur', checkSubmitButtonState);
    
    // Rating stars functionality
    $('.stars-input i').on('click', function() {
        selectedRating = $(this).data('rating');
        $('#rating').val(selectedRating);
        
        // Update stars display
        $('.stars-input i').removeClass('active').removeClass('fas').addClass('far');
        for (var i = 1; i <= selectedRating; i++) {
            $('.stars-input i[data-rating="' + i + '"]').addClass('active').removeClass('far').addClass('fas');
        }
        
        // Update rating text
        var ratingTexts = {
            1: 'Погано',
            2: 'Незадовільно', 
            3: 'Нормально',
            4: 'Добре',
            5: 'Відмінно'
        };
        $('.rating-text').text(ratingTexts[selectedRating] || 'Оберіть оцінку');
        
        checkSubmitButtonState();
    });

    // Hover effect for stars
    $('.stars-input i').on('mouseenter', function() {
        var hoverRating = $(this).data('rating');
        $('.stars-input i').removeClass('hover').removeClass('fas').addClass('far');
        for (var i = 1; i <= hoverRating; i++) {
            $('.stars-input i[data-rating="' + i + '"]').addClass('hover').removeClass('far').addClass('fas');
        }
    });

    $('.stars-input').on('mouseleave', function() {
        $('.stars-input i').removeClass('hover').removeClass('fas').addClass('far');
        // Restore selected rating
        for (var i = 1; i <= selectedRating; i++) {
            $('.stars-input i[data-rating="' + i + '"]').addClass('active').removeClass('far').addClass('fas');
        }
    });

    // Form submission
    $('#testimonial-form').on('submit', function(e) {
        e.preventDefault();
        
        // Final validation
        if (!validateName()) {
            $('.form-message').removeClass('success error').addClass('error')
                   .text('Будь ласка, введіть коректне ім\'я').show();
            return;
        }
        
        if (!validatePhone()) {
            $('.form-message').removeClass('success error').addClass('error')
                   .text('Будь ласка, введіть повний номер телефону у форматі +38 (XXX) XXX-XX-XX').show();
            return;
        }
        
        if (!validateEmail()) {
            $('.form-message').removeClass('success error').addClass('error')
                   .text('Будь ласка, введіть коректний email').show();
            return;
        }
        
        if (!validateText()) {
            $('.form-message').removeClass('success error').addClass('error')
                   .text('Відгук повинен містити мінімум 10 символів').show();
            return;
        }
        
        // Check if rating is selected
        if (selectedRating === 0) {
            $('.form-message').removeClass('success error').addClass('error')
                .text('Будь ласка, оберіть оцінку').show();
            return;
        }
        
        var $form = $(this);
        var $submitButton = $form.find('button[type="submit"]');
        var $message = $form.find('.form-message');
        
        $submitButton.prop('disabled', true).text('Відправка...');
        $message.hide().removeClass('success error');
        
        $.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: {
                action: 'submit_testimonial',
                nonce: $('#testimonial_nonce').val(),
                customer_name: $('#customer_name').val(),
                customer_phone: $('#customer_phone').val(),
                customer_email: $('#customer_email').val(),
                rating: selectedRating,
                testimonial_text: $('#testimonial_text').val()
            },
            success: function(response) {
                if (response.success) {
                    $message.addClass('success').text(response.data).show();
                    $form[0].reset();
                    selectedRating = 0;
                    $('#rating').val('');
                    $('.stars-input i').removeClass('active fas').addClass('far');
                    $('.rating-text').text('Оберіть оцінку');
                    $('.form-control').removeClass('valid error');
                    $('.field-error').hide();
                    $('#submit-testimonial-btn').prop('disabled', true);
                    $('#customer_phone').val('+38'); // Reset phone with prefix
                } else {
                    $message.addClass('error').text(response.data).show();
                }
            },
            error: function() {
                $message.addClass('error').text('Помилка при відправці. Спробуйте ще раз.').show();
            },
            complete: function() {
                $submitButton.prop('disabled', false).text('<?php esc_html_e('Відправити відгук', 'ratatouille'); ?>');
            }
        });
    });
    // Initialize testimonials slider
    if ($('.testimonials-slider').length && $('.testimonials-slider .testimonial-slide').length > 0) {
        $('.testimonials-slider').slick({
            dots: true,
            infinite: true,
            speed: 500,
            fade: true,
            cssEase: 'linear',
            autoplay: true,
            autoplaySpeed: 5000,
            arrows: true,
            adaptiveHeight: true,
            prevArrow: '<button type="button" class="slick-prev"></button>',
            nextArrow: '<button type="button" class="slick-next"></button>',
            responsive: [
                {
                    breakpoint: 768,
                    settings: {
                        arrows: true,
                        dots: true
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        arrows: false,
                        dots: true
                    }
                }
            ]
        });
    }
    
    // Initial state - disable submit button
    $('#submit-testimonial-btn').prop('disabled', true);
});
</script>

<?php get_footer(); ?>