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

    //ELIMINACION USUARIOS (se desactiva)

    if(isset($_POST['eliminar_usuario'])){

        $id_usuario=$_POST['id_usuario'];

        $eliminacion_usuario=$conexion->prepare("delete from usuario where id = ?");
        $eliminacion_usuario->bind_param("i",$id_usuario);
        $eliminacion_usuario->execute();
        $eliminacion_usuario->close();  
 
        include "lista_nuevos_usuarios.php";
    }

    //ELIMINACION LUGARES//--------------

    //Eliminar lugar en lista nuevos lugares

    if(isset($_POST['eliminar_lugar'])){

        $id_lugar=$_POST['id_lugar'];

        $eliminacion_lugar=$conexion->prepare("delete from lugar where id = ?");
        $eliminacion_lugar->bind_param("i",$id_lugar);
        $eliminacion_lugar->execute();
        $eliminacion_lugar->close();  

        include "lista_nuevos_lugares.php";
    }

    //Eliminar lugar posteriormente (se desactiva)

    if(isset($_POST['eliminar_lugar_d'])){

        $id_lugar=$_POST['id_lugar'];

        $eliminacion_lugar_esp=$conexion->prepare("update espacio set estado = 0, texto = '[No disponible]' where id_lugar = ?");
        $eliminacion_lugar_esp->bind_param("i",$id_lugar);
        $eliminacion_lugar_esp->execute();
        $eliminacion_lugar_esp->close(); 

        $eliminacion_lugar=$conexion->prepare("update lugar set  direccion = '', cp='', ciudad = '', texto = 'Deshabilitado', 
        estado = 0, foto ='../img_lugares/prede_lugar.png' where id = ?");
        $eliminacion_lugar->bind_param("i",$id_lugar);
        $eliminacion_lugar->execute();
        $eliminacion_lugar->close();  

        include "lista_lugares.php";
    }


    //ELIMINACION ESPACIOS//----------------

    if(isset($_POST['eliminar_espacio'])||isset($_POST['eliminar_espacio_a'])){

        $id_espacio=$_POST['id_espacio'];

        $eliminacion_espacio=$conexion->prepare("update espacio set estado = 0, texto = '[No disponible]' where id = ?");
        $eliminacion_espacio->bind_param("i",$id_espacio);
        $eliminacion_espacio->execute();
        $eliminacion_espacio->close();  

        if(isset($_POST['eliminar_espacio'])){
            include "misespacios.php";
        }else{
            include "lista_lugares.php";
        }
    }


    //ELIMINACION INFORMES

    if(isset($_POST['eliminacion_informe'])){

        $id_informe=$_POST['id_informe'];

        $eliminacion_informe=$conexion->prepare("delete from informe where id = ?");
        $eliminacion_informe->bind_param("i",$id_informe);
        $eliminacion_informe->execute();
        $eliminacion_informe->close();  
 
        include "informes.php";
    }

    //ELIMINACION MENSAJES

        if(isset($_POST['eliminacion_mensaje'])){

            $id_mensaje=$_POST['id_mensaje'];
    
            $eliminacion_informe=$conexion->prepare("delete from mensaje where id = ?");
            $eliminacion_informe->bind_param("i",$id_mensaje);
            $eliminacion_informe->execute();
            $eliminacion_informe->close();  
     
            include "mensajes.php";
        }

    //ELIMINACION RESERVAS QUE ENTRAN


    if(isset($_POST['eliminar_reserva'])){

        $id_reserva=$_POST['id_reserva'];
        $eliminacion_reserva=$conexion->prepare("delete from reserva where id = ?");
        $eliminacion_reserva->bind_param("i",$id_reserva);
        $eliminacion_reserva->execute();
        $eliminacion_reserva->close();  
 
        include "lista_nuevas_reservas.php";
    }
    
?>