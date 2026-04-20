<h1 class="mb-4">Crear Bodega</h1>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger">
        <?= $error ?>
    </div>
<?php endif; ?>

<form method="POST" class="card p-4 shadow-sm">

    <div class="mb-3">
        <label class="form-label">Código</label>
        <input
            type="text"
            name="codigo"
            maxlength="5"
            required
            class="form-control"
            value="<?= $_POST['codigo'] ?? '' ?>">
    </div>

    <div class="mb-3">
        <label class="form-label">Nombre</label>
        <input
            type="text"
            name="nombre"
            required
            class="form-control"
            value="<?= $_POST['nombre'] ?? '' ?>">
    </div>

    <div class="mb-3">
        <label class="form-label">Dirección</label>
        <input
            required
            type="text"
            name="direccion"
            class="form-control"
            value="<?= $_POST['direccion'] ?? '' ?>">
    </div>

    <div class="mb-3">
        <label class="form-label">Dotación</label>
        <input
            type="number"
            name="dotacion"
            min="1"
            required
            class="form-control"
            value="<?= $_POST['dotacion'] ?? '' ?>">
    </div>

    <div class="mb-3">
        <label class="form-label">Encargados</label>

        <?php
        $encargadosSeleccionados = $_POST['encargados'] ?? [];
        ?>

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

    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="/bodega-app/index.php" class="btn btn-secondary">Volver</a>
    </div>

</form>