// ============================================
// JavaScript Mejorado - Consejo Escolar
// ============================================

document.addEventListener('DOMContentLoaded', function() {
    
    // Inicializar funcionalidades
    initMobileMenu();
    initTabs();
    initAlerts();
    initSmoothScroll();
    initLazyLoading();
    initFormValidation();
    
});

// ============================================
// Menu Mobile
// ============================================
function initMobileMenu() {
    const menuToggle = document.getElementById('menuToggle');
    const mainNav = document.getElementById('mainNav');
    
    if (menuToggle && mainNav) {
        menuToggle.addEventListener('click', function() {
            mainNav.classList.toggle('active');
            
            // Animación del icono hamburguesa
            this.classList.toggle('active');
            
            // Prevenir scroll cuando menu está abierto
            if (mainNav.classList.contains('active')) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = '';
            }
        });
        
        // Cerrar menu al hacer click fuera
        document.addEventListener('click', function(e) {
            if (!menuToggle.contains(e.target) && !mainNav.contains(e.target)) {
                mainNav.classList.remove('active');
                menuToggle.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
        
        // Cerrar menu al hacer click en un enlace
        const navLinks = mainNav.querySelectorAll('a');
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                mainNav.classList.remove('active');
                menuToggle.classList.remove('active');
                document.body.style.overflow = '';
            });
        });
    }
}

// ============================================
// Sistema de Tabs
// ============================================
function initTabs() {
    const tabButtons = document.querySelectorAll('.tab-btn');
    
    if (tabButtons.length === 0) return;
    
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetTab = this.getAttribute('data-tab');
            
            // Remover active de todos los botones y panes
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            
            document.querySelectorAll('.tab-pane').forEach(pane => {
                pane.classList.remove('active');
            });
            
            // Agregar active al botón clickeado y su pane correspondiente
            this.classList.add('active');
            const targetPane = document.getElementById(targetTab);
            if (targetPane) {
                targetPane.classList.add('active');
                
                // Scroll suave al inicio del contenido
                targetPane.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }
        });
    });
    
    // Soporte para navegación con teclado
    tabButtons.forEach((button, index) => {
        button.addEventListener('keydown', function(e) {
            let newIndex = index;
            
            if (e.key === 'ArrowRight') {
                newIndex = (index + 1) % tabButtons.length;
                e.preventDefault();
            } else if (e.key === 'ArrowLeft') {
                newIndex = (index - 1 + tabButtons.length) % tabButtons.length;
                e.preventDefault();
            } else if (e.key === 'Home') {
                newIndex = 0;
                e.preventDefault();
            } else if (e.key === 'End') {
                newIndex = tabButtons.length - 1;
                e.preventDefault();
            }
            
            if (newIndex !== index) {
                tabButtons[newIndex].click();
                tabButtons[newIndex].focus();
            }
        });
    });
}

// ============================================
// Sistema de Alertas
// ============================================
function initAlerts() {
    // Auto-hide alerts después de 5 segundos
    const alerts = document.querySelectorAll('.alert');
    
    alerts.forEach(alert => {
        // Agregar botón de cerrar si no existe
        if (!alert.querySelector('.alert-close')) {
            const closeBtn = document.createElement('button');
            closeBtn.className = 'alert-close';
            closeBtn.innerHTML = '&times;';
            closeBtn.setAttribute('aria-label', 'Cerrar alerta');
            alert.appendChild(closeBtn);
            
            closeBtn.addEventListener('click', function() {
                dismissAlert(alert);
            });
        }
        
        // Auto-dismiss después de 5 segundos
        setTimeout(() => {
            dismissAlert(alert);
        }, 5000);
    });
}

function dismissAlert(alert) {
    alert.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
    alert.style.opacity = '0';
    alert.style.transform = 'translateY(-20px)';
    setTimeout(() => {
        alert.remove();
    }, 500);
}

// ============================================
// Smooth Scroll
// ============================================
function initSmoothScroll() {
    const links = document.querySelectorAll('a[href^="#"]');
    
    links.forEach(link => {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            
            if (href === '#') return;
            
            const target = document.querySelector(href);
            if (target) {
                e.preventDefault();
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
                
                // Actualizar URL sin saltar
                if (history.pushState) {
                    history.pushState(null, null, href);
                }
            }
        });
    });
}

