<?php
require("../general/valida_session.php");
$session = new ValidaSession();

$metodo = $_SERVER["REQUEST_METHOD"];
$datos = json_decode(file_get_contents("php://input"));

if ($session->verifica_session()) {

	switch ($datos->accion) {
		
		case 'ticket':
			ControladorJasperServer::GenerarTicket($datos);
		break;

	}
} else {
	$output = array('message' => 'Not authorizedv2');
	echo json_encode($output);
}


class ControladorJasperServer
{

	

	public static function GenerarTicket($datos)
	{
		require_once "../model/m_jasper_server.php";
		$r = ModeloJasperServer::GenerarTicketM($datos);
		echo ($r);
	}

}

