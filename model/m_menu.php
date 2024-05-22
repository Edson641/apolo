<?php

include("../db/ConexionDB.php");




class MenuM extends ConexionDB


{


    public static $vIdRol;
    public static $vIdUsuario;

    public static function inicializacion()
    {
        self::$vIdUsuario = (int) $_SESSION['usuarioApolo'][0]['id_empleado'];
        self::$vIdRol = (int) $_SESSION['usuarioApolo'][0]['id_rol'];
    }

    public static function obtenerMenuM()
    {

        try {
            static $query = "SELECT id_menu, nombre, url, svg, orden, CASE WHEN pagina_principal = true THEN 'SI' ELSE 'NO' END AS pagina_principal
                            ,CASE WHEN esactivo = true THEN 'SI' ELSE 'NO' END AS esactivo FROM menu order by id_menu asc
                           ";


            $stmt = ConexionDB::conectar()->prepare($query);

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {

            return $e;
        }
    }

    public static function insertarMenuM($datos)

    {
        static $tabla = "menu";
        $pdo = ConexionDB::conectar();
        $stmt = $pdo->prepare("INSERT INTO $tabla (nombre, url, svg, orden, pagina_principal, esactivo, creado, creadopor, actualizado, actualizadopor)
        VALUES (:nombre, :url, :svg::TEXT, :orden::NUMERIC, :esmenu, :esactivo, current_timestamp AT TIME ZONE 'Etc/GMT+6', :creadopor, current_timestamp AT TIME ZONE 'Etc/GMT+6' , :actualizadopor)");

        $stmt->bindParam(":nombre", $datos->nombre, PDO::PARAM_STR);
        $stmt->bindParam(":url", $datos->url, PDO::PARAM_STR);
        $stmt->bindParam(":svg", $datos->svg, PDO::PARAM_STR);
        $stmt->bindParam(":orden", $datos->orden, PDO::PARAM_INT);
        $stmt->bindParam(":esmenu", $datos->esmenu, PDO::PARAM_BOOL);
        $stmt->bindParam(":esactivo", $datos->esactivo, PDO::PARAM_BOOL);
        $stmt->bindParam(":creadopor", self::$vIdUsuario, PDO::PARAM_INT);
        $stmt->bindParam(":actualizadopor", self::$vIdUsuario, PDO::PARAM_INT);


        if ($stmt->execute())

            return true;
    }

    public static function editarMenuM($datos)

    {
        static $tabla = "menu";
        $pdo = ConexionDB::conectar();
        $stmt = $pdo->prepare("UPDATE $tabla SET nombre = :nombre, url = :url, svg =:svg, orden = :orden, pagina_principal =:esmenu,
                                                     esactivo = :esactivo, actualizado = current_timestamp AT TIME ZONE 'Etc/GMT+6', actualizadopor = :actualizadopor WHERE id_menu = :id");

        $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);
        $stmt->bindParam(":nombre", $datos->nombre, PDO::PARAM_STR);
        $stmt->bindParam(":url", $datos->url, PDO::PARAM_STR);
        $stmt->bindParam(":svg", $datos->svg, PDO::PARAM_STR);
        $stmt->bindParam(":orden", $datos->orden, PDO::PARAM_INT);
        $stmt->bindParam(":esmenu", $datos->esmenu, PDO::PARAM_BOOL);
        $stmt->bindParam(":esactivo", $datos->esactivo, PDO::PARAM_BOOL);
        $stmt->bindParam(":actualizadopor", self::$vIdUsuario, PDO::PARAM_INT);


        if ($stmt->execute())

            return true;
    }

    public static function eliminarMenuM($datos)

    {
        static $tabla = "menu";
        $pdo = ConexionDB::conectar();
        $stmt = $pdo->prepare("DELETE FROM $tabla WHERE id_menu = :id");

        $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);

        if ($stmt->execute())

            return true;
    }

    public static function obtenerEmpresaM()
    {

        try {
            static $query = "SELECT * FROM empresa WHERE esactivo = true";

            $stmt = ConexionDB::conectar()->prepare($query);

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {

            return $e;
        }
    }

    public static function agregarRelacionM($datos)
    {

        static $tabla = "menu_relacion";
        $pdo = ConexionDB::conectar();
        $stmt = $pdo->prepare("INSERT INTO $tabla (creado, creadopor, actualizado, actualizadopor, id_menu, id_empresa)
        VALUES (current_timestamp AT TIME ZONE 'Etc/GMT+6', :creadopor, current_timestamp AT TIME ZONE 'Etc/GMT+6' , :actualizadopor, :id, :id_empresa)");

        $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);
        $stmt->bindParam(":id_empresa", $datos->id_empresa, PDO::PARAM_INT);
        $stmt->bindParam(":creadopor", self::$vIdUsuario, PDO::PARAM_INT);
        $stmt->bindParam(":actualizadopor", self::$vIdUsuario, PDO::PARAM_INT);


        if ($stmt->execute())

            return true;
    }

    public static function listarRelacionM($datos)
    {

        try {
            static $query = "SELECT mr.id_menu_relacion, mr.id_empresa, mr.id_menu, emp.nombre_empresa
                            FROM menu_relacion AS mr
                            INNER JOIN empresa AS emp
                            ON mr.id_empresa = emp.id_empresa
                            WHERE mr.id_menu = :id";

            $stmt = ConexionDB::conectar()->prepare($query);
            $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);


            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {

            return $e;
        }
    }

    public static function eliminarRelacionM($datos)

    {
        static $tabla = "menu_relacion";
        $pdo = ConexionDB::conectar();
        $stmt = $pdo->prepare("DELETE FROM $tabla WHERE id_menu_relacion = :id");

        $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);

        if ($stmt->execute())

            return true;
    }
}

MenuM::inicializacion();
