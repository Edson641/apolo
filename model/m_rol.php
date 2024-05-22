<?php

include("../db/ConexionDB.php");




class RolM extends ConexionDB


{

    public static $vIdRol;
    public static $vIdUsuario;

    public static function inicializacion()
    {
        self::$vIdUsuario = (int) $_SESSION['usuarioApolo'][0]['id_empleado'];
        self::$vIdRol = (int) $_SESSION['usuarioApolo'][0]['id_rol'];
    }

    public static function obtenerRolM()
    {

        try {
            static $query = "SELECT id_rol, nombre_rol, rol, CASE WHEN esactivo = true THEN 'SI' ELSE 'NO' END AS esactivo FROM rol order by id_rol asc
                           ";


            $stmt = ConexionDB::conectar()->prepare($query);

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {

            return $e;
        }
    }

    public static function insertarRolM($datos)

    {
        static $tabla = "rol";
        $pdo = ConexionDB::conectar();
        $stmt = $pdo->prepare("INSERT INTO $tabla (creado, creadopor, actualizado, actualizadopor, nombre_rol, rol, esactivo)
        VALUES (current_timestamp AT TIME ZONE 'Etc/GMT+6', :creadopor, current_timestamp AT TIME ZONE 'Etc/GMT+6' , :actualizadopor, :nombre_rol, :rol, :esactivo)");

        $stmt->bindParam(":nombre_rol", $datos->rol, PDO::PARAM_STR);
        $stmt->bindParam(":rol", $datos->rol, PDO::PARAM_STR);
        $stmt->bindParam(":esactivo", $datos->esactivo, PDO::PARAM_BOOL);
        $stmt->bindParam(":creadopor", self::$vIdUsuario, PDO::PARAM_INT);
        $stmt->bindParam(":actualizadopor", self::$vIdUsuario, PDO::PARAM_INT);


        if ($stmt->execute())

            return true;
    }

    public static function editarRolM($datos)

    {
        static $tabla = "rol";
        $pdo = ConexionDB::conectar();
        $stmt = $pdo->prepare("UPDATE $tabla SET nombre_rol = :nombre_rol, rol = :rol,esactivo = :esactivo, actualizado = current_timestamp AT TIME ZONE 'Etc/GMT+6'
                                            , actualizadopor = :actualizadopor WHERE id_rol = :id");

        $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);
        $stmt->bindParam(":nombre_rol", $datos->rol, PDO::PARAM_STR);
        $stmt->bindParam(":rol", $datos->rol, PDO::PARAM_STR);
        $stmt->bindParam(":esactivo", $datos->esactivo, PDO::PARAM_BOOL);
        $stmt->bindParam(":actualizadopor", self::$vIdUsuario, PDO::PARAM_INT);


        if ($stmt->execute())

            return true;
    }

    public static function eliminarRolM($datos)

    {
        static $tabla = "rol";
        $pdo = ConexionDB::conectar();
        $stmt = $pdo->prepare("DELETE FROM $tabla WHERE id_rol = :id");

        $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);

        if ($stmt->execute())

            return true;
    }

    public static function obtenerMenuRelacionM($datos)
    {

        try {
            static $query = "SELECT mr.id_menu_relacion, mr.id_menu, mr.id_empresa, m.nombre FROM menu_relacion as mr
                            INNER JOIN menu AS m
                            ON m.id_menu = mr.id_menu
                            WHERE mr.id_empresa = :id_empresa";

            $stmt = ConexionDB::conectar()->prepare($query);
            $stmt->bindParam(":id_empresa", $datos->id_empresa, PDO::PARAM_INT);

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {

            return $e;
        }
    }

    public static function agregarRelacionM($datos)
    {

        static $tabla = "menu_rol";
        $pdo = ConexionDB::conectar();
        $stmt = $pdo->prepare("INSERT INTO $tabla (creado, creadopor, actualizado, actualizadopor, id_rol ,id_menu, id_empresa)
        VALUES (current_timestamp AT TIME ZONE 'Etc/GMT+6', :creadopor, current_timestamp AT TIME ZONE 'Etc/GMT+6' , :actualizadopor, :id_rol, :id_menu, :id_empresa)");

        $stmt->bindParam(":id_rol", $datos->id_rol, PDO::PARAM_INT);
        $stmt->bindParam(":id_menu", $datos->id_menu, PDO::PARAM_INT);
        $stmt->bindParam(":id_empresa", $datos->id_empresa, PDO::PARAM_INT);
        $stmt->bindParam(":creadopor", self::$vIdUsuario, PDO::PARAM_INT);
        $stmt->bindParam(":actualizadopor", self::$vIdUsuario, PDO::PARAM_INT);


        if ($stmt->execute())

            return true;
    }

    public static function listarRelacionM($datos)
    {

        try {
            static $query = "SELECT mr.id_menu_rol, mr.id_rol, mr.id_empresa, mr.id_menu, m.nombre, em.nombre_empresa
                            FROM menu_rol AS mr
                            INNER JOIN menu AS m
                            ON m.id_menu = mr.id_menu
                            INNER JOIN empresa AS em
                            ON em.id_empresa = mr.id_empresa
                            WHERE mr.id_rol = :id";

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
        static $tabla = "menu_rol";
        $pdo = ConexionDB::conectar();
        $stmt = $pdo->prepare("DELETE FROM $tabla WHERE id_menu_rol = :id");

        $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);

        if ($stmt->execute())

            return true;
    }
}

RolM::inicializacion();
