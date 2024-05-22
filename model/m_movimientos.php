<?php

include("../db/ConexionDB.php");


class MovimientosM extends ConexionDB


{

    public static $vIdRol;
    public static $vIdUsuario;

    public static function inicializacion()
    {
        self::$vIdUsuario = (int) $_SESSION['usuarioApolo'][0]['id_empleado'];
        self::$vIdRol = (int) $_SESSION['usuarioApolo'][0]['id_rol'];
    }

    public static function obtenerMovimientosM($datos)
    {

        try {
            static $query = "SELECT m.id_movimientos, m.caja_origen, m.caja_destino, m.monto, m.descripcion, m.tipo, c.nombre_caja AS origen, to_char(m.creado, 'YYYY-MM-DD') AS fecha
            ,atr.nombre_atributo, CASE WHEN cj.nombre_caja = cj.nombre_caja THEN cj.nombre_caja ELSE cjd.nombre_caja_departamento END as destino
                                 FROM movimientos AS m
                                 LEFT JOIN caja AS c
                                 ON c.id_caja = m.caja_origen
                                 LEFT JOIN caja AS cj
                                 ON cj.id_caja = m.caja_destino
                                 INNER JOIN atributo AS atr
                                 ON atr.id_atributo = m.tipo
                                 LEFT JOIN caja_departamento AS cjd
                                 ON cjd.id_caja_departamento = m.caja_destino
								 WHERE CASE WHEN :anio = '' THEN to_char(m.creado, 'YYYY') = to_char(m.creado, 'YYYY') ELSE to_char(m.creado, 'YYYY') = :anio  END
								 AND CASE WHEN :mes = 0 THEN EXTRACT(MONTH FROM m.creado) = EXTRACT(MONTH FROM m.creado) ELSE EXTRACT(MONTH FROM m.creado) = :mes  END
								 AND CASE WHEN :id_caja = 0 THEN m.caja_origen = m.caja_origen OR m.caja_destino = m.caja_destino ELSE m.caja_origen = :id_caja OR m.caja_destino = :id_caja END 
                                 order by m.id_movimientos DESC
                           ";
            $stmt = ConexionDB::conectar()->prepare($query);

            $stmt->bindParam(":id_caja", $datos->id_caja, PDO::PARAM_INT);
            $stmt->bindParam(":anio", $datos->anio, PDO::PARAM_STR);
            $stmt->bindParam(":mes", $datos->mes, PDO::PARAM_INT);

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {

            return $e;
        }
    }

    public static function insertarMovimientosM($datos)

    {
        static $tabla = "movimientos";
        $pdo = ConexionDB::conectar();
        $stmt = $pdo->prepare("INSERT INTO $tabla (creado, creadopor, actualizado, actualizadopor, monto, caja_origen, caja_destino, descripcion, tipo)
                                           VALUES (current_timestamp AT TIME ZONE 'Etc/GMT+6', :creadopor, current_timestamp AT TIME ZONE 'Etc/GMT+6', :actualizadopor, :monto::NUMERIC, :caja_origen, :caja_destino, :descripcion, :tipo)");

        $stmt->bindParam(":monto", $datos->monto, PDO::PARAM_INT);
        $stmt->bindParam(":caja_origen", $datos->caja_origen, PDO::PARAM_INT);
        $stmt->bindParam(":caja_destino", $datos->caja_destino, PDO::PARAM_INT);
        $stmt->bindParam(":tipo", $datos->tipo, PDO::PARAM_INT);
        $stmt->bindParam(":descripcion", $datos->descripcion, PDO::PARAM_STR);
        $stmt->bindParam(":creadopor", self::$vIdUsuario, PDO::PARAM_INT);
        $stmt->bindParam(":actualizadopor", self::$vIdUsuario, PDO::PARAM_INT);


        if ($stmt->execute())

            return true;
    }

    public static function crearHistorial($datos)

    {
        static $tabla = "historial";
        $pdo = ConexionDB::conectar();
        $stmt = $pdo->prepare("INSERT INTO $tabla (creado, creadopor, actualizado, actualizadopor, monto, id_caja, descripcion, tipo, moneda, id_concepto, monto_anterior, cliente)
                               VALUES (current_timestamp AT TIME ZONE 'Etc/GMT+6', :creadopor, current_timestamp AT TIME ZONE 'Etc/GMT+6', :actualizadopor, :monto::NUMERIC, :id_caja, :descripcion, :tipo, :moneda, :id_concepto, :monto_anterior, :cliente)");

        $stmt->bindParam(":monto", $datos->model->monto, PDO::PARAM_INT);
        $stmt->bindParam(":monto_anterior", $datos->model->monto_anterior, PDO::PARAM_INT);
        $stmt->bindParam(":tipo", $datos->model->tipo, PDO::PARAM_INT);
        $stmt->bindParam(":id_concepto", $datos->model->id_concepto, PDO::PARAM_INT);
        $stmt->bindParam(":moneda", $datos->model->moneda, PDO::PARAM_INT);
        $stmt->bindParam(":id_caja", $datos->model->id_caja, PDO::PARAM_INT);
        $stmt->bindParam(":descripcion", $datos->model->descripcion, PDO::PARAM_STR);
        $stmt->bindParam(":creadopor", self::$vIdUsuario, PDO::PARAM_INT);
        $stmt->bindParam(":actualizadopor", self::$vIdUsuario, PDO::PARAM_INT);
        $stmt->bindParam(":cliente", $datos->model->cliente, PDO::PARAM_STR);


        if ($stmt->execute())

            return true;
    }

    public static function eliminarMovimientosM($datos)

    {
        static $tabla = "empresa";
        $pdo = ConexionDB::conectar();
        $stmt = $pdo->prepare("DELETE FROM $tabla WHERE id_empresa = :id");

        $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);

        if ($stmt->execute())

            return true;
    }

    public static function obtenerTipoM()
    {

        try {
            static $query = "SELECT id_atributo, nombre_atributo, esactivo, tabla
                             FROM atributo
                             WHERE tabla = 'tipo_movimiento' 
                             order by id_atributo asc
                           ";
            $stmt = ConexionDB::conectar()->prepare($query);

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {

            return $e;
        }
    }
}

MovimientosM::inicializacion();
