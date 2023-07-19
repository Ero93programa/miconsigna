<?php
if(!isset($_SESSION)) {
    session_start();
}     
    if(isset($_POST['logout'])){
        session_destroy();
        echo "<meta http-equiv='refresh' content='0' url='#'>";
    }

    require_once "../functions.php";
    require_once "../conexion.php";
    $user = comprobarUsuario();

    //Comprobamos el origen del envío, si de perfil, o de sección mensajería
    if(isset($_POST['add_mensaje_p']) || isset($_POST['add_mensaje_m'])) {   

        $sent_mi_id=$conexion->prepare("select id from usuario where email = ?");
        $sent_mi_id->bind_param("s", $user);
        $sent_mi_id->bind_result($mi_id);
        $sent_mi_id->execute();
        $sent_mi_id->fetch();
        $sent_mi_id->close();

        $id_receptor=$_POST['identificacion'];
        $asunto=$_POST['asunto'];
        $asunto=trim($asunto);
        $mensaje=$_POST['mensaje'];
        $mensaje=trim($mensaje);
        $fecha=$_POST['fecha_hoy'];   
        
        //Si contenido de mensaje y asunto no están vacíos, se añade el mensaje enviado a la BD
        if(!empty($mensaje)&&!empty($asunto)){
            $sent_add_espacio=$conexion->prepare("insert into mensaje (id,texto,asunto,fecha,id_emisor,id_receptor) values (null,?,?,?,?,?)");
            $sent_add_espacio->bind_param("sssss",$mensaje,$asunto,$fecha,$mi_id,$id_receptor);
            $sent_add_espacio->execute();
            $sent_add_espacio->close();
        }

        //Redirige dependiendo si es desde mensajes o desde perfil
        
        if(isset($_POST['add_mensaje_p'])){
            header("location:../index.php");
        }

        if(isset($_POST['add_mensaje_m'])){
            header("location:mensajes.php");
        }
        
    }
    

?>