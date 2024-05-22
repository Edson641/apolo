<?php

include("../db/ConexionDB.php");


class CajaM extends ConexionDB


{

    public static $vIdRol;
    public static $vIdUsuario;

    public static function inicializacion()
    {
        self::$vIdUsuario = (int) $_SESSION['usuarioApolo'][0]['id_empleado'];
        self::$vIdRol = (int) $_SESSION['usuarioApolo'][0]['id_rol'];
    }

    public static function obtenerCajaM()
    {

        try {
            static $query = "SELECT c.id_caja, c.nombre_caja, c.saldo, c.saldo_dolar, c.id_empresa, c.historico, c.historico_descripcion
                            ,CASE WHEN c.esactivo = true THEN 'SI' ELSE 'NO' END AS esactivo, e.nombre_empresa, suc.nombre_sucursal, c.id_sucursal
                             FROM caja AS c 
                             INNER JOIN empresa AS e
                             ON c.id_empresa = e.id_empresa
                            --  INNER JOIN moneda AS mon
                            --  ON mon.id_moneda = c.id_moneda
                             INNER JOIN sucursal AS suc
                             ON c.id_sucursal = suc.id_sucursal
                             ORDER BY c.id_caja asc
                           ";
            $stmt = ConexionDB::conectar()->prepare($query);

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {

            return $e;
        }
    }

    public static function insertarCajaM($datos)

    {
        static $tabla = "caja";
        $pdo = ConexionDB::conectar();
        $stmt = $pdo->prepare("INSERT INTO $tabla (creado, creadopor, actualizado, actualizadopor, nombre_caja, saldo, id_empresa, id_sucursal , historico, historico_descripcion , esactivo, saldo_dolar)
                                           VALUES (current_timestamp AT TIME ZONE 'Etc/GMT+6', :creadopor, current_timestamp AT TIME ZONE 'Etc/GMT+6' , :actualizadopor, :nombre_caja, :saldo::NUMERIC, :id_empresa, :id_sucursal , current_timestamp AT TIME ZONE 'Etc/GMT+6', 'Caja Creada' ,:esactivo, :saldo_dolar)");

        $stmt->bindParam(":nombre_caja", $datos->nombre_caja, PDO::PARAM_STR);
        $stmt->bindParam(":saldo", $datos->saldo, PDO::PARAM_INT);
        $stmt->bindParam(":saldo_dolar", $datos->saldo_dolar, PDO::PARAM_INT);
        $stmt->bindParam(":id_empresa", $datos->id_empresa, PDO::PARAM_INT);
        $stmt->bindParam(":id_sucursal", $datos->id_sucursal, PDO::PARAM_INT);
        $stmt->bindParam(":esactivo", $datos->esactivo, PDO::PARAM_BOOL);
        $stmt->bindParam(":creadopor", self::$vIdUsuario, PDO::PARAM_INT);
        $stmt->bindParam(":actualizadopor", self::$vIdUsuario, PDO::PARAM_INT);


        if ($stmt->execute())

            return true;
    }

    public static function editarCajaM($datos)

    {
        static $tabla = "caja";
        $pdo = ConexionDB::conectar();
        $stmt = $pdo->prepare("UPDATE $tabla SET nombre_caja = :nombre_caja, esactivo = :esactivo, actualizado = current_timestamp AT TIME ZONE 'Etc/GMT+6', actualizadopor = :actualizadopor WHERE id_caja = :id");

        $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);
        $stmt->bindParam(":nombre_caja", $datos->nombre_caja, PDO::PARAM_STR);
        $stmt->bindParam(":esactivo", $datos->esactivo, PDO::PARAM_BOOL);
        $stmt->bindParam(":actualizadopor", self::$vIdUsuario, PDO::PARAM_INT);


        if ($stmt->execute())

            return true;
    }

    public static function eliminarCajaM($datos)

    {
        static $tabla = "caja";
        $pdo = ConexionDB::conectar();
        $stmt = $pdo->prepare("DELETE FROM $tabla WHERE id_caja = :id");

        $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);

        if ($stmt->execute())

            return true;
    }

