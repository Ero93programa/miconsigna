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

    if(isset($_POST['enviar'])){
        $user=$_POST['user'];
        $pass=$_POST['pass'];

        $pass=md5(md5($pass));


        $acceso = $conexion->prepare("select count(*) from usuario where email = ? and pass = ?");
        $acceso->bind_param('ss', $user, $pass);
        $acceso->bind_result($comprobante_datos_correctos);
        $acceso->execute();
        $acceso->fetch();
        $acceso->close();

        $usuario_correcto=true;
        $usuario_activado=true;
        $usuario_expulsado=false;

        $guardar;

        if(isset($_POST["guardar"])){
            $guardar = true;
        }else{
            $guardar = false;
        }
         
        if($comprobante_datos_correctos==1){

            $comp_activo = $conexion->prepare("select count(*) from usuario where email = ? and activado = 1");
            $comp_activo->bind_param('s', $user);
            $comp_activo->bind_result($comprobante_activo);
            $comp_activo->execute();
            $comp_activo->fetch();
            $comp_activo->close();

            if($comprobante_activo==0){
                $usuario_activado=false;
            }else{
                
                $comp_exp = $conexion->prepare("select count(*) from usuario where email = ? and(estado = 0 or penalizacion = 3)");
                $comp_exp->bind_param('s', $user);
                $comp_exp->bind_result($comprobante_exp);
                $comp_exp->execute();
                $comp_exp->fetch();
                $comp_exp->close();

                if($comprobante_exp==1){
                    $usuario_expulsado=true;
                }else{
                    $usuario_correcto=true;
                    $_SESSION['user'] = $user;
                    
                    $codif_usuario = session_encode();
                    if($guardar==true){
                        $duracion=time()+86400;
                    }else{
                        $duracion=0;
                    }
                    setcookie('sesion',$codif_usuario,$duracion,'/');                    
                }

            }

        }else{
            $usuario_correcto=false;
            
        }
        include "acceder.php";
    }


?>


