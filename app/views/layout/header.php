<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title . ' - ' : ''; ?>Consejo Escolar</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/style.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <a href="<?php echo BASE_URL; ?>">
                        <h1>Consejo Escolar</h1>
                    </a>
                </div>
                
                <button class="menu-toggle" id="menuToggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                
                <nav class="main-nav" id="mainNav">
                    <ul>
                        <li><a href="<?php echo BASE_URL; ?>">Inicio</a></li>
                        <li><a href="<?php echo BASE_URL; ?>avisos">Avisos</a></li>
                        <li><a href="<?php echo BASE_URL; ?>oficinas">Oficinas</a></li>
                        <li><a href="<?php echo BASE_URL; ?>sobre-nosotros">Sobre Nosotros</a></li>
                        <li><a href="<?php echo ADMIN_URL; ?>">Admin</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <main class="main-content"></main>