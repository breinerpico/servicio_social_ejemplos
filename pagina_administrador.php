<?php
error_reporting(E_ALL);
ini_set('display_errors','1');

require 'modelo/conexion.php';
session_start();

if(isset($_SESSION['username'])) {
    $nombre_usuario = $_SESSION['username'];

    // Obtener datos del administrador
    $query = "SELECT nombre, apellidos FROM administrador WHERE correo = '$nombre_usuario'";
    $resultado = mysqli_query($conexion, $query);
    $datos = mysqli_fetch_array($resultado);
} else {
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
  <title>Panel Administrador</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      display: flex;
      height: 100vh;
      background: #f4f6f9;
    }

    /* Menú lateral */
    .sidebar {
      width: 250px;
      background: #2c3e50;
      color: white;
      display: flex;
      flex-direction: column;
      padding: 20px;
    }

    .sidebar h2 {
      text-align: center;
      margin-bottom: 30px;
      font-size: 20px;
      color: #ecf0f1;
    }

    .sidebar a {
      display: block;
      padding: 12px;
      margin: 5px 0;
      text-decoration: none;
      color: white;
      background: #34495e;
      border-radius: 6px;
      transition: background 0.3s;
    }

    .sidebar a:hover {
      background: #1abc9c;
    }

    .sidebar .logout {
      margin-top: auto;
      background: #e74c3c;
      text-align: center;
    }

    /* Área de contenido */
    .content {
      flex: 1;
      padding: 30px;
    }

    .content h1 {
      margin-top: 0;
      color: #2c3e50;
    }

    .welcome-box {
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
  </style>
</head>
<body>
  <!-- Sidebar -->
  <div class="sidebar">
    <h2>Menú Admin</h2>
    <a href="gestionar_estudiante.php">Gestionar Estudiantes</a>
    <a href="gestionar_acudientes.php">Gestionar Acudientes</a>
    <a href="gestionar_adminitradores.php">Gestionar Administradores</a>
    <a href="gestionar_supervisores.php">Gestionar Supervisores</a>
    <a href="gestionar_grupos.php">Gestionar Grupos</a>
    <a href="#">Soporte PDF</a>
    <a href="modelo/inicio_sesion.php" class="logout">Cerrar Sesión</a>

  </div>

  <!-- Contenido principal -->
  <div class="content">
    <div class="welcome-box">
      <?php
        if(isset($datos['nombre']) && isset($datos['apellidos'])) {
            echo '<h1>Bienvenido/a, ' . $datos['nombre'] . ' ' . $datos['apellidos'] . '</h1>';
        } else {
            echo '<h1>Usuario: ' . $nombre_usuario . '</h1>';
        }
      ?>
    </div>

    <div class="info">
      <h2>Panel de Control</h2>
      <p>Aquí puedes gestionar estudiantes, acudientes, supervisores y más. 
      Usa el menú lateral para navegar entre las diferentes secciones del sistema.</p>
      <p><strong>Consejo:</strong> Mantén actualizada la información de usuarios y grupos para garantizar el correcto funcionamiento.</p>
    </div>
  </div>
</body>
</html>
