<?php

require_once("../general/Session.php");

$metodo = $_SERVER["REQUEST_METHOD"];
$datos = json_decode(file_get_contents("php://input"));

switch($datos->accion)
{
	case 'buscarUsuarios': 
        Login::buscarUsuarios($datos);

	break;

	case 'acceder': 
        Login::validaracceso($datos);

	break;

}

class Login
{
	public static function buscarUsuarios($datos)
	{
		require_once "../model/m_login.php";
		$r = LoginM::buscarUsuariosM($datos);
		echo json_encode($r);
	}

	public static function validaracceso($datos)
	{
		require_once "../model/m_login.php";
		$r = LoginM::validaraccesoM($datos);
		echo json_encode($r);
	}

  
}
