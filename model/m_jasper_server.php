<?php

require "../lib/phpclient/autoload.php"; //local

use Jaspersoft\Client\Client; //Local
use Jaspersoft\Exception\RESTRequestException;

class ModeloJasperServer
{

    public static $HOST;
    public static $USER;
    public static $PASSWORD;
    public static $vIdUsuario;
    public static $vIdRol;


    public static function init()
    {

        self::$HOST = "http://67.205.162.138:51541/jasperserver";
        self::$USER = "DesarrolloAdmin";
        self::$PASSWORD = "Dev_JasperSoft#20";
        self::$vIdUsuario = (int) $_SESSION['usuarioApolo'][0]['id_empleado'];
        self::$vIdRol = (int) $_SESSION['usuarioApolo'][0]['id_rol'];
        }


    // public static function GenerarTicketM($datos)
    // {
    //     try {
    //         $params = array(
    //             'id_historial' => $datos->id_historial,
    //         );

    //         $c = new Client(self::$HOST, self::$USER, self::$PASSWORD);
    //         $c->setRequestTimeout(600);
    //         $report = $c->reportService()->runReport('/reports/Apolo/ticket',  $datos->tipo, null, null, $params);
    //         $directorio = __DIR__ .'/../Ticket/';
    //         $fechaActual = date('d-m-Y-');
    //         $nombreArchivo = $fechaActual. 'Report_' .'xs'. '-cr'. self::$vIdUsuario.  '.pdf';
    //         file_put_contents($directorio . ($nombreArchivo),$report);

    //         return $nombreArchivo;

    //     } catch (Throwable $th) {

    //         return $th;
    //     }
    // }

    public static function GenerarTicketM($datos)
    {
        try {
            $params = array(
                'historial' => $datos->id_historial,
            );

            $c = new Client(self::$HOST, self::$USER, self::$PASSWORD);
            $c->setRequestTimeout(600);
            $report = $c->reportService()->runReport('/reports/Apolo/'. 'ticketMov', $datos->tipo, null, null, $params);

            header('Access-Control-Allow-Origin: *');
            header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
            header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

            return $report;

        } catch (Throwable $th) {

            return $th;
        }
    }
}

ModeloJasperServer::init();
