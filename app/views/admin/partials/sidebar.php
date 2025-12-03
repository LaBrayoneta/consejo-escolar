
<aside class="admin-sidebar">
    <div class="sidebar-header">
        <h2>🏫 Consejo Escolar</h2>
        <p style="font-size: 12px; opacity: 0.7; margin-top: 4px;">Panel de Administración</p>
    </div>
    
    <nav class="sidebar-nav">
        <ul>
            <li><a href="<?php echo BASE_URL; ?>admin">📊 Dashboard</a></li>
            <li><a href="<?php echo BASE_URL; ?>admin/avisos">📝 Avisos</a></li>
            <li><a href="<?php echo BASE_URL; ?>admin/oficinas">🏢 Oficinas</a></li>
            <li><a href="<?php echo BASE_URL; ?>admin/consejeros">👔 Consejeros</a></li>
            <li><a href="<?php echo BASE_URL; ?>admin/instituciones">🏫 Instituciones</a></li>
            <li><a href="<?php echo BASE_URL; ?>admin/informacion">📋 Información Institucional</a></li>
            <li><a href="<?php echo BASE_URL; ?>admin/usuarios">👥 Usuarios</a></li>
        </ul>
    </nav>
    
    <div class="sidebar-footer">
        <a href="<?php echo BASE_URL; ?>">🌐 Ver sitio público</a>
        <a href="<?php echo BASE_URL; ?>admin/logout">🚪 Cerrar Sesión</a>
    </div>
</aside>

<style>
/* Mejoras específicas para el sidebar footer */
.sidebar-footer {
    padding: 16px;
    background: rgba(0,0,0,0.2);
    border-top: 1px solid rgba(255,255,255,0.1);
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.footer-link {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 16px;
    color: rgba(255,255,255,0.9);
    text-decoration: none;
    border-radius: 12px;
    transition: all 0.3s ease;
    font-weight: 600;
    font-size: 14px;
    position: relative;
    overflow: hidden;
    border: 1px solid rgba(255,255,255,0.1);
}

.footer-link::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255,255,255,0.1);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.footer-link:hover::before {
    opacity: 1;
}

.footer-link-primary {
    background: linear-gradient(135deg, rgba(79, 172, 254, 0.2) 0%, rgba(0, 242, 254, 0.2) 100%);
    border-color: rgba(79, 172, 254, 0.3);
}

.footer-link-primary:hover {
    background: linear-gradient(135deg, rgba(79, 172, 254, 0.3) 0%, rgba(0, 242, 254, 0.3) 100%);
    border-color: rgba(79, 172, 254, 0.5);
    transform: translateX(4px);
}

.footer-link-danger {
    background: linear-gradient(135deg, rgba(245, 101, 101, 0.2) 0%, rgba(229, 62, 62, 0.2) 100%);
    border-color: rgba(245, 101, 101, 0.3);
}

.footer-link-danger:hover {
    background: linear-gradient(135deg, rgba(245, 101, 101, 0.3) 0%, rgba(229, 62, 62, 0.3) 100%);
    border-color: rgba(245, 101, 101, 0.5);
    transform: translateX(4px);
}

.link-icon {
    font-size: 20px;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    background: rgba(255,255,255,0.1);
    border-radius: 8px;
    transition: all 0.3s ease;
}

.footer-link:hover .link-icon {
    background: rgba(255,255,255,0.2);
    transform: scale(1.1);
}

.link-text {
    flex: 1;
    position: relative;
    z-index: 1;
}

.link-arrow {
    font-size: 18px;
    font-weight: 800;
    opacity: 0.7;
    transition: all 0.3s ease;
    position: relative;
    z-index: 1;
}

.footer-link:hover .link-arrow {
    opacity: 1;
    transform: translateX(4px);
}

/* Animación de brillo */
@keyframes shine {
    0% {
        left: -100%;
    }
    50%, 100% {
        left: 100%;
    }
}

.footer-link::after {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s ease;
}

.footer-link:hover::after {
    animation: shine 1s ease-in-out;
}

/* Responsive */
@media (max-width: 1024px) {
    .sidebar-footer {
        padding: 12px;
    }
    
    .footer-link {
        padding: 12px 14px;
        font-size: 13px;
    }
    
    .link-icon {
        width: 28px;
        height: 28px;
        font-size: 18px;
    }
}
</style>