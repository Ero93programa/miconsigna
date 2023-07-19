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

    if(isset($_POST['registrarse'])){
    
            $nombre=$_POST['nombre'];
            $nombre=trim($nombre);

            $apellidos=$_POST['apellidos'];
            $apellidos=trim($apellidos);

            $pass=$_POST['pass'];
            $pass=trim($pass);
            $pass=md5(md5($pass));

            $pass2=$_POST['pass2'];
            $pass2=trim($pass2);
            $pass2=md5(md5($pass2));

            $correo=$_POST['correo'];
            $correo=trim($correo);

            $telefono=$_POST['telefono'];
            $telefono=trim($telefono);

            $f_nac=$_POST['f_nac'];
            //Edad
            $hoy = new DateTime();
            $fechaNac = new DateTime($f_nac);
            $edad = $fechaNac->diff($hoy)->y;

            $dni=$_POST['dni'];
            $dni=trim($dni);    

            $menor=false;
            $campos_vacios=false;
            $repetido=false;
            $contraseña_diferente=false;
            $terminado=false;

            if($edad<18||(empty(trim($nombre))||empty(trim($apellidos))||empty(trim($pass))||
            empty(trim($correo))||empty(trim($telefono))||empty($f_nac)||empty(trim($dni)))){
                if($edad<18){
                    $menor=true;
                }
                if(empty(trim($nombre))||empty(trim($apellidos))||empty(trim($pass))||
                empty(trim($correo))||empty(trim($telefono))||empty($f_nac)||empty(trim($dni))){
                    $campos_vacios=true;
                }
                
            }else{
                // Mirar si hay usuarios con el mismo mail o dni
                $registro = $conexion->prepare("select count(*) from usuario where email = ? or dni = ?");
                $registro->bind_param('ss', $correo, $dni);
                $registro->bind_result($comprobante_registro_correcto);
                $registro->execute();
                $registro->fetch();
                $registro->close();

                if($comprobante_registro_correcto>0){
                    $repetido=true;
                }else{
                    if($pass!=$pass2){
                        $contraseña_diferente=true;
                    }else{
                        //Insertar nuevo usuario
                        $registro2= $conexion->prepare("insert into usuario (id,dni,nombre,apellidos,email,telefono,fecha_nac,pass,estado,activado,penalizacion) values (null,?,?,?,?,?,?,?,1,0,0)");
                        $registro2->bind_param('sssssss',$dni,$nombre,$apellidos,$correo,$telefono,$f_nac,$pass);
                        $registro2->execute();
                        $registro2->close();

                        $terminado=true;                        
                    }
                }
            }

            include "registro.php";
    }


    
    // if(empty(trim($nombre))||empty(trim($apellidos))||empty(trim($pass))||
    // empty(trim($correo))||empty(trim($telefono))||empty($f_nac)||empty(trim($dni))){
    //     $campos_vacios=true;
        
    // }else{
    //     $registro = $conexion->prepare("select count(*) from usuario where email = ? or dni = ?");
    //     $registro->bind_param('ss', $correo, $dni);
    //     $registro->bind_result($comprobante_registro_correcto);
    //     $registro->execute();
    //     $registro->fetch();
    //     $registro->close();

    //     if($comprobante_registro_correcto>0){
    //         $repetido=true;
    //     }else{}
    // }

    // include "registro.php";
    

?>


