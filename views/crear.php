<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Crear Bodega</title>
</head>

<body>

    <h1>Crear Bodega</h1>


    <?php if (!empty($error)): ?>
        <p style="color:red;"><?= $error ?></p>
    <?php endif; ?>
    <form method="POST">

        <label>Código:</label><br>
        <input type="text" name="codigo" maxlength="5" required value="<?= $_POST['codigo'] ?? '' ?>"><br><br>

        <label>Nombre:</label><br>
        <input type="text" name="nombre" required value="<?= $_POST['nombre'] ?? '' ?>"><br><br>

        <label>Dirección:</label><br>
        <input type="text" name="direccion" value="<?= $_POST['direccion'] ?? '' ?>"><br><br>

        <label>Dotación:</label><br>
        <input type="number" name="dotacion" min="1" required value="<?= $_POST['dotacion'] ?? '' ?>"><br><br>

        <label>Encargados:</label><br>

        <?php
        $encargadosSeleccionados = $_POST['encargados'] ?? [];
        ?>

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

        <button type="submit">Guardar</button>
    </form>

    <br>
    <a href="/bodega-app/index.php">Volver</a>

</body>

</html>