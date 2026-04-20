<?php if (isset($_GET['success'])): ?>

    <div class="alert alert-success">

        <?php if ($_GET['success'] == 1): ?>
            Bodega creada correctamente
        <?php elseif ($_GET['success'] == 2): ?>
            Bodega actualizada correctamente
        <?php elseif ($_GET['success'] == 3): ?>
            Bodega eliminada correctamente
        <?php endif; ?>

    </div>

<?php endif; ?>
<?php if (isset($_GET['error'])): ?>

    <div class="alert alert-danger">
        Ocurrió un error al procesar la solicitud
    </div>

<?php endif; ?>



<h1 class="mb-4">Listado de Bodegas</h1>

<form method="GET" class="mb-3">
    <select name="estado" class="form-select w-auto d-inline">
        <option value="">Todas</option>
        <option value="1">Activadas</option>
        <option value="0">Desactivadas</option>
    </select>
    <button class="btn btn-primary">Filtrar</button>
</form>

<a href="index.php?accion=crear" class="btn btn-success mb-3">Crear Bodega</a>

<table class="table table-striped table-bordered">
    <thead class="table-dark">
        <tr>
            <th>Código</th>
            <th>Nombre</th>
            <th>Dirección</th>
            <th>Dotación</th>
            <th>Encargados</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>

        <?php foreach ($bodegas as $bodega): ?>
            <tr>
                <td><?= $bodega['codigo'] ?></td>
                <td><?= $bodega['nombre'] ?></td>
                <td><?= $bodega['direccion'] ?></td>
                <td><?= $bodega['dotacion'] ?></td>
                <td><?= $bodega['encargados'] ?></td>
                <td>
                    <span class="badge <?= $bodega['estado'] ? 'bg-success' : 'bg-danger' ?>">
                        <?= $bodega['estado'] ? 'Activa' : 'Inactiva' ?>
                    </span>
                </td>
                <td>
                    <a href="index.php?accion=editar&id=<?= $bodega['id'] ?>" class="btn btn-warning btn-sm">Editar</a>

                    <a
                        href="index.php?accion=eliminar&id=<?= $bodega['id'] ?>"
                        class="btn btn-danger btn-sm"
                        onclick="return confirm('¿Eliminar esta bodega?')">
                        Eliminar
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>

    </tbody>
</table>