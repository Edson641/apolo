<?php

require_once("../general/valida_session.php");
$session = new ValidaSession();

$metodo = $_SERVER["REQUEST_METHOD"];
$datos = json_decode(file_get_contents("php://input"));

if ($session->verifica_session()) {
    switch ($datos->accion) {

        case 'obtenerMenu':
            Menu::obtenerMenu($datos);
            break;
        case 'insertarMenu':
            Menu::insertarMenu($datos);
            break;
        case 'editarMenu':
            Menu::editarMenu($datos);
            break;
        case 'eliminarMenu':
            Menu::eliminarMenu($datos);
            break;
        case 'obtenerEmpresa':
            Menu::obtenerEmpresa($datos);
            break;
        case 'agregarRelacion':
            Menu::agregarRelacion($datos);
            break;
        case 'listarRelacion':
            Menu::listarRelacion($datos);
            break;
        case 'eliminarRelacion':
            Menu::eliminarRelacion($datos);
            break;
    }
} else {
    $output = array('message' => 'Not authorizedv2');
    echo json_encode($output);
}


class Menu
{
    public static function obtenerMenu($datos)
    {
        require_once "../model/m_menu.php";
        $r = MenuM::obtenerMenuM();
        echo json_encode($r);
    }
    public static function insertarMenu($datos)
    {
        require_once "../model/m_menu.php";
        $r = MenuM::insertarMenuM($datos);
        echo json_encode($r);
    }
    public static function editarMenu($datos)
    {
        require_once "../model/m_menu.php";
        $r = MenuM::editarMenuM($datos);
        echo json_encode($r);
    }
    public static function eliminarMenu($datos)
    {
        require_once "../model/m_menu.php";
        $r = MenuM::eliminarMenuM($datos);
        echo json_encode($r);
    }
    public static function obtenerEmpresa($datos)
    {
        require_once "../model/m_menu.php";
        $r = MenuM::obtenerEmpresaM();
        echo json_encode($r);
    }
    public static function agregarRelacion($datos)
    {
        require_once "../model/m_menu.php";
        $r = MenuM::agregarRelacionM($datos);
        echo json_encode($r);
    }
    public static function listarRelacion($datos)
    {
        require_once "../model/m_menu.php";
        $r = MenuM::listarRelacionM($datos);
        echo json_encode($r);
    }
    public static function eliminarRelacion($datos)
    {
        require_once "../model/m_menu.php";
        $r = MenuM::eliminarRelacionM($datos);
        echo json_encode($r);
    }
}
