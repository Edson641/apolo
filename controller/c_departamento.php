<?php

require_once("../general/valida_session.php");
$session = new ValidaSession();

$metodo = $_SERVER["REQUEST_METHOD"];
$datos = json_decode(file_get_contents("php://input"));

if ($session->verifica_session()) {
    switch ($datos->accion) {

        case 'obtenerDepartamento':
            Departamento::obtenerDepartamento($datos);
            break;
        case 'insertarDepartamento':
            Departamento::insertarDepartamento($datos);
            break;
        case 'editarDepartamento':
            Departamento::editarDepartamento($datos);
            break;
        case 'eliminarDepartamento':
            Departamento::eliminarDepartamento($datos);
            break;
        case 'obtenerDepartamentoSucursal':
            Departamento::obtenerDepartamentoSucursal($datos);
            break;
    }
} else {
    $output = array('message' => 'Not authorizedv2');
    echo json_encode($output);
}


class Departamento
{
    public static function obtenerDepartamento($datos)
    {
        require_once "../model/m_departamento.php";
        $r = DepartamentoM::obtenerDepartamentoM();
        echo json_encode($r);
    }
    public static function insertarDepartamento($datos)
    {
        require_once "../model/m_departamento.php";
        $r = DepartamentoM::insertarDepartamentoM($datos);
        echo json_encode($r);
    }
    public static function editarDepartamento($datos)
    {
        require_once "../model/m_departamento.php";
        $r = DepartamentoM::editarDepartamentoM($datos);
        echo json_encode($r);
    }
    public static function eliminarDepartamento($datos)
    {
        require_once "../model/m_departamento.php";
        $r = DepartamentoM::eliminarDepartamentoM($datos);
        echo json_encode($r);
    }
    public static function obtenerDepartamentoSucursal($datos)
    {
        require_once "../model/m_departamento.php";
        $r = DepartamentoM::obtenerDepartamentoSucursalM($datos);
        echo json_encode($r);
    }
}
