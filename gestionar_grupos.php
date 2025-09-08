<?php
error_reporting(E_ALL);
ini_set('display_errors','1');

require 'modelo/conexion.php';
session_start();

// Verificar si existe una sesión de administrador
if(!isset($_SESSION['username'])) {
    header("location: index.php");
    exit();
}

$nombre_usuario = $_SESSION['username'];

// Obtener datos del administrador
$query = "SELECT nombre, apellidos FROM administrador WHERE correo = '$nombre_usuario'";
$resultado = mysqli_query($conexion, $query);
$datos = mysqli_fetch_array($resultado);

// Inicializar variables
$mensaje = '';

// Obtener lista de grados para el formulario
$query_grados = "SELECT id_grado, nombre FROM grado ORDER BY nombre";
$resultado_grados = mysqli_query($conexion, $query_grados);

// Procesar formulario de agregar
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['agregar'])) {
    $id_grupo = mysqli_real_escape_string($conexion, $_POST['id_grupo']);
    $nombre_grupo = mysqli_real_escape_string($conexion, $_POST['nombre_grupo']);
    $id_grado = mysqli_real_escape_string($conexion, $_POST['id_grado']);
    
    // Verificar si el grupo ya existe
    $verificar = "SELECT * FROM grupo WHERE id_grupo = '$id_grupo'";
    $resultado_verificar = mysqli_query($conexion, $verificar);
    
    if (mysqli_num_rows($resultado_verificar) > 0) {
        $mensaje = "❌ El ID del grupo ya está registrado";
    } else {
        // Insertar el nuevo grupo con nombre
        $insertar = "INSERT INTO grupo (id_grupo, nombre, id_grado) VALUES ('$id_grupo', '$nombre_grupo', '$id_grado')";
        
        if (mysqli_query($conexion, $insertar)) {
            $mensaje = "✅ Grupo agregado correctamente";
        } else {
            $mensaje = "❌ Error al agregar grupo: " . mysqli_error($conexion);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
        <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Agregar Grupo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 20px;
        }
        h1, h2 {
            color: #333;
            text-align: center;
        }
        form {
            max-width: 600px;
            background: #fff;
            padding: 25px;
            margin: 20px auto;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0,0,0,0.1);
        }
        form div {
            margin-bottom: 15px;
        }
        label {
            font-weight: bold;
            display: block;
            margin-bottom: 6px;
        }
        input, select {
            width: 100%;
            padding: 10px;
            border: 1px solid #bbb;
            border-radius: 6px;
            font-size: 14px;
        }
        .mensaje {
            text-align: center;
            padding: 10px;
            margin: 15px auto;
            border-radius: 8px;
            max-width: 600px;
            font-weight: bold;
        }
        .mensaje-success {
            background: #d4edda;
            color: #155724;
        }
        .mensaje-error {
            background: #f8d7da;
            color: #721c24;
        }
        .botones {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            flex-wrap: wrap;
        }
        button, a.boton {
            flex: 1;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            text-decoration: none;
            display: inline-block;
        }
        button {
            background: #007bff;
            color: white;
        }
        button:hover {
            background: #0056b3;
        }
        a.boton {
            background: #6c757d;
            color: white;
        }
        a.boton:hover {
            background: #5a6268;
        }
    </style>
</head>
<body>
    <h1>Agregar Grupo</h1>
    <hr>
    <p style="text-align:center;">
        <?php
            if(isset($datos['nombre']) && isset($datos['apellidos'])) {
                echo '👤 Administrador: <b>' . $datos['nombre'] . ' ' . $datos['apellidos'] . '</b> (' . $nombre_usuario . ')';
            } else {
                echo '👤 Usuario: <b>' . $nombre_usuario . '</b>';
            }
        ?>
    </p>
    <hr>

    <?php if(!empty($mensaje)): ?>
        <div class="mensaje <?php echo (strpos($mensaje, '✅') !== false) ? 'mensaje-success' : 'mensaje-error'; ?>">
            <?php echo $mensaje; ?>
        </div>
    <?php endif; ?>

    <h2>Formulario de Registro</h2>
    <form method="POST" action="">
        <div>
            <label for="id_grupo">ID del Grupo:</label>
            <input type="text" id="id_grupo" name="id_grupo" required>
        </div>
        <div>
            <label for="nombre_grupo">Nombre del Grupo:</label>
            <input type="text" id="nombre_grupo" name="nombre_grupo" placeholder="Ejemplo: Grupo A" required>
        </div>
        <div>
            <label for="id_grado">Grado:</label>
            <select id="id_grado" name="id_grado" required>
                <option value="">Seleccione un grado</option>
                <?php while($grado = mysqli_fetch_assoc($resultado_grados)): ?>
                    <option value="<?php echo $grado['id_grado']; ?>">
                        <?php echo $grado['nombre']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="botones">
            <button type="submit" name="agregar">➕ Agregar Grupo</button>
            <a href="ver_grupo.php" class="boton">📋 Ver Grupos</a>
            <a href="pagina_administrador.php" class="boton">🏠 Panel Admin</a>
        </div>
    </form>
</body>
</html>
