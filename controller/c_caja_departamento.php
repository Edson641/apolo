<?php

require_once("../general/valida_session.php");
$session = new ValidaSession();

$metodo = $_SERVER["REQUEST_METHOD"];
$datos = json_decode(file_get_contents("php://input"));

if ($session->verifica_session()) {
    switch ($datos->accion) {

        case 'obtenerCajaDepartamento':
            CajaDepartamento::obtenerCajaDepartamento($datos);
            break;
        case 'insertarCajaDepartamento':
            CajaDepartamento::insertarCajaDepartamento($datos);
            break;
        case 'editarCajaDepartamento':
            CajaDepartamento::editarCajaDepartamento($datos);
            break;
        case 'eliminarCajaDepartamento':
            CajaDepartamento::eliminarCajaDepartamento($datos);
            break;
        case 'editarSaldo':
            CajaDepartamento::editarSaldo($datos);
            break;
        case 'obtenerCajaDepartS':
            CajaDepartamento::obtenerCajaDepartS($datos);
            break;
        case 'agregarSaldo':
            CajaDepartamento::agregarSaldo($datos);
            break;
        case 'agregarSaldoDolar':
            CajaDepartamento::agregarSaldoDolar($datos);
            break;
        case 'restarSaldo':
            CajaDepartamento::restarSaldo($datos);
            break;
        case 'restarSaldoDolar':
            CajaDepartamento::restarSaldoDolar($datos);
            break;
        case 'obtenerSaldoCaja':
            CajaDepartamento::obtenerSaldoCaja($datos);
            break;
    }
} else {
    $output = array('message' => 'Not authorizedv2');
    echo json_encode($output);
}


class CajaDepartamento
{
    public static function obtenerCajaDepartamento($datos)
    {
        require_once "../model/m_caja_departamento.php";
        $r = CajaDepartamentoM::obtenerCajaDepartamentoM($datos);
        echo json_encode($r);
    }
    public static function insertarCajaDepartamento($datos)
    {
        require_once "../model/m_caja_departamento.php";
        $r = CajaDepartamentoM::insertarCajaDepartamentoM($datos);
        echo json_encode($r);
    }
    public static function editarCajaDepartamento($datos)
    {
        require_once "../model/m_caja_departamento.php";
        $r = CajaDepartamentoM::editarCajaDepartamentoM($datos);
        echo json_encode($r);
    }
    public static function eliminarCajaDepartamento($datos)
    {
        require_once "../model/m_caja_departamento.php";
        $r = CajaDepartamentoM::eliminarCajaDepartamentoM($datos);
        echo json_encode($r);
    }
    public static function editarSaldo($datos)
    {
        require_once "../model/m_caja_departamento.php";
        $r = CajaDepartamentoM::editarSaldoM($datos);
        echo json_encode($r);
    }
    public static function obtenerCajaDepartS($datos)
    {
        require_once "../model/m_caja_departamento.php";
        $r = CajaDepartamentoM::obtenerCajaDepartSM($datos);
        echo json_encode($r);
    }
    public static function agregarSaldo($datos)
    {
        require_once "../model/m_caja_departamento.php";
        $r = CajaDepartamentoM::agregarSaldoM($datos);
        echo json_encode($r);
    }
    public static function agregarSaldoDolar($datos)
    {
        require_once "../model/m_caja_departamento.php";
        $r = CajaDepartamentoM::agregarSaldoDolarM($datos);
        echo json_encode($r);
    }
    public static function restarSaldo($datos)
    {
        require_once "../model/m_caja_departamento.php";
        $r = CajaDepartamentoM::restarSaldoM($datos);
        echo json_encode($r);
    }
    public static function restarSaldoDolar($datos)
    {
        require_once "../model/m_caja_departamento.php";
        $r = CajaDepartamentoM::restarSaldoDolarM($datos);
        echo json_encode($r);
    }
    public static function obtenerSaldoCaja($datos)
    {
        require_once "../model/m_caja_departamento.php";
        $r = CajaDepartamentoM::obtenerSaldoCajaM($datos);
        echo json_encode($r);
    }
}
