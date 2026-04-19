<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Listado de Bodegas</title>
</head>

<body>

    <h1>Listado de Bodegas</h1>

    <!-- Filtro básico -->
    <form method="GET">
        <label>Estado:</label>
        <select name="estado">
            <option value="">Todas</option>
            <option value="1">Activadas</option>
            <option value="0">Desactivadas</option>
        </select>
        <button type="submit">Filtrar</button>
    </form>

    <hr>

    <?php if (empty($bodegas)): ?>
        <p>No hay bodegas</p>
    <?php else: ?>

        <?php foreach ($bodegas as $bodega): ?>
            <div style="margin-bottom: 20px; border:1px solid #ccc; padding:10px;">
                <strong>Código:</strong> <?= $bodega['codigo'] ?> <br>
                <strong>Nombre:</strong> <?= $bodega['nombre'] ?> <br>
                <strong>Dirección:</strong> <?= $bodega['direccion'] ?> <br>
                <strong>Dotación:</strong> <?= $bodega['dotacion'] ?> <br>
                <strong>Encargados:</strong> <?= $bodega['encargados'] ?> <br>
                <strong>Fecha creación:</strong> <?= $bodega['created_at'] ?> <br>
                <strong>Estado:</strong> <?= $bodega['estado'] ? 'Activada' : 'Desactivada' ?> <br>
                <a href="/bodega-app/index.php?accion=editar&id=<?= $bodega['id'] ?>">Editar</a>
                <a
                    href="/bodega-app/index.php?accion=eliminar&id=<?= $bodega['id'] ?>"
                    onclick="return confirm('¿Seguro que deseas eliminar esta bodega? Esta acción no se puede deshacer.')">
                    Eliminar
                </a>
            </div>
        <?php endforeach; ?>

    <?php endif; ?>

</body>

</html>