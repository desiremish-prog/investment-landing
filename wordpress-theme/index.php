<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Персональные финансовые консультации. Наводим порядок в личных финансах и помогаем начать инвестировать.">
    <title><?php bloginfo('name'); ?> - <?php bloginfo('description'); ?></title>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

    <!-- Header -->
    <header class="header" id="header">
        <div class="container">
            <div class="header-content">
                <!-- Logo -->
                <div class="header-logo">
                    <a href="<?php echo home_url('/'); ?>">
                        <h2 class="logo-text"><?php bloginfo('name'); ?></h2>
                    </a>
                </div>

                <!-- Navigation -->
                <nav class="header-nav" id="headerNav">
                    <ul class="nav-menu">
                        <li class="nav-item"><a href="#benefits" class="nav-link">Услуги</a></li>
                        <li class="nav-item"><a href="#how-it-works" class="nav-link">Как работаем</a></li>
                        <li class="nav-item"><a href="#expertise" class="nav-link">О нас</a></li>
                        <li class="nav-item"><a href="#testimonials" class="nav-link">Отзывы</a></li>
                        <li class="nav-item"><a href="#contacts" class="nav-link">Контакты</a></li>
                    </ul>
                </nav>

                <!-- Header Actions -->
                <div class="header-actions">
                    <a href="tel:+74951234567" class="header-phone">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                        </svg>
                        <span>+7 (495) 123-45-67</span>
                    </a>
                    <button class="header-cta-btn" onclick="openModal()">Записаться</button>
                </div>

                <!-- Mobile Menu Toggle -->
                <button class="mobile-menu-toggle" id="mobileMenuToggle" aria-label="Открыть меню">
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                </button>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero" id="hero">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title">Наводим порядок в личных финансах и помогаем начать инвестировать</h1>
                <p class="hero-subtitle">Персональные финансовые консультации для тех, кто хочет, чтобы деньги работали на него</p>
                <button class="cta-button" onclick="openModal()">Записаться на встречу</button>
            </div>
            <div class="hero-image">
                <div class="hero-placeholder"></div>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section class="benefits" id="benefits">
        <div class="container">
            <h2 class="section-title">Что вы получите</h2>
            <div class="benefits-grid">
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 11L12 14L22 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M21 12V19C21 19.5304 20.7893 20.0391 20.4142 20.4142C20.0391 20.7893 19.5304 21 19 21H5C4.46957 21 3.96086 20.7893 3.58579 20.4142C3.21071 20.0391 3 19.5304 3 19V5C3 4.46957 3.21071 3.96086 3.58579 3.58579C3.96086 3.21071 4.46957 3 5 3H16" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <h3 class="benefit-title">Индивидуальный финансовый план</h3>
                    <p class="benefit-description">Разработаем стратегию, которая учитывает именно ваши цели, доходы и жизненную ситуацию</p>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <h3 class="benefit-title">Понятные объяснения без сложных терминов</h3>
                    <p class="benefit-description">Говорим простым языком о сложных вещах. Вы будете понимать каждое решение</p>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M12 6V12L16 14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <h3 class="benefit-title">Помощь с первыми инвестициями</h3>
                    <p class="benefit-description">Поможем выбрать инструменты и сделать первые шаги в инвестировании</p>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 22C12 22 20 18 20 12V5L12 2L4 5V12C4 18 12 22 12 22Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <h3 class="benefit-title">Фокус на безопасности и долгосрочном росте</h3>
                    <p class="benefit-description">Никаких рисковых схем. Только проверенные стратегии для стабильного роста капитала</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="how-it-works" id="how-it-works">
        <div class="container">
            <h2 class="section-title">Как проходит консультация</h2>
            <div class="steps">
                <div class="step">
                    <div class="step-number">1</div>
                    <h3 class="step-title">Вы оставляете заявку</h3>
                    <p class="step-description">Заполняете простую форму на сайте — это займет не больше минуты</p>
                </div>
                <div class="step-arrow">→</div>
                <div class="step">
                    <div class="step-number">2</div>
                    <h3 class="step-title">Мы связываемся и уточняем цели</h3>
                    <p class="step-description">Созваниваемся в удобное время и обсуждаем ваши финансовые цели</p>
                </div>
                <div class="step-arrow">→</div>
                <div class="step">
                    <div class="step-number">3</div>
                    <h3 class="step-title">Проводим онлайн-созвон</h3>
                    <p class="step-description">Детально разбираем вашу финансовую ситуацию и возможности</p>
                </div>
                <div class="step-arrow">→</div>
                <div class="step">
                    <div class="step-number">4</div>
                    <h3 class="step-title">Вы получаете план действий</h3>
                    <p class="step-description">Получаете конкретные рекомендации и пошаговый план</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Expertise Section -->
    <section class="expertise" id="expertise">
        <div class="container">
            <div class="expertise-content">
                <div class="expertise-text">
                    <h2 class="section-title">О консультанте</h2>
                    <p class="expertise-description">Более 7 лет опыта работы с частными клиентами. Помог более 200 людям начать инвестировать и упорядочить личные финансы.</p>
                    <div class="expertise-points">
                        <div class="expertise-point">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M20 6L9 17L4 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span>Опыт работы с частными клиентами</span>
                        </div>
                        <div class="expertise-point">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M20 6L9 17L4 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span>Без агрессивных продаж и рисковых стратегий</span>
                        </div>
                        <div class="expertise-point">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M20 6L9 17L4 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span>Фокус на долгосрочных результатах</span>
                        </div>
                    </div>
                </div>
                <div class="expertise-image">
                    <div class="expertise-placeholder"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials" id="testimonials">
        <div class="container">
            <h2 class="section-title">Отзывы клиентов</h2>
            <div class="testimonials-grid">
                <div class="testimonial-card">
                    <div class="testimonial-stars">★★★★★</div>
                    <p class="testimonial-text">«Помог разобраться с финансами и начать инвестировать. За полгода мой портфель вырос на 15%. Главное — я теперь понимаю, что делаю.»</p>
                    <p class="testimonial-author">Анна, 32 года</p>
                    <p class="testimonial-result">Создан инвестиционный портфель, доходность +15% за 6 месяцев</p>
                </div>
                <div class="testimonial-card">
                    <div class="testimonial-stars">★★★★★</div>
                    <p class="testimonial-text">«Благодаря консультации смог упорядочить расходы и начал откладывать 20% дохода. Через год накопил на первоначальный взнос по ипотеке.»</p>
                    <p class="testimonial-author">Дмитрий, 28 лет</p>
                    <p class="testimonial-result">Упорядочены финансы, накоплено на важную цель</p>
                </div>
                <div class="testimonial-card">
                    <div class="testimonial-stars">★★★★★</div>
                    <p class="testimonial-text">«Очень доступно объясняет сложные вещи. Составили план на 5 лет вперед, теперь я уверена в своем финансовом будущем.»</p>
                    <p class="testimonial-author">Елена, 41 год</p>
                    <p class="testimonial-result">Создан долгосрочный финансовый план</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section" id="cta">
        <div class="container">
            <div class="cta-content">
                <h2 class="cta-title">Готовы навести порядок в финансах?</h2>
                <p class="cta-subtitle">Запишитесь на бесплатную консультацию прямо сейчас</p>
                <button class="cta-button" onclick="openModal()">Записаться на встречу</button>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-main">
                <div class="footer-column footer-about">
                    <div class="footer-logo">
                        <h3><?php bloginfo('name'); ?></h3>
                    </div>
                    <p class="footer-description"><?php bloginfo('description'); ?> Помогаем людям достигать финансовых целей с 2015 года.</p>
                    <div class="footer-social">
                        <a href="#" class="social-link" aria-label="Facebook">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="#" class="social-link" aria-label="LinkedIn">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                        </a>
                        <a href="#" class="social-link" aria-label="Telegram">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/>
                            </svg>
                        </a>
                        <a href="#" class="social-link" aria-label="YouTube">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="footer-column">
                    <h4 class="footer-title">Услуги</h4>
                    <ul class="footer-menu">
                        <li><a href="#benefits">Финансовое планирование</a></li>
                        <li><a href="#benefits">Инвестиционное консультирование</a></li>
                        <li><a href="#benefits">Управление портфелем</a></li>
                        <li><a href="#benefits">Пенсионное планирование</a></li>
                        <li><a href="#benefits">Налоговая оптимизация</a></li>
                    </ul>
                </div>

                <div class="footer-column">
                    <h4 class="footer-title">Компания</h4>
                    <ul class="footer-menu">
                        <li><a href="#expertise">О нас</a></li>
                        <li><a href="#expertise">Наша команда</a></li>
                        <li><a href="#testimonials">Отзывы клиентов</a></li>
                        <li><a href="#how-it-works">Как мы работаем</a></li>
                        <li><a href="#blog">Блог</a></li>
                    </ul>
                </div>

                <div class="footer-column">
                    <h4 class="footer-title">Ресурсы</h4>
                    <ul class="footer-menu">
                        <li><a href="#faq">Часто задаваемые вопросы</a></li>
                        <li><a href="#guides">Руководства</a></li>
                        <li><a href="#calculator">Калькуляторы</a></li>
                        <li><a href="#webinars">Вебинары</a></li>
                        <li><a href="#news">Новости</a></li>
                    </ul>
                </div>

                <div class="footer-column">
                    <h4 class="footer-title">Контакты</h4>
                    <ul class="footer-contacts">
                        <li>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>
                            <span>Москва, Россия</span>
                        </li>
                        <li>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                            </svg>
                            <a href="tel:+74951234567">+7 (495) 123-45-67</a>
                        </li>
                        <li>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                            <a href="mailto:info@finance-consulting.ru">info@finance-consulting.ru</a>
                        </li>
                        <li>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                            <span>Пн-Пт: 9:00 - 18:00</span>
                        </li>
                    </ul>
                    <button class="footer-cta-btn" onclick="openModal()">Записаться на консультацию</button>
                </div>
            </div>

            <div class="footer-bottom">
                <div class="footer-bottom-left">
                    <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. Все права защищены.</p>
                </div>
                <div class="footer-bottom-right">
                    <a href="<?php echo get_privacy_policy_url(); ?>">Политика конфиденциальности</a>
                    <a href="#terms">Условия использования</a>
                    <a href="#cookies">Политика Cookies</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Modal Form -->
    <div class="modal" id="consultationModal">
        <div class="modal-overlay" onclick="closeModal()"></div>
        <div class="modal-content">
            <button class="modal-close" onclick="closeModal()">&times;</button>
            <h2 class="modal-title">Запись на консультацию</h2>
            <p class="modal-subtitle">Заполните форму, и мы свяжемся с вами в ближайшее время</p>
            <form id="consultationForm" class="consultation-form" onsubmit="handleSubmit(event)">
                <?php wp_nonce_field('consultation_request', 'consultation_nonce'); ?>
                <div class="form-group">
                    <label for="name">Имя *</label>
                    <input type="text" id="name" name="name" required placeholder="Ваше имя">
                    <span class="error-message" id="nameError"></span>
                </div>
                <div class="form-group">
                    <label for="email">Email *</label>
                    <input type="email" id="email" name="email" required placeholder="your@email.com">
                    <span class="error-message" id="emailError"></span>
                </div>
                <div class="form-group">
                    <label for="phone">Телефон *</label>
                    <input type="tel" id="phone" name="phone" required placeholder="+7 (___) ___-__-__">
                    <span class="error-message" id="phoneError"></span>
                </div>
                <div class="form-group">
                    <label for="comment">Комментарий</label>
                    <textarea id="comment" name="comment" rows="4" placeholder="Расскажите немного о ваших финансовых целях (необязательно)"></textarea>
                </div>
                <div class="form-group checkbox-group">
                    <input type="checkbox" id="privacy" name="privacy" required>
                    <label for="privacy">Я согласен с <a href="#privacy" target="_blank">политикой конфиденциальности</a> *</label>
                    <span class="error-message" id="privacyError"></span>
                </div>
                <button type="submit" class="submit-button" id="submitButton">
                    <span class="button-text">Отправить заявку</span>
                    <span class="button-loader" style="display: none;">Отправка...</span>
                </button>
                <div class="success-message" id="successMessage" style="display: none;">
                    ✓ Заявка успешно отправлена! Мы свяжемся с вами в ближайшее время.
                </div>
            </form>
        </div>
    </div>

<?php wp_footer(); ?>
</body>
</html>
