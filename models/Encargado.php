<?php

class Encargado
{
    private $db;

    public function __construct($conexion)
    {
        $this->db = $conexion;
    }

    public function getAll()
    {
        $stmt = $this->db->query("SELECT * FROM encargados ORDER BY nombre");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
