<?php
header("Content-Type: application/json");
function jsonResponse($code, $message, $others = array()) {
    return json_encode([
        'status' => $code,
        'message' => $message,
        'data' => $others
    ]);
}


if(!isset($_POST['id'])) {
    die(jsonResponse(-1, "Error remaining data"));
}

$id_informe = $_POST['id'];


require_once "../../conexion.php";

$query = "update informe set leido = 1 where id = $id_informe";
$actualizar_leido=$conexion->query($query);

//Comprobarcion de errores
$nRows = $conexion->affected_rows;

echo jsonResponse(1, "Actualizado no leido", ['nRows' => $nRows]);