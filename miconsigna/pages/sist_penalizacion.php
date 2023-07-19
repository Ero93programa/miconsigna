<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 

    if(isset($_POST['logout'])){
        session_destroy();
        echo "<meta http-equiv='refresh' content='0' url='#'>";
    }

    require_once "../functions.php";
    require_once "../conexion.php";

    if(isset($_POST['liberar'])){

        $id_usuario=$_POST['id_usuario'];

        $liberacion=$conexion->prepare("update usuario set estado = 1 where id = ?");
        $liberacion->bind_param("i",$id_usuario);
        $liberacion->execute();
        $liberacion->close();  
 
    }

    if(isset($_POST['penalizar'])){

        $id_usuario=$_POST['id_usuario'];
        $estado_usuario=$_POST['estado_usuario'];

        $penalizacion=$conexion->prepare("update usuario set estado = 0 where id = ?");
        $penalizacion->bind_param("i",$id_usuario);
        $penalizacion->execute();
        $penalizacion->close();  

        $suma_penalizacion=$conexion->prepare("update usuario set penalizacion = penalizacion + 1 where id = ?");
        $suma_penalizacion->bind_param("i",$id_usuario);
        $suma_penalizacion->execute();
        $suma_penalizacion->close(); 
    }
        include "lista_usuarios.php";

?>