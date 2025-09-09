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
$busqueda = '';

// Procesar formulario de búsqueda
if(isset($_GET['buscar'])) {
    $busqueda = mysqli_real_escape_string($conexion, $_GET['busqueda']);
}

// Procesar formularios de edición y eliminación
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Eliminar acudiente
    if (isset($_POST['eliminar'])) {
        $id_acudiente = mysqli_real_escape_string($conexion, $_POST['id_acudiente']);
        $verificar = "SELECT * FROM estudiante WHERE id_acudiente = $id_acudiente";
        $resultado_verificar = mysqli_query($conexion, $verificar);
        
        if (mysqli_num_rows($resultado_verificar) > 0) {
            $mensaje = "No se puede eliminar este acudiente porque tiene estudiantes asociados";
        } else {
            $eliminar = "DELETE FROM acudiente WHERE id_acudiente = $id_acudiente";
            if (mysqli_query($conexion, $eliminar)) {
                $mensaje = "Acudiente eliminado correctamente";
            } else {
                $mensaje = "Error al eliminar acudiente: " . mysqli_error($conexion);
            }
        }
    }
    
    // Actualizar acudiente
    if (isset($_POST['actualizar'])) {
        $id_acudiente = mysqli_real_escape_string($conexion, $_POST['id_acudiente']);
        $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
        $apellidos = mysqli_real_escape_string($conexion, $_POST['apellidos']);
        $cedula = mysqli_real_escape_string($conexion, $_POST['cedula']);
        $correo = mysqli_real_escape_string($conexion, $_POST['correo']);
        $telefono = mysqli_real_escape_string($conexion, $_POST['telefono']);
        $contrasena = mysqli_real_escape_string($conexion, $_POST['contrasena']);
        
        $verificar = "SELECT * FROM acudiente WHERE correo = '$correo' AND id_acudiente != $id_acudiente";
        $resultado_verificar = mysqli_query($conexion, $verificar);
        
        if (mysqli_num_rows($resultado_verificar) > 0) {
            $mensaje = "El correo electrónico ya está registrado con otro acudiente";
        } else {
            $actualizar = "UPDATE acudiente SET 
                          nombre = '$nombre', 
                          apellidos = '$apellidos', 
                          doc_identidad = '$cedula', 
                          correo = '$correo', 
                          telefono = '$telefono'";
            
            if (!empty($contrasena)) {
                $actualizar .= ", contraseña = '$contrasena'";
            }
            
            $actualizar .= " WHERE id_acudiente = $id_acudiente";
            
            if (mysqli_query($conexion, $actualizar)) {
                $mensaje = "Acudiente actualizado correctamente";
            } else {
                $mensaje = "Error al actualizar acudiente: " . mysqli_error($conexion);
            }
        }
    }
}

// Obtener acudientes
$query_acudientes = "SELECT * FROM acudiente";
if (!empty($busqueda)) {
    $query_acudientes .= " WHERE nombre LIKE '%$busqueda%' OR apellidos LIKE '%$busqueda%'";
}
$query_acudientes .= " ORDER BY nombre, apellidos";
$resultado_acudientes = mysqli_query($conexion, $query_acudientes);

