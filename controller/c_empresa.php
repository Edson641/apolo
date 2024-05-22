<?php

require_once("../general/valida_session.php");
$session = new ValidaSession();

$metodo = $_SERVER["REQUEST_METHOD"];
$datos = json_decode(file_get_contents("php://input"));

if ($session->verifica_session()) {
    switch ($datos->accion) {

        case 'obtenerEmpresa':
            Empresa::obtenerEmpresa($datos);
            break;
        case 'insertarEmpresa':
            Empresa::insertarEmpresa($datos);
            break;
        case 'editarEmpresa':
            Empresa::editarEmpresa($datos);
            break;
        case 'eliminarEmpresa':
            Empresa::eliminarEmpresa($datos);
            break;
        case 'obtenerEmpresaC':
            Empresa::obtenerEmpresaC($datos);
            break;
    }
} else {
    $output = array('message' => 'Not authorizedv2');
    echo json_encode($output);
}


class Empresa
{
    public static function obtenerEmpresa($datos)
    {
        require_once "../model/m_empresa.php";
        $r = EmpresaM::obtenerEmpresaM();
        echo json_encode($r);
    }
    public static function insertarEmpresa($datos)
    {
        require_once "../model/m_empresa.php";
        $r = EmpresaM::insertarEmpresaM($datos);
        echo json_encode($r);
    }
    public static function editarEmpresa($datos)
    {
        require_once "../model/m_empresa.php";
        $r = EmpresaM::editarEmpresaM($datos);
        echo json_encode($r);
    }
    public static function eliminarEmpresa($datos)
    {
        require_once "../model/m_empresa.php";
        $r = EmpresaM::eliminarEmpresaM($datos);
        echo json_encode($r);
    }
    public static function obtenerEmpresaC($datos)
    {
        require_once "../model/m_empresa.php";
        $r = EmpresaM::obtenerEmpresaC($datos);
        echo json_encode($r);
    }
}
