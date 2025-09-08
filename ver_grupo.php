<?php
error_reporting(E_ALL);
ini_set('display_errors','1');

require 'modelo/conexion.php';
session_start();

// Verificar si existe sesión de administrador
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

// Procesar formularios de edición y eliminación
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Eliminar grupo
    if (isset($_POST['eliminar'])) {
        $id_grupo = mysqli_real_escape_string($conexion, $_POST['id_grupo']);

        // Comprobar si tiene estudiantes asociados
        $verificar = "SELECT * FROM estudiante WHERE id_grupo = $id_grupo";
        $resultado_verificar = mysqli_query($conexion, $verificar);

        if (mysqli_num_rows($resultado_verificar) > 0) {
            $mensaje = "No se puede eliminar este grupo porque tiene estudiantes asociados";
        } else {
            $eliminar = "DELETE FROM grupo WHERE id_grupo = $id_grupo";
            if (mysqli_query($conexion, $eliminar)) {
                $mensaje = "Grupo eliminado correctamente";
            } else {
                $mensaje = "Error al eliminar grupo: " . mysqli_error($conexion);
            }
        }
    }

    // Actualizar grupo
    if (isset($_POST['actualizar'])) {
        $id_grupo = mysqli_real_escape_string($conexion, $_POST['id_grupo']);
        $nombre_grupo = mysqli_real_escape_string($conexion, $_POST['nombre_grupo']);
        $id_grado = mysqli_real_escape_string($conexion, $_POST['id_grado']);
        $descripcion = mysqli_real_escape_string($conexion, $_POST['descripcion']);

        $actualizar = "UPDATE grupo SET 
                      nombre_grupo = '$nombre_grupo',
                      id_grado = '$id_grado',
                      descripcion = '$descripcion'
                      WHERE id_grupo = $id_grupo";

        if (mysqli_query($conexion, $actualizar)) {
            $mensaje = "Grupo actualizado correctamente";
        } else {
            $mensaje = "Error al actualizar grupo: " . mysqli_error($conexion);
        }
    }
}

// Obtener lista de grupos
$query_grupos = "SELECT * FROM grupo";

// Filtro de búsqueda
if (!empty($busqueda)) {
    $query_grupos .= " WHERE nombre_grupo LIKE '%$busqueda%' OR descripcion LIKE '%$busqueda%'";
}

$query_grupos .= " ORDER BY nombre_grupo";
$resultado_grupos = mysqli_query($conexion, $query_grupos);

// Total grupos
$query_total = "SELECT COUNT(*) as total FROM grupo";
$resultado_total = mysqli_query($conexion, $query_total);
$datos_total = mysqli_fetch_assoc($resultado_total);
$total_grupos = $datos_total['total'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Grupos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 20px;
        }
        h1, h2 { color: #2c3e50; }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0px 4px 8px rgba(0,0,0,0.1);
        }
        table th, table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }
        table th {
            background: #2c3e50;
            color: white;
        }
        button {
            padding: 6px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button[name="eliminar"] {
            background: #e74c3c;
            color: white;
        }
        button[name="actualizar"], .btn-editar {
            background: #3498db;
            color: white;
        }
        form { display: inline; }
        .mensaje {
            margin: 15px 0;
            padding: 10px;
            border-radius: 6px;
            background: #ecf0f1;
        }
    </style>
</head>
<body>
    <h1>Lista de Grupos</h1>
    <hr>
    <?php
        if(isset($datos['nombre']) && isset($datos['apellidos'])) {
            echo 'Administrador: ' . $datos['nombre'] . ' ' . $datos['apellidos'] . ' (' . $nombre_usuario . ')';
        } else {
            echo 'Usuario: ' . $nombre_usuario;
        }
    ?>
    <hr>

    <?php if(!empty($mensaje)): ?>
        <div class="mensaje">
            <?php echo $mensaje; ?>
        </div>
    <?php endif; ?>

    <div>
        <p>Total de grupos en la base de datos: <?php echo $total_grupos; ?></p>
    </div>

    <h2>Buscar Grupos</h2>
    <form method="GET" action="">
        <div>
            <label for="busqueda">Buscar por nombre:</label>
            <input type="text" id="busqueda" name="busqueda" value="<?php echo htmlspecialchars($busqueda); ?>">
            <button type="submit" name="buscar">Buscar</button>
            <?php if (!empty($busqueda)): ?>
                <a href="ver_grupos.php">Limpiar búsqueda</a>
            <?php endif; ?>
        </div>
    </form>

    <h2>Lista de Grupos</h2>
    <table>
        <thead>
            <tr>
                <th>ID Grupo</th>
                <th>Nombre Grupo</th>
                <th>ID Grado</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if (mysqli_num_rows($resultado_grupos) > 0) {
                while($grupo = mysqli_fetch_assoc($resultado_grupos)): 
            ?>
            <tr>
                <td><?php echo $grupo['id_grupo']; ?></td>
                <td><?php echo $grupo['nombre_grupo']; ?></td>
                <td><?php echo $grupo['id_grado']; ?></td>
                <td><?php echo $grupo['descripcion']; ?></td>
                <td>
                    <form method="POST" action="">
                        <input type="hidden" name="id_grupo" value="<?php echo $grupo['id_grupo']; ?>">
                        <button type="submit" name="eliminar">Eliminar</button>
                    </form>

                    <button class="btn-editar" onclick="mostrarFormularioEdicion(<?php echo $grupo['id_grupo']; ?>)">Editar</button>

                    <div id="editar-<?php echo $grupo['id_grupo']; ?>" style="display: none; margin-top:10px;">
                        <form method="POST" action="">
                            <input type="hidden" name="id_grupo" value="<?php echo $grupo['id_grupo']; ?>">
                            <div>
                                <label>Nombre Grupo:</label>
                                <input type="text" name="nombre_grupo" value="<?php echo $grupo['nombre_grupo']; ?>" required>
                            </div>
                            <div>
                                <label>ID Grado:</label>
                                <input type="text" name="id_grado" value="<?php echo $grupo['id_grado']; ?>" required>
                            </div>
                            <div>
                                <label>Descripción:</label>
                                <textarea name="descripcion" required><?php echo $grupo['descripcion']; ?></textarea>
                            </div>
                            <div>
                                <button type="submit" name="actualizar">Guardar Cambios</button>
                            </div>
                        </form>
                    </div>
                </td>
            </tr>
            <?php 
                endwhile; 
            } else {
                echo "<tr><td colspan='5'>No se encontraron grupos</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <hr>
    <a href="gestionar_grupos.php">Agregar Nuevo Grupo</a>
    <br>
    <a href="pagina_administrador.php">Volver al Panel de Administrador</a>

    <script>
        function mostrarFormularioEdicion(id) {
            var formulario = document.getElementById('editar-' + id);
            if (formulario.style.display === 'none') {
                formulario.style.display = 'block';
            } else {
                formulario.style.display = 'none';
            }
        }
    </script>
</body>
</html>
