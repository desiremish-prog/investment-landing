<?php
/**
 * Investment Consultant Landing Theme Functions
 * 
 * @package Investment_Landing
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme Setup
 */
function investment_landing_setup() {
    // Add theme support
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
    
    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'investment-landing'),
    ));
}
add_action('after_setup_theme', 'investment_landing_setup');

/**
 * Enqueue Scripts and Styles
 */
function investment_landing_scripts() {
    // Google Fonts
    wp_enqueue_style('investment-landing-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap', array(), null);
    
    // Main stylesheet
    wp_enqueue_style('investment-landing-style', get_template_directory_uri() . '/assets/css/style.css', array(), '1.0.0');
    
    // Main JavaScript
    wp_enqueue_script('investment-landing-script', get_template_directory_uri() . '/assets/js/main.js', array(), '1.0.0', true);
    
    // Localize script for AJAX
    wp_localize_script('investment-landing-script', 'investmentLanding', array(
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('consultation_request')
    ));
}
add_action('wp_enqueue_scripts', 'investment_landing_scripts');

/**
 * Create Database Table for Consultation Requests
 */
function investment_landing_create_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'consultation_requests';
    $charset_collate = $wpdb->get_charset_collate();
    
    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        name varchar(200) NOT NULL,
        email varchar(200) NOT NULL,
        phone varchar(50) NOT NULL,
        comment text,
        ip_address varchar(100),
        user_agent text,
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        status varchar(50) DEFAULT 'new',
        PRIMARY KEY (id),
        KEY email (email),
        KEY created_at (created_at),
        KEY status (status)
    ) $charset_collate;";
    
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
register_activation_hook(__FILE__, 'investment_landing_create_table');

/**
 * AJAX Handler for Consultation Form Submission
 */
function investment_landing_save_consultation() {
    // Verify nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'consultation_request')) {
        wp_send_json_error(array('message' => 'Ошибка безопасности. Обновите страницу и попробуйте снова.'));
        exit;
    }
    
    // Rate limiting - check if IP has submitted recently
    $ip_address = investment_landing_get_client_ip();
    if (investment_landing_check_rate_limit($ip_address)) {
        wp_send_json_error(array('message' => 'Слишком много запросов. Пожалуйста, попробуйте позже.'));
        exit;
    }
    
    // Sanitize and validate input
    $name = sanitize_text_field($_POST['name'] ?? '');
    $email = sanitize_email($_POST['email'] ?? '');
    $phone = sanitize_text_field($_POST['phone'] ?? '');
    $comment = sanitize_textarea_field($_POST['comment'] ?? '');
    
    // Validation
    $errors = array();
    
    if (empty($name) || strlen($name) < 2) {
        $errors[] = 'Пожалуйста, укажите ваше имя';
    }
    
    if (empty($email) || !is_email($email)) {
        $errors[] = 'Пожалуйста, укажите корректный email';
    }
    
    if (empty($phone)) {
        $errors[] = 'Пожалуйста, укажите номер телефона';
    }
    
    // Check for spam patterns
    if (investment_landing_is_spam($name, $email, $comment)) {
        $errors[] = 'Ваша заявка похожа на спам. Пожалуйста, свяжитесь с нами по email.';
    }
    
    if (!empty($errors)) {
        wp_send_json_error(array('message' => implode(' ', $errors)));
        exit;
    }
    
    // Save to database
    global $wpdb;
    $table_name = $wpdb->prefix . 'consultation_requests';
    
    $result = $wpdb->insert(
        $table_name,
        array(
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'comment' => $comment,
            'ip_address' => $ip_address,
            'user_agent' => sanitize_text_field($_SERVER['HTTP_USER_AGENT'] ?? ''),
            'created_at' => current_time('mysql'),
            'status' => 'new'
        ),
        array('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')
    );
    
    if ($result === false) {
        wp_send_json_error(array('message' => 'Ошибка при сохранении данных. Пожалуйста, попробуйте позже.'));
        exit;
    }
    
    // Send email notification to admin
    investment_landing_send_notification_email($name, $email, $phone, $comment);
    
    // Send confirmation email to user
    investment_landing_send_confirmation_email($name, $email);
    
    wp_send_json_success(array('message' => 'Ваша заявка успешно отправлена!'));
    exit;
}
add_action('wp_ajax_save_consultation_request', 'investment_landing_save_consultation');
add_action('wp_ajax_nopriv_save_consultation_request', 'investment_landing_save_consultation');

/**
 * Get Client IP Address
 */
function investment_landing_get_client_ip() {
    $ip = '';
    
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'] ?? '';
    }
    
    return sanitize_text_field($ip);
}

/**
 * Check Rate Limiting
 */
function investment_landing_check_rate_limit($ip_address) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'consultation_requests';
    
    // Check if IP has submitted in last 5 minutes
    $recent_count = $wpdb->get_var($wpdb->prepare(
        "SELECT COUNT(*) FROM $table_name 
        WHERE ip_address = %s 
        AND created_at > DATE_SUB(NOW(), INTERVAL 5 MINUTE)",
        $ip_address
    ));
    
    return ($recent_count > 0);
}

/**
 * Simple Spam Detection
 */
function investment_landing_is_spam($name, $email, $comment) {
    // Check for common spam patterns
    $spam_patterns = array(
        'viagra', 'cialis', 'casino', 'porn', 'xxx',
        'lottery', 'winner', 'prize', 'bitcoin', 'crypto'
    );
    
    $text = strtolower($name . ' ' . $email . ' ' . $comment);
    
    foreach ($spam_patterns as $pattern) {
        if (strpos($text, $pattern) !== false) {
            return true;
        }
    }
    
    // Check for excessive links in comment
    if (substr_count($comment, 'http') > 2) {
        return true;
    }
    
    return false;
}

