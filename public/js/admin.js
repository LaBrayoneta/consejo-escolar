document.addEventListener('DOMContentLoaded', function() {
    initSidebarToggle();
    initSearch();
    initFilters();
    initAlertDismiss();
});

// ============================================
// Sidebar Toggle
// ============================================
function initSidebarToggle() {
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.querySelector('.admin-sidebar');
    
    if (!sidebarToggle || !sidebar) return;
    
    sidebarToggle.addEventListener('click', function() {
        sidebar.classList.toggle('active');
        
        // Animar el botón
        this.classList.toggle('active');
    });
    
    // Cerrar al hacer click fuera en móvil
    document.addEventListener('click', function(e) {
        if (window.innerWidth <= 1024) {
            if (!sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
                sidebar.classList.remove('active');
                sidebarToggle.classList.remove('active');
            }
        }
    });
}

// ============================================
// Search Functionality
// ============================================
function initSearch() {
    const searchInput = document.getElementById('searchInput');
    const avisosGrid = document.getElementById('avisosGrid');
    const emptySearch = document.getElementById('emptySearch');
    
    if (!searchInput || !avisosGrid) return;
    
    searchInput.addEventListener('input', debounce(function() {
        const searchTerm = this.value.toLowerCase().trim();
        const cards = avisosGrid.querySelectorAll('.aviso-card-admin');
        let visibleCount = 0;
        
        cards.forEach(card => {
            const title = card.querySelector('.aviso-title').textContent.toLowerCase();
            const excerpt = card.querySelector('.aviso-excerpt').textContent.toLowerCase();
            
            if (title.includes(searchTerm) || excerpt.includes(searchTerm)) {
                card.style.display = '';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });
        
        // Mostrar/ocultar empty state
        if (emptySearch) {
            if (visibleCount === 0 && searchTerm !== '') {
                avisosGrid.style.display = 'none';
                emptySearch.style.display = 'block';
            } else {
                avisosGrid.style.display = 'grid';
                emptySearch.style.display = 'none';
            }
        }
    }, 300));
}

// ============================================
// Filters
// ============================================
function initFilters() {
    const filterSelect = document.getElementById('filterStatus');
    const avisosGrid = document.getElementById('avisosGrid');
    
    if (!filterSelect || !avisosGrid) return;
    
    filterSelect.addEventListener('change', function() {
        const filterValue = this.value;
        const cards = avisosGrid.querySelectorAll('.aviso-card-admin');
        
        cards.forEach(card => {
            const status = card.dataset.status;
            const destacado = card.dataset.destacado;
            
            switch(filterValue) {
                case 'all':
                    card.style.display = '';
                    break;
                case 'active':
                    card.style.display = status === 'active' ? '' : 'none';
                    break;
                case 'inactive':
                    card.style.display = status === 'inactive' ? '' : 'none';
                    break;
                case 'destacado':
                    card.style.display = destacado === '1' ? '' : 'none';
                    break;
            }
        });
    });
}

// ============================================
// Alert Dismiss
// ============================================
function initAlertDismiss() {
    const alerts = document.querySelectorAll('.alert');
    
    alerts.forEach(alert => {
        // Crear botón de cerrar si no existe
        if (!alert.querySelector('.alert-close')) {
            const closeBtn = document.createElement('button');
            closeBtn.className = 'alert-close';
            closeBtn.innerHTML = '×';
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
    alert.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
    alert.style.opacity = '0';
    alert.style.transform = 'translateY(-20px)';
    
    setTimeout(() => {
        alert.remove();
    }, 300);
}

// ============================================
// Utilidades
// ============================================

// Debounce function
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

// Formatear fecha
function formatDate(dateString) {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateString).toLocaleDateString('es-AR', options);
}

// Confirmación de acciones
function confirm(message) {
    return window.confirm(message);
}

// ============================================
// Form Validation
// ============================================
function initFormValidation() {
    const forms = document.querySelectorAll('form[data-validate]');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!validateForm(this)) {
                e.preventDefault();
                
                // Scroll al primer error
                const firstError = this.querySelector('.form-error:not([style*="display: none"])');
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
// Exportar funciones globales
// ============================================
window.adminUtils = {
    dismissAlert,
    formatDate,
    debounce
};