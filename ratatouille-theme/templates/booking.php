<?php
/**
 * Template Name: Restaurant Booking Page
 */

get_header(); ?>

<main id="main" class="site-main">
    <div class="restaurant-layout">
          <!-- Блок для відображення обраних столиків -->
        <div class="selected-tables-info" style="display: none;">
            <h3><?php esc_html_e('Обрані столики:', 'ratatouille'); ?></h3>
            <div class="selected-tables-list"></div>
            <div class="total-seats-info">
                <strong><?php esc_html_e('Загальна кількість місць:', 'ratatouille'); ?> <span id="total-seats">0</span></strong>
            </div>
            <div class="seats-validation-info" style="display: none;">
                <div class="validation-message"></div>
            </div>
        </div>

        <form id="reservation-form" class="reservation-form">
            <?php wp_nonce_field('reservation_nonce', 'reservation_nonce'); ?>
            
            <h3><?php esc_html_e('Форма бронювання', 'ratatouille'); ?></h3>
            
            <!-- Перевірка віку -->
            <div class="age-verification">
                <label class="age-checkbox">
                    <input type="checkbox" id="age_confirmation" name="age_confirmation" required>
                    <span class="checkmark"></span>
                    <?php esc_html_e('Підтверджую, що мені виповнилося 18 років', 'ratatouille'); ?> *
                </label>
                <div class="age-error" style="display: none;">
                    <?php esc_html_e('Для бронювання столика необхідно бути повнолітнім (18+)', 'ratatouille'); ?>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="name"><?php esc_html_e('Ім\'я *', 'ratatouille'); ?></label>
                    <input type="text" id="name" name="name" class="form-control" required>
                    <div class="field-error" id="name-error" style="display: none;"></div>
                </div>
                
                <div class="form-group">
                    <label for="phone"><?php esc_html_e('Телефон *', 'ratatouille'); ?></label>
                    <input type="tel" id="phone" name="phone" class="form-control" required 
                           placeholder="+38 (XXX) XXX-XX-XX">
                    <div class="field-error" id="phone-error" style="display: none;"></div>
                    <small class="help-text"><?php esc_html_e('Формат: +38 (XXX) XXX-XX-XX', 'ratatouille'); ?></small>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="email"><?php esc_html_e('Email *', 'ratatouille'); ?></label>
                    <input type="email" id="email" name="email" class="form-control" required
                           placeholder="example@email.com">
                    <div class="field-error" id="email-error" style="display: none;"></div>
                    <small class="help-text"><?php esc_html_e('Формат: example@email.com', 'ratatouille'); ?></small>
                </div>
                
                <div class="form-group">
                    <label for="guests"><?php esc_html_e('Кількість гостей *', 'ratatouille'); ?></label>
                    <select id="guests" name="guests" class="form-control" required>
                        <option value=""><?php esc_html_e('Оберіть кількість', 'ratatouille'); ?></option>
                        <?php
                        for ($i = 1; $i <= 50; $i++) {
                            echo '<option value="' . esc_attr($i) . '">' . esc_html($i) . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="date"><?php esc_html_e('Дата *', 'ratatouille'); ?></label>
                    <input type="date" id="date" name="date" class="form-control" required min="<?php echo date('Y-m-d'); ?>">
                </div>
                
                <div class="form-group">
                    <label for="time"><?php esc_html_e('Час *', 'ratatouille'); ?></label>
                    <select id="time" name="time" class="form-control" required>
                        <option value=""><?php esc_html_e('Оберіть час', 'ratatouille'); ?></option>
                        <?php
                        $times = array('12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00', '21:00');
                        foreach ($times as $time) {
                            echo '<option value="' . esc_attr($time) . '">' . esc_html($time) . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="table_numbers"><?php esc_html_e('Номери столиків *', 'ratatouille'); ?></label>
                <input type="text" id="table_numbers" name="table_numbers" class="form-control" required readonly>
                <small class="help-text"><?php esc_html_e('Оберіть столики на схемі нижче', 'ratatouille'); ?></small>
            </div>
            
            <div class="form-group">
                <label for="notes"><?php esc_html_e('Особливі побажання', 'ratatouille'); ?></label>
                <textarea id="notes" name="notes" class="form-control" rows="3" placeholder="<?php esc_attr_e('Наприклад: столики поруч, день народження, алергії тощо', 'ratatouille'); ?>"></textarea>
            </div>
            
            <button type="submit" class="btn btn-primary" id="submit-btn" disabled><?php esc_html_e('Забронювати столики', 'ratatouille'); ?></button>
            <div class="form-message"></div>
        </form>
        <h2 class="section-title"><?php esc_html_e('Бронювання столика', 'ratatouille'); ?></h2>
        
        <div class="halls-info">
            <div class="total-info">
                <span><?php esc_html_e('Всього столиків: 55', 'ratatouille'); ?></span>
                <span><?php esc_html_e('Всього місць: 220', 'ratatouille'); ?></span>
            </div>
        </div>

        <?php
        // Різна кількість місць для різних столиків
        $table_seats = array(
            // Головний зал (1-15) - 2-6 місць
            1 => 4, 2 => 2, 3 => 6, 4 => 4, 5 => 2, 6 => 4, 7 => 6, 8 => 4, 
            9 => 2, 10 => 4, 11 => 6, 12 => 4, 13 => 2, 14 => 4, 15 => 6,
            
            // VIP зал (16-25) - 4-8 місць
            16 => 6, 17 => 8, 18 => 4, 19 => 6, 20 => 8, 21 => 4, 22 => 6, 
            23 => 8, 24 => 4, 25 => 6,
            
            // Тераса (26-35) - 2-4 місця
            26 => 2, 27 => 4, 28 => 2, 29 => 4, 30 => 2, 31 => 4, 32 => 2, 
            33 => 4, 34 => 2, 35 => 4,
            
            // Лаунж зона (36-45) - 3-5 місць
            36 => 3, 37 => 5, 38 => 3, 39 => 5, 40 => 3, 41 => 5, 42 => 3, 
            43 => 5, 44 => 3, 45 => 5,
            
            // Барна зона (46-55) - 2-3 місця
            46 => 2, 47 => 3, 48 => 2, 49 => 3, 50 => 2, 51 => 3, 52 => 2, 
            53 => 3, 54 => 2, 55 => 3
        );

        $halls = array(
            'main' => array(
                'name' => 'Головний зал',
                'tables' => range(1, 15),
                'description' => 'Просторий зал з панорамними вікнами'
            ),
            'vip' => array(
                'name' => 'VIP зал',
                'tables' => range(16, 25),
                'description' => 'Окремий зал для особливих подій'
            ),
            'terrace' => array(
                'name' => 'Тераса',
                'tables' => range(26, 35),
                'description' => 'Відкрита тераса з видом на місто'
            ),
            'lounge' => array(
                'name' => 'Лаунж зона',
                'tables' => range(36, 45),
                'description' => 'Затишна зона з м\'якими диванами'
            ),
            'bar' => array(
                'name' => 'Барна зона',
                'tables' => range(46, 55),
                'description' => 'Зона біля бару з високими столиками'
            )
        );
        ?>

        <div class="halls-container">
            <?php foreach ($halls as $hall_id => $hall) : ?>
                <div class="hall-section" id="<?php echo esc_attr($hall_id); ?>">
                    <h3 class="hall-title"><?php echo esc_html($hall['name']); ?></h3>
                    <p class="hall-description"><?php echo esc_html($hall['description']); ?></p>
                    
                    <div class="tables-grid">
                        <?php foreach ($hall['tables'] as $table_number) : 
                            $seats = $table_seats[$table_number];
                        ?>
                            <div class="table-item" data-table="<?php echo esc_attr($table_number); ?>" data-seats="<?php echo esc_attr($seats); ?>">
                                <span class="table-number"><?php echo esc_html($table_number); ?></span>
                                <span class="table-seats"><?php echo esc_html($seats . ' місць'); ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

     
    </div>
</main>

<style>
.reservation-form {
    background: #fff;
    padding: 30px;
    border-radius: 10px;
    margin-top: 30px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}

.reservation-form h3 {
    margin-bottom: 25px;
    color: #2c3e50;
    text-align: center;
}

/* Age verification styles */
.age-verification {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 25px;
    border: 2px solid #e67e22;
}

.age-checkbox {
    display: flex;
    align-items: center;
    cursor: pointer;
    font-size: 16px;
    font-weight: 600;
    color: #2c3e50;
    position: relative;
    padding-left: 35px;
    margin-bottom: 0;
}

.age-checkbox input[type="checkbox"] {
    position: absolute;
    opacity: 0;
    cursor: pointer;
    height: 0;
    width: 0;
}

.checkmark {
    position: absolute;
    top: 0;
    left: 0;
    height: 25px;
    width: 25px;
    background-color: #fff;
    border: 2px solid #e67e22;
    border-radius: 4px;
    transition: all 0.3s ease;
}

.age-checkbox:hover input ~ .checkmark {
    background-color: #f8f9fa;
}

.age-checkbox input:checked ~ .checkmark {
    background-color: #e67e22;
    border-color: #e67e22;
}

.checkmark:after {
    content: "";
    position: absolute;
    display: none;
}

.age-checkbox input:checked ~ .checkmark:after {
    display: block;
}

.age-checkbox .checkmark:after {
    left: 8px;
    top: 4px;
    width: 6px;
    height: 12px;
    border: solid white;
    border-width: 0 3px 3px 0;
    transform: rotate(45deg);
}

.age-error {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
    padding: 10px;
    border-radius: 4px;
    margin-top: 10px;
    font-size: 14px;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: #2c3e50;
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
    border-color: #e67e22;
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

.form-message.loading {
    background-color: #d1ecf1;
    color: #0c5460;
    border: 1px solid #bee5eb;
    display: block;
}

/* Selected Tables Info */
.selected-tables-info {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 10px;
    margin: 20px 0;
    border: 2px solid #e67e22;
}

.selected-tables-info h3 {
    color: #2c3e50;
    margin-bottom: 15px;
}

.selected-tables-list {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 15px;
}

.selected-table-item {
    background: #e67e22;
    color: white;
    padding: 8px 15px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 8px;
}

.remove-table {
    background: rgba(255,255,255,0.3);
    border: none;
    color: white;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    cursor: pointer;
    font-size: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.remove-table:hover {
    background: rgba(255,255,255,0.5);
}

.total-seats-info {
    color: #2c3e50;
    font-size: 16px;
    margin-bottom: 10px;
}

/* Validation styles */
.seats-validation-info {
    margin-top: 15px;
    padding: 15px;
    border-radius: 8px;
}

.validation-message {
    font-weight: 600;
    font-size: 14px;
}

.validation-warning {
    background-color: #fff3cd;
    border: 1px solid #ffeaa7;
    color: #856404;
}

.validation-error {
    background-color: #f8d7da;
    border: 1px solid #f5c6cb;
    color: #721c24;
}

.validation-success {
    background-color: #d4edda;
    border: 1px solid #c3e6cb;
    color: #155724;
}

.btn:disabled {
    background-color: #6c757d;
    border-color: #6c757d;
    cursor: not-allowed;
    opacity: 0.65;
}

/* Updated Restaurant Layout Styles */
.restaurant-layout {
    margin: 2rem auto;
    max-width: 1200px;
    background: #fff;
    padding: 2rem;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}

.halls-info {
    text-align: center;
    margin-bottom: 2rem;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 8px;
}

.total-info {
    display: flex;
    justify-content: center;
    gap: 2rem;
    font-size: 1.2rem;
    font-weight: 600;
    color: #2c3e50;
}

.halls-container {
    display: grid;
    gap: 2rem;
}

.hall-section {
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.hall-title {
    font-size: 1.5rem;
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

.hall-description {
    color: #666;
    margin-bottom: 1rem;
    font-size: 0.9rem;
}

.tables-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
    gap: 1rem;
    margin-top: 1rem;
}

.table-item {
    aspect-ratio: 1;
    background: #fff;
    border: 2px solid #e67e22;
    border-radius: 8px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    padding: 0.5rem;
    position: relative;
}

.table-item:hover:not(.table-booked) {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(230, 126, 34, 0.2);
}

.table-number {
    font-size: 1.4rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 0.2rem;
}

.table-seats {
    font-size: 0.8rem;
    color: #666;
    text-align: center;
}

.table-booked {
    background: #fee;
    border-color: #e74c3c;
    cursor: not-allowed;
    opacity: 0.7;
}

.table-booked .table-number {
    color: #e74c3c;
}

.table-booked .table-seats {
    color: #e74c3c;
}

.table-selected {
    background: #e8f8f5;
    border-color: #2ecc71;
    border-width: 3px;
}

.table-selected .table-number {
    color: #2ecc71;
}

.table-selected .table-seats {
    color: #2ecc71;
}

.suitable-table {
    border-color: #3498db !important;
    background-color: #ebf3fd !important;
}

.suitable-table .table-number,
.suitable-table .table-seats {
    color: #3498db !important;
}

.table-disabled {
    background: #f8f9fa !important;
    border-color: #dee2e6 !important;
    cursor: not-allowed !important;
    opacity: 0.5;
}

.table-disabled .table-number,
.table-disabled .table-seats {
    color: #6c757d !important;
}

@media (max-width: 768px) {
    .total-info {
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .tables-grid {
        grid-template-columns: repeat(auto-fit, minmax(80px, 1fr));
        gap: 0.5rem;
    }
    
    .table-item {
        padding: 0.3rem;
    }
    
    .table-number {
        font-size: 1.1rem;
    }
    
    .table-seats {
        font-size: 0.7rem;
    }
    
    .form-row {
        grid-template-columns: 1fr;
        gap: 0;
    }
    
    .reservation-form {
        padding: 20px;
    }
    
    .selected-tables-list {
        justify-content: center;
    }
}
</style>

<script>
jQuery(document).ready(function($) {
    let selectedTables = [];
    let totalSeats = 0;
    let requiredGuests = 0;
    const MAX_EXTRA_SEATS = 1; // Максимальна похибка в 1 місце

    // Validation patterns
    const phonePattern = /^\+38\s?\(\d{3}\)\s?\d{3}-\d{2}-\d{2}$/;
    const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

    // Phone number formatting - IMPROVED VERSION
    $('#phone').on('input', function() {
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
    $('#phone').on('keydown', function(e) {
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
    if ($('#phone').val() === '') {
        $('#phone').val('+38');
    }

    // Real-time validation functions
    function validatePhone() {
        const phone = $('#phone').val();
        const $phoneField = $('#phone');
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
        const email = $('#email').val();
        const $emailField = $('#email');
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
        const name = $('#name').val().trim();
        const $nameField = $('#name');
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

    // Age verification check
    $('#age_confirmation').on('change', function() {
        const isChecked = $(this).is(':checked');
        const $ageError = $('.age-error');
        
        if (!isChecked) {
            $ageError.show();
        } else {
            $ageError.hide();
        }
        
        checkSubmitButtonState();
    });

    function checkSubmitButtonState() {
        const ageConfirmed = $('#age_confirmation').is(':checked');
        const hasSelectedTables = selectedTables.length > 0;
        const validSeatsCount = requiredGuests === 0 || (totalSeats >= requiredGuests && totalSeats <= (requiredGuests + MAX_EXTRA_SEATS));
        const validPhone = validatePhone();
        const validEmail = validateEmail();
        const validName = validateName();
        
        const allValid = ageConfirmed && hasSelectedTables && validSeatsCount && validPhone && validEmail && validName;
        
        $('#submit-btn').prop('disabled', !allValid);
    }

    // Table selection with multiple tables support
    $('.table-item').on('click', function() {
        if ($(this).hasClass('table-booked') || $(this).hasClass('table-disabled')) {
            return;
        }

        const tableNumber = parseInt($(this).data('table'));
        const tableSeats = parseInt($(this).data('seats'));
        
        if ($(this).hasClass('table-selected')) {
            // Remove table from selection
            removeTableFromSelection(tableNumber);
        } else {
            // Check if adding this table would exceed the limit
            if (requiredGuests > 0 && (totalSeats + tableSeats) > (requiredGuests + MAX_EXTRA_SEATS)) {
                showValidationMessage('error', `Не можна додати цей столик. Перевищення ліміту місць на ${(totalSeats + tableSeats) - (requiredGuests + MAX_EXTRA_SEATS)} місць.`);
                return;
            }
            
            // Add table to selection
            addTableToSelection(tableNumber, tableSeats);
        }
        
        updateSelectedTablesDisplay();
        updateFormField();
        updateTableStates();
        checkTableAvailability();
        checkSubmitButtonState();
    });

    function addTableToSelection(tableNumber, tableSeats) {
        if (!selectedTables.find(t => t.number === tableNumber)) {
            selectedTables.push({
                number: tableNumber,
                seats: tableSeats
            });
            
            totalSeats += tableSeats;
            $(`.table-item[data-table="${tableNumber}"]`).addClass('table-selected');
        }
    }

    function removeTableFromSelection(tableNumber) {
        const tableIndex = selectedTables.findIndex(t => t.number === tableNumber);
        if (tableIndex !== -1) {
            totalSeats -= selectedTables[tableIndex].seats;
            selectedTables.splice(tableIndex, 1);
            $(`.table-item[data-table="${tableNumber}"]`).removeClass('table-selected');
        }
    }

    function updateSelectedTablesDisplay() {
        const $selectedInfo = $('.selected-tables-info');
        const $selectedList = $('.selected-tables-list');
        
        if (selectedTables.length > 0) {
            $selectedInfo.show();
            $selectedList.empty();
            
            selectedTables.forEach(table => {
                const tableItem = $(`
                    <div class="selected-table-item">
                        Столик №${table.number} (${table.seats} місць)
                        <button type="button" class="remove-table" data-table="${table.number}">×</button>
                    </div>
                `);
                $selectedList.append(tableItem);
            });
            
            $('#total-seats').text(totalSeats);
            
            // Show validation info
            updateValidationDisplay();
        } else {
            $selectedInfo.hide();
            hideValidationMessage();
        }
    }

    function updateValidationDisplay() {
        if (requiredGuests > 0) {
            const difference = totalSeats - requiredGuests;
            
            if (difference < 0) {
                showValidationMessage('error', `Недостатньо місць! Потрібно ще ${Math.abs(difference)} місць.`);
            } else if (difference > MAX_EXTRA_SEATS) {
                showValidationMessage('error', `Забагато місць! Перевищення на ${difference - MAX_EXTRA_SEATS} місць. Максимальна похибка: ${MAX_EXTRA_SEATS} місце.`);
            } else if (difference > 0) {
                showValidationMessage('warning', `Додаткові місця: ${difference} (в межах допустимого).`);
            } else {
                showValidationMessage('success', 'Ідеальна відповідність кількості гостей і місць!');
            }
        } else {
            hideValidationMessage();
        }
    }

    function showValidationMessage(type, message) {
        const $validationInfo = $('.seats-validation-info');
        const $validationMessage = $('.validation-message');
        
        $validationInfo.show();
        $validationMessage.removeClass('validation-warning validation-error validation-success')
                         .addClass(`validation-${type}`)
                         .text(message);
        $validationInfo.removeClass('validation-warning validation-error validation-success')
                      .addClass(`validation-${type}`);
    }

    function hideValidationMessage() {
        $('.seats-validation-info').hide();
    }

    function updateTableStates() {
        if (requiredGuests > 0) {
            $('.table-item').each(function() {
                const $table = $(this);
                const tableSeats = parseInt($table.data('seats'));
                
                if (!$table.hasClass('table-selected') && !$table.hasClass('table-booked')) {
                    // Check if adding this table would exceed the limit
                    if ((totalSeats + tableSeats) > (requiredGuests + MAX_EXTRA_SEATS)) {
                        $table.addClass('table-disabled');
                    } else {
                        $table.removeClass('table-disabled');
                    }
                }
            });
        } else {
            $('.table-item').removeClass('table-disabled');
        }
    }

    function updateFormField() {
        const tableNumbers = selectedTables.map(t => t.number).sort((a, b) => a - b).join(', ');
        $('#table_numbers').val(tableNumbers);
    }

    // Remove table from selection
    $(document).on('click', '.remove-table', function() {
        const tableNumber = parseInt($(this).data('table'));
        removeTableFromSelection(tableNumber);
        updateSelectedTablesDisplay();
        updateFormField();
        updateTableStates();
        checkSubmitButtonState();
    });

    // Guest count change handler
    $('#guests').on('change', function() {
        requiredGuests = parseInt($(this).val()) || 0;
        
        if (requiredGuests > 0) {
            highlightSuitableTables();
            updateSelectedTablesDisplay();
            updateTableStates();
            
            // Check if current selection is still valid
            if (totalSeats > (requiredGuests + MAX_EXTRA_SEATS)) {
                showValidationMessage('error', `Поточний вибір перевищує ліміт на ${totalSeats - (requiredGuests + MAX_EXTRA_SEATS)} місць. Зменшіть кількість столиків.`);
            }
        } else {
            $('.table-item').removeClass('suitable-table table-disabled');
            hideValidationMessage();
        }
        
        checkSubmitButtonState();
    });

    function highlightSuitableTables() {
        $('.table-item').removeClass('suitable-table');
        
        if (requiredGuests > 0) {
            $('.table-item').each(function() {
                const tableSeats = parseInt($(this).data('seats'));
                // Highlight tables that can accommodate guests efficiently
                if (tableSeats >= Math.min(requiredGuests, 8) && tableSeats <= (requiredGuests + MAX_EXTRA_SEATS)) {
                    $(this).addClass('suitable-table');
                }
            });
        }
    }

    // Check availability when date/time changes
    $('#date, #time').on('change', function() {
        checkTableAvailability();
    });

    function checkTableAvailability() {
        const date = $('#date').val();
        const time = $('#time').val();
        
        if (!date || !time || selectedTables.length === 0) return;

        selectedTables.forEach(table => {
            $.ajax({
                url: ratatouilleAjax.ajaxurl,
                type: 'POST',
                data: {
                    action: 'check_table_availability',
                    nonce: ratatouilleAjax.nonce,
                    date: date,
                    time: time,
                    table: table.number
                },
                success: function(response) {
                    if (response.success) {
                        const tableItem = $(`.table-item[data-table="${table.number}"]`);
                        
                        if (!response.data.available) {
                            tableItem.addClass('table-booked').removeClass('table-selected');
                            removeTableFromSelection(table.number);
                            updateSelectedTablesDisplay();
                            updateFormField();
                            updateTableStates();
                            checkSubmitButtonState();
                            alert(`Столик №${table.number} вже заброньовано на цей час`);
                        } else {
                            tableItem.removeClass('table-booked');
                        }
                    }
                }
            });
        });
    }

    // Form submission
    $('#reservation-form').on('submit', function(e) {
        e.preventDefault();
        
        const $form = $(this);
        const $submitButton = $form.find('button[type="submit"]');
        const $message = $form.find('.form-message');
        
        // Age verification check
        if (!$('#age_confirmation').is(':checked')) {
            $message.removeClass('success error loading').addClass('error')
                   .text('Для бронювання столика необхідно підтвердити, що вам виповнилося 18 років').show();
            return;
        }
        
        // Validation checks
        if (!validateName()) {
            $message.removeClass('success error loading').addClass('error')
                   .text('Будь ласка, введіть коректне ім\'я').show();
            return;
        }
        
        if (!validatePhone()) {
            $message.removeClass('success error loading').addClass('error')
                   .text('Будь ласка, введіть повний номер телефону у форматі +38 (XXX) XXX-XX-XX').show();
            return;
        }
        
        if (!validateEmail()) {
            $message.removeClass('success error loading').addClass('error')
                   .text('Будь ласка, введіть коректний email').show();
            return;
        }
        
        // Table validation
        if (selectedTables.length === 0) {
            $message.removeClass('success error loading').addClass('error')
                   .text('Будь ласка, оберіть хоча б один столик').show();
            return;
        }
        
        if (requiredGuests > 0) {
            const difference = totalSeats - requiredGuests;
            if (difference < 0) {
                $message.removeClass('success error loading').addClass('error')
                       .text(`Недостатньо місць. Вам потрібно ще ${Math.abs(difference)} місць.`).show();
                return;
            }
            
            if (difference > MAX_EXTRA_SEATS) {
                $message.removeClass('success error loading').addClass('error')
                       .text(`Забагато місць. Перевищення на ${difference - MAX_EXTRA_SEATS} місць. Максимальна похибка: ${MAX_EXTRA_SEATS} місце.`).show();
                return;
            }
        }
        
        $submitButton.prop('disabled', true).text('Відправка...');
        $message.removeClass('success error').addClass('loading').text('Відправка...').show();
        
        // Submit each table as separate reservation
        let completedReservations = 0;
        let hasErrors = false;
        
        selectedTables.forEach((table, index) => {
            const guestsForTable = Math.min(table.seats, Math.max(1, Math.ceil(requiredGuests / selectedTables.length)));
            
            $.ajax({
                url: ratatouilleAjax.ajaxurl,
                type: 'POST',
                data: {
                    action: 'reservation_submit',
                    nonce: $('#reservation_nonce').val(),
                    name: $('#name').val(),
                    phone: $('#phone').val(),
                    email: $('#email').val(),
                    date: $('#date').val(),
                    time: $('#time').val(),
                    guests: guestsForTable,
                    table_number: table.number,
                    notes: $('#notes').val() + (selectedTables.length > 1 ? ` (Частина групового бронювання: столики ${selectedTables.map(t => t.number).join(', ')})` : '')
                },
                success: function(response) {
                    completedReservations++;
                    
                    if (!response.success) {
                        hasErrors = true;
                    }
                    
                    // Check if all reservations are completed
                    if (completedReservations === selectedTables.length) {
                        if (!hasErrors) {
                            $message.removeClass('loading error').addClass('success')
                                   .text(`Дякуємо! Ваше бронювання на ${selectedTables.length} столик${selectedTables.length > 1 ? 'и' : ''} прийнято. Ми зв'яжемося з вами найближчим часом для підтвердження.`);
                            $form[0].reset();
                            selectedTables = [];
                            totalSeats = 0;
                            requiredGuests = 0;
                            $('.table-item').removeClass('table-selected suitable-table table-disabled');
                            $('.selected-tables-info').hide();
                            hideValidationMessage();
                            $('#submit-btn').prop('disabled', true);
                            $('.form-control').removeClass('valid error');
                            $('.field-error').hide();
                            $('#phone').val('+38'); // Reset phone with prefix
                        } else {
                            $message.removeClass('loading success').addClass('error')
                                   .text('Деякі столики не вдалося забронювати. Будь ласка, спробуйте ще раз.');
                        }
                        
                        $submitButton.prop('disabled', false).text('Забронювати столики');
                    }
                },
                error: function() {
                    completedReservations++;
                    hasErrors = true;
                    
                    if (completedReservations === selectedTables.length) {
                        $message.removeClass('loading success').addClass('error')
                               .text('Помилка при бронюванні. Спробуйте ще раз.');
                        $submitButton.prop('disabled', false).text('Забронювати столики');
                    }
                }
            });
        });
    });

    // Set minimum date to today
    const today = new Date().toISOString().split('T')[0];
    $('#date').attr('min', today);
    
    // Initial state - disable submit button
    $('#submit-btn').prop('disabled', true);
    
    // Bind validation events to check submit button state
    $('#name, #phone, #email').on('input blur', checkSubmitButtonState);
});
</script>

<?php get_footer(); ?>