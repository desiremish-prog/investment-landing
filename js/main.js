// Preloader
window.addEventListener('load', function() {
    const preloader = document.getElementById('preloader');
    // Add a small delay to ensure smooth transition
    setTimeout(() => {
        preloader.classList.add('hidden');
        // Remove preloader from DOM after transition
        setTimeout(() => {
            preloader.style.display = 'none';
        }, 500);
    }, 500);
});

// Modal Functions
function openModal() {
    const modal = document.getElementById('consultationModal');
    modal.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    const modal = document.getElementById('consultationModal');
    modal.classList.remove('active');
    document.body.style.overflow = 'auto';
    
    // Reset form
    const form = document.getElementById('consultationForm');
    form.reset();
    clearErrors();
    hideSuccessMessage();
}

// Form Validation Functions
function validateName(name) {
    if (name.length < 2) {
        return 'Имя должно содержать минимум 2 символа';
    }
    if (!/^[а-яА-ЯёЁa-zA-Z\s-]+$/.test(name)) {
        return 'Имя может содержать только буквы, пробелы и дефисы';
    }
    return null;
}

function validateEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        return 'Введите корректный email адрес';
    }
    return null;
}

function validatePhone(phone) {
    // Remove all non-digit characters
    const cleanPhone = phone.replace(/\D/g, '');
    
    if (cleanPhone.length < 10) {
        return 'Введите корректный номер телефона';
    }
    return null;
}

function showError(fieldId, message) {
    const field = document.getElementById(fieldId);
    const errorElement = document.getElementById(fieldId + 'Error');
    
    field.classList.add('error');
    errorElement.textContent = message;
    errorElement.classList.add('active');
}

function clearError(fieldId) {
    const field = document.getElementById(fieldId);
    const errorElement = document.getElementById(fieldId + 'Error');
    
    field.classList.remove('error');
    errorElement.textContent = '';
    errorElement.classList.remove('active');
}

function clearErrors() {
    const fields = ['name', 'email', 'phone', 'privacy'];
    fields.forEach(field => clearError(field));
}

function hideSuccessMessage() {
    const successMessage = document.getElementById('successMessage');
    successMessage.style.display = 'none';
}

// Phone Input Formatting
function formatPhoneNumber(input) {
    let value = input.value.replace(/\D/g, '');
    
    // Limit to 11 digits (Russian phone number)
    if (value.length > 11) {
        value = value.substring(0, 11);
    }
    
    // Format as +7 (XXX) XXX-XX-XX
    let formatted = '';
    if (value.length > 0) {
        formatted = '+7';
        if (value.length > 1) {
            formatted += ' (' + value.substring(1, 4);
            if (value.length > 4) {
                formatted += ') ' + value.substring(4, 7);
                if (value.length > 7) {
                    formatted += '-' + value.substring(7, 9);
                    if (value.length > 9) {
                        formatted += '-' + value.substring(9, 11);
                    }
                }
            }
        }
    }
    
    input.value = formatted;
}

// Form Submission Handler
async function handleSubmit(event) {
    event.preventDefault();
    
    clearErrors();
    hideSuccessMessage();
    
    const form = event.target;
    const submitButton = document.getElementById('submitButton');
    const buttonText = submitButton.querySelector('.button-text');
    const buttonLoader = submitButton.querySelector('.button-loader');
    
    // Get form values
    const formData = {
        name: document.getElementById('name').value.trim(),
        email: document.getElementById('email').value.trim(),
        phone: document.getElementById('phone').value.trim(),
        comment: document.getElementById('comment').value.trim(),
        privacy: document.getElementById('privacy').checked,
        timestamp: new Date().toISOString()
    };
    
    // Validate all fields
    let hasErrors = false;
    
    const nameError = validateName(formData.name);
    if (nameError) {
        showError('name', nameError);
        hasErrors = true;
    }
    
    const emailError = validateEmail(formData.email);
    if (emailError) {
        showError('email', emailError);
        hasErrors = true;
    }
    
    const phoneError = validatePhone(formData.phone);
    if (phoneError) {
        showError('phone', phoneError);
        hasErrors = true;
    }
    
    if (!formData.privacy) {
        showError('privacy', 'Необходимо согласие с политикой конфиденциальности');
        hasErrors = true;
    }
    
    if (hasErrors) {
        return;
    }
    
    // Disable submit button and show loader
    submitButton.disabled = true;
    buttonText.style.display = 'none';
    buttonLoader.style.display = 'inline';
    
    try {
        // Save to database (WordPress backend will handle this)
        const response = await saveFormData(formData);
        
        if (response.success) {
            // Show success message
            document.getElementById('successMessage').style.display = 'block';
            
            // Reset form
            form.reset();
            
            // Close modal after 3 seconds
            setTimeout(() => {
                closeModal();
            }, 3000);
        } else {
            throw new Error(response.message || 'Ошибка при отправке формы');
        }
    } catch (error) {
        console.error('Form submission error:', error);
        alert('Произошла ошибка при отправке формы. Пожалуйста, попробуйте позже или свяжитесь с нами по email.');
    } finally {
        // Re-enable submit button
        submitButton.disabled = false;
        buttonText.style.display = 'inline';
        buttonLoader.style.display = 'none';
    }
}

