document.addEventListener('DOMContentLoaded', function() {
    initSidebarToggle();
    initSearch();
    initFilters();
    initAlertDismiss();
    initDeleteButtons(); // NUEVO: Inicializar botones de eliminar
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
    const grids = [
        document.getElementById('avisosGrid'),
        document.getElementById('oficinasgrid'),
        document.getElementById('consejerosGrid'),
        document.getElementById('institucionesGrid'),
        document.getElementById('seccionesGrid')
    ].filter(grid => grid !== null); // Filtrar los que existen
    
    const emptySearch = document.getElementById('emptySearch');
    
    if (!searchInput || grids.length === 0) return;
    
    searchInput.addEventListener('input', debounce(function() {
        const searchTerm = this.value.toLowerCase().trim();
        let totalVisibleCount = 0;
        
        grids.forEach(grid => {
            const cards = grid.querySelectorAll('.aviso-card-admin');
            let visibleCount = 0;
            
            cards.forEach(card => {
                const title = card.querySelector('.aviso-title')?.textContent.toLowerCase() || '';
                const excerpt = card.querySelector('.aviso-excerpt')?.textContent.toLowerCase() || '';
                
                if (title.includes(searchTerm) || excerpt.includes(searchTerm)) {
                    card.style.display = '';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });
            
            totalVisibleCount += visibleCount;
            
            // Mostrar/ocultar grid completo
            if (visibleCount === 0 && searchTerm !== '') {
                grid.style.display = 'none';
            } else {
                grid.style.display = 'grid';
            }
        });
        
        // Mostrar/ocultar empty state
        if (emptySearch) {
            if (totalVisibleCount === 0 && searchTerm !== '') {
                emptySearch.style.display = 'block';
            } else {
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
    const filterNivel = document.getElementById('filterNivel');
    
    if (filterSelect) {
        const grids = [
            document.getElementById('avisosGrid'),
            document.getElementById('oficinasgrid'),
            document.getElementById('consejerosGrid'),
            document.getElementById('institucionesGrid')
        ].filter(grid => grid !== null);
        
        filterSelect.addEventListener('change', function() {
            const filterValue = this.value;
            
            grids.forEach(grid => {
                const cards = grid.querySelectorAll('.aviso-card-admin');
                
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
        });
    }
    
    // Filtro por nivel (para instituciones)
    if (filterNivel) {
        const grid = document.getElementById('institucionesGrid');
        if (grid) {
            filterNivel.addEventListener('change', function() {
                const nivel = this.value;
                const cards = grid.querySelectorAll('[data-nivel]');
                
                cards.forEach(card => {
                    if(nivel === 'all' || card.dataset.nivel === nivel) {
                        card.style.display = '';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        }
    }
}

// ============================================
// DELETE BUTTONS - NUEVO
// ============================================
function initDeleteButtons() {
    // Interceptar todos los onclick de los botones de eliminar
    const deleteButtons = document.querySelectorAll('.btn-delete');
    
    deleteButtons.forEach(button => {
        // Si el botón tiene un onclick inline, prevenir ejecución y manejar aquí
        const onclickAttr = button.getAttribute('onclick');
        if (onclickAttr) {
            // Remover el onclick inline
            button.removeAttribute('onclick');
            
            // Agregar event listener
            button.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                // Ejecutar la función original del onclick
                try {
                    // Evaluar el código del onclick en el contexto global
                    const func = new Function(onclickAttr);
                    func.call(this);
                } catch (error) {
                    console.error('Error ejecutando función de eliminación:', error);
                }
            });
        }
    });
}

// ============================================
// FUNCIÓN GLOBAL confirmarEliminar
// ============================================
window.confirmarEliminar = function(id, nombre, tipo) {
    // Mensaje de confirmación mejorado
    const tipoTexto = tipo || 'elemento';
    const mensaje = `¿Estás seguro de eliminar "${nombre}"?\n\n⚠️ Esta acción no se puede deshacer.`;
    
    return confirm(mensaje);
};

// ============================================
// Alert Dismiss
// ============================================
function initAlertDismiss() {
    const alerts = document.querySelectorAll('.alert');
    
    alerts.forEach(alert => {
        if (!alert.querySelector('.alert-close')) {
            const closeBtn = document.createElement('button');
            closeBtn.className = 'alert-close';
            closeBtn.innerHTML = '×';
            closeBtn.setAttribute('aria-label', 'Cerrar alerta');
            closeBtn.style.cssText = `
                position: absolute;
                top: 8px;
                right: 12px;
                background: none;
                border: none;
                font-size: 24px;
                line-height: 1;
                cursor: pointer;
                opacity: 0.6;
                transition: opacity 0.2s;
            `;
            alert.style.position = 'relative';
            alert.appendChild(closeBtn);
            
            closeBtn.addEventListener('click', function() {
                dismissAlert(alert);
            });
            
            closeBtn.addEventListener('mouseenter', function() {
                this.style.opacity = '1';
            });
            
            closeBtn.addEventListener('mouseleave', function() {
                this.style.opacity = '0.6';
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

// ============================================
// Form Validation
// ============================================
function initFormValidation() {
    const forms = document.querySelectorAll('form[data-validate]');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!validateForm(this)) {
                e.preventDefault();
                
                const firstError = this.querySelector('.form-error:not([style*="display: none"])');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }
        });
        
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
    
    clearFieldError(field);
    
    if (field.hasAttribute('required') && value === '') {
        isValid = false;
        errorMessage = 'Este campo es obligatorio';
    }
    
    if (field.type === 'email' && value !== '') {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(value)) {
            isValid = false;
            errorMessage = 'Ingrese un email válido';
        }
    }
    
    if (field.hasAttribute('minlength')) {
        const minLength = parseInt(field.getAttribute('minlength'));
        if (value.length < minLength && value.length > 0) {
            isValid = false;
            errorMessage = `Mínimo ${minLength} caracteres`;
        }
    }
    
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
            errorElement.style.cssText = `
                color: #e53e3e;
                font-size: 13px;
                margin-top: 6px;
                font-weight: 600;
            `;
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

// Log de confirmación
console.log('✓ Admin.js cargado correctamente');
console.log('✓ Función confirmarEliminar disponible globalmente');