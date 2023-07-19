<?php

    // $identificacion
    $cual_es_id=$conexion->prepare("select id from usuario where email = ?");
    $cual_es_id->bind_param("s", $user);
    $cual_es_id->bind_result($id_usuario);
    $cual_es_id->execute();
    $cual_es_id->fetch();
    $cual_es_id->close();

    //Comprobar si hay reservas efectuadas

    $sent_sacar_servicios="select reserva.id from reserva,pago where reserva.id_pago=pago.id and 
    reserva.id_usuario = $id_usuario and pago.estado = 1 and reserva.estado = 1";
    $consulta_sacar_servicios=$conexion->query($sent_sacar_servicios);
    $numero_filas=$consulta_sacar_servicios->num_rows;

    if ($numero_filas>=1) {
       
?>

        <section class="mt-4 col-md-7 m-auto">
            <h2 class='text-center pt-5'>Mis <u class="underline">servicios contra</u>tados</h2>
            <div class='container my-5 py-2 text-dark'>
                <div class='row d-flex justify-content-center'>
                <div class='col-12'>
                    <ul class="nav nav-tabs nav-fill w-100 m-0" id="myTab" role="tablist" style="background-color: #bdd3f9;">
                        <li class="nav-item w-50" role="presentation">
                            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Servicios actuales</button>
                        </li>
                        <li class="nav-item w-50" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Servicios previos</button>
                        </li>
                    </ul>

                <div class="tab-content m-auto bg-white" id="myTabContent">
                    <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                        <?php

                        //indicar que fechas son anteriores

                        $numeracion_primera=0;
                        $f_hoy = date('Y.m.d');

                        $servicios_actuales=$conexion->prepare("select reserva.id,lugar.direccion,lugar.cp,lugar.ciudad, reserva.fecha_ini,reserva.fecha_fin,
                        pago.cuantia from reserva,pago,espacio,lugar where reserva.id_pago=pago.id and reserva.id_espacio = espacio.id and espacio.id_lugar = lugar.id 
                        and reserva.id_usuario = ? and pago.estado = 1 and reserva.estado = 1 and reserva.fecha_fin >='$f_hoy' order by fecha_fin desc limit 15");
                        $servicios_actuales->bind_param("s", $id_usuario);
                        $servicios_actuales->bind_result($id_reserva, $dire_re, $cp_re, $ciudad_re, $fecha_ini, $fecha_fin, $cuantia);
                        $servicios_actuales->execute();
                        $servicios_actuales->store_result();
                        if($servicios_actuales->num_rows==0){
                            echo "<div class=\"pt-4\"><ul>
                                <li class=\"list-unstyled text-center\">No hay ningún servicio contratado actualmente</li>
                            </ul></div>";
                        }

                        echo "<div class=\"p-4\"><ul>";
                        
                        while($servicios_actuales->fetch()) {
                            $numeracion_primera++;
                            $fecha_ini_lista=formateoFecha($fecha_ini);
                            $fecha_fin_lista=formateoFecha($fecha_fin);
                            echo "<li class=\"list-unstyled text-center\"> $numeracion_primera | <b>$dire_re $cp_re $ciudad_re</b>  <br> $fecha_ini_lista / $fecha_fin_lista <b>$cuantia €</b></li>";
                            if($numeracion_primera==15) {
                                echo "[...]";
                            }
                        }
                        $servicios_actuales->close();

                        echo "</ul></div>";

                        ?>
                </div>

            <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                <?php

                    //indicar que fechas son posteriores

                    $numeracion_segunda=0;

                        $servicios_previos=$conexion->prepare("select reserva.id,lugar.direccion,lugar.cp,lugar.ciudad, reserva.fecha_ini,reserva.fecha_fin,
                        pago.cuantia from reserva,pago,espacio,lugar where reserva.id_pago=pago.id and reserva.id_espacio = espacio.id and espacio.id_lugar = lugar.id 
                        and reserva.id_usuario = ? and pago.estado = 1 and reserva.estado = 1 and reserva.fecha_fin <'$f_hoy' order by fecha_fin desc limit 15");
                        $servicios_previos->bind_param("s", $id_usuario);
                        $servicios_previos->bind_result($id_reserva, $dire_re, $cp_re, $ciudad_re, $fecha_ini, $fecha_fin, $cuantia);
                        $servicios_previos->execute();
                        $servicios_previos->store_result();
                        if($servicios_previos->num_rows==0){
                            echo "<div class=\"pt-4\"><ul>
                                <li class=\"list-unstyled text-center\">No hay ningún servicio contratado</li>
                            </ul></div>";
                        }

                        echo "<div class=\"p-4\"><ul>";
                        while($servicios_previos->fetch()) {
                            $numeracion_segunda++;
                            $fecha_ini_lista=formateoFecha($fecha_ini);
                            $fecha_fin_lista=formateoFecha($fecha_fin);
                            echo "<li class=\"list-unstyled text-center\"> $numeracion_segunda | <b>$dire_re $cp_re $ciudad_re</b> <br> $fecha_ini_lista / $fecha_fin_lista <b>$cuantia €</b></li>";
                            if($numeracion_segunda==15) {
                                echo "[...]";
                            }
                        }
    $servicios_previos->close();

    echo "</ul></div>";
    ?>
     
            </div>
            </div>
        </div>
    </div>
</section>

<?php
    }

?>