// Save form data to backend
async function saveFormData(formData) {
    // This function will be integrated with WordPress
    // For now, we'll simulate a successful save
    
    try {
        // In WordPress, this will be handled by admin-ajax.php or REST API
        const response = await fetch('/wp-admin/admin-ajax.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                action: 'save_consultation_request',
                nonce: window.consultationNonce || '',
                ...formData
            })
        });
        
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        
        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Error saving form data:', error);
        
        // Fallback: Save to localStorage for development/testing
        const consultations = JSON.parse(localStorage.getItem('consultations') || '[]');
        consultations.push(formData);
        localStorage.setItem('consultations', JSON.stringify(consultations));
        
        console.log('Form data saved to localStorage:', formData);
        
        return { success: true };
    }
}

// Header Functions
function initHeader() {
    const header = document.getElementById('header');
    const mobileMenuToggle = document.getElementById('mobileMenuToggle');
    const headerNav = document.getElementById('headerNav');
    const navLinks = document.querySelectorAll('.nav-link');

    // Sticky header on scroll
    let lastScroll = 0;
    window.addEventListener('scroll', function() {
        const currentScroll = window.pageYOffset;
        
        if (currentScroll > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
        
        lastScroll = currentScroll;
    });

    // Mobile menu toggle
    if (mobileMenuToggle) {
        mobileMenuToggle.addEventListener('click', function() {
            mobileMenuToggle.classList.toggle('active');
            headerNav.classList.toggle('active');
            document.body.style.overflow = headerNav.classList.contains('active') ? 'hidden' : '';
        });
    }

    // Close mobile menu on link click
    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            if (window.innerWidth <= 968) {
                mobileMenuToggle.classList.remove('active');
                headerNav.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
    });

    // Active navigation link on scroll
    const sections = document.querySelectorAll('section[id]');
    
    function highlightNavigation() {
        const scrollPosition = window.pageYOffset + 100;

        sections.forEach(section => {
            const sectionTop = section.offsetTop;
            const sectionHeight = section.offsetHeight;
            const sectionId = section.getAttribute('id');
            const navLink = document.querySelector(`.nav-link[href="#${sectionId}"]`);

            if (navLink && scrollPosition >= sectionTop && scrollPosition < sectionTop + sectionHeight) {
                navLinks.forEach(link => link.classList.remove('active'));
                navLink.classList.add('active');
            }
        });
    }

    window.addEventListener('scroll', highlightNavigation);
    highlightNavigation(); // Initial call
}

// Initialize scroll animations
document.addEventListener('DOMContentLoaded', function() {
    initScrollAnimations();
});

// Scroll Animation Observer - Enhanced
function initScrollAnimations() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -100px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                // Добавляем дополнительный класс для особых эффектов
                if (entry.target.classList.contains('section-title')) {
                    setTimeout(() => {
                        entry.target.style.transform = 'translateY(0) scale(1.02)';
                        setTimeout(() => {
                            entry.target.style.transform = 'translateY(0) scale(1)';
                        }, 200);
                    }, 400);
                }
            }
        });
    }, observerOptions);

    // Observe all animated elements
    const animatedElements = document.querySelectorAll(
        '.fade-in, .slide-in-left, .slide-in-right, .scale-in, ' +
        '.problem-card, .service-card, .case-card, .trust-item, .format-card, ' +
        '.finance-area, .step, .testimonial-card, .section-title, .section-subtitle'
    );

    animatedElements.forEach(el => observer.observe(el));
    
    // Добавляем параллакс эффект при скролле
    let ticking = false;
    window.addEventListener('scroll', () => {
        if (!ticking) {
            window.requestAnimationFrame(() => {
                addParallaxEffect();
                ticking = false;
            });
            ticking = true;
        }
    });
}

// Параллакс эффект для hero секции
function addParallaxEffect() {
    const scrolled = window.pageYOffset;
    const hero = document.querySelector('.hero');
    if (hero && scrolled < window.innerHeight) {
        hero.style.transform = `translateY(${scrolled * 0.5}px)`;
        hero.style.opacity = 1 - (scrolled / window.innerHeight) * 0.5;
    }
}

// Event Listeners
document.addEventListener('DOMContentLoaded', function() {
    // Initialize header
    initHeader();
    // Phone input formatting
    const phoneInput = document.getElementById('phone');
    if (phoneInput) {
        phoneInput.addEventListener('input', function() {
            formatPhoneNumber(this);
        });
        
        phoneInput.addEventListener('focus', function() {
            if (this.value === '') {
                this.value = '+7 ';
            }
        });
    }
    
    // Real-time validation
    const nameInput = document.getElementById('name');
    if (nameInput) {
        nameInput.addEventListener('blur', function() {
            const error = validateName(this.value.trim());
            if (error) {
                showError('name', error);
            } else {
                clearError('name');
            }
        });
    }
    
    const emailInput = document.getElementById('email');
    if (emailInput) {
        emailInput.addEventListener('blur', function() {
            const error = validateEmail(this.value.trim());
            if (error) {
                showError('email', error);
            } else {
                clearError('email');
            }
        });
    }
    
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href !== '#privacy' && href !== '#') {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }
        });
    });
    
    // Close modal on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const modal = document.getElementById('consultationModal');
            if (modal.classList.contains('active')) {
                closeModal();
            }
        }
    });
    
    // Prevent modal close when clicking inside modal content
    const modalContent = document.querySelector('.modal-content');
    if (modalContent) {
        modalContent.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    }
});

// Add animation on scroll
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver(function(entries) {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.animation = 'fadeInUp 0.6s ease-out forwards';
            observer.unobserve(entry.target);
        }
    });
}, observerOptions);

document.addEventListener('DOMContentLoaded', function() {
    const animatedElements = document.querySelectorAll('.benefit-card, .step, .testimonial-card');
    animatedElements.forEach(el => {
        el.style.opacity = '0';
        observer.observe(el);
    });
});
