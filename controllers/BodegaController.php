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
        //5.1 cargar el layout y el titulo para la vista
        $title = "Listado de Bodegas";
        $view = __DIR__ . '/../views/listar.php';
        require __DIR__ . '/../views/layout.php';
    }


    public function crear()
    {
        // 1. Conexión
        $conexion = new ConexionBD();
        $db = $conexion->getConexion();
        // 2. Modelos
        $bodegaModel = new Bodega($db);
        $encargadoModel = new Encargado($db);

        // Si viene POST guardar
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // obtener los datos del formulario
            $bodega = [
                'codigo' => $_POST['codigo'],
                'nombre' => $_POST['nombre'],
                'direccion' => $_POST['direccion'],
                'dotacion' => $_POST['dotacion']
            ];
            // obtener encargados seleccionados
            $encargados = $_POST['encargados'] ?? [];

            try {
                // crear la bodega y asignar encargados
                $bodegaModel->create($bodega, $encargados);
                //dirigir al listado con mensaje de éxito
                header('Location: /bodega-app/index.php?success=1');
                exit;
            } catch (PDOException $e) {

                // Detectar error de código duplicado
                if ($e->getCode() == '23505') {
                    $error = "El código ya existe. Intenta con otro.";
                } else {
                    $error = "Error al crear la bodega.";
                }

                $encargados = $encargadoModel->getAll();

                // cargar el layout y el titulo para la vista
                $title = "Crear Bodega";
                $view = __DIR__ . '/../views/crear.php';
                require __DIR__ . '/../views/layout.php';
                exit;
            }
        }

        // Si no es POST → mostrar formulario
        $encargados = $encargadoModel->getAll();


        // cargar el layout y el titulo para la vista
        $title = "Crear Bodega";
        $view = __DIR__ . '/../views/crear.php';
        require __DIR__ . '/../views/layout.php';
    }


    public function editar($id)
    {
        // 1. Conexión
        $conexion = new ConexionBD();
        $db = $conexion->getConexion();
        // 2. Modelos
        $bodegaModel = new Bodega($db);
        $encargadoModel = new Encargado($db);

        // Si viene POST guardar
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // obtener los datos del formulario
            $bodega = [
                'codigo' => $_POST['codigo'],
                'nombre' => $_POST['nombre'],
                'direccion' => $_POST['direccion'],
                'dotacion' => $_POST['dotacion'],
                'estado' => $_POST['estado']
            ];

            $encargados = $_POST['encargados'] ?? [];

            try {

                // actualizar la bodega y asignar encargados
                $bodegaModel->update($id, $bodega, $encargados);
                // dirigir al listado con mensaje de éxito
                header('Location: /bodega-app/index.php?success=2');
                exit;
            } catch (PDOException $e) {
                // error del tipo de violación de restricción (código duplicado o dotación no válida)
                if ($e->getCode() == '23505') {
                    $error = "El código ya existe.";
                } elseif ($e->getCode() == '23514') { // error de restricción CHECK (dotación > 0)
                    $error = "La dotación debe ser mayor a 0.";
                } else {
                    $error = "Error al actualizar.";
                }

                $encargados = $encargadoModel->getAll();
                $encargadosAsignados = $_POST['encargados'] ?? [];

                // cargar el layout y el titulo para la vista
                $title = "Editar Bodega";
                $view = __DIR__ . '/../views/editar.php';
                require __DIR__ . '/../views/layout.php';
                exit;
            }
        }

        // GET normal
        $bodega = $bodegaModel->getById($id);
        $encargados = $encargadoModel->getAll();
        $encargadosAsignados = $bodegaModel->getEncargadosByBodega($id);


        // cargar el layout y el titulo para la vista
        $title = "Listado de Bodegas";
        $view = __DIR__ . '/../views/editar.php';
        require __DIR__ . '/../views/layout.php';
    }


    public function eliminar($id)
    {
        // 1. Conexión
        $conexion = new ConexionBD();
        $db = $conexion->getConexion();
        // 2. Modelo
        $bodegaModel = new Bodega($db);
        // 3. Eliminar
        try {
            $bodegaModel->delete($id);
        } catch (Exception $e) {
            header('Location: /bodega-app/index.php?error=1');
            exit;
        }
        // 4. Redirigir al listado con mensaje de éxito
        header('Location: /bodega-app/index.php?success=3');
        exit;
    }
}
