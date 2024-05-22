<?php

include("../db/ConexionDB.php");


class DepartamentoM extends ConexionDB


{

    public static $vIdRol;
    public static $vIdUsuario;

    public static function inicializacion()
    {
        self::$vIdUsuario = (int) $_SESSION['usuarioApolo'][0]['id_empleado'];
        self::$vIdRol = (int) $_SESSION['usuarioApolo'][0]['id_rol'];
    }

    public static function obtenerDepartamentoM()
    {

        try {
            static $query = "SELECT d.id_departamento, d.nombre_departamento, s.nombre_sucursal
                            ,CASE WHEN d.esactivo = true THEN 'SI' ELSE 'NO' END AS esactivo, d.id_sucursal
                            FROM departamento AS d
                            INNER JOIN sucursal AS s
                            ON d.id_sucursal = s.id_sucursal
                            ORDER BY d.id_departamento
                           ";
            $stmt = ConexionDB::conectar()->prepare($query);

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {

            return $e;
        }
    }

    public static function insertarDepartamentoM($datos)

    {
        static $tabla = "departamento";
        $pdo = ConexionDB::conectar();
        $stmt = $pdo->prepare("INSERT INTO $tabla (nombre_departamento, esactivo, creado, creadopor, actualizado, actualizadopor, id_sucursal)
		                                    VALUES ( :nombre_departamento, :esactivo, current_timestamp AT TIME ZONE 'Etc/GMT+6', :creadopor, current_timestamp AT TIME ZONE 'Etc/GMT+6', :actualizadopor, :id_sucursal)");

        $stmt->bindParam(":nombre_departamento", $datos->nombre_departamento, PDO::PARAM_STR);
        $stmt->bindParam(":id_sucursal", $datos->id_sucursal, PDO::PARAM_INT);
        $stmt->bindParam(":esactivo", $datos->esactivo, PDO::PARAM_BOOL);
        $stmt->bindParam(":creadopor", self::$vIdUsuario, PDO::PARAM_INT);
        $stmt->bindParam(":actualizadopor", self::$vIdUsuario, PDO::PARAM_INT);


        if ($stmt->execute())

            return true;
    }

    public static function editarDepartamentoM($datos)

    {
        static $tabla = "departamento";
        $pdo = ConexionDB::conectar();
        $stmt = $pdo->prepare("UPDATE $tabla SET nombre_departamento = :nombre_departamento, id_sucursal = :id_sucursal, esactivo = :esactivo
                                    , actualizado = current_timestamp AT TIME ZONE 'Etc/GMT+6', actualizadopor = :actualizadopor WHERE id_departamento = :id");

        $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);
        $stmt->bindParam(":nombre_departamento", $datos->nombre_departamento, PDO::PARAM_STR);
        $stmt->bindParam(":id_sucursal", $datos->id_sucursal, PDO::PARAM_INT);
        $stmt->bindParam(":esactivo", $datos->esactivo, PDO::PARAM_BOOL);
        $stmt->bindParam(":actualizadopor", self::$vIdUsuario, PDO::PARAM_INT);


        if ($stmt->execute())

            return true;
    }

    public static function eliminarDepartamentoM($datos)

    {
        static $tabla = "departamento";
        $pdo = ConexionDB::conectar();
        $stmt = $pdo->prepare("DELETE FROM $tabla WHERE id_departamento = :id");

        $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);

        if ($stmt->execute())

            return true;
    }

    public static function obtenerDepartamentoSucursalM($datos)
    {

        try {
            static $query = "SELECT d.id_departamento, d.nombre_departamento, s.nombre_sucursal
                            ,CASE WHEN d.esactivo = true THEN 'SI' ELSE 'NO' END AS esactivo, d.id_sucursal
                            FROM departamento AS d
                            INNER JOIN sucursal AS s
                            ON d.id_sucursal = s.id_sucursal
                            WHERE d.id_sucursal =:id_sucursal
                            ORDER BY d.id_departamento
                           ";
            $stmt = ConexionDB::conectar()->prepare($query);
            $stmt->bindParam(":id_sucursal", $datos->id_sucursal, PDO::PARAM_INT);

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {

            return $e;
        }
    }
}

DepartamentoM::inicializacion();
