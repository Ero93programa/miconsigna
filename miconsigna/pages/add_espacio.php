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



    if(isset($_POST['add_espacio'])){
    
            $id_lugar=$_POST['lugar_espacio'];
            
            $texto_espacio=$_POST['texto_espacio'];
            $texto_espacio=trim($texto_espacio);
            
            $precio_espacio=$_POST['precio_espacio'];

            $f_nac=$_POST['fecha_hoy'];

  
            if(empty($texto_espacio)||empty($precio_espacio)){
                $campos_vacios_esp=true;
                
            }else{ 
                $sent_add_espacio=$conexion->prepare("insert into espacio (id,texto,fecha_ad,precio_d,id_lugar) values (null,?,?,?,?)");
                $sent_add_espacio->bind_param("ssdi",$texto_espacio,$f_nac,$precio_espacio,$id_lugar);
                $sent_add_espacio->execute();
                $sent_add_espacio->close();
            }

            include "misespacios.php";

    }
    

?>