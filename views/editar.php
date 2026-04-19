<?php
$encargadosSeleccionados = $_POST['encargados'] ?? $encargadosAsignados;
?>

<form method="POST">

    <input type="text" name="codigo" value="<?= $_POST['codigo'] ?? $bodega['codigo'] ?>"><br>

    <input type="text" name="nombre" value="<?= $_POST['nombre'] ?? $bodega['nombre'] ?>"><br>

    <input type="text" name="direccion" value="<?= $_POST['direccion'] ?? $bodega['direccion'] ?>"><br>

    <input type="number" name="dotacion" value="<?= $_POST['dotacion'] ?? $bodega['dotacion'] ?>"><br>

    <select name="estado">
        <option value="1" <?= (($_POST['estado'] ?? $bodega['estado']) == 1) ? 'selected' : '' ?>>Activada</option>
        <option value="0" <?= (($_POST['estado'] ?? $bodega['estado']) == 0) ? 'selected' : '' ?>>Desactivada</option>
    </select>

    <br><br>

    <?php foreach ($encargados as $e): ?>

        <input
            type="checkbox"
            name="encargados[]"
            value="<?= $e['id'] ?>"
            <?= in_array($e['id'], $encargadosSeleccionados) ? 'checked' : '' ?>>

        <?= trim($e['nombre'] . ' ' . $e['apellido1'] . ' ' . $e['apellido2']) ?>
        <br>

    <?php endforeach; ?>

    <br>
    <button type="submit">Actualizar</button>

</form>