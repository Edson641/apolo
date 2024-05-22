<?php

require_once("../general/valida_session.php");
$session = new ValidaSession();

$metodo = $_SERVER["REQUEST_METHOD"];
$datos = json_decode(file_get_contents("php://input"));

if ($session->verifica_session()) {
    switch ($datos->accion) {

        case 'obtenerMoneda':
            Moneda::obtenerMoneda($datos);
            break;
        case 'insertarMoneda':
            Moneda::insertarMoneda($datos);
            break;
        case 'editarMoneda':
            Moneda::editarMoneda($datos);
            break;
        case 'eliminarMoneda':
            Moneda::eliminarMoneda($datos);
            break;
    }
} else {
    $output = array('message' => 'Not authorizedv2');
    echo json_encode($output);
}


class Moneda
{
    public static function obtenerMoneda($datos)
    {
        require_once "../model/m_moneda.php";
        $r = MonedaM::obtenerMonedaM();
        echo json_encode($r);
    }
    public static function insertarMoneda($datos)
    {
        require_once "../model/m_moneda.php";
        $r = MonedaM::insertarMonedaM($datos);
        echo json_encode($r);
    }
    public static function editarMoneda($datos)
    {
        require_once "../model/m_moneda.php";
        $r = MonedaM::editarMonedaM($datos);
        echo json_encode($r);
    }
    public static function eliminarMoneda($datos)
    {
        require_once "../model/m_moneda.php";
        $r = MonedaM::eliminarMonedaM($datos);
        echo json_encode($r);
    }
}
