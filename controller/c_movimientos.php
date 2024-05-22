<?php

require_once("../general/valida_session.php");
$session = new ValidaSession();

$metodo = $_SERVER["REQUEST_METHOD"];
$datos = json_decode(file_get_contents("php://input"));

if ($session->verifica_session()) {
    switch ($datos->accion) {

        case 'obtenerMovimientos':
            Movimientos::obtenerMovimientos($datos);
            break;
        case 'insertarMovimientos':
            Movimientos::insertarMovimientos($datos);
            break;
        case 'crearHistorial':
            Movimientos::crearHistorial($datos);
            break;
        case 'eliminarMovimientos':
            Movimientos::eliminarMovimientos($datos);
            break;
        case 'obtenerTipo':
            Movimientos::obtenerTipo($datos);
            break;
    }
} else {
    $output = array('message' => 'Not authorizedv2');
    echo json_encode($output);
}


class Movimientos
{
    public static function obtenerMovimientos($datos)
    {
        require_once "../model/m_movimientos.php";
        $r = MovimientosM::obtenerMovimientosM($datos);
        echo json_encode($r);
    }
    public static function insertarMovimientos($datos)
    {
        require_once "../model/m_movimientos.php";
        $r = MovimientosM::insertarMovimientosM($datos);
        echo json_encode($r);
    }
    public static function crearHistorial($datos)
    {
        require_once "../model/m_movimientos.php";
        $r = MovimientosM::crearHistorial($datos);
        echo json_encode($r);
    }
    public static function eliminarMovimientos($datos)
    {
        require_once "../model/m_movimientos.php";
        $r = MovimientosM::eliminarMovimientosM($datos);
        echo json_encode($r);
    }
    public static function obtenerTipo($datos)
    {
        require_once "../model/m_movimientos.php";
        $r = MovimientosM::obtenerTipoM();
        echo json_encode($r);
    }
}
