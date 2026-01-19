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
    
    if (field && errorElement) {
        field.classList.add('error');
        errorElement.textContent = message;
        errorElement.classList.add('active');
    }
}

function clearError(fieldId) {
    const field = document.getElementById(fieldId);
    const errorElement = document.getElementById(fieldId + 'Error');
    
    if (field && errorElement) {
        field.classList.remove('error');
        errorElement.textContent = '';
        errorElement.classList.remove('active');
    }
}

function clearErrors() {
    const fields = ['name', 'email', 'phone', 'privacy'];
    fields.forEach(field => clearError(field));
}

function hideSuccessMessage() {
    const successMessage = document.getElementById('successMessage');
    if (successMessage) {
        successMessage.style.display = 'none';
    }
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
    const formData = new FormData(form);
    const data = {
        name: formData.get('name').trim(),
        email: formData.get('email').trim(),
        phone: formData.get('phone').trim(),
        comment: formData.get('comment').trim(),
        privacy: formData.get('privacy') ? true : false,
        nonce: formData.get('consultation_nonce')
    };
    
    // Validate all fields
    let hasErrors = false;
    
    const nameError = validateName(data.name);
    if (nameError) {
        showError('name', nameError);
        hasErrors = true;
    }
    
    const emailError = validateEmail(data.email);
    if (emailError) {
        showError('email', emailError);
        hasErrors = true;
    }
    
    const phoneError = validatePhone(data.phone);
    if (phoneError) {
        showError('phone', phoneError);
        hasErrors = true;
    }
    
    if (!data.privacy) {
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
        // Send to WordPress AJAX handler
        const response = await fetch(investmentLanding.ajaxUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                action: 'save_consultation_request',
                ...data
            })
        });
        
        const result = await response.json();
        
        if (result.success) {
            // Show success message
            document.getElementById('successMessage').style.display = 'block';
            
            // Reset form
            form.reset();
            
            // Close modal after 3 seconds
            setTimeout(() => {
                closeModal();
            }, 3000);
        } else {
            throw new Error(result.data?.message || 'Ошибка при отправке формы');
        }
    } catch (error) {
        console.error('Form submission error:', error);
        alert('Произошла ошибка при отправке формы. Пожалуйста, попробуйте позже или свяжитесь с нами по email: info@finance-consulting.ru');
    } finally {
        // Re-enable submit button
        submitButton.disabled = false;
        buttonText.style.display = 'inline';
        buttonLoader.style.display = 'none';
    }
}

// Event Listeners
document.addEventListener('DOMContentLoaded', function() {
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
            if (modal && modal.classList.contains('active')) {
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
