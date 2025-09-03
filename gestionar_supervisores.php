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

// Obtener lista de sedes para el formulario
$query_sedes = "SELECT id_sede, nombre_sede FROM sede ORDER BY nombre_sede";
$resultado_sedes = mysqli_query($conexion, $query_sedes);

// Procesar formulario de agregar
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['agregar'])) {
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $apellidos = mysqli_real_escape_string($conexion, $_POST['apellidos']);
    $doc_identidad = mysqli_real_escape_string($conexion, $_POST['doc_identidad']);
    $telefono = mysqli_real_escape_string($conexion, $_POST['telefono']);
    $correo = mysqli_real_escape_string($conexion, $_POST['correo']);
    $contrasena = mysqli_real_escape_string($conexion, $_POST['contrasena']);
    $id_sede = mysqli_real_escape_string($conexion, $_POST['id_sede']);
    $dependencia = mysqli_real_escape_string($conexion, $_POST['dependencia']);
    
    // Verificar si el correo ya existe
    $verificar = "SELECT * FROM supervisor WHERE correo = '$correo'";
    $resultado_verificar = mysqli_query($conexion, $verificar);
    
    if (mysqli_num_rows($resultado_verificar) > 0) {
        $mensaje = "❌ El correo electrónico ya está registrado";
    } else {
        // Insertamos el nuevo supervisor
        $insertar = "INSERT INTO supervisor (nombre, apellidos, doc_identidad, telefono, correo, contraseña, id_sede, dependencia) 
                    VALUES ('$nombre', '$apellidos', '$doc_identidad', '$telefono', '$correo', '$contrasena', '$id_sede', '$dependencia')";
        
        if (mysqli_query($conexion, $insertar)) {
            $mensaje = "✅ Supervisor agregado correctamente";
        } else {
            $mensaje = "❌ Error al agregar supervisor: " . mysqli_error($conexion);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
        <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Agregar Supervisor</title>
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
            max-width: 650px;
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
    <h1>Agregar Supervisor</h1>
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
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>
        </div>
        <div>
            <label for="apellidos">Apellidos:</label>
            <input type="text" id="apellidos" name="apellidos" required>
        </div>
        <div>
            <label for="doc_identidad">Documento de Identidad:</label>
            <input type="text" id="doc_identidad" name="doc_identidad" required>
        </div>
        <div>
            <label for="telefono">Teléfono:</label>
            <input type="text" id="telefono" name="telefono" required>
        </div>
        <div>
            <label for="correo">Correo Electrónico:</label>
            <input type="email" id="correo" name="correo" required>
        </div>
        <div>
            <label for="contrasena">Contraseña:</label>
            <input type="password" id="contrasena" name="contrasena" required>
        </div>
        <div>
            <label for="id_sede">Sede:</label>
            <select id="id_sede" name="id_sede" required>
                <option value="">Seleccione una sede</option>
                <?php while($sede = mysqli_fetch_assoc($resultado_sedes)): ?>
                    <option value="<?php echo $sede['id_sede']; ?>">
                        <?php echo $sede['nombre_sede']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div>
            <label for="dependencia">Dependencia:</label>
            <input type="text" id="dependencia" name="dependencia" required>
        </div>
        <div class="botones">
            <button type="submit" name="agregar">➕ Agregar Supervisor</button>
            <a href="ver_supervisores.php" class="boton">📋 Ver Supervisores</a>
            <a href="pagina_administrador.php" class="boton">🏠 Panel Admin</a>
        </div>
    </form>
</body>
</html>
