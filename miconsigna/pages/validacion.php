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

    if(isset($_POST['validar'])) {

        $id_usuario=$_POST['id_usuario'];

        $validacion_usuario=$conexion->prepare("update usuario set activado = 1 where id = ?");
        $validacion_usuario->bind_param("i", $id_usuario);
        $validacion_usuario->execute();
        $validacion_usuario->close();

        include "lista_nuevos_usuarios.php";
    }

    if(isset($_POST['validar_lugar'])){

        $id_lugar=$_POST['id_lugar'];

        $validacion_lugar=$conexion->prepare("update lugar set estado = 1 where id = ?");
        $validacion_lugar->bind_param("i",$id_lugar);
        $validacion_lugar->execute();
        $validacion_lugar->close();  
    
        include "lista_nuevos_lugares.php";
    }

    if(isset($_POST['validar_reserva'])){

        //---1)Confirmación reserva. Aparecerá ahora listada en histórico reservas

        $id_reserva=$_POST['id_reserva'];

        $validacion_reserva=$conexion->prepare("update reserva set estado = 1 where id = ?");
        $validacion_reserva->bind_param("i",$id_reserva);
        $validacion_reserva->execute();
        $validacion_reserva->close();  

        //---2)Obtener cuantía total de reserva y usuario que reserva 

        $info_res_pago=$conexion->prepare("select espacio.precio_d, reserva.id_usuario reservador, reserva.fecha_ini, reserva.fecha_fin from reserva,espacio 
        where reserva.id_espacio=espacio.id and reserva.id = ?");
        $info_res_pago->bind_param("i",$id_reserva);
        $info_res_pago->bind_result($precio_d,$reservador,$fecha_ini,$fecha_fin);
        $info_res_pago->execute();
        $info_res_pago->fetch();
        $info_res_pago->close();  

        $fecha_ini_o = strtotime($fecha_ini);
        $fecha_fin_o = strtotime($fecha_fin);

        $diferencia=$fecha_fin_o - $fecha_ini_o;
        $total_dias=round($diferencia / (60 * 60 * 24));
        if($total_dias == 0){
            $total_dias= 1;
        } 
        $total_precio=$total_dias*$precio_d;

        //---3)Tras confirmar reserva y obtener información para pago, se añade a tabla pago de la BD

        $hoy=date('Y-m-d');

        $sent_add_pago=$conexion->prepare("insert into pago (id,id_reserva,fecha,cuantia) values (null,?,?,?)");
        $sent_add_pago->bind_param("ssd",$id_reserva,$hoy,$total_precio);
        $sent_add_pago->execute();
        $sent_add_pago->close();  

        //--4)Se obtiene id del pago

        $sent_id_pago=$conexion->prepare("select id from pago where id_reserva = ?");
        $sent_id_pago->bind_param("s",$id_reserva);
        $sent_id_pago->bind_result($id_pago);
        $sent_id_pago->execute();
        $sent_id_pago->fetch();
        $sent_id_pago->close();

        //--5)Se añade id del pago a la reserva correspondiente

        $add_id_pago=$conexion->prepare("update reserva set id_pago = ? where id = ?");
        $add_id_pago->bind_param("ss",$id_pago,$id_reserva);
        $add_id_pago->execute();
        $add_id_pago->close();  

        //--6) Se obtienen datos adicionales de la reserva y se avisa mediante mensaje a usuario que su reserva ha sido aceptada
        
        $datos_adicionales=$conexion->prepare("select usuario.nombre,usuario.apellidos,lugar.direccion,lugar.cp,lugar.ciudad 
        from usuario,lugar,espacio,reserva where reserva.id_espacio = espacio.id and espacio.id_lugar = lugar.id and lugar.id_usuario = usuario.id 
        and reserva.id = ?");
        $datos_adicionales->bind_param("s",$id_reserva);
        $datos_adicionales->bind_result($nombre_propietario,$apellidos_propietario,$direccion,$cp,$ciudad);
        $datos_adicionales->execute();
        $datos_adicionales->fetch();
        $datos_adicionales->close();

        $fecha_inim=formateoFecha($fecha_ini);
        $fecha_finm=formateoFecha($fecha_fin);

        $asunto_aviso="Reserva confirmada";
        $texto_aviso="El propietario $nombre_propietario $apellidos_propietario ha confirmado tu reserva. <br> 
        El espacio elegido se encuentra en $direccion $cp $ciudad. <br> 
        Fecha de inicio: $fecha_inim <br> Fecha final: $fecha_finm <br> Cuantía total: $total_precio €";
        $id_emisor_aviso=0;

        $aviso_usuario=$conexion->prepare("insert into mensaje (id,texto,asunto,fecha,id_emisor,id_receptor) values (null,?,?,?,?,?)");
        $aviso_usuario->bind_param ("sssss",$texto_aviso,$asunto_aviso,$hoy,$id_emisor_aviso,$reservador);
        $aviso_usuario->execute();
        $aviso_usuario->close();

       include "lista_nuevas_reservas.php";
    }
?>