<?php

require_once __DIR__ . '/../models/Bodega.php';
require_once __DIR__ . '/../models/Encargado.php';
require_once __DIR__ . '/../config/ConexionBD.php';

class BodegaController
{

    public function index()
    {

        // 1. Conexión
        $conexion = new ConexionBD();
        $db = $conexion->getConexion();

        // 2. Modelo
        $bodegaModel = new Bodega($db);

        // 3. Obtener filtro
        $estado = null;
        if (isset($_GET['estado'])) {
            if ($_GET['estado'] === '1') {
                $estado = true;
            } elseif ($_GET['estado'] === '0') {
                $estado = false;
            }
        }

        // 4. Obtener datos
        $bodegas = $bodegaModel->getAll($estado);

        // 5. Pasar a la vista
        require __DIR__ . '/../views/listar.php';
    }


    public function crear()
    {

        $conexion = new ConexionBD();
        $db = $conexion->getConexion();

        $bodegaModel = new Bodega($db);
        $encargadoModel = new Encargado($db);

        // Si viene POST → guardar
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $bodega = [
                'codigo' => $_POST['codigo'],
                'nombre' => $_POST['nombre'],
                'direccion' => $_POST['direccion'],
                'dotacion' => $_POST['dotacion']
            ];

            $encargados = $_POST['encargados'] ?? [];

            try {
                $bodegaModel->create($bodega, $encargados);

                header('Location: /bodega-app/index.php');
                exit;
            } catch (PDOException $e) {

                // Detectar error de código duplicado
                if ($e->getCode() == '23505') {
                    $error = "El código ya existe. Intenta con otro.";
                } else {
                    $error = "Error al crear la bodega.";
                }

                $encargados = $encargadoModel->getAll();

                require __DIR__ . '/../views/crear.php';
                exit;
            }
        }

        // Si no es POST → mostrar formulario
        $encargados = $encargadoModel->getAll();

        require __DIR__ . '/../views/crear.php';
    }


    public function editar($id)
    {

        $conexion = new ConexionBD();
        $db = $conexion->getConexion();

        $bodegaModel = new Bodega($db);
        $encargadoModel = new Encargado($db);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $bodega = [
                'codigo' => $_POST['codigo'],
                'nombre' => $_POST['nombre'],
                'direccion' => $_POST['direccion'],
                'dotacion' => $_POST['dotacion'],
                'estado' => $_POST['estado']
            ];

            $encargados = $_POST['encargados'] ?? [];

            try {

                // 🔥 AQUÍ SE EJECUTA EL UPDATE
                $bodegaModel->update($id, $bodega, $encargados);

                header('Location: /bodega-app/index.php');
                exit;
            } catch (PDOException $e) {

                // 🔥 👉 ESTE BLOQUE VA AQUÍ
                if ($e->getCode() == '23505') {
                    $error = "El código ya existe.";
                } elseif ($e->getCode() == '23514') {
                    $error = "La dotación debe ser mayor a 0.";
                } else {
                    $error = "Error al actualizar.";
                }

                $encargados = $encargadoModel->getAll();
                $encargadosAsignados = $_POST['encargados'] ?? [];

                require __DIR__ . '/../views/editar.php';
                exit;
            }
        }

        // GET normal
        $bodega = $bodegaModel->getById($id);
        $encargados = $encargadoModel->getAll();
        $encargadosAsignados = $bodegaModel->getEncargadosByBodega($id);

        require __DIR__ . '/../views/editar.php';
    }


    public function eliminar($id)
    {

        $conexion = new ConexionBD();
        $db = $conexion->getConexion();

        $bodegaModel = new Bodega($db);

        try {
            $bodegaModel->delete($id);
        } catch (Exception $e) {
            // opcional: manejar error
        }

        header('Location: /bodega-app/index.php');
        exit;
    }
}
