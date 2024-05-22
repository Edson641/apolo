<?php

include("../db/ConexionDB.php");


class MonedaM extends ConexionDB


{

    public static $vIdRol;
    public static $vIdUsuario;

    public static function inicializacion()
    {
        self::$vIdUsuario = (int) $_SESSION['usuarioApolo'][0]['id_empleado'];
        self::$vIdRol = (int) $_SESSION['usuarioApolo'][0]['id_rol'];
    }

    public static function obtenerMonedaM()
    {

        try {
            static $query = "SELECT id_moneda, nombre_moneda, moneda
            ,CASE WHEN esactivo = true THEN 'SI' ELSE 'NO' END AS esactivo FROM moneda order by id_moneda asc
                           ";
            $stmt = ConexionDB::conectar()->prepare($query);

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {

            return $e;
        }
    }

    public static function insertarMonedaM($datos)

    {
        static $tabla = "moneda";
        $pdo = ConexionDB::conectar();
        $stmt = $pdo->prepare("INSERT INTO $tabla (creado, creadopor, actualizado, actualizadopor, nombre_moneda, moneda, esactivo)
                                           VALUES (current_timestamp AT TIME ZONE 'Etc/GMT+6', :creadopor, current_timestamp AT TIME ZONE 'Etc/GMT+6' , :actualizadopor, :nombre_moneda, :moneda, :esactivo)");

        $stmt->bindParam(":nombre_moneda", $datos->nombre_moneda, PDO::PARAM_STR);
        $stmt->bindParam(":moneda", $datos->moneda, PDO::PARAM_STR);
        $stmt->bindParam(":esactivo", $datos->esactivo, PDO::PARAM_BOOL);
        $stmt->bindParam(":creadopor", self::$vIdUsuario, PDO::PARAM_INT);
        $stmt->bindParam(":actualizadopor", self::$vIdUsuario, PDO::PARAM_INT);


        if ($stmt->execute())

            return true;
    }

    public static function editarMonedaM($datos)

    {
        static $tabla = "moneda";
        $pdo = ConexionDB::conectar();
        $stmt = $pdo->prepare("UPDATE $tabla SET nombre_moneda = :nombre_moneda, moneda = :moneda, esactivo = :esactivo
                                    , actualizado = current_timestamp AT TIME ZONE 'Etc/GMT+6', actualizadopor = :actualizadopor WHERE id_moneda = :id");

        $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);
        $stmt->bindParam(":nombre_moneda", $datos->nombre_moneda, PDO::PARAM_STR);
        $stmt->bindParam(":moneda", $datos->moneda, PDO::PARAM_STR);
        $stmt->bindParam(":esactivo", $datos->esactivo, PDO::PARAM_BOOL);
        $stmt->bindParam(":actualizadopor", self::$vIdUsuario, PDO::PARAM_INT);


        if ($stmt->execute())

            return true;
    }

    public static function eliminarMonedaM($datos)

    {
        static $tabla = "moneda";
        $pdo = ConexionDB::conectar();
        $stmt = $pdo->prepare("DELETE FROM $tabla WHERE id_moneda = :id");

        $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);

        if ($stmt->execute())

            return true;
    }

}

MonedaM::inicializacion();
