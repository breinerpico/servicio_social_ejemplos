<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Colegio Guanentá</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #ffeef8 0%, #f8e1f4 50%, #f0d4ed 100%);
            min-height: 100vh;
            color: #6d4c7d;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            position: relative;
            min-height: 100vh;
        }

        /* Imágenes en las esquinas superiores */
        .corner-image {
            position: absolute;
            top: 20px;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 4px solid #e6b3d6;
            box-shadow: 0 8px 20px rgba(230, 179, 214, 0.4);
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .corner-image:hover {
            transform: scale(1.1) rotate(5deg);
        }

        .corner-left {
            left: 20px;
        }

        .corner-right {
            right: 20px;
        }

        /* Header */
        .header {
            text-align: center;
            margin: 60px 0 40px 0;
        }

        .header h1 {
            font-size: 2.5em;
            color: #8b5a6b;
            text-shadow: 2px 2px 4px rgba(139, 90, 107, 0.3);
            margin-bottom: 10px;
        }

        .header p {
            font-size: 1.2em;
            color: #a67c8a;
            font-style: italic;
        }

        /* Imagen central */
        .center-image-container {
            display: flex;
            justify-content: center;
            margin: 40px 0;
        }

        .center-image {
            width: 300px;
            height: 200px;
            border-radius: 20px;
            border: 5px solid #e6b3d6;
            box-shadow: 0 15px 35px rgba(230, 179, 214, 0.5);
            object-fit: cover;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .center-image:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 45px rgba(230, 179, 214, 0.7);
        }

        /* Contenedor de botones */
        .buttons-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            margin-top: 50px;
            padding: 0 20px;
        }

        /* Estilos de botones */
        .btn {
            background: linear-gradient(145deg, #f4c2c2, #e8a5c4);
            border: none;
            padding: 20px 25px;
            border-radius: 15px;
            color: #6d4c7d;
            font-size: 1.1em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 8px 20px rgba(232, 165, 196, 0.4);
            text-decoration: none;
            display: inline-block;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.6s ease;
        }

        .btn:hover::before {
            left: 100%;
        }

        .btn:hover {
            transform: translateY(-5px) scale(1.03);
            box-shadow: 0 12px 30px rgba(232, 165, 196, 0.6);
            background: linear-gradient(145deg, #f8d0d0, #edb3d1);
        }

        .btn:active {
            transform: translateY(-2px) scale(1.01);
        }

        /* Botón especial para iniciar sesión */
        .btn-login {
            background: linear-gradient(145deg, #d49ac7, #c485b8);
            color: #ffffff;
            font-weight: 700;
            text-shadow: 1px 1px 2px rgba(109, 76, 125, 0.5);
        }

        .btn-login:hover {
            background: linear-gradient(145deg, #db9fce, #cd8bbf);
            box-shadow: 0 12px 30px rgba(196, 133, 184, 0.6);
        }

        /* Iconos para botones */
        .btn-icon {
            margin-right: 10px;
            font-size: 1.3em;
        }

        /* Footer */
        .footer {
            text-align: center;
            margin-top: 60px;
            padding: 20px;
            color: #a67c8a;
        }

        /* Animaciones */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .floating {
            animation: float 3s ease-in-out infinite;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .corner-image {
                width: 80px;
                height: 80px;
            }

            .header h1 {
                font-size: 2em;
            }

            .center-image {
                width: 250px;
                height: 160px;
            }

            .buttons-container {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .btn {
                font-size: 1em;
                padding: 18px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Imágenes en las esquinas superiores -->
        <img src="https://via.placeholder.com/120x120/e6b3d6/ffffff?text=Logo+1" alt="Logo izquierdo" class="corner-image corner-left floating">
        <img src="https://via.placeholder.com/120x120/e6b3d6/ffffff?text=Logo+2" alt="Logo derecho" class="corner-image corner-right floating">

        <!-- Header -->
        <div class="header">
            <h1>🌸 Colegio Guanentá 🌸</h1>
            <p>Excelencia Educativa con Corazón</p>
        </div>

        <!-- Imagen central -->
        <div class="center-image-container">
            <img src="https://via.placeholder.com/300x200/f4c2c2/6d4c7d?text=Colegio+Guanentá" alt="Colegio Guanentá" class="center-image">
        </div>

        <!-- Botones principales -->
        <div class="buttons-container">
            <a href="generalidades.php" class="btn">
                <span class="btn-icon">🏫</span>
                Generalidades del Colegio Guanentá
            </a>

            <a href="examen-saber.php" class="btn">
                <span class="btn-icon">📚</span>
                Información sobre el examen Saber
            </a>

            <a href="estrategia-guanentino.php" class="btn">
                <span class="btn-icon">🎯</span>
                Estrategia Guanentino, Responda!
            </a>

            <a href="login.php" class="btn btn-login">
                <span class="btn-icon">🔐</span>
                Iniciar Sesión
            </a>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>&copy; <?php echo date('Y'); ?> Colegio Guanentá - Todos los derechos reservados</p>
            <p>Formando líderes con valores y excelencia académica</p>
        </div>
    </div>

    <script>
        // Agregar efectos interactivos
        document.querySelectorAll('.btn').forEach(button => {
            button.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px) scale(1.03)';
            });
            
            button.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });

        // Efecto de partículas flotantes
        function createFloatingElements() {
            const colors = ['#f4c2c2', '#e8a5c4', '#d49ac7', '#ffeef8'];
            
            for(let i = 0; i < 15; i++) {
                const element = document.createElement('div');
                element.style.position = 'fixed';
                element.style.width = Math.random() * 10 + 5 + 'px';
                element.style.height = element.style.width;
                element.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
                element.style.borderRadius = '50%';
                element.style.opacity = '0.3';
                element.style.left = Math.random() * 100 + '%';
                element.style.top = Math.random() * 100 + '%';
                element.style.pointerEvents = 'none';
                element.style.zIndex = '-1';
                
                document.body.appendChild(element);
                
                // Animación flotante
                element.animate([
                    { transform: 'translateY(0px)' },
                    { transform: 'translateY(-20px)' },
                    { transform: 'translateY(0px)' }
                ], {
                    duration: 3000 + Math.random() * 2000,
                    iterations: Infinity,
                    easing: 'ease-in-out'
                });
            }
        }

        // Inicializar efectos cuando se carga la página
        window.addEventListener('load', createFloatingElements);
    </script>
</body>
</html>