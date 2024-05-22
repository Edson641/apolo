<?php

include("../db/ConexionDB.php");


class EmpresaM extends ConexionDB


{

    public static $vIdRol;
    public static $vIdUsuario;

    public static function inicializacion()
    {
        self::$vIdUsuario = (int) $_SESSION['usuarioApolo'][0]['id_empleado'];
        self::$vIdRol = (int) $_SESSION['usuarioApolo'][0]['id_rol'];
    }

    public static function obtenerEmpresaM()
    {

        try {
            static $query = "SELECT id_empresa, nombre_empresa, nombre_corto
            ,CASE WHEN esactivo = true THEN 'SI' ELSE 'NO' END AS esactivo FROM empresa 
            WHERE esactivo = true order by id_empresa asc
                           ";
            $stmt = ConexionDB::conectar()->prepare($query);

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {

            return $e;
        }
    }

    public static function insertarEmpresaM($datos)

    {
        static $tabla = "empresa";
        $pdo = ConexionDB::conectar();
        $stmt = $pdo->prepare("INSERT INTO $tabla (creado, creadopor, actualizado, actualizadopor, nombre_empresa, nombre_corto, esactivo)
                                           VALUES (current_timestamp AT TIME ZONE 'Etc/GMT+6', :creadopor, current_timestamp AT TIME ZONE 'Etc/GMT+6' , :actualizadopor, :nombre_empresa, :nombre_corto, :esactivo)");

        $stmt->bindParam(":nombre_empresa", $datos->nombre_empresa, PDO::PARAM_STR);
        $stmt->bindParam(":nombre_corto", $datos->nombre_corto, PDO::PARAM_STR);
        $stmt->bindParam(":esactivo", $datos->esactivo, PDO::PARAM_BOOL);
        $stmt->bindParam(":creadopor", self::$vIdUsuario, PDO::PARAM_INT);
        $stmt->bindParam(":actualizadopor", self::$vIdUsuario, PDO::PARAM_INT);


        if ($stmt->execute())

            return true;
    }

    public static function editarEmpresaM($datos)

    {
        static $tabla = "empresa";
        $pdo = ConexionDB::conectar();
        $stmt = $pdo->prepare("UPDATE $tabla SET nombre_empresa = :nombre_empresa, nombre_corto = :nombre_corto, esactivo = :esactivo
                                    , actualizado = current_timestamp AT TIME ZONE 'Etc/GMT+6', actualizadopor = :actualizadopor WHERE id_empresa = :id");

        $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);
        $stmt->bindParam(":nombre_empresa", $datos->nombre_empresa, PDO::PARAM_STR);
        $stmt->bindParam(":nombre_corto", $datos->nombre_corto, PDO::PARAM_STR);
        $stmt->bindParam(":esactivo", $datos->esactivo, PDO::PARAM_BOOL);
        $stmt->bindParam(":actualizadopor", self::$vIdUsuario, PDO::PARAM_INT);


        if ($stmt->execute())

            return true;
    }

    public static function eliminarEmpresaM($datos)

    {
        static $tabla = "empresa";
        $pdo = ConexionDB::conectar();
        $stmt = $pdo->prepare("DELETE FROM $tabla WHERE id_empresa = :id");

        $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);

        if ($stmt->execute())

            return true;
    }

    public static function obtenerEmpresaC($datos)
    {

        try {
            static $query = "SELECT id_empresa, nombre_empresa, nombre_corto
            ,CASE WHEN esactivo = true THEN 'SI' ELSE 'NO' END AS esactivo FROM empresa 
            WHERE esactivo = true
            AND id_empresa = :id_empresa
            order by id_empresa asc
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

EmpresaM::inicializacion();
