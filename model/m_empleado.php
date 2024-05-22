<?php

include("../db/ConexionDB.php");


class EmpleadoM extends ConexionDB


{

    public static $vIdRol;
    public static $vIdUsuario;

    public static function inicializacion()
    {
        self::$vIdUsuario = (int) $_SESSION['usuarioApolo'][0]['id_empleado'];
        self::$vIdRol = (int) $_SESSION['usuarioApolo'][0]['id_rol'];
    }

    public static function obtenerEmpleadoM()
    {

        try {
            static $query = "SELECT e.id_empleado, e.nombre, e.ap_paterno, e.ap_materno, CONCAT(e.nombre,' ',e.ap_paterno,' ',e.ap_materno) as empleado
            , e.nombre_usuario, e.id_empresa, e.id_sucursal, e.id_departamento, CASE WHEN e.esactivo = true THEN 'SI' ELSE 'NO' END AS esactivo
            ,emp.nombre_empresa, dep.nombre_departamento, suc.nombre_sucursal, e.id_rol, rol.rol
             FROM empleado AS e
             INNER JOIN empresa AS emp
             ON e.id_empresa = emp.id_empresa
             INNER JOIN sucursal AS suc
             ON e.id_sucursal = suc.id_sucursal
             INNER JOIN departamento AS dep
             ON e.id_departamento = dep.id_departamento
             INNER JOIN rol AS rol
             ON e.id_rol = rol.id_rol
             order by e.id_empleado asc";


            $stmt = ConexionDB::conectar()->prepare($query);

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {

            return $e;
        }
    }

    public static function insertarEmpleadoM($datos)

    {
        static $tabla = "empleado";
        $pdo = ConexionDB::conectar();
        $stmt = $pdo->prepare("INSERT INTO $tabla (creado, creadopor, actualizado, actualizadopor, nombre, ap_paterno, ap_materno, nombre_usuario, id_empresa, id_sucursal, id_departamento, id_rol, esactivo, contrasenia)
                                           VALUES (current_timestamp AT TIME ZONE 'Etc/GMT+6', :creadopor, current_timestamp AT TIME ZONE 'Etc/GMT+6' , :actualizadopor, :nombre, :paterno, :materno, :nombre_usuario, :id_empresa, :id_sucursal, :id_departamento, :id_rol, :esactivo, MD5('apolo123'))");

        $stmt->bindParam(":nombre", $datos->nombre, PDO::PARAM_STR);
        $stmt->bindParam(":paterno", $datos->paterno, PDO::PARAM_STR);
        $stmt->bindParam(":materno", $datos->materno, PDO::PARAM_STR);
        $stmt->bindParam(":nombre_usuario", $datos->nombre_usuario, PDO::PARAM_STR);
        $stmt->bindParam(":id_empresa", $datos->id_empresa, PDO::PARAM_INT);
        $stmt->bindParam(":id_sucursal", $datos->id_sucursal, PDO::PARAM_INT);
        $stmt->bindParam(":id_departamento", $datos->id_departamento, PDO::PARAM_INT);
        $stmt->bindParam(":id_rol", $datos->id_rol, PDO::PARAM_INT);
        $stmt->bindParam(":esactivo", $datos->esactivo, PDO::PARAM_BOOL);
        $stmt->bindParam(":creadopor", self::$vIdUsuario, PDO::PARAM_INT);
        $stmt->bindParam(":actualizadopor", self::$vIdUsuario, PDO::PARAM_INT);


        if ($stmt->execute())

        $ultimo_id = $pdo->lastInsertId();

        $role = new EmpleadoM;
        $role = $role->insertarRol($datos->id_rol, $ultimo_id);

            return true;
    }

    public static function insertarRol($rol, $id)

	{
		static $tabla = "empleado_rol";
        $pdo = ConexionDB::conectar();
		$stmt = $pdo->prepare("INSERT INTO $tabla (creado, creadopor, actualizado, actualizadopor, id_empleado, id_rol, esactivo)
                                                 VALUES (current_timestamp AT TIME ZONE 'Etc/GMT+6', :creadopor, current_timestamp AT TIME ZONE 'Etc/GMT+6', :actualizadopor, :id_empleado, :id_rol, true)");

        $stmt->bindParam(":creadopor", self::$vIdUsuario, PDO::PARAM_INT);
        $stmt->bindParam(":actualizadopor", self::$vIdUsuario, PDO::PARAM_INT);
        $stmt->bindParam(":id_empleado", $id, PDO::PARAM_INT);
        $stmt->bindParam(":id_rol", $rol, PDO::PARAM_INT);

      

        if($stmt->execute())

			return true;
			
	}

    public static function editarEmpleadoM($datos)

    {
        static $tabla = "empleado";
        $pdo = ConexionDB::conectar();
        $stmt = $pdo->prepare("UPDATE $tabla SET nombre = :nombre, ap_paterno = :paterno, ap_materno = :materno, nombre_usuario = :nombre_usuario, id_empresa = :id_empresa, id_rol = :id_rol,
         id_sucursal = :id_sucursal, id_departamento = :id_departamento, esactivo = :esactivo, actualizado = current_timestamp AT TIME ZONE 'Etc/GMT+6', actualizadopor = :actualizadopor WHERE id_empleado = :id");

        $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);
        $stmt->bindParam(":nombre", $datos->nombre, PDO::PARAM_STR);
        $stmt->bindParam(":paterno", $datos->paterno, PDO::PARAM_STR);
        $stmt->bindParam(":materno", $datos->materno, PDO::PARAM_STR);
        $stmt->bindParam(":nombre_usuario", $datos->nombre_usuario, PDO::PARAM_STR);
        $stmt->bindParam(":id_empresa", $datos->id_empresa, PDO::PARAM_INT);
        $stmt->bindParam(":id_sucursal", $datos->id_sucursal, PDO::PARAM_INT);
        $stmt->bindParam(":id_departamento", $datos->id_departamento, PDO::PARAM_INT);
        $stmt->bindParam(":id_rol", $datos->id_rol, PDO::PARAM_INT);
        $stmt->bindParam(":esactivo", $datos->esactivo, PDO::PARAM_BOOL);
        $stmt->bindParam(":actualizadopor", self::$vIdUsuario, PDO::PARAM_INT);


        if ($stmt->execute())

        $role = new EmpleadoM;
        $role = $role->editarRol($datos->id_rol, $datos->id);

            return true;
    }

    public static function editarRol($rol, $id)

	{
		static $tabla = "empleado_rol";
        $pdo = ConexionDB::conectar();
		$stmt = $pdo->prepare("UPDATE $tabla SET actualizado = current_timestamp AT TIME ZONE 'Etc/GMT+6', actualizadopor = :actualizadopor, id_rol = :id_rol WHERE id_empleado = :id_empleado");

        $stmt->bindParam(":actualizadopor", self::$vIdUsuario, PDO::PARAM_INT);
        $stmt->bindParam(":id_empleado", $id, PDO::PARAM_INT);
        $stmt->bindParam(":id_rol", $rol, PDO::PARAM_INT);

      

        if($stmt->execute())

			return true;
			
	}

    public static function eliminarEmpleadoM($datos)

    {
        static $tabla = "empleado";
        $pdo = ConexionDB::conectar();
        $stmt = $pdo->prepare("DELETE FROM $tabla WHERE id_empleado = :id");

        $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);

        if ($stmt->execute())

        $role = new EmpleadoM;
        $role = $role->eliminarRolM($datos->id);

            return true;
    }

    public static function eliminarRolM($ide)

    {
        static $tabla = "empleado_rol";
        $pdo = ConexionDB::conectar();
        $stmt = $pdo->prepare("DELETE FROM $tabla WHERE id_empleado = :id");

        $stmt->bindParam(":id", $ide, PDO::PARAM_INT);

        if ($stmt->execute())

            return true;
    }
    

    public static function obtenerMenuRelacionM()
    {

        try {
            static $query = "SELECT mr.id_menu_relacion, mr.id_menu, mr.id_empresa, m.nombre FROM menu_relacion as mr
                            INNER JOIN menu AS m
                            ON m.id_menu = mr.id_menu";

            $stmt = ConexionDB::conectar()->prepare($query);

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

EmpleadoM::inicializacion();