    public static function editarSaldoM($datos)

    {
        static $tabla = "caja";
        $pdo = ConexionDB::conectar();
        $stmt = $pdo->prepare("UPDATE $tabla SET saldo = :saldo::NUMERIC, historico_descripcion = 'Se ha agregado saldo en PESOS (MXN)'
                                    , actualizado = current_timestamp AT TIME ZONE 'Etc/GMT+6', historico = current_timestamp AT TIME ZONE 'Etc/GMT+6', actualizadopor = :actualizadopor WHERE id_caja = :id");

        $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);
        $stmt->bindParam(":saldo", $datos->saldo, PDO::PARAM_INT);
        $stmt->bindParam(":actualizadopor", self::$vIdUsuario, PDO::PARAM_INT);


        if ($stmt->execute())

            return true;
    }

    public static function editarSaldoDolarM($datos)

    {
        static $tabla = "caja";
        $pdo = ConexionDB::conectar();
        $stmt = $pdo->prepare("UPDATE $tabla SET saldo_dolar = :saldo::NUMERIC, historico_descripcion = 'Se ha agregado saldo en Dolares (USD)'
                                    , actualizado = current_timestamp AT TIME ZONE 'Etc/GMT+6', historico = current_timestamp AT TIME ZONE 'Etc/GMT+6', actualizadopor = :actualizadopor WHERE id_caja = :id");

        $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);
        $stmt->bindParam(":saldo", $datos->saldo, PDO::PARAM_INT);
        $stmt->bindParam(":actualizadopor", self::$vIdUsuario, PDO::PARAM_INT);


        if ($stmt->execute())

            return true;
    }

    public static function editarSaldoOutM($datos)

    {
        static $tabla = "caja";
        $pdo = ConexionDB::conectar();
        $stmt = $pdo->prepare("UPDATE $tabla SET saldo = :saldo::NUMERIC, historico_descripcion = 'Se ha retirado saldo en PESOS (MXN)'
                                    , actualizado = current_timestamp AT TIME ZONE 'Etc/GMT+6', historico = current_timestamp AT TIME ZONE 'Etc/GMT+6', actualizadopor = :actualizadopor WHERE id_caja = :id");

        $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);
        $stmt->bindParam(":saldo", $datos->saldo, PDO::PARAM_INT);
        $stmt->bindParam(":actualizadopor", self::$vIdUsuario, PDO::PARAM_INT);


        if ($stmt->execute())

            return true;
    }

    public static function editarSaldoDolarOutM($datos)

    {
        static $tabla = "caja";
        $pdo = ConexionDB::conectar();
        $stmt = $pdo->prepare("UPDATE $tabla SET saldo_dolar = :saldo::NUMERIC, historico_descripcion = 'Se ha retirado saldo en Dolares (USD)'
                                    , actualizado = current_timestamp AT TIME ZONE 'Etc/GMT+6', historico = current_timestamp AT TIME ZONE 'Etc/GMT+6', actualizadopor = :actualizadopor WHERE id_caja = :id");

        $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);
        $stmt->bindParam(":saldo", $datos->saldo, PDO::PARAM_INT);
        $stmt->bindParam(":actualizadopor", self::$vIdUsuario, PDO::PARAM_INT);


        if ($stmt->execute())

            return true;
    }