// Total acudientes
$query_total = "SELECT COUNT(*) as total FROM acudiente";
$resultado_total = mysqli_query($conexion, $query_total);
$datos_total = mysqli_fetch_assoc($resultado_total);
$total_acudientes = $datos_total['total'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
        <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Ver Acudientes</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f9; margin: 20px; }
        h1, h2 { color: #2c3e50; }
        .mensaje { background: #dff0d8; padding: 10px; border-radius: 6px; margin-bottom: 15px; }
        .tabla { width: 100%; border-collapse: collapse; background: white; box-shadow: 0px 4px 10px rgba(0,0,0,0.1); }
        .tabla th, .tabla td { padding: 12px; text-align: center; border: 1px solid #ddd; }
        .tabla th { background: #34495e; color: white; }
        .tabla tr:nth-child(even) { background: #f9f9f9; }
        .btn { padding: 8px 12px; border: none; border-radius: 6px; cursor: pointer; font-size: 14px; margin: 2px; }
        .btn-eliminar { background: #e74c3c; color: white; }
        .btn-eliminar:hover { background: #c0392b; }
        .btn-editar { background: #3498db; color: white; }
        .btn-editar:hover { background: #2980b9; }
        .btn-guardar { background: #2ecc71; color: white; }
        .btn-guardar:hover { background: #27ae60; }
        .form-edicion { background: #ecf0f1; padding: 15px; margin-top: 10px; border-radius: 8px; display: none; text-align: left; }
        .form-edicion label { display: block; margin-top: 8px; font-weight: bold; }
        .form-edicion input { width: 100%; padding: 6px; margin-top: 4px; border: 1px solid #ccc; border-radius: 6px; }
        .acciones { display: flex; justify-content: center; gap: 5px; flex-wrap: wrap; }
        .links { margin-top: 20px; }
    </style>
</head>
<body>
    <h1>Lista de Acudientes</h1>
    <hr>
    <p><strong>Administrador:</strong> <?php echo $datos['nombre'] . " " . $datos['apellidos']; ?> (<?php echo $nombre_usuario; ?>)</p>
    <p>Total de acudientes: <?php echo $total_acudientes; ?></p>
    
    <?php if(!empty($mensaje)): ?>
        <div class="mensaje"><?php echo $mensaje; ?></div>
    <?php endif; ?>

    <!-- Búsqueda -->
    <h2>Buscar Acudientes</h2>
    <form method="GET" action="">
        <input type="text" name="busqueda" placeholder="Nombre o apellido" value="<?php echo htmlspecialchars($busqueda); ?>">
        <button type="submit" name="buscar" class="btn btn-editar">Buscar</button>
        <?php if (!empty($busqueda)): ?>
            <a href="ver_acudientes.php" class="btn btn-eliminar">Limpiar</a>
        <?php endif; ?>
    </form>

    <!-- Tabla -->
    <h2>Lista</h2>
    <table class="tabla">
        <thead>
            <tr>
                <th>ID</th><th>Nombre</th><th>Apellidos</th><th>Documento</th>
                <th>Correo</th><th>Teléfono</th><th>Contraseña</th><th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($resultado_acudientes) > 0): ?>
                <?php while($acudiente = mysqli_fetch_assoc($resultado_acudientes)): ?>
                    <tr>
                        <td><?php echo $acudiente['id_acudiente']; ?></td>
                        <td><?php echo $acudiente['nombre']; ?></td>
                        <td><?php echo $acudiente['apellidos']; ?></td>
                        <td><?php echo $acudiente['doc_identidad']; ?></td>
                        <td><?php echo $acudiente['correo']; ?></td>
                        <td><?php echo $acudiente['telefono']; ?></td>
                        <td><?php echo $acudiente['contraseña']; ?></td>
                        <td class="acciones">
                            <form method="POST" action="">
                                <input type="hidden" name="id_acudiente" value="<?php echo $acudiente['id_acudiente']; ?>">
                                <button type="submit" name="eliminar" class="btn btn-eliminar">Eliminar</button>
                            </form>
                            <button onclick="mostrarFormularioEdicion(<?php echo $acudiente['id_acudiente']; ?>)" class="btn btn-editar">Editar</button>
                        </td>
                    </tr>
                    <tr id="editar-<?php echo $acudiente['id_acudiente']; ?>" style="display:none;">
                        <td colspan="8">
                            <div class="form-edicion">
                                <form method="POST" action="">
                                    <input type="hidden" name="id_acudiente" value="<?php echo $acudiente['id_acudiente']; ?>">
                                    <label>Nombre:</label>
                                    <input type="text" name="nombre" value="<?php echo $acudiente['nombre']; ?>" required>
                                    <label>Apellidos:</label>
                                    <input type="text" name="apellidos" value="<?php echo $acudiente['apellidos']; ?>" required>
                                    <label>Documento:</label>
                                    <input type="text" name="cedula" value="<?php echo $acudiente['doc_identidad']; ?>" required>
                                    <label>Correo:</label>
                                    <input type="email" name="correo" value="<?php echo $acudiente['correo']; ?>" required>
                                    <label>Teléfono:</label>
                                    <input type="text" name="telefono" value="<?php echo $acudiente['telefono']; ?>" required>
                                    <label>Nueva Contraseña:</label>
                                    <input type="text" name="contrasena">
                                    <button type="submit" name="actualizar" class="btn btn-guardar">Guardar Cambios</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="8">No se encontraron acudientes</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="links">
        <a href="gestionar_acudientes.php" class="btn btn-guardar">Agregar Nuevo Acudiente</a>
        <a href="pagina_administrador.php" class="btn btn-editar">Volver al Panel</a>
    </div>

    <script>
        function mostrarFormularioEdicion(id) {
            var fila = document.getElementById('editar-' + id);
            fila.style.display = (fila.style.display === 'none') ? 'table-row' : 'none';
        }
    </script>
</body>
</html>
