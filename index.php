<?php

// cargar BodegaController
require_once __DIR__ . '/controllers/BodegaController.php';


$controller = new BodegaController();

// router simple 
$accion = $_GET['accion'] ?? 'listar';
switch ($accion) {
    case 'crear':
        $controller->crear();
        break;
    case 'editar':
        $controller->editar($_GET['id']);
        break;
    case 'eliminar':
        $controller->eliminar($_GET['id']);
        break;
    default:
        $controller->index(); // listar
        break;
}
