<?php

include("../db/ConexionDB.php");


class CajaDepartamentoM extends ConexionDB


{

    public static $vIdRol;
    public static $vIdUsuario;

    public static function inicializacion()
    {
        self::$vIdUsuario = (int) $_SESSION['usuarioApolo'][0]['id_empleado'];
        self::$vIdRol = (int) $_SESSION['usuarioApolo'][0]['id_rol'];
    }

    public static function obtenerCajaDepartamentoM($datos)
    {

        try {
            static $query = "SELECT c.id_caja_departamento, c.nombre_caja_departamento, c.saldo, c.id_empresa, c.historico
                                    ,c.historico_descripcion, c.id_caja, c.id_sucursal, c.id_departamento , CASE WHEN c.esactivo = true THEN 'SI' ELSE 'NO' END AS esactivo
                                    ,e.nombre_empresa, suc.nombre_sucursal, cj.nombre_caja, dep.nombre_departamento
                             FROM caja_departamento AS c 
                             INNER JOIN empresa AS e
                             ON c.id_empresa = e.id_empresa
                            --  INNER JOIN moneda AS mon
                            --  ON mon.id_moneda = c.id_moneda
                             INNER JOIN sucursal AS suc
                             ON c.id_sucursal = suc.id_sucursal
                             INNER JOIN caja AS cj
                             ON cj.id_caja = c.id_caja
                             INNER JOIN departamento AS dep
                             ON c.id_departamento = dep.id_departamento
                             WHERE cj.id_caja = :id_caja
                             AND c.id_empresa = :id_empresa
                             AND c.id_sucursal = :id_sucursal
                             ORDER BY c.id_caja_departamento asc
                           ";
            $stmt = ConexionDB::conectar()->prepare($query);
            $stmt->bindParam(":id_empresa", $datos->id_empresa, PDO::PARAM_INT);
            $stmt->bindParam(":id_sucursal", $datos->id_sucursal, PDO::PARAM_INT);
            $stmt->bindParam(":id_caja", $datos->id_caja, PDO::PARAM_INT);

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {

            return $e;
        }
    }

    public static function insertarCajaDepartamentoM($datos)

    {
        static $tabla = "caja_departamento";
        $pdo = ConexionDB::conectar();
        $stmt = $pdo->prepare("INSERT INTO $tabla (creado, creadopor, actualizado, actualizadopor, nombre_caja_departamento, saldo, id_empresa, id_sucursal, id_departamento, id_caja , historico, historico_descripcion , esactivo)
                                           VALUES (current_timestamp AT TIME ZONE 'Etc/GMT+6', :creadopor, current_timestamp AT TIME ZONE 'Etc/GMT+6' , :actualizadopor, :nombre_caja_departamento, 0, :id_empresa, :id_sucursal, :id_departamento , :id_caja ,current_timestamp AT TIME ZONE 'Etc/GMT+6', 'Caja Creada' ,:esactivo)");

        $stmt->bindParam(":nombre_caja_departamento", $datos->nombre_caja_departamento, PDO::PARAM_STR);
        $stmt->bindParam(":id_empresa", $datos->id_empresa, PDO::PARAM_INT);
        $stmt->bindParam(":id_sucursal", $datos->id_sucursal, PDO::PARAM_INT);
        $stmt->bindParam(":id_departamento", $datos->id_departamento, PDO::PARAM_INT);
        $stmt->bindParam(":id_caja", $datos->id_caja, PDO::PARAM_INT);
        $stmt->bindParam(":esactivo", $datos->esactivo, PDO::PARAM_BOOL);
        $stmt->bindParam(":creadopor", self::$vIdUsuario, PDO::PARAM_INT);
        $stmt->bindParam(":actualizadopor", self::$vIdUsuario, PDO::PARAM_INT);


        if ($stmt->execute())

            return true;
    }

    public static function editarCajaDepartamentoM($datos)

    {
        static $tabla = "caja_departamento";
        $pdo = ConexionDB::conectar();
        $stmt = $pdo->prepare("UPDATE $tabla SET nombre_caja = :nombre_caja, esactivo = :esactivo, actualizado = current_timestamp AT TIME ZONE 'Etc/GMT+6', actualizadopor = :actualizadopor WHERE id_caja = :id");

        $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);
        $stmt->bindParam(":nombre_caja", $datos->nombre_caja, PDO::PARAM_STR);
        $stmt->bindParam(":esactivo", $datos->esactivo, PDO::PARAM_BOOL);
        $stmt->bindParam(":actualizadopor", self::$vIdUsuario, PDO::PARAM_INT);


        if ($stmt->execute())

            return true;
    }

    public static function eliminarCajaDepartamentoM($datos)

    {
        static $tabla = "caja_departamento";
        $pdo = ConexionDB::conectar();
        $stmt = $pdo->prepare("DELETE FROM $tabla WHERE id_caja_departamento = :id");

        $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);

        if ($stmt->execute())

            return true;
    }

    public static function editarSaldoM($datos)

