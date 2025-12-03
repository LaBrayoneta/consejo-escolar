/**
 * Utilidades para manejo de eliminaciones en el panel de administración
 * Guarda como: public/js/admin-delete.js
 */

// ============================================
// Confirmación de Eliminación Mejorada
// ============================================

/**
 * Función global para confirmar eliminación
 * @param {number} id - ID del elemento a eliminar
 * @param {string} nombre - Nombre del elemento
 * @param {string} tipo - Tipo de elemento (aviso, oficina, consejero, etc.)
 * @returns {boolean}
 */
window.confirmarEliminar = function(id, nombre, tipo = 'elemento') {
    // Crear un modal de confirmación personalizado
    const mensaje = `¿Estás seguro de que deseas eliminar ${tipo === 'elemento' ? 'este elemento' : 'el ' + tipo}?

📋 Nombre: "${nombre}"
🆔 ID: #${id}

⚠️ ADVERTENCIA: Esta acción no se puede deshacer.`;

    return window.confirm(mensaje);
};

/**
 * Eliminar elemento con confirmación y feedback visual
 */
window.eliminarConConfirmacion = function(url, nombre, tipo = 'elemento') {
    if (!window.confirmarEliminar(null, nombre, tipo)) {
        return false;
    }
    
    // Mostrar indicador de carga
    const loadingOverlay = document.createElement('div');
    loadingOverlay.id = 'deleteLoadingOverlay';
    loadingOverlay.innerHTML = `
        <div style="
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        ">
            <div style="
                background: white;
                padding: 30px 40px;
                border-radius: 16px;
                text-align: center;
                box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            ">
                <div class="spinner" style="
                    width: 50px;
                    height: 50px;
                    margin: 0 auto 20px;
                    border: 4px solid #f3f3f3;
                    border-top: 4px solid #667eea;
                    border-radius: 50%;
                    animation: spin 1s linear infinite;
                "></div>
                <p style="margin: 0; font-size: 18px; font-weight: 600; color: #333;">
                    Eliminando...
                </p>
            </div>
        </div>
    `;
    
    document.body.appendChild(loadingOverlay);
    
    // Agregar animación de spinner
    const style = document.createElement('style');
    style.textContent = `
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    `;
    document.head.appendChild(style);
    
    // Redirigir después de un pequeño delay para mostrar el loading
    setTimeout(() => {
        window.location.href = url;
    }, 500);
    
    return false;
};

/**
 * Manejar eliminación desde onclick inline
 */
document.addEventListener('DOMContentLoaded', function() {
    // Interceptar todos los botones de eliminación
    const deleteButtons = document.querySelectorAll('[data-delete]');
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const url = this.getAttribute('data-delete-url');
            const nombre = this.getAttribute('data-delete-nombre');
            const tipo = this.getAttribute('data-delete-tipo') || 'elemento';
            
            if (confirmarEliminar(null, nombre, tipo)) {
                eliminarConConfirmacion(url, nombre, tipo);
            }
        });
    });
});

/**
 * Funciones específicas por tipo de contenido
 */

window.eliminarAviso = function(id, titulo) {
    const url = BASE_URL + 'admin/eliminar_aviso/' + id;
    return eliminarConConfirmacion(url, titulo, 'aviso');
};

window.eliminarOficina = function(id, nombre) {
    const url = BASE_URL + 'admin/oficinas/eliminar/' + id;
    return eliminarConConfirmacion(url, nombre, 'oficina');
};

window.eliminarConsejero = function(id, nombre) {
    const url = BASE_URL + 'admin/consejeros/eliminar/' + id;
    return eliminarConConfirmacion(url, nombre, 'consejero');
};

window.eliminarInstitucion = function(id, nombre) {
    const url = BASE_URL + 'admin/instituciones/eliminar/' + id;
    return eliminarConConfirmacion(url, nombre, 'institución');
};

window.eliminarSeccion = function(id, titulo) {
    const url = BASE_URL + 'admin/informacion/eliminar/' + id;
    return eliminarConConfirmacion(url, titulo, 'sección');
};

/**
 * Mostrar notificación después de eliminar
 */
window.addEventListener('load', function() {
    // Verificar si hay un mensaje flash de éxito en la eliminación
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('deleted') === 'success') {
        mostrarNotificacion('Elemento eliminado exitosamente', 'success');
    }
});

function mostrarNotificacion(mensaje, tipo = 'success') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${tipo}`;
    notification.innerHTML = `
        <div style="
            position: fixed;
            top: 20px;
            right: 20px;
            background: ${tipo === 'success' ? '#48bb78' : '#f56565'};
            color: white;
            padding: 16px 24px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            z-index: 10000;
            animation: slideIn 0.3s ease-out;
        ">
            <strong>${tipo === 'success' ? '✓' : '✗'}</strong> ${mensaje}
        </div>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.opacity = '0';
        notification.style.transform = 'translateX(100px)';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Agregar estilos para animaciones
const animationStyles = document.createElement('style');
animationStyles.textContent = `
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(100px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
`;
document.head.appendChild(animationStyles);

console.log('✓ Sistema de eliminación cargado correctamente');