<?php
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

// Inicializar mensaje
$mensaje = '';

// Obtener lista de acudientes
$query_acudientes = "SELECT id_acudiente, nombre, apellidos FROM acudiente ORDER BY nombre, apellidos";
$resultado_acudientes = mysqli_query($conexion, $query_acudientes);

// Obtener lista de grupos
$query_grupos = "SELECT g.id_grupo, g.nombre, gr.nombre as nombre_grado 
                 FROM grupo g 
                 LEFT JOIN grado gr ON g.id_grado = gr.id_grado 
                 ORDER BY g.nombre";
$resultado_grupos = mysqli_query($conexion, $query_grupos);

// Procesar formulario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['agregar'])) {
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $apellidos = mysqli_real_escape_string($conexion, $_POST['apellidos']);
    $doc_identidad = mysqli_real_escape_string($conexion, $_POST['doc_identidad']);
    $telefono = mysqli_real_escape_string($conexion, $_POST['telefono']);
    $correo = mysqli_real_escape_string($conexion, $_POST['correo']);
    $raw_pass = $_POST['contrasena'];
    $contrasena = password_hash($raw_pass, PASSWORD_BCRYPT); // Contraseña encriptada
    $id_acudiente = mysqli_real_escape_string($conexion, $_POST['id_acudiente']);
    $id_grupo = mysqli_real_escape_string($conexion, $_POST['id_grupo']);

    // Validar grupo seleccionado
    if (empty($id_grupo)) {
        $mensaje = "❌ Debe seleccionar un grupo.";
    } else {
        // Validar correo duplicado
        $verificar = "SELECT * FROM estudiante WHERE correo = '$correo'";
        $resultado_verificar = mysqli_query($conexion, $verificar);

        if (mysqli_num_rows($resultado_verificar) > 0) {
            $mensaje = "❌ El correo electrónico ya está registrado.";
        } else {
            // Validar documento duplicado (opcional)
            $verificar_doc = "SELECT * FROM estudiante WHERE doc_identidad = '$doc_identidad'";
            $resultado_verificar_doc = mysqli_query($conexion, $verificar_doc);

            if (mysqli_num_rows($resultado_verificar_doc) > 0) {
                $mensaje = "❌ El documento de identidad ya está registrado.";
            } else {
                // Insertar estudiante
                $insertar = "INSERT INTO estudiante (nombre, apellidos, doc_identidad, telefono, correo, contraseña, id_acudiente) 
                             VALUES ('$nombre', '$apellidos', '$doc_identidad', '$telefono', '$correo', '$contrasena', '$id_acudiente')";

                if (mysqli_query($conexion, $insertar)) {
                    $id_estudiante = mysqli_insert_id($conexion);
                    $ano_actual = date('Y-m-d');

                    $insertar_grupo = "INSERT INTO grupo_estudiante (id_grupo, año, id_estudiante) 
                                       VALUES ('$id_grupo', '$ano_actual', '$id_estudiante')";
                    mysqli_query($conexion, $insertar_grupo);

                    $mensaje = "✅ Estudiante registrado correctamente.";
                } else {
                    $mensaje = "❌ Error al registrar el estudiante.";
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Agregar Estudiante</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background:rgb(166, 128, 238);
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
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
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
            background:rgb(68, 22, 153);
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
    <h1>Agregar Estudiante</h1>
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
            <label for="id_acudiente">Acudiente:</label>
            <select id="id_acudiente" name="id_acudiente" required>
                <option value="">Seleccione un acudiente</option>
                <?php while($acudiente = mysqli_fetch_assoc($resultado_acudientes)): ?>
                    <option value="<?php echo $acudiente['id_acudiente']; ?>">
                        <?php echo $acudiente['nombre'] . ' ' . $acudiente['apellidos']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div>
            <label for="id_grupo">Grupo:</label>
            <select id="id_grupo" name="id_grupo" required>
                <option value="">Seleccione un grupo</option>
                <?php while($grupo = mysqli_fetch_assoc($resultado_grupos)): ?>
                    <option value="<?php echo $grupo['id_grupo']; ?>">
                        <?php echo $grupo['nombre'] . ' - ' . $grupo['nombre_grado']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="botones">
            <button type="submit" name="agregar">➕ Agregar Estudiante</button>
            <a href="ver_estudiante.php" class="boton">📋 Ver Estudiantes</a>
            <a href="pagina_administrador.php" class="boton">🏠 Panel Admin</a>
        </div>
    </form>
</body>
</html>
