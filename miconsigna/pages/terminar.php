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



    if(isset($_POST['terminar'])){
        $id_usuario=$_POST['id_propio'];
        $id_espacio=$_POST['id_espacio'];
        $precio_dia=$_POST['precio_dia'];
        $fecha_1=$_POST['fecha_1'];
        $fecha_2=$_POST['fecha_2'];

        $fecha_1 = $_POST['fecha_1'];
        $fecha_2 = $_POST['fecha_2'];

        $fecha_1_objeto = new DateTime($fecha_1);
        $fecha_2_objeto = new DateTime($fecha_2);
        $intervalo = $fecha_1_objeto->diff($fecha_2_objeto);
        $total_dias = $intervalo->days;
        $total_dias = (int) $total_dias;

        //-------
        if($total_dias == 0){
            $total_dias= 1;
        } 
        $total_precio=$precio_dia*$total_dias;
        //------
    

        //-----AÑADIR RESERVA

        $fecha_1_str = $fecha_1_objeto->format('Y-m-d');
        $fecha_2_str = $fecha_2_objeto->format('Y-m-d');

        $sent_add_reserva=$conexion->prepare("insert into reserva (id,id_espacio,fecha_ini,fecha_fin,id_usuario) values (null,?,?,?,?)");
        $sent_add_reserva->bind_param("ssss",$id_espacio,$fecha_1_str,$fecha_2_str,$id_usuario);
        $sent_add_reserva->execute();
        $sent_add_reserva->close();

        //--- Obtener datos de solicitante y propietario, y avisar propietario sobre solicitud reserva 

        $datos_adicionales_usu=$conexion->prepare("select usuario.nombre,usuario.apellidos from usuario where id = ?");
        $datos_adicionales_usu->bind_param("s",$id_usuario);
        $datos_adicionales_usu->bind_result($nombre_usuario,$apellidos_usuario);
        $datos_adicionales_usu->execute();
        $datos_adicionales_usu->fetch();
        $datos_adicionales_usu->close();

        $datos_adicionales_usu2=$conexion->prepare("select usuario.id,lugar.direccion,lugar.cp,lugar.ciudad 
        from usuario,lugar,espacio where espacio.id_lugar=lugar.id and lugar.id_usuario = usuario.id and espacio.id = ?");
        $datos_adicionales_usu2->bind_param("s",$id_espacio);
        $datos_adicionales_usu2->bind_result($id_propietario,$direccion,$cp,$ciudad);
        $datos_adicionales_usu2->execute();
        $datos_adicionales_usu2->fetch();
        $datos_adicionales_usu2->close();

        $asunto_aviso="Solicitud de reserva";
        $texto_aviso="El usuario $nombre_usuario $apellidos_usuario desea hacer una reserva. <br> 
        El espacio elegido se encuentra en $direccion $cp $ciudad. <br> 
        Fecha de inicio: $fecha_1_str <br> Fecha final: $fecha_2_str <br> Cuantía total: $total_precio €";
        $id_emisor_aviso=0;


        $hoy = date('Y-m-d');
        $aviso_propietario=$conexion->prepare("insert into mensaje (id,texto,asunto,fecha,id_emisor,id_receptor) values (null,?,?,?,?,?)");
        $aviso_propietario->bind_param ("sssss",$texto_aviso,$asunto_aviso,$hoy,$id_emisor_aviso,$id_propietario);
        $aviso_propietario->execute();
        $aviso_propietario->close();

        //--
        
      header("location:perfil_usuario.php");

    }
    

?>