<?php

require_once("../config/default.php");

class ConexionDB
{

	public static function conectar()
	{
		try
		{
            $config = new Datos();
            $connect = new PDO("pgsql:host=".Datos::SERVIDOR.";port=".Datos::PUERTO.";dbname=".Datos::BASEDATOS."", Datos::USUARIO, Datos::CONTRASENIA);
            $connect->exec('SET search_path TO '.Datos::ESQUEMA.'');
            $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $connect;
		}
		catch(PDOException $e) 
		{
    		echo 'Conexión fallida: ' . $e->getMessage();
            die();
		}
	
	}

	public static function close(){
		die();
	}




}
