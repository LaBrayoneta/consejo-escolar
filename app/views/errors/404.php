<!-- Este archivo debe estar en: app/views/errors/404.php -->

<section class="page-header">
    <div class="container">
        <h1>Página no encontrada</h1>
    </div>
</section>

<section class="error-section">
    <div class="container">
        <div class="error-card">
            <div class="error-icon">🔍</div>
            <h2>404 - Página no encontrada</h2>
            <p>Lo sentimos, el contenido que buscas no existe o no está disponible.</p>
            <div class="error-actions">
                <a href="<?php echo BASE_URL; ?>" class="btn btn-primary">
                    🏠 Ir al inicio
                </a>
                <a href="<?php echo BASE_URL; ?>avisos" class="btn btn-secondary">
                    📋 Ver avisos
                </a>
            </div>
        </div>
    </div>
</section>

<style>
.error-section {
    padding: var(--spacing-3xl) 0;
    min-height: 60vh;
    display: flex;
    align-items: center;
}

.error-card {
    max-width: 600px;
    margin: 0 auto;
    text-align: center;
    background: white;
    padding: var(--spacing-3xl);
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-lg);
}

.error-icon {
    font-size: 5rem;
    margin-bottom: var(--spacing-lg);
    animation: float 3s ease-in-out infinite;
}

@keyframes float {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-20px);
    }
}

.error-card h2 {
    font-size: 2rem;
    color: var(--text-primary);
    margin-bottom: var(--spacing-md);
    font-weight: 800;
    background: var(--primary-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.error-card p {
    font-size: 1.125rem;
    color: var(--text-secondary);
    margin-bottom: var(--spacing-xl);
    line-height: 1.6;
}

.error-actions {
    display: flex;
    gap: var(--spacing-md);
    justify-content: center;
    flex-wrap: wrap;
}

.btn {
    display: inline-flex;
    align-items: center;
    gap: var(--spacing-sm);
    padding: var(--spacing-md) var(--spacing-xl);
    border-radius: var(--radius-md);
    font-weight: 700;
    text-decoration: none;
    transition: all var(--transition-base);
    box-shadow: var(--shadow-md);
}

.btn-primary {
    background: var(--primary-gradient);
    color: white;
}

.btn-secondary {
    background: var(--secondary-gradient);
    color: white;
}

.btn:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-lg);
}

@media (max-width: 768px) {
    .error-actions {
        flex-direction: column;
    }
    
    .btn {
        width: 100%;
        justify-content: center;
    }
}
</style>