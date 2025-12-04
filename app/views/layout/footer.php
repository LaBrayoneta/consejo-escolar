</main>

    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Consejo Escolar</h3>
                    <p>Administración y gestión de instituciones educativas</p>
                </div>
                
                <div class="footer-section">
                    <h3>Enlaces</h3>
                    <ul>
                        <li><a href="<?php echo BASE_URL; ?>">Inicio</a></li>
                        <li><a href="<?php echo BASE_URL; ?>avisos">Avisos</a></li>
                        <li><a href="<?php echo BASE_URL; ?>oficinas">Oficinas</a></li>
                        <li><a href="<?php echo BASE_URL; ?>horarios">Horarios</a></li>
                        <li><a href="<?php echo BASE_URL; ?>sobre-nosotros">Sobre Nosotros</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h3>Contacto</h3>
                    <p>Email: ce008@abc.gob.ar</p>
                    <p>Teléfono: (0291) 123-4567</p>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> Consejo Escolar. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <style>
        .footer-horario {
            margin-top: 24px;
            padding: 16px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .footer-horario h4 {
            margin: 0 0 12px 0;
            font-size: 16px;
            font-weight: 800;
            color: white;
        }

        .footer-horario .horario-dias {
            margin: 0 0 6px 0;
            color: rgba(255, 255, 255, 0.9);
            font-size: 14px;
            font-weight: 600;
        }

        .footer-horario .horario-horas {
            margin: 0 0 12px 0;
            color: white;
            font-size: 18px;
            font-weight: 800;
            font-family: 'Monaco', 'Courier New', monospace;
        }

        .footer-horario .ver-horarios {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            font-size: 13px;
            font-weight: 700;
            transition: all 0.3s ease;
        }

        .footer-horario .ver-horarios:hover {
            gap: 10px;
            color: white;
        }
    </style>

    <script src="<?php echo BASE_URL; ?>js/main.js"></script>
</body>
</html>