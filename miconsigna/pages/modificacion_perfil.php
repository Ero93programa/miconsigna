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

    $user = comprobarUsuario();


if(isset($_POST['modificar'])) {

    $identificacion=$_POST['nombre_nuevo'];
    $nombre_nuevo=trim($_POST['nombre_nuevo']);
    $apellidos_nuevos=trim($_POST['apellidos_nuevos']);
    $fecha_nac_nueva=$_POST['fecha_nac_nueva'];
    $dni=$_POST['dni'];
    $telefono_nuevo=trim($_POST['telefono_nuevo']);
    $descripcion_nueva=trim($_POST['descripcion_nueva']);
    $pass_nueva=$_POST['pass_nueva'];
    $pass_nueva2=$_POST['pass_nueva2'];

    if(isset($_FILES['foto_nueva'])) {
        $name=$_FILES['foto_nueva']['name'];
        $temp=$_FILES['foto_nueva']['tmp_name'];
        $tipos=$_FILES['foto_nueva']['type'];
        $tamano=$_FILES['foto_nueva']['size'];

        //Comprobacion archivo imagen

        $img_correcta=true;

        if($name != "") {
            if(!file_exists("../img_usuarios")) {
                mkdir("../img_usuarios");
            }
            $ruta;
            $tamano_mb=$tamano/(1024*1024);

            if($tipos=="image/png" || $tipos=="image/jpeg" || $tipos=="image/gif") {
                if($tamano_mb<2) {
                    switch ($tipos) {
                        case 'image/png':
                            $ruta="../img_usuarios/$identificacion.png";
                            break;
                        case 'image/jpeg':
                            $ruta="../img_usuarios/$identificacion.png";
                            break;
                        case 'image/gif':
                            $ruta="../img_usuarios/$identificacion.gif";
                            break;
                    }
                    move_uploaded_file($temp, $ruta);
                }
            } else {
                echo "<p style=\"color:#FF0000\">*Error: Tipo de imagen incorrecto</p>";
                //$img_correcta=false;
            }
        } else {
            // $img_correcta=true;
            $ruta = $_POST['foto_recibida'];
        }

    } else {
        //$img_correcta=true;

    }

    $sent_modificacion="update usuario set nombre='$nombre_nuevo', apellidos='$apellidos_nuevos', 
        fecha_nac='$fecha_nac_nueva', telefono='$telefono_nuevo', descripcion='$descripcion_nueva', foto='$ruta' 
        where dni='$dni'";

        if(empty(trim($pass_nueva))||empty(trim($pass_nueva2))){
           $sent_modificacion="update usuario set nombre='$nombre_nuevo', apellidos='$apellidos_nuevos', 
           fecha_nac='$fecha_nac_nueva', telefono='$telefono_nuevo', descripcion='$descripcion_nueva', foto='$ruta' 
           where dni='$dni'"; 
        }else{
           if($pass_nueva===$pass_nueva2){
            $pass_nueva=md5(md5($pass_nueva));
            $sent_modificacion="update usuario set nombre = '$nombre_nuevo', apellidos='$apellidos_nuevos', 
            fecha_nac='$fecha_nac_nueva', pass = '$pass_nueva', telefono = '$telefono_nuevo', descripcion='$descripcion_nueva', foto='$ruta' 
            where dni='$dni'";
           }else{
               $sent_modificacion="update usuario set nombre='$nombre_nuevo', apellidos='$apellidos_nuevos', 
               fecha_nac='$fecha_nac_nueva', telefono='$telefono_nuevo', descripcion='$descripcion_nueva', foto='$ruta' 
               where dni='$dni'"; 
           }
        }
           
        $conexion->query($sent_modificacion);    

        //controlar segun usuario

        if($user=="admin"){
            header("Location:./lista_usuarios.php");            
      
        }else{
            header("Location:./perfil_usuario.php");            
        }

    }
    
?>
