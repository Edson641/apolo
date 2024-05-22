<?php

include("../db/ConexionDB.php");


class SucursalM extends ConexionDB


{

    public static $vIdRol;
    public static $vIdUsuario;

    public static function inicializacion()
    {
        self::$vIdUsuario = (int) $_SESSION['usuarioApolo'][0]['id_empleado'];
        self::$vIdRol = (int) $_SESSION['usuarioApolo'][0]['id_rol'];
    }

    public static function obtenerSucursalM()
    {

        try {
            static $query = "SELECT s.id_sucursal, s.nombre_sucursal
                            ,CASE WHEN s.esactivo = true THEN 'SI' ELSE 'NO' END AS esactivo, e.nombre_empresa, s.id_empresa
                            FROM sucursal AS s
                            INNER JOIN empresa AS e
                            ON s.id_empresa = e.id_empresa
                            ORDER BY s.id_sucursal
                           ";
            $stmt = ConexionDB::conectar()->prepare($query);

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {

            return $e;
        }
    }

    public static function insertarSucursalM($datos)

    {
        static $tabla = "sucursal";
        $pdo = ConexionDB::conectar();
        $stmt = $pdo->prepare("INSERT INTO $tabla (nombre_sucursal, esactivo, creado, creadopor, actualizado, actualizadopor, id_empresa)
		                                    VALUES ( :nombre_sucursal, :esactivo, current_timestamp AT TIME ZONE 'Etc/GMT+6', :creadopor, current_timestamp AT TIME ZONE 'Etc/GMT+6', :actualizadopor, :id_empresa)");

        $stmt->bindParam(":nombre_sucursal", $datos->nombre_sucursal, PDO::PARAM_STR);
        $stmt->bindParam(":id_empresa", $datos->id_empresa, PDO::PARAM_INT);
        $stmt->bindParam(":esactivo", $datos->esactivo, PDO::PARAM_BOOL);
        $stmt->bindParam(":creadopor", self::$vIdUsuario, PDO::PARAM_INT);
        $stmt->bindParam(":actualizadopor", self::$vIdUsuario, PDO::PARAM_INT);


        if ($stmt->execute())

            return true;
    }

    public static function editarSucursalM($datos)

    {
        static $tabla = "sucursal";
        $pdo = ConexionDB::conectar();
        $stmt = $pdo->prepare("UPDATE $tabla SET nombre_sucursal = :nombre_sucursal, id_empresa = :id_empresa, esactivo = :esactivo
                                    , actualizado = current_timestamp AT TIME ZONE 'Etc/GMT+6', actualizadopor = :actualizadopor WHERE id_sucursal = :id");

        $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);
        $stmt->bindParam(":nombre_sucursal", $datos->nombre_sucursal, PDO::PARAM_STR);
        $stmt->bindParam(":id_empresa", $datos->id_empresa, PDO::PARAM_INT);
        $stmt->bindParam(":esactivo", $datos->esactivo, PDO::PARAM_BOOL);
        $stmt->bindParam(":actualizadopor", self::$vIdUsuario, PDO::PARAM_INT);


        if ($stmt->execute())

            return true;
    }

    public static function eliminarSucursalM($datos)

    {
        static $tabla = "sucursal";
        $pdo = ConexionDB::conectar();
        $stmt = $pdo->prepare("DELETE FROM $tabla WHERE id_sucursal = :id");

        $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);

        if ($stmt->execute())

            return true;
    }

    public static function obtenerSucursalEmpresaM($datos)
    {

        try {
            static $query = "SELECT s.id_sucursal, s.nombre_sucursal
                            ,CASE WHEN s.esactivo = true THEN 'SI' ELSE 'NO' END AS esactivo, e.nombre_empresa, s.id_empresa
                            FROM sucursal AS s
                            INNER JOIN empresa AS e
                            ON s.id_empresa = e.id_empresa
                            WHERE s.id_empresa = :id_empresa
                            ORDER BY s.id_sucursal
                           ";
            $stmt = ConexionDB::conectar()->prepare($query);
            $stmt->bindParam(":id_empresa", $datos->id_empresa, PDO::PARAM_INT);


            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {

            return $e;
        }
    }
}

SucursalM::inicializacion();
