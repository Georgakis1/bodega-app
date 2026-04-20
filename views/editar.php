<h1 class="mb-4">Editar Bodega</h1>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger">
        <?= $error ?>
    </div>
<?php endif; ?>

<?php
$encargadosSeleccionados = $_POST['encargados'] ?? $encargadosAsignados;
?>

<form method="POST" class="card p-4 shadow-sm">

    <div class="mb-3">
        <label class="form-label">Código</label>
        <input
            type="text"
            name="codigo"
            maxlength="5"
            required
            class="form-control"
            value="<?= $_POST['codigo'] ?? $bodega['codigo'] ?>">
    </div>

    <div class="mb-3">
        <label class="form-label">Nombre</label>
        <input
            type="text"
            name="nombre"
            required
            class="form-control"
            value="<?= $_POST['nombre'] ?? $bodega['nombre'] ?>">
    </div>

    <div class="mb-3">
        <label class="form-label">Dirección</label>
        <input
            required
            type="text"
            name="direccion"
            class="form-control"
            value="<?= $_POST['direccion'] ?? $bodega['direccion'] ?>">
    </div>

    <div class="mb-3">
        <label class="form-label">Dotación</label>
        <input
            type="number"
            name="dotacion"
            min="1"
            required
            class="form-control"
            value="<?= $_POST['dotacion'] ?? $bodega['dotacion'] ?>">
    </div>

    <div class="mb-3">
        <label class="form-label">Estado</label>
        <select name="estado" class="form-select">
            <option value="1" <?= (($_POST['estado'] ?? $bodega['estado']) == 1) ? 'selected' : '' ?>>
                Activada
            </option>
            <option value="0" <?= (($_POST['estado'] ?? $bodega['estado']) == 0) ? 'selected' : '' ?>>
                Desactivada
            </option>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Encargados</label>

        <div class="border rounded p-3">
            <?php foreach ($encargados as $e): ?>

                <div class="form-check">
                    <input
                        class="form-check-input"
                        type="checkbox"
                        name="encargados[]"
                        value="<?= $e['id'] ?>"
                        <?= in_array($e['id'], $encargadosSeleccionados) ? 'checked' : '' ?>>

                    <label class="form-check-label">
                        <?= trim($e['nombre'] . ' ' . $e['apellido1'] . ' ' . $e['apellido2']) ?>
                    </label>
                </div>

            <?php endforeach; ?>
        </div>
    </div>

    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="/bodega-app/index.php" class="btn btn-secondary">Volver</a>
    </div>

</form>