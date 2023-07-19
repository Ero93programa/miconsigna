<?php
//Creo las variables de conexión a MySQL
	$servidor = "localhost";
	$usuario = "root";
	$pass = "";
	$basedatos = "miconsigna";
	
	//Establecer la conexión con MySQL
	$conexion = mysqli_connect($servidor,$usuario,$pass) or die("Error de conexión");
	
	//Seleccionamos la Base de Datos
	mysqli_select_db($conexion,$basedatos);



function dbGetUserId($mailUser) {
	global $conexion;
	$res = $conexion->query("SELECT id FROM usuario WHERE email='" . $conexion->real_escape_string($mailUser) . "'");
	if($res->num_rows == 0) {
		return null;
	}
	return ($res->fetch_object())->id;
}