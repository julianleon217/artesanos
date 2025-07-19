<?php
require_once '../config/db.php';

// Obtener historia del local
$query_local = "SELECT historia FROM local WHERE id_usuario = 1";
$stmt_local = $conn->prepare($query_local);
$stmt_local->execute();
$result_local = $stmt_local->get_result();

$historia = "";
if ($result_local && $result_local->num_rows > 0) {
    $fila_local = $result_local->fetch_assoc();
    $historia = $fila_local['historia'];
}

// Obtener datos del artesano
$query_usuario = "SELECT nombre, imagen FROM usuario WHERE id_usuario = 1";
$stmt_usuario = $conn->prepare($query_usuario);
$stmt_usuario->execute();
$result_usuario = $stmt_usuario->get_result();

if (!$result_usuario || $result_usuario->num_rows !== 1) {
    echo "Artesano no encontrado.";
    exit;
}

$usuario = $result_usuario->fetch_assoc();

// Obtener productos del artesano
$query_productos = "
    SELECT producto.id_producto, producto.nombre_producto, producto.descripcion_producto, producto.imagen_producto
    FROM producto
    WHERE ID_LOCAL = 1
";
$stmt_productos = $conn->prepare($query_productos);
$stmt_productos->execute();
$productos = $stmt_productos->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Título de la Página</title>
    <link rel="stylesheet" href="../styles/ver_artesano.css">
</head>
<body>
    <main class="main-artesano">
    <div class="volver">
        <a href="our_artisans.php">← Volver a productos</a>
    </div>

    <div class="contenido-artesano">
        <!-- Card info del artesano -->
        <div class="card-info-artesano">
            <img src="..<?php echo $usuario['imagen']; ?>" alt="Imagen del artesano">
            <h2><?php echo htmlspecialchars($usuario['nombre']); ?></h2>

            <?php if (!empty($historia)): ?>
                <div class="historia-artesano">
                    <h4>Historia:</h4>
                    <p><?php echo nl2br(htmlspecialchars($historia)); ?></p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Card productos -->
        <div class="card-productos-artesano">
            <h3>Productos del Artesano</h3>
            <div class="productos-grid">
                <?php if ($productos->num_rows > 0): ?>
                    <?php while ($producto = $productos->fetch_assoc()): ?>
                        <div class="card-producto">
                            <img src="../<?php echo $producto['imagen_producto']; ?>" alt="Imagen del producto">
                            <h4><?php echo htmlspecialchars($producto['nombre_producto']); ?></h4>
                            <p><?php echo htmlspecialchars($producto['descripcion_producto']); ?></p>
                            <a class="button-card-artesano" href="ver-producto.php?id=<?php echo $producto['id_producto']; ?>">Ver más</a>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p class="p-error">No hay productos registrados para este artesano.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>
</body>
</html>

