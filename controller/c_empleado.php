<?php

require_once("../general/valida_session.php");
$session = new ValidaSession();

$metodo = $_SERVER["REQUEST_METHOD"];
$datos = json_decode(file_get_contents("php://input"));

if ($session->verifica_session()) {
    switch ($datos->accion) {

        case 'obtenerEmpleado':
            Empleado::obtenerEmpleado($datos);
            break;
        case 'insertarEmpleado':
            Empleado::insertarEmpleado($datos);
            break;
        case 'editarEmpleado':
            Empleado::editarEmpleado($datos);
            break;
        case 'eliminarEmpleado':
            Empleado::eliminarEmpleado($datos);
            break;
        case 'obtenerMenuRelacion':
            Empleado::obtenerMenuRelacion($datos);
            break;
        case 'agregarRelacion':
            Empleado::agregarRelacion($datos);
            break;
        case 'listarRelacion':
            Empleado::listarRelacion($datos);
            break;
        case 'eliminarRelacion':
            Empleado::eliminarRelacion($datos);
            break;
    }
} else {
    $output = array('message' => 'Not authorizedv2');
    echo json_encode($output);
}


class Empleado
{
    public static function obtenerEmpleado($datos)
    {
        require_once "../model/m_empleado.php";
        $r = EmpleadoM::obtenerEmpleadoM();
        echo json_encode($r);
    }
    public static function insertarEmpleado($datos)
    {
        require_once "../model/m_empleado.php";
        $r = EmpleadoM::insertarEmpleadoM($datos);
        echo json_encode($r);
    }
    public static function editarEmpleado($datos)
    {
        require_once "../model/m_empleado.php";
        $r = EmpleadoM::editarEmpleadoM($datos);
        echo json_encode($r);
    }
    public static function eliminarEmpleado($datos)
    {
        require_once "../model/m_empleado.php";
        $r = EmpleadoM::eliminarEmpleadoM($datos);
        echo json_encode($r);
    }
    public static function obtenerMenuRelacion($datos)
    {
        require_once "../model/m_empleado.php";
        $r = EmpleadoM::obtenerMenuRelacionM();
        echo json_encode($r);
    }
    public static function agregarRelacion($datos)
    {
        require_once "../model/m_empleado.php";
        $r = EmpleadoM::agregarRelacionM($datos);
        echo json_encode($r);
    }
    public static function listarRelacion($datos)
    {
        require_once "../model/m_empleado.php";
        $r = EmpleadoM::listarRelacionM($datos);
        echo json_encode($r);
    }
    public static function eliminarRelacion($datos)
    {
        require_once "../model/m_empleado.php";
        $r = EmpleadoM::eliminarRelacionM($datos);
        echo json_encode($r);
    }
}
