<?php

require_once("../general/valida_session.php");
$session = new ValidaSession();

$metodo = $_SERVER["REQUEST_METHOD"];
$datos = json_decode(file_get_contents("php://input"));

if ($session->verifica_session()) {
    switch ($datos->accion) {

        case 'obtenerSucursal':
            Sucursal::obtenerSucursal($datos);
            break;
        case 'insertarSucursal':
            Sucursal::insertarSucursal($datos);
            break;
        case 'editarSucursal':
            Sucursal::editarSucursal($datos);
            break;
        case 'eliminarSucursal':
            Sucursal::eliminarSucursal($datos);
            break;
        case 'obtenerSucursalEmpresa':
            Sucursal::obtenerSucursalEmpresa($datos);
            break;
    }
} else {
    $output = array('message' => 'Not authorizedv2');
    echo json_encode($output);
}


class Sucursal
{
    public static function obtenerSucursal($datos)
    {
        require_once "../model/m_sucursal.php";
        $r = SucursalM::obtenerSucursalM();
        echo json_encode($r);
    }
    public static function insertarSucursal($datos)
    {
        require_once "../model/m_sucursal.php";
        $r = SucursalM::insertarSucursalM($datos);
        echo json_encode($r);
    }
    public static function editarSucursal($datos)
    {
        require_once "../model/m_sucursal.php";
        $r = SucursalM::editarSucursalM($datos);
        echo json_encode($r);
    }
    public static function eliminarSucursal($datos)
    {
        require_once "../model/m_sucursal.php";
        $r = SucursalM::eliminarSucursalM($datos);
        echo json_encode($r);
    }
    public static function obtenerSucursalEmpresa($datos)
    {
        require_once "../model/m_sucursal.php";
        $r = SucursalM::obtenerSucursalEmpresaM($datos);
        echo json_encode($r);
    }
}
