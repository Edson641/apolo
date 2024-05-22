<?php

require_once("../general/valida_session.php");
$session = new ValidaSession();

$metodo = $_SERVER["REQUEST_METHOD"];
$datos = json_decode(file_get_contents("php://input"));

if ($session->verifica_session()) {
    switch ($datos->accion) {

        case 'obtenerCaja':
            Caja::obtenerCaja($datos);
            break;
        case 'insertarCaja':
            Caja::insertarCaja($datos);
            break;
        case 'editarCaja':
            Caja::editarCaja($datos);
            break;
        case 'eliminarCaja':
            Caja::eliminarCaja($datos);
            break;
        case 'editarSaldo':
            Caja::editarSaldo($datos);
            break;
        case 'editarSaldoDolar':
            Caja::editarSaldoDolar($datos);
            break;
        case 'editarSaldoOut':
            Caja::editarSaldoOut($datos);
            break;
        case 'editarSaldoDolarOut':
            Caja::editarSaldoDolarOut($datos);
            break;
        case 'obtenerCajaEmpresa':
            Caja::obtenerCajaEmpresa($datos);
            break;
        case 'obtenerSaldoCaja':
            Caja::obtenerSaldoCaja($datos);
            break;
        case 'agregarSaldo':
            Caja::agregarSaldo($datos);
            break;
        case 'agregarSaldoDolar':
            Caja::agregarSaldoDolar($datos);
            break;
        case 'restarSaldo':
            Caja::restarSaldo($datos);
            break;
        case 'restarSaldoDolar':
            Caja::restarSaldoDolar($datos);
            break;
    }
} else {
    $output = array('message' => 'Not authorizedv2');
    echo json_encode($output);
}


class Caja
{
    public static function obtenerCaja($datos)
    {
        require_once "../model/m_caja.php";
        $r = CajaM::obtenerCajaM();
        echo json_encode($r);
    }
    public static function insertarCaja($datos)
    {
        require_once "../model/m_caja.php";
        $r = CajaM::insertarCajaM($datos);
        echo json_encode($r);
    }
    public static function editarCaja($datos)
    {
        require_once "../model/m_caja.php";
        $r = CajaM::editarCajaM($datos);
        echo json_encode($r);
    }
    public static function eliminarCaja($datos)
    {
        require_once "../model/m_caja.php";
        $r = CajaM::eliminarCajaM($datos);
        echo json_encode($r);
    }
    public static function editarSaldo($datos)
    {
        require_once "../model/m_caja.php";
        $r = CajaM::editarSaldoM($datos);
        echo json_encode($r);
    }

    public static function editarSaldoDolar($datos)
    {
        require_once "../model/m_caja.php";
        $r = CajaM::editarSaldoDolarM($datos);
        echo json_encode($r);
    }

    public static function editarSaldoOut($datos)
    {
        require_once "../model/m_caja.php";
        $r = CajaM::editarSaldoOutM($datos);
        echo json_encode($r);
    }

    public static function editarSaldoDolarOut($datos)
    {
        require_once "../model/m_caja.php";
        $r = CajaM::editarSaldoDolarOutM($datos);
        echo json_encode($r);
    }
    public static function obtenerCajaEmpresa($datos)
    {
        require_once "../model/m_caja.php";
        $r = CajaM::obtenerCajaEmpresaM($datos);
        echo json_encode($r);
    }
    public static function obtenerSaldoCaja($datos)
    {
        require_once "../model/m_caja.php";
        $r = CajaM::obtenerSaldoCajaM($datos);
        echo json_encode($r);
    }
    public static function agregarSaldo($datos)
    {
        require_once "../model/m_caja.php";
        $r = CajaM::agregarSaldoM($datos);
        echo json_encode($r);
    }
    public static function agregarSaldoDolar($datos)
    {
        require_once "../model/m_caja.php";
        $r = CajaM::agregarSaldoDolarM($datos);
        echo json_encode($r);
    }
    public static function restarSaldo($datos)
    {
        require_once "../model/m_caja.php";
        $r = CajaM::restarSaldoM($datos);
        echo json_encode($r);
    }
    public static function restarSaldoDolar($datos)
    {
        require_once "../model/m_caja.php";
        $r = CajaM::restarSaldoDolarM($datos);
        echo json_encode($r);
    }
}
