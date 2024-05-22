<?php

include("../db/ConexionDB.php");


class HistorialM extends ConexionDB


{

    public static $vIdRol;
    public static $vIdUsuario;

    public static function inicializacion()
    {
        self::$vIdUsuario = (int) $_SESSION['usuarioApolo'][0]['id_empleado'];
        self::$vIdRol = (int) $_SESSION['usuarioApolo'][0]['id_rol'];
    }

    public static function obtenerHistorialM($datos)
    {

        try {
            static $query = "SELECT h.id_historial, h.id_caja, h.monto, h.tipo, to_char(h.creado, 'YYYY-MM-DD')as fecha ,h.descripcion, h.creado
                             ,atr.nombre_atributo, c.nombre_caja
                             ,con.concepto, mon.moneda
                             FROM historial AS h
                             INNER JOIN atributo AS atr
                             ON atr.id_atributo = h.tipo
                             INNER JOIN caja AS c
                             ON c.id_caja = h.id_caja
                             INNER JOIN concepto AS con
                             ON con.id_concepto = h.id_concepto
                             INNER JOIN moneda AS mon
                             ON mon.id_moneda = h.moneda
                             WHERE h.id_caja = :id_caja
                             ORDER BY h.id_historial DESC";
            $stmt = ConexionDB::conectar()->prepare($query);
            $stmt->bindParam(":id_caja", $datos->id_caja, PDO::PARAM_INT);


            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {

            return $e;
        }
    }

    public static function obtenerHistorialDM($datos)
    {

        try {
            static $query = "SELECT h.id_historial, h.id_caja, h.monto, h.tipo, to_char(h.creado, 'YYYY-MM-DD')as fecha ,h.descripcion, h.creado
                             ,atr.nombre_atributo, c.nombre_caja_departamento
                             FROM historial AS h
                             INNER JOIN atributo AS atr
                             ON atr.id_atributo = h.tipo
                             INNER JOIN caja_departamento AS c
                             ON c.id_caja_departamento = h.id_caja
                             WHERE h.id_caja = :id_caja
                             ORDER BY h.id_historial DESC";
            $stmt = ConexionDB::conectar()->prepare($query);
            $stmt->bindParam(":id_caja", $datos->id_caja, PDO::PARAM_INT);


            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {

            return $e;
        }
    }

    public static function insertarHistorialM($datos)

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

    public static function editarHistorialM($datos)

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

    public static function eliminarHistorialM($datos)

    {
        static $tabla = "empresa";
        $pdo = ConexionDB::conectar();
        $stmt = $pdo->prepare("DELETE FROM $tabla WHERE id_empresa = :id");

        $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);

        if ($stmt->execute())

            return true;
    }

    public static function obtenerHistorialC($datos)
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

HistorialM::inicializacion();
