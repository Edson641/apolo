<?php

require_once("../general/valida_session.php");
$session = new ValidaSession();

$metodo = $_SERVER["REQUEST_METHOD"];
$datos = json_decode(file_get_contents("php://input"));

if ($session->verifica_session()) {
    switch ($datos->accion) {

        case 'obtenerRol':
            Rol::obtenerRol($datos);
            break;
        case 'insertarRol':
            Rol::insertarRol($datos);
            break;
        case 'editarRol':
            Rol::editarRol($datos);
            break;
        case 'eliminarRol':
            Rol::eliminarRol($datos);
            break;
        case 'obtenerMenuRelacion':
            Rol::obtenerMenuRelacion($datos);
            break;
        case 'agregarRelacion':
            Rol::agregarRelacion($datos);
            break;
        case 'listarRelacion':
            Rol::listarRelacion($datos);
            break;
        case 'eliminarRelacion':
            Rol::eliminarRelacion($datos);
            break;
    }
} else {
    $output = array('message' => 'Not authorizedv2');
    echo json_encode($output);
}


class Rol
{
    public static function obtenerRol($datos)
    {
        require_once "../model/m_rol.php";
        $r = RolM::obtenerRolM();
        echo json_encode($r);
    }
    public static function insertarRol($datos)
    {
        require_once "../model/m_rol.php";
        $r = RolM::insertarRolM($datos);
        echo json_encode($r);
    }
    public static function editarRol($datos)
    {
        require_once "../model/m_rol.php";
        $r = RolM::editarRolM($datos);
        echo json_encode($r);
    }
    public static function eliminarRol($datos)
    {
        require_once "../model/m_rol.php";
        $r = RolM::eliminarRolM($datos);
        echo json_encode($r);
    }
    public static function obtenerMenuRelacion($datos)
    {
        require_once "../model/m_rol.php";
        $r = RolM::obtenerMenuRelacionM($datos);
        echo json_encode($r);
    }
    public static function agregarRelacion($datos)
    {
        require_once "../model/m_rol.php";
        $r = RolM::agregarRelacionM($datos);
        echo json_encode($r);
    }
    public static function listarRelacion($datos)
    {
        require_once "../model/m_rol.php";
        $r = RolM::listarRelacionM($datos);
        echo json_encode($r);
    }
    public static function eliminarRelacion($datos)
    {
        require_once "../model/m_rol.php";
        $r = RolM::eliminarRelacionM($datos);
        echo json_encode($r);
    }
}
