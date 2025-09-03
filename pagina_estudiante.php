<?php
session_start();

require 'modelo/conexion.php';

if(isset($_SESSION['username']))
{
    $nombre_usuario = $_SESSION['username'];
    
    // Obtener datos del estudiante
    $query = "SELECT nombre, apellidos FROM estudiante WHERE correo = '$nombre_usuario'";
    $resultado = mysqli_query($conexion, $query);
    $datos = mysqli_fetch_array($resultado);
}
else
{
    // Si no hay sesión, redirigir al index
    header("location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
        <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Portal Estudiante</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f6f9;
        }

        /* Barra superior */
        .navbar {
            display: flex;
            justify-content: space-around;
            background: #34495e;
            padding: 15px;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            padding: 10px 15px;
            border-radius: 6px;
            transition: background 0.3s;
        }

        .navbar a:hover {
            background: #1abc9c;
        }

        .logout {
            background: #e74c3c;
        }

        /* Contenido */
        .container {
            max-width: 900px;
            margin: 30px auto;
            padding: 20px;
        }

        .welcome {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .info {
            background: #ecf0f1;
            padding: 15px;
            border-radius: 8px;
        }

        h1, h2 {
            color: #2c3e50;
        }
    </style>
</head>
<body>

    <!-- Menú superior -->
    <div class="navbar">
        <a href="#">Inicio</a>
        <a href="#">Mis Horas de Servicio</a>
        <a href="#">Enviar Solicitudes</a>
        <a href="#">Estado de Solicitudes</a>
        <a href="modelo/cerrar_sesion.php" class="logout">Cerrar Sesión</a>
    </div>

    <!-- Contenido -->
    <div class="container">
        <div class="welcome">
            <?php
                if(isset($datos['nombre']) && isset($datos['apellidos'])) {
                    echo '<h1>Bienvenido/a, ' . $datos['nombre'] . ' ' . $datos['apellidos'] . '</h1>';
                } else {
                    echo '<h1>Usuario: ' . $nombre_usuario . '</h1>';
                }
            ?>
        </div>

        <div class="info">
            <h2>Información del Portal</h2>
            <p>En este portal puedes realizar las siguientes acciones:</p>
            <ul>
                <li>Consultar y hacer seguimiento a tus horas de servicio social.</li>
                <li>Enviar solicitudes para realizar actividades de servicio.</li>
                <li>Verificar el estado de tus solicitudes enviadas.</li>
            </ul>
            <p><strong>Consejo:</strong> Usa los botones superiores para acceder rápidamente a cada sección.</p>
        </div>
    </div>

</body>
</html>
