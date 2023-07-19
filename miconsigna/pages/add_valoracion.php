<?php
    if (!isset($_SESSION)) {
        session_start();
    }

    if (isset($_POST['logout'])) {
        session_destroy();
        echo "<meta http-equiv='refresh' content='0' url='#'>";
    }

    require_once "../functions.php";
    require_once "../conexion.php";


    if (isset($_POST['comentar']) || isset($_POST['descartar_comentario'])) {

    
        $id_reserva=$_POST['id_reserva'];

        //-----ACTUALIZAR CAMPO DE RESERVA COMO COMENTADO Y AÑADIR COMENTARIO

        if(isset($_POST['comentar'])) {
            $identificacion=$_POST['identificacion'];

            echo "El valor de la reserva es $id_reserva";

            $fecha_hoy=$_POST['fecha_hoy'];
            $nota_valoracion=$_POST['nota_valoracion'];
            $texto_valoracion=$_POST['texto_valoracion'];

            $sent_add_comentario= $conexion->prepare("insert into valoracion (id,texto,fecha,puntuacion,id_usuario,id_reserva) values (null,?,?,?,?,?)");
            $sent_add_comentario->bind_param("ssiss",$texto_valoracion, $fecha_hoy, $nota_valoracion, $identificacion, $id_reserva);
            $sent_add_comentario->execute();
            $sent_add_comentario->close();
        }

        //-----ACTUALIZAR CAMPO SIN COMENTAR (DESCARTAR COMENTARIO)

            $act_campo_comentario=$conexion->prepare("update reserva set comentado = 1 where id = ?");
            $act_campo_comentario->bind_param("s", $id_reserva);
            $act_campo_comentario->execute();
            $act_campo_comentario->close();

        //---------

        header("location:comentarios_pendientes.php");

    }

?>