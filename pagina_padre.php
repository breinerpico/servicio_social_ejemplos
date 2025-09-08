<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'modelo/conexion.php';

// Verificar si hay sesión iniciada
if (isset($_SESSION['username'])) {
    $nombre_usuario = $_SESSION['username'];

    // Obtener datos del acudiente
    $query = "SELECT nombre, apellidos FROM acudiente WHERE correo = '$nombre_usuario'";
    $resultado = mysqli_query($conexion, $query);
    $datos = mysqli_fetch_array($resultado);
} else {
    // Redirigir si no hay sesión
    header("location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Portal Acudientes</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f6f9;
        }

        /* Barra superior fija */
        .navbar {
            display: flex;
            justify-content: space-around;
            align-items: center;
            background: #2c3e50;
            padding: 15px;
            position: fixed; /* fijo arriba */
            top: 0;
            left: 0;
            width: 100%;
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

        /* Contenido inferior */
        .container {
            max-width: 900px;
            margin: 100px auto 30px auto; /* espacio para el menú */
            padding: 20px;
        }

        .welcome {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            text-align: center;
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

    <!-- Menú superior fijo -->
    <div class="navbar">
        <a href="#">Inicio</a>
        <a href="#">Progreso de mi hijo</a>
        <a href="#">Horas de Servicio</a>
        <a href="modelo/cerrar_sesion.php" class="logout">Cerrar Sesión</a>

    </div>

    <!-- Contenido en la parte inferior -->
    <div class="container">
        <div class="welcome">
            <?php
                if (isset($datos['nombre']) && isset($datos['apellidos'])) {
                    echo '<h1>Bienvenido/a, ' . $datos['nombre'] . ' ' . $datos['apellidos'] . '</h1>';
                } else {
                    echo '<h1>Usuario: ' . $nombre_usuario . '</h1>';
                }
            ?>
        </div>

        <div class="info">
            <h2>Información del Portal</h2>
            <p>En este portal puedes:</p>
            <ul>
                <li>Consultar el progreso académico de tu hijo.</li>
                <li>Revisar las horas de servicio realizadas.</li>
                <li>Mantenerte informado sobre el estado de sus actividades escolares.</li>
            </ul>
            <p><strong>Consejo:</strong> Usa el menú superior para navegar fácilmente.</p>
        </div>
    </div>

</body>
</html>
