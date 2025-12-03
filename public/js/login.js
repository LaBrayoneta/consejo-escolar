document.addEventListener('DOMContentLoaded', function() {
    
    initPasswordToggle();
    initFormValidation();
    initRememberMe();
    
});

// ============================================
// Toggle Password Visibility
// ============================================
function initPasswordToggle() {
    const toggleButton = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    
    if (toggleButton && passwordInput) {
        toggleButton.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            // Cambiar el emoji
            this.textContent = type === 'password' ? '👁️' : '🙈';
        });
    }
}

// ============================================
// Form Validation
// ============================================
function initFormValidation() {
    const form = document.getElementById('loginForm');
    
    if (!form) return;
    
    const usernameInput = document.getElementById('username');
    const passwordInput = document.getElementById('password');
    
    form.addEventListener('submit', function(e) {
        let isValid = true;
        
        // Validar usuario
        if (usernameInput.value.trim() === '') {
            showError(usernameInput, 'Por favor ingrese su usuario');
            isValid = false;
        } else {
            clearError(usernameInput);
        }
        
        // Validar contraseña
        if (passwordInput.value.trim() === '') {
            showError(passwordInput, 'Por favor ingrese su contraseña');
            isValid = false;
        } else {
            clearError(passwordInput);
        }
        
        if (!isValid) {
            e.preventDefault();
            return false;
        }
        
        // Mostrar loading state
        const submitButton = form.querySelector('button[type="submit"]');
        if (submitButton) {
            submitButton.classList.add('loading');
            submitButton.disabled = true;
        }
    });
    
    // Limpiar errores al escribir
    usernameInput.addEventListener('input', function() {
        clearError(this);
    });
    
    passwordInput.addEventListener('input', function() {
        clearError(this);
    });
}

function showError(input, message) {
    const formGroup = input.closest('.form-group');
    if (!formGroup) return;
    
    // Remover error previo
    clearError(input);
    
    // Agregar clase de error
    input.style.borderColor = '#e53e3e';
    
    // Crear mensaje de error
    const errorDiv = document.createElement('div');
    errorDiv.className = 'input-error';
    errorDiv.textContent = message;
    errorDiv.style.cssText = `
        color: #e53e3e;
        font-size: 12px;
        margin-top: 6px;
        font-weight: 500;
        animation: slideIn 0.3s ease;
    `;
    
    formGroup.appendChild(errorDiv);
    
    // Shake animation
    input.style.animation = 'shake 0.5s ease';
    setTimeout(() => {
        input.style.animation = '';
    }, 500);
}

function clearError(input) {
    const formGroup = input.closest('.form-group');
    if (!formGroup) return;
    
    input.style.borderColor = '';
    
    const errorDiv = formGroup.querySelector('.input-error');
    if (errorDiv) {
        errorDiv.remove();
    }
}

// ============================================
// Remember Me
// ============================================
function initRememberMe() {
    const rememberCheckbox = document.getElementById('remember');
    const usernameInput = document.getElementById('username');
    
    if (!rememberCheckbox || !usernameInput) return;
    
    // Cargar usuario guardado
    const savedUsername = localStorage.getItem('remembered_username');
    if (savedUsername) {
        usernameInput.value = savedUsername;
        rememberCheckbox.checked = true;
    }
    
    // Guardar o eliminar al enviar
    const form = document.getElementById('loginForm');
    if (form) {
        form.addEventListener('submit', function() {
            if (rememberCheckbox.checked) {
                localStorage.setItem('remembered_username', usernameInput.value);
            } else {
                localStorage.removeItem('remembered_username');
            }
        });
    }
}

// ============================================
// Auto-hide alerts
// ============================================
const alerts = document.querySelectorAll('.alert');
alerts.forEach(alert => {
    setTimeout(() => {
        alert.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
        alert.style.opacity = '0';
        alert.style.transform = 'translateY(-20px)';
        setTimeout(() => alert.remove(), 500);
    }, 5000);
});

// ============================================
// Keyboard shortcuts
// ============================================
document.addEventListener('keydown', function(e) {
    // Enter en cualquier input ejecuta el submit
    if (e.key === 'Enter' && document.activeElement.tagName === 'INPUT') {
        const form = document.getElementById('loginForm');
        if (form) {
            form.requestSubmit();
        }
    }
});