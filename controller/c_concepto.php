<?php

require_once("../general/valida_session.php");
$session = new ValidaSession();

$metodo = $_SERVER["REQUEST_METHOD"];
$datos = json_decode(file_get_contents("php://input"));

if ($session->verifica_session()) {
    switch ($datos->accion) {

        case 'obtenerConcepto':
            Concepto::obtenerConcepto($datos);
            break;
        case 'insertarConcepto':
            Concepto::insertarConcepto($datos);
            break;
        case 'editarConcepto':
            Concepto::editarConcepto($datos);
            break;
        case 'eliminarConcepto':
            Concepto::eliminarConcepto($datos);
            break;
    }
} else {
    $output = array('message' => 'Not authorizedv2');
    echo json_encode($output);
}


class Concepto
{
    public static function obtenerConcepto($datos)
    {
        require_once "../model/m_concepto.php";
        $r = ConceptoM::obtenerConceptoM();
        echo json_encode($r);
    }
    public static function insertarConcepto($datos)
    {
        require_once "../model/m_concepto.php";
        $r = ConceptoM::insertarConceptoM($datos);
        echo json_encode($r);
    }
    public static function editarConcepto($datos)
    {
        require_once "../model/m_concepto.php";
        $r = ConceptoM::editarConceptoM($datos);
        echo json_encode($r);
    }
    public static function eliminarConcepto($datos)
    {
        require_once "../model/m_concepto.php";
        $r = ConceptoM::eliminarConceptoM($datos);
        echo json_encode($r);
    }
}
