<?php
error_reporting(E_ALL);
ini_set('display_errors','1');
require 'modelo/conexion.php';

session_start();

// Verificar sesión
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

// Procesar búsqueda
if(isset($_GET['buscar'])) {
    $busqueda = mysqli_real_escape_string($conexion, $_GET['busqueda']);
}

// Procesar formularios
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Eliminar
    if (isset($_POST['eliminar'])) {
        $id_administrador = mysqli_real_escape_string($conexion, $_POST['id_administrador']);
        $query_verificar = "SELECT correo FROM administrador WHERE id_administrador = $id_administrador";
        $resultado_verificar = mysqli_query($conexion, $query_verificar);
        $admin_a_eliminar = mysqli_fetch_assoc($resultado_verificar);

        if ($admin_a_eliminar['correo'] == $nombre_usuario) {
            $mensaje = "⚠️ No puedes eliminar tu propia cuenta.";
        } else {
            $eliminar = "DELETE FROM administrador WHERE id_administrador = $id_administrador";
            $mensaje = mysqli_query($conexion, $eliminar) ? 
                "✅ Administrador eliminado correctamente." : 
                "❌ Error al eliminar administrador: " . mysqli_error($conexion);
        }
    }

    // Actualizar
    if (isset($_POST['actualizar'])) {
        $id_administrador = mysqli_real_escape_string($conexion, $_POST['id_administrador']);
        $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
        $apellidos = mysqli_real_escape_string($conexion, $_POST['apellidos']);
        $doc_identidad = mysqli_real_escape_string($conexion, $_POST['doc_identidad']);
        $correo = mysqli_real_escape_string($conexion, $_POST['correo']);
        $telefono = mysqli_real_escape_string($conexion, $_POST['telefono']);
        $contrasena = mysqli_real_escape_string($conexion, $_POST['contrasena']);

        $verificar = "SELECT * FROM administrador WHERE correo = '$correo' AND id_administrador != $id_administrador";
        $resultado_verificar = mysqli_query($conexion, $verificar);

        if (mysqli_num_rows($resultado_verificar) > 0) {
            $mensaje = "⚠️ El correo ya está registrado con otro administrador.";
        } else {
            $actualizar = "UPDATE administrador SET 
                            nombre='$nombre', 
                            apellidos='$apellidos', 
                            doc_identidad='$doc_identidad', 
                            correo='$correo', 
                            telefono='$telefono'";
            if (!empty($contrasena)) {
                $actualizar .= ", contraseña='$contrasena'";
            }
            $actualizar .= " WHERE id_administrador=$id_administrador";

            $mensaje = mysqli_query($conexion, $actualizar) ? 
                "✅ Administrador actualizado correctamente." : 
                "❌ Error al actualizar administrador: " . mysqli_error($conexion);
        }
    }
}

