<?php

class ConexionBD
{
    private static $conexion = null;

    public static function getConexion()
    {
        if (self::$conexion === null) {

            $env = parse_ini_file(__DIR__ . '/../.env');

            $host = $env['DB_HOST'];
            $port = $env['DB_PORT'];
            $dbname = $env['DB_NAME'];
            $user = $env['DB_USER'];
            $pass = $env['DB_PASS'];

            try {
                self::$conexion = new PDO(
                    "pgsql:host=$host;port=$port;dbname=$dbname",
                    $user,
                    $pass
                );

                self::$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Error de conexión: " . $e->getMessage());
            }
        }

        return self::$conexion;
    }
}
