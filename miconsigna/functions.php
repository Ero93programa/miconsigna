<?php

    /*--FORMATEAR LA FECHA--*/

    function formateoFecha($fecha){
        $marcatiempo = strtotime($fecha);
        $fecha_arreglada = date('d-m-Y', $marcatiempo);
        return $fecha_arreglada;
    }

    /*----*/

    function comprobarUsuario(){
        if(isset($_COOKIE['sesion'])){
            session_decode($_COOKIE['sesion']);
            $user = $_SESSION['user'];
        }elseif(isset($_SESSION['user'])){
            $user = $_SESSION['user'];
        }else{
            $user = "";
        }
        
        return $user;
    }


    //Pasar a UTF
	function codificacion_utf($conexion){
		return $conexion->set_charset("utf8");
	}  

?>