// ============================================
// Lazy Loading de Imágenes
// ============================================
function initLazyLoading() {
    const images = document.querySelectorAll('img[data-src]');
    
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.removeAttribute('data-src');
                    img.classList.add('loaded');
                    observer.unobserve(img);
                }
            });
        }, {
            rootMargin: '50px'
        });
        
        images.forEach(img => imageObserver.observe(img));
    } else {
        // Fallback para navegadores sin soporte
        images.forEach(img => {
            img.src = img.dataset.src;
            img.removeAttribute('data-src');
        });
    }
}

// ============================================
// Validación de Formularios
// ============================================
function initFormValidation() {
    const forms = document.querySelectorAll('form[data-validate]');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const isValid = validateForm(this);
            
            if (!isValid) {
                e.preventDefault();
                
                // Scroll al primer error
                const firstError = this.querySelector('.form-error');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }
        });
        
        // Validación en tiempo real
        const inputs = form.querySelectorAll('input, textarea, select');
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                validateField(this);
            });
            
            input.addEventListener('input', function() {
                if (this.classList.contains('is-invalid')) {
                    validateField(this);
                }
            });
        });
    });
}

function validateForm(form) {
    let isValid = true;
    const inputs = form.querySelectorAll('input[required], textarea[required], select[required]');
    
    inputs.forEach(input => {
        if (!validateField(input)) {
            isValid = false;
        }
    });
    
    return isValid;
}

function validateField(field) {
    const value = field.value.trim();
    let isValid = true;
    let errorMessage = '';
    
    // Limpiar errores previos
    clearFieldError(field);
    
    // Validar campo requerido
    if (field.hasAttribute('required') && value === '') {
        isValid = false;
        errorMessage = 'Este campo es obligatorio';
    }
    
    // Validar email
    if (field.type === 'email' && value !== '') {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(value)) {
            isValid = false;
            errorMessage = 'Ingrese un email válido';
        }
    }
    
    // Validar longitud mínima
    if (field.hasAttribute('minlength')) {
        const minLength = parseInt(field.getAttribute('minlength'));
        if (value.length < minLength && value.length > 0) {
            isValid = false;
            errorMessage = `Mínimo ${minLength} caracteres`;
        }
    }
    
    // Validar longitud máxima
    if (field.hasAttribute('maxlength')) {
        const maxLength = parseInt(field.getAttribute('maxlength'));
        if (value.length > maxLength) {
            isValid = false;
            errorMessage = `Máximo ${maxLength} caracteres`;
        }
    }
    
    // Mostrar error si existe
    if (!isValid) {
        showFieldError(field, errorMessage);
    }
    
    return isValid;
}

function showFieldError(field, message) {
    field.classList.add('is-invalid');
    
    const formGroup = field.closest('.form-group');
    if (formGroup) {
        let errorElement = formGroup.querySelector('.form-error');
        
        if (!errorElement) {
            errorElement = document.createElement('div');
            errorElement.className = 'form-error';
            formGroup.appendChild(errorElement);
        }
        
        errorElement.textContent = message;
        errorElement.style.display = 'block';
    }
}

function clearFieldError(field) {
    field.classList.remove('is-invalid');
    
    const formGroup = field.closest('.form-group');
    if (formGroup) {
        const errorElement = formGroup.querySelector('.form-error');
        if (errorElement) {
            errorElement.style.display = 'none';
        }
    }
}

// ============================================
// Confirmación de Eliminación
// ============================================
function confirmarEliminacion(mensaje) {
    return confirm(mensaje || '¿Está seguro de que desea eliminar este elemento? Esta acción no se puede deshacer.');
}

// ============================================
// Utilidades
// ============================================

// Formatear fechas
function formatDate(dateString) {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateString).toLocaleDateString('es-AR', options);
}

// Truncar texto
function truncateText(text, maxLength) {
    if (text.length <= maxLength) return text;
    return text.substring(0, maxLength) + '...';
}

// Debounce para búsquedas
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// ============================================
// Animaciones de Entrada
// ============================================
function initScrollAnimations() {
    const elements = document.querySelectorAll('.animate-on-scroll');
    
    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animated');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });
        
        elements.forEach(el => observer.observe(el));
    }
}

// Inicializar animaciones si existen elementos
if (document.querySelectorAll('.animate-on-scroll').length > 0) {
    initScrollAnimations();
}

// ============================================
// Exportar funciones para uso global
// ============================================
window.consejoEscolar = {
    confirmarEliminacion,
    formatDate,
    truncateText,
    debounce,
    dismissAlert
};