    public static function obtenerCajaEmpresaM($datos)
    {

        try {
            static $query = "SELECT c.id_caja, c.nombre_caja, c.saldo, c.id_empresa, c.historico, c.historico_descripcion, c.id_sucursal
                            ,CASE WHEN c.esactivo = true THEN 'SI' ELSE 'NO' END AS esactivo, e.nombre_empresa, suc.nombre_sucursal
                             FROM caja AS c 
                             INNER JOIN empresa AS e
                             ON c.id_empresa = e.id_empresa
                            --  INNER JOIN moneda AS mon
                            --  ON mon.id_moneda = c.id_moneda
                             INNER JOIN sucursal AS suc
                             ON suc.id_sucursal = c.id_sucursal
                             WHERE c.id_empresa = :id_empresa
                             AND c.id_sucursal = :id_sucursal
                             ORDER BY c.id_caja asc
                           ";
            $stmt = ConexionDB::conectar()->prepare($query);
            $stmt->bindParam(":id_empresa", $datos->id_empresa, PDO::PARAM_INT);
            $stmt->bindParam(":id_sucursal", $datos->id_sucursal, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {

            return $e;
        }
    }

    public static function obtenerSaldoCajaM($datos)
    {

        try {
            static $query = "SELECT c.id_caja, c.nombre_caja, c.saldo, c.id_empresa, c.historico, c.historico_descripcion, c.id_sucursal, c.saldo_dolar
                            ,CASE WHEN c.esactivo = true THEN 'SI' ELSE 'NO' END AS esactivo
                             FROM caja AS c 
                             WHERE c.id_caja = :id_caja
                             ORDER BY c.id_caja asc
                           ";
            $stmt = ConexionDB::conectar()->prepare($query);
            $stmt->bindParam(":id_caja", $datos->id_caja, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {

            return $e;
        }
    }

    public static function agregarSaldoM($datos)

    {
        static $tabla = "caja";
        $pdo = ConexionDB::conectar();
        $stmt = $pdo->prepare("UPDATE $tabla SET saldo = :saldo, actualizado = current_timestamp AT TIME ZONE 'Etc/GMT+6', actualizadopor = :actualizadopor, historico_descripcion = 'Transferencia recíbida en Pesos (MXN)' WHERE id_caja = :id");

        $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);
        $stmt->bindParam(":saldo", $datos->saldo, PDO::PARAM_INT);
        $stmt->bindParam(":actualizadopor", self::$vIdUsuario, PDO::PARAM_INT);


        if ($stmt->execute())

            return true;
    }

    public static function agregarSaldoDolarM($datos)

    {
        static $tabla = "caja";
        $pdo = ConexionDB::conectar();
        $stmt = $pdo->prepare("UPDATE $tabla SET saldo_dolar = :saldo, actualizado = current_timestamp AT TIME ZONE 'Etc/GMT+6', actualizadopor = :actualizadopor, historico_descripcion = 'Transferencia recíbida en Dolares (USD)' WHERE id_caja = :id");

        $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);
        $stmt->bindParam(":saldo", $datos->saldo, PDO::PARAM_INT);
        $stmt->bindParam(":actualizadopor", self::$vIdUsuario, PDO::PARAM_INT);


        if ($stmt->execute())

            return true;
    }

    public static function restarSaldoM($datos)

    {
        static $tabla = "caja";
        $pdo = ConexionDB::conectar();
        $stmt = $pdo->prepare("UPDATE $tabla SET saldo = :saldo, actualizado = current_timestamp AT TIME ZONE 'Etc/GMT+6', actualizadopor = :actualizadopor, historico_descripcion = 'Se ha enviado saldo en Pesos (MXN)' WHERE id_caja = :id");

        $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);
        $stmt->bindParam(":saldo", $datos->saldo, PDO::PARAM_INT);
        $stmt->bindParam(":actualizadopor", self::$vIdUsuario, PDO::PARAM_INT);


        if ($stmt->execute())

            return true;
    }

    public static function restarSaldoDolarM($datos)

    {
        static $tabla = "caja";
        $pdo = ConexionDB::conectar();
        $stmt = $pdo->prepare("UPDATE $tabla SET saldo_dolar = :saldo, actualizado = current_timestamp AT TIME ZONE 'Etc/GMT+6', actualizadopor = :actualizadopor, historico_descripcion = 'Se ha enviado saldo en Dolares (USD)' WHERE id_caja = :id");

        $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);
        $stmt->bindParam(":saldo", $datos->saldo, PDO::PARAM_INT);
        $stmt->bindParam(":actualizadopor", self::$vIdUsuario, PDO::PARAM_INT);


        if ($stmt->execute())

            return true;
    }
}

CajaM::inicializacion();
