<?php
include("../db/ConexionDB.php");

class LoginM extends ConexionDB
{

    public static function buscarUsuariosM($datos)
    {



        try {
            static $query = "SELECT e.id_empleado
            ,e.nombre
            ,e.nombre_usuario,
            er.id_rol
            ,rol.rol
        FROM empleado as e
        INNER JOIN empleado_rol as er
        ON er.id_empleado = e.id_empleado
        INNER JOIN rol as rol
        ON rol.id_rol = er.id_rol
        WHERE e.nombre_usuario = :usuario 
            AND contrasenia = MD5(:contrasenia)";

            $stmt = ConexionDB::conectar()->prepare($query);
            $stmt->bindParam(":usuario", $datos->user, PDO::PARAM_STR);
            $stmt->bindParam(":contrasenia", $datos->password, PDO::PARAM_STR);

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {

            return $e;
        }
    }

    public static function validaraccesoM($datos)
    {

        try {
            static $query = "SELECT
                                e.id_empleado
                                ,e.id_empresa
                                ,e.nombre
                                ,e.ap_paterno
                                ,e.ap_materno
                                ,e.nombre_usuario
                                ,r.rol
                                ,r.id_rol
                                ,r.nombre_rol AS nombrerol

                                FROM empleado e
                                INNER JOIN empleado_rol er
                                    ON er.id_empleado = e.id_empleado
                                INNER JOIN rol r
                                    ON r.id_rol = er.id_rol
                                INNER JOIN empresa AS em
                                    ON em.id_empresa = e.id_empresa
                                WHERE 
                                    e.nombre_usuario= :usuario AND e.contrasenia = MD5(:contrasenia)
                                AND r.id_rol = :rol
                                ;	
                            ";


            $stmt = ConexionDB::conectar()->prepare($query);
            $stmt->bindParam(":usuario", $datos->user, PDO::PARAM_STR);
            $stmt->bindParam(":contrasenia", $datos->password, PDO::PARAM_STR);
            $stmt->bindParam(":rol", $datos->rol, PDO::PARAM_INT);

            $stmt->execute();

            session_start();
            $_SESSION['usuarioApolo'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $resultado = new LoginM();
            $resultado->obtenerMenu($_SESSION['usuarioApolo'][0]['id_empleado'], $_SESSION['usuarioApolo'][0]['id_rol']);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e;
        }
    }

    public static function obtenerMenu($idusuario, $idrol)
    {
        

        try {
            static $query = "SELECT
                            e.id_empleado AS IDUsuario
                            ,e.nombre AS Usuario
                            ,e.id_empresa
                            ,rol.rol AS IdentificadorRol
                            ,rol.nombre_rol AS Rol
                            ,menu.nombre AS NombreUrl
                            ,menu.url AS Url
                            ,menu.svg AS SVG

                        FROM empleado AS e
                        INNER JOIN empleado_rol AS e_rol
                            ON e_rol.id_empleado = e.id_empleado
                        INNER JOIN rol AS rol
                            ON rol.id_rol = e_rol.id_rol
                            AND rol.esactivo = true
                        INNER JOIN menu_rol AS menu_rol
                            ON menu_rol.id_rol = rol.id_rol
                        INNER JOIN menu AS menu
                            ON menu.id_menu = menu_rol.id_menu
                        INNER JOIN menu_relacion AS menu_relacion
                            ON menu_relacion.id_menu = menu.id_menu
                        INNER JOIN empresa AS em
                            ON em.id_empresa = e.id_empresa
                                AND menu_rol.id_empresa = em.id_empresa
                                AND menu_relacion.id_empresa = em.id_empresa
                        WHERE
                            e.id_empleado = :idusuario
                            AND rol.id_rol = :idrol
                                AND menu.esactivo = true		
                                    AND menu.pagina_principal = true

                        ORDER BY menu.orden ASC
                        ";


            $stmt = LoginM::conectar()->prepare($query);
            $stmt->bindParam(":idusuario", $idusuario, PDO::PARAM_STR);
            $stmt->bindParam(":idrol", $idrol, PDO::PARAM_INT);

            $stmt->execute();

            //session_start();   
            $_SESSION['menuLucas'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e;
        }
    }
}