    {
        static $tabla = "caja";
        $pdo = ConexionDB::conectar();
        $stmt = $pdo->prepare("UPDATE $tabla SET saldo = :saldo::NUMERIC, historico_descripcion = 'Se ha agregado saldo'
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
            static $query = "SELECT c.id_caja, c.nombre_caja, c.saldo, c.id_empresa, c.id_moneda, c.historico, c.historico_descripcion
                            ,CASE WHEN c.esactivo = true THEN 'SI' ELSE 'NO' END AS esactivo, e.nombre_empresa, mon.moneda
                             FROM caja AS c 
                             INNER JOIN empresa AS e
                             ON c.id_empresa = e.id_empresa
                             INNER JOIN moneda AS mon
                             ON mon.id_moneda = c.id_moneda
                             WHERE c.id_empresa = :id_empresa
                             ORDER BY c.id_caja asc
                           ";
            $stmt = ConexionDB::conectar()->prepare($query);
            $stmt->bindParam(":id_empresa", $datos->id_empresa, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {

            return $e;
        }
    }

    public static function obtenerCajaDepartSM($datos)
    {

        try {
            static $query = "SELECT id_caja_departamento, nombre_caja_departamento, esactivo FROM caja_departamento
        WHERE id_departamento = :id_departamento
                       ";
            $stmt = ConexionDB::conectar()->prepare($query);
            $stmt->bindParam(":id_departamento", $datos->id_departamento, PDO::PARAM_INT);


            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {

            return $e;
        }
    }
    public static function agregarSaldoM($datos)

    {
        static $tabla = "caja_departamento";
        $pdo = ConexionDB::conectar();
        $stmt = $pdo->prepare("UPDATE $tabla SET saldo = :saldo, actualizado = current_timestamp AT TIME ZONE 'Etc/GMT+6', actualizadopor = :actualizadopor, historico_descripcion = 'Se ha recibido Saldo en Pesos (MXN)' WHERE id_caja_departamento = :id");

        $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);
        $stmt->bindParam(":saldo", $datos->saldo, PDO::PARAM_INT);
        $stmt->bindParam(":actualizadopor", self::$vIdUsuario, PDO::PARAM_INT);


        if ($stmt->execute())

            return true;
    }

    public static function agregarSaldoDolarM($datos)

    {
        static $tabla = "caja_departamento";
        $pdo = ConexionDB::conectar();
        $stmt = $pdo->prepare("UPDATE $tabla SET saldo_dolar = :saldo, actualizado = current_timestamp AT TIME ZONE 'Etc/GMT+6', actualizadopor = :actualizadopor, historico_descripcion = 'Se ha recibido Saldo en Dolares (USD)' WHERE id_caja_departamento = :id");

        $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);
        $stmt->bindParam(":saldo", $datos->saldo, PDO::PARAM_INT);
        $stmt->bindParam(":actualizadopor", self::$vIdUsuario, PDO::PARAM_INT);


        if ($stmt->execute())

            return true;
    }

    public static function restarSaldoM($datos)

    {
        static $tabla = "caja_departamento";
        $pdo = ConexionDB::conectar();
        $stmt = $pdo->prepare("UPDATE $tabla SET saldo = :saldo, actualizado = current_timestamp AT TIME ZONE 'Etc/GMT+6', actualizadopor = :actualizadopor, historico_descripcion = 'Se ha restado Saldo en Pesos (MXN)' WHERE id_caja_departamento = :id");

        $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);
        $stmt->bindParam(":saldo", $datos->saldo, PDO::PARAM_INT);
        $stmt->bindParam(":actualizadopor", self::$vIdUsuario, PDO::PARAM_INT);


        if ($stmt->execute())

            return true;
    }
    public static function restarSaldoDolarM($datos)

    {
        static $tabla = "caja_departamento";
        $pdo = ConexionDB::conectar();
        $stmt = $pdo->prepare("UPDATE $tabla SET saldo_dolar = :saldo, actualizado = current_timestamp AT TIME ZONE 'Etc/GMT+6', actualizadopor = :actualizadopor, historico_descripcion = 'Se ha restado Saldo en Dolares (USD)' WHERE id_caja_departamento = :id");

        $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);
        $stmt->bindParam(":saldo", $datos->saldo, PDO::PARAM_INT);
        $stmt->bindParam(":actualizadopor", self::$vIdUsuario, PDO::PARAM_INT);


        if ($stmt->execute())

            return true;
    }

    public static function obtenerSaldoCajaM($datos)
    {

        try {
            static $query = "SELECT c.id_caja_departamento, c.nombre_caja_departamento, c.saldo, c.id_empresa, c.historico, c.historico_descripcion, c.id_sucursal, c.id_departamento
                            ,CASE WHEN c.esactivo = true THEN 'SI' ELSE 'NO' END AS esactivo
                             FROM caja_departamento AS c 
                             WHERE c.id_caja_departamento = :id_caja
                             AND id_departamento = :id_departamento
                             ORDER BY c.id_caja_departamento asc
                           ";
            $stmt = ConexionDB::conectar()->prepare($query);
            $stmt->bindParam(":id_caja", $datos->id_caja, PDO::PARAM_INT);
            $stmt->bindParam(":id_departamento", $datos->id_departamento, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {

            return $e;
        }
    }

}

CajaDepartamentoM::inicializacion();
