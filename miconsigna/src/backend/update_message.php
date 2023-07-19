<?php
require_once __DIR__ . "/ajax_helpers.php";
header("Content-Type: application/json");



if(!isset($_POST['id'])) {
    die(jsonResponse(-1, "Error remaining data"));
}


$id_mensaje = $_POST['id'];


require_once "../../conexion.php";

$query = "update mensaje set leido = 1 where id = $id_mensaje";
$actualizar_leido=$conexion->query($query);

//Comprobarcion de errores
$nRows = $conexion->affected_rows;

echo jsonResponse(1, "Actualizado no leido", ['nRows' => $nRows]);