/**
 * Send Email Notification to Admin
 */
function investment_landing_send_notification_email($name, $email, $phone, $comment) {
    $admin_email = get_option('admin_email');
    $subject = 'Новая заявка на консультацию - ' . get_bloginfo('name');
    
    $message = "Получена новая заявка на консультацию:\n\n";
    $message .= "Имя: $name\n";
    $message .= "Email: $email\n";
    $message .= "Телефон: $phone\n";
    
    if (!empty($comment)) {
        $message .= "Комментарий: $comment\n";
    }
    
    $message .= "\n---\n";
    $message .= "Время: " . current_time('mysql') . "\n";
    $message .= "IP: " . investment_landing_get_client_ip() . "\n";
    
    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: ' . get_bloginfo('name') . ' <' . $admin_email . '>'
    );
    
    wp_mail($admin_email, $subject, $message, $headers);
}

/**
 * Send Confirmation Email to User
 */
function investment_landing_send_confirmation_email($name, $email) {
    $subject = 'Спасибо за вашу заявку - ' . get_bloginfo('name');
    
    $message = "Здравствуйте, $name!\n\n";
    $message .= "Спасибо за вашу заявку на консультацию. Мы получили ваш запрос и свяжемся с вами в ближайшее время.\n\n";
    $message .= "Если у вас есть срочные вопросы, вы можете связаться с нами по email: info@finance-consulting.ru\n\n";
    $message .= "С уважением,\n";
    $message .= "Команда финансовых консультантов\n";
    $message .= get_bloginfo('url');
    
    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: ' . get_bloginfo('name') . ' <info@finance-consulting.ru>'
    );
    
    wp_mail($email, $subject, $message, $headers);
}

/**
 * Add Admin Menu for Consultation Requests
 */
function investment_landing_admin_menu() {
    add_menu_page(
        'Заявки на консультацию',
        'Заявки',
        'manage_options',
        'consultation-requests',
        'investment_landing_admin_page',
        'dashicons-email-alt',
        30
    );
}
add_action('admin_menu', 'investment_landing_admin_menu');

/**
 * Admin Page for Viewing Consultation Requests
 */
function investment_landing_admin_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'consultation_requests';
    
    // Handle status update
    if (isset($_POST['update_status']) && isset($_POST['request_id'])) {
        check_admin_referer('update_status_nonce');
        $request_id = intval($_POST['request_id']);
        $new_status = sanitize_text_field($_POST['status']);
        
        $wpdb->update(
            $table_name,
            array('status' => $new_status),
            array('id' => $request_id),
            array('%s'),
            array('%d')
        );
        
        echo '<div class="notice notice-success"><p>Статус обновлен</p></div>';
    }
    
    // Get all requests
    $requests = $wpdb->get_results("SELECT * FROM $table_name ORDER BY created_at DESC");
    
    ?>
    <div class="wrap">
        <h1>Заявки на консультацию</h1>
        
        <?php if (empty($requests)): ?>
            <p>Пока нет заявок.</p>
        <?php else: ?>
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Имя</th>
                        <th>Email</th>
                        <th>Телефон</th>
                        <th>Комментарий</th>
                        <th>Дата</th>
                        <th>Статус</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($requests as $request): ?>
                        <tr>
                            <td><?php echo esc_html($request->id); ?></td>
                            <td><?php echo esc_html($request->name); ?></td>
                            <td><a href="mailto:<?php echo esc_attr($request->email); ?>"><?php echo esc_html($request->email); ?></a></td>
                            <td><?php echo esc_html($request->phone); ?></td>
                            <td><?php echo esc_html(substr($request->comment, 0, 50)) . (strlen($request->comment) > 50 ? '...' : ''); ?></td>
                            <td><?php echo esc_html($request->created_at); ?></td>
                            <td>
                                <span class="status-badge status-<?php echo esc_attr($request->status); ?>">
                                    <?php 
                                    $statuses = array(
                                        'new' => 'Новая',
                                        'in_progress' => 'В работе',
                                        'completed' => 'Завершена',
                                        'cancelled' => 'Отменена'
                                    );
                                    echo esc_html($statuses[$request->status] ?? $request->status);
                                    ?>
                                </span>
                            </td>
                            <td>
                                <form method="post" style="display: inline;">
                                    <?php wp_nonce_field('update_status_nonce'); ?>
                                    <input type="hidden" name="request_id" value="<?php echo esc_attr($request->id); ?>">
                                    <select name="status">
                                        <option value="new" <?php selected($request->status, 'new'); ?>>Новая</option>
                                        <option value="in_progress" <?php selected($request->status, 'in_progress'); ?>>В работе</option>
                                        <option value="completed" <?php selected($request->status, 'completed'); ?>>Завершена</option>
                                        <option value="cancelled" <?php selected($request->status, 'cancelled'); ?>>Отменена</option>
                                    </select>
                                    <button type="submit" name="update_status" class="button button-small">Обновить</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
    
    <style>
        .status-badge {
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }
        .status-new { background: #dbeafe; color: #1e40af; }
        .status-in_progress { background: #fef3c7; color: #92400e; }
        .status-completed { background: #d1fae5; color: #065f46; }
        .status-cancelled { background: #fee2e2; color: #991b1b; }
    </style>
    <?php
}

/**
 * Security Headers
 */
function investment_landing_security_headers() {
    if (!is_admin()) {
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: SAMEORIGIN');
        header('X-XSS-Protection: 1; mode=block');
        header('Referrer-Policy: strict-origin-when-cross-origin');
    }
}
add_action('send_headers', 'investment_landing_security_headers');
