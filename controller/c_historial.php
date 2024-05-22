<?php

require_once("../general/valida_session.php");
$session = new ValidaSession();

$metodo = $_SERVER["REQUEST_METHOD"];
$datos = json_decode(file_get_contents("php://input"));

if ($session->verifica_session()) {
    switch ($datos->accion) {

        case 'obtenerHistorial':
            Historial::obtenerHistorial($datos);
            break;
        case 'obtenerHistorialD':
            Historial::obtenerHistorialD($datos);
            break;
        case 'insertarHistorial':
            Historial::insertarHistorial($datos);
            break;
        case 'editarHistorial':
            Historial::editarHistorial($datos);
            break;
        case 'eliminarHistorial':
            Historial::eliminarHistorial($datos);
            break;
        case 'obtenerHistorialC':
            Historial::obtenerHistorialC($datos);
            break;
    }
} else {
    $output = array('message' => 'Not authorizedv2');
    echo json_encode($output);
}


class Historial
{
    public static function obtenerHistorial($datos)
    {
        require_once "../model/m_historial.php";
        $r = HistorialM::obtenerHistorialM($datos);
        echo json_encode($r);
    }
    public static function obtenerHistorialD($datos)
    {
        require_once "../model/m_historial.php";
        $r = HistorialM::obtenerHistorialDM($datos);
        echo json_encode($r);
    }
    public static function insertarHistorial($datos)
    {
        require_once "../model/m_historial.php";
        $r = HistorialM::insertarHistorialM($datos);
        echo json_encode($r);
    }
    public static function editarHistorial($datos)
    {
        require_once "../model/m_historial.php";
        $r = HistorialM::editarHistorialM($datos);
        echo json_encode($r);
    }
    public static function eliminarHistorial($datos)
    {
        require_once "../model/m_historial.php";
        $r = HistorialM::eliminarHistorialM($datos);
        echo json_encode($r);
    }
    public static function obtenerHistorialC($datos)
    {
        require_once "../model/m_historial.php";
        $r = HistorialM::obtenerHistorialC($datos);
        echo json_encode($r);
    }
}