// Consultar administradores
$query_administradores = "SELECT * FROM administrador";
if (!empty($busqueda)) {
    $query_administradores .= " WHERE nombre LIKE '%$busqueda%' OR apellidos LIKE '%$busqueda%'";
}
$query_administradores .= " ORDER BY nombre, apellidos";
$resultado_administradores = mysqli_query($conexion, $query_administradores);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Lista de Administradores</title>
  <style>
    body { font-family: Arial, sans-serif; background: #f4f6f9; margin: 20px; }
    h1 { color: #2c3e50; }
    .mensaje { padding: 10px; margin-bottom: 15px; border-radius: 8px; }
    .mensaje.ok { background: #d4edda; color: #155724; }
    .mensaje.error { background: #f8d7da; color: #721c24; }

    table { width: 100%; border-collapse: collapse; margin-top: 20px; background: #fff; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
    th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
    th { background: #2c3e50; color: white; }
    tr:nth-child(even) { background: #f2f2f2; }
    tr:hover { background: #eaf2f8; }

    .btn { padding: 6px 12px; border: none; border-radius: 6px; cursor: pointer; text-decoration: none; font-size: 14px; }
    .btn-editar { background: #27ae60; color: white; }
    .btn-editar:hover { background: #219150; }
    .btn-eliminar { background: #e74c3c; color: white; }
    .btn-eliminar:hover { background: #c0392b; }
    .btn-primario { background: #2980b9; color: white; padding: 10px 18px; margin: 10px 5px; display: inline-block; }
    .btn-primario:hover { background: #1f6391; }

    .form-edicion { background: #f9f9f9; padding: 15px; margin-top: 10px; border-radius: 8px; display: none; }
    .acciones { display: flex; gap: 10px; }
  </style>
</head>
<body>
  <h1>📋 Lista de Administradores</h1>
  <p><strong>Administrador actual:</strong> <?php echo $datos['nombre']." ".$datos['apellidos']." (".$nombre_usuario.")"; ?></p>

  <?php if(!empty($mensaje)): ?>
    <div class="mensaje <?php echo strpos($mensaje, '✅') !== false ? 'ok' : 'error'; ?>">
      <?php echo $mensaje; ?>
    </div>
  <?php endif; ?>

  <!-- Buscar -->
  <form method="GET" action="">
    <label for="busqueda">🔎 Buscar:</label>
    <input type="text" id="busqueda" name="busqueda" value="<?php echo htmlspecialchars($busqueda); ?>">
    <button type="submit" name="buscar" class="btn btn-primario">Buscar</button>
    <?php if (!empty($busqueda)): ?>
      <a href="ver_administradores.php" class="btn btn-primario">Limpiar</a>
    <?php endif; ?>
  </form>

  <!-- Tabla -->
  <table>
    <thead>
      <tr>
        <th>ID</th><th>Nombre</th><th>Apellidos</th><th>Documento</th>
        <th>Correo</th><th>Teléfono</th><th>Contraseña</th><th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php if (mysqli_num_rows($resultado_administradores) > 0): ?>
        <?php while($admin = mysqli_fetch_assoc($resultado_administradores)): ?>
        <tr>
          <td><?php echo $admin['id_administrador']; ?></td>
          <td><?php echo $admin['nombre']; ?></td>
          <td><?php echo $admin['apellidos']; ?></td>
          <td><?php echo $admin['doc_identidad']; ?></td>
          <td><?php echo $admin['correo']; ?></td>
          <td><?php echo $admin['telefono']; ?></td>
          <td><?php echo $admin['contraseña']; ?></td>
          <td class="acciones">
            <?php if($admin['correo'] != $nombre_usuario): ?>
              <form method="POST" action="" onsubmit="return confirm('¿Seguro que quieres eliminar este administrador?')">
                <input type="hidden" name="id_administrador" value="<?php echo $admin['id_administrador']; ?>">
                <button type="submit" name="eliminar" class="btn btn-eliminar">Eliminar</button>
              </form>
            <?php endif; ?>
            <button class="btn btn-editar" onclick="toggleEdicion(<?php echo $admin['id_administrador']; ?>)">Editar</button>
          </td>
        </tr>
        <tr id="form-<?php echo $admin['id_administrador']; ?>" style="display:none;">
          <td colspan="8">
            <div class="form-edicion">
              <form method="POST" action="">
                <input type="hidden" name="id_administrador" value="<?php echo $admin['id_administrador']; ?>">
                <p><label>Nombre:</label> <input type="text" name="nombre" value="<?php echo $admin['nombre']; ?>" required></p>
                <p><label>Apellidos:</label> <input type="text" name="apellidos" value="<?php echo $admin['apellidos']; ?>" required></p>
                <p><label>Documento:</label> <input type="text" name="doc_identidad" value="<?php echo $admin['doc_identidad']; ?>" required></p>
                <p><label>Correo:</label> <input type="email" name="correo" value="<?php echo $admin['correo']; ?>" required></p>
                <p><label>Teléfono:</label> <input type="text" name="telefono" value="<?php echo $admin['telefono']; ?>" required></p>
                <p><label>Nueva contraseña:</label> <input type="text" name="contrasena"></p>
                <button type="submit" name="actualizar" class="btn btn-editar">💾 Guardar Cambios</button>
              </form>
            </div>
          </td>
        </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr><td colspan="8">⚠️ No se encontraron administradores.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>

  <p>
    <a href="gestionar_administradores.php" class="btn btn-primario">➕ Agregar Nuevo Administrador</a>
    <a href="pagina_administrador.php" class="btn btn-primario">⬅ Volver al Panel</a>
  </p>

  <script>
    function toggleEdicion(id) {
      var fila = document.getElementById("form-" + id);
      fila.style.display = fila.style.display === "none" ? "table-row" : "none";
    }
  </script>
</body>
</html>
