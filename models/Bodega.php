<?php

class Bodega
{
    private $db;

    public function __construct($conexion)
    {
        $this->db = $conexion;
    }

    // Obtener todas con encargados
    public function getAll($estado = null)
    {
        //preparamos la consulta para traer las bodegas con sus encargados concatenados
        $sql = "
            SELECT 
                b.id,
                b.codigo,
                b.nombre,
                b.direccion,
                b.dotacion,
                b.estado,
                b.created_at,
                STRING_AGG(
                    TRIM(
                        COALESCE(e.nombre, '') || ' ' ||
                        COALESCE(e.apellido1, '') || ' ' ||
                        COALESCE(e.apellido2, '')
                    ),
                    ', '
                ) as encargados
            FROM bodegas b
            LEFT JOIN bodega_encargado be ON b.id = be.bodega_id
            LEFT JOIN encargados e ON be.encargado_id = e.id
        ";

        if ($estado !== null) {
            $sql .= " WHERE b.estado = :estado";
        }

        $sql .= " GROUP BY b.id ORDER BY b.id DESC";

        $stmt = $this->db->prepare($sql);

        if ($estado !== null) {
            $stmt->bindValue(':estado', $estado, PDO::PARAM_BOOL);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($bodega, $encargados)
    {
        $this->db->beginTransaction();


        try {
            // crear la consula con los datos de la bodega
            $sql = "INSERT INTO bodegas (codigo, nombre, direccion, dotacion)
                VALUES (:codigo, :nombre, :direccion, :dotacion)
                RETURNING id";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':codigo' => $bodega['codigo'],
                ':nombre' => $bodega['nombre'],
                ':direccion' => $bodega['direccion'],
                ':dotacion' => $bodega['dotacion']
            ]);

            $bodegaId = $stmt->fetchColumn();

            //validar si no viene vacio el array de encargados
            if (!empty($encargados)) {
                //recorrer el array de encargados y guardar en la tabla intermedia
                foreach ($encargados as $encargadoId) {
                    $stmt = $this->db->prepare("
                    INSERT INTO bodega_encargado (bodega_id, encargado_id)
                    VALUES (:bodega_id, :encargado_id)
                ");
                    $stmt->execute([
                        ':bodega_id' => $bodegaId,
                        ':encargado_id' => $encargadoId
                    ]);
                }
            }

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function getById($id)
    {
        // obtener una bodega por su id
        $stmt = $this->db->prepare("SELECT * FROM bodegas WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function getEncargadosByBodega($id)
    {
        // obtener los ids de los encargados asignados a una bodega
        $stmt = $this->db->prepare("
            SELECT encargado_id 
            FROM bodega_encargado 
            WHERE bodega_id = :id
        ");
        $stmt->execute([':id' => $id]);

        return array_column($stmt->fetchAll(PDO::FETCH_ASSOC), 'encargado_id');
    }


    public function update($id, $bodega, $encargados)
    {

        $this->db->beginTransaction();

        try {

            // 1. Actualizar bodega
            $sql = "UPDATE bodegas SET 
                        codigo = :codigo,
                        nombre = :nombre,
                        direccion = :direccion,
                        dotacion = :dotacion,
                        estado = :estado
                    WHERE id = :id";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':codigo' => $bodega['codigo'],
                ':nombre' => $bodega['nombre'],
                ':direccion' => $bodega['direccion'],
                ':dotacion' => $bodega['dotacion'],
                ':estado' => $bodega['estado'],
                ':id' => $id
            ]);

            // 2. Limpiar relaciones
            $stmt = $this->db->prepare("DELETE FROM bodega_encargado WHERE bodega_id = :id");
            $stmt->execute([':id' => $id]);

            // 3. Insertar nuevas
            foreach ($encargados as $encargadoId) {
                $stmt = $this->db->prepare("
                    INSERT INTO bodega_encargado (bodega_id, encargado_id)
                    VALUES (:bodega_id, :encargado_id)
                ");
                $stmt->execute([
                    ':bodega_id' => $id,
                    ':encargado_id' => $encargadoId
                ]);
            }

            $this->db->commit();
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function delete($id)
    {
        // eliminar una bodega por su id
        $stmt = $this->db->prepare("DELETE FROM bodegas WHERE id = :id");
        $stmt->execute([':id' => $id]);
    }
}
