<?php
    session_start();

    if (isset($_POST['logout'])) {
        setcookie('sesion', "", time()-3600, '/');
    }

    if (isset($_POST['logout'])) {
        session_destroy();
        echo "<meta http-equiv='refresh' content='0' url=../index.php'>";
    }

    require_once "../functions.php";
    require_once "../conexion.php";
    require_once "header.php";

    codificacion_utf($conexion);

    $user = comprobarUsuario();

    if($user==""){
        echo "<script>window.location.href='../index.php'</script>";
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="../img/favicon.ico">
    <title>Valoraciones pendientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js" integrity="sha256-xLD7nhI62fcsEZK2/v8LsBcb4lG7dgULkuXoXB/j91c=" crossorigin="anonymous"></script>
    <!-- Datatables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <!-- CDN font-awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <!-- Styles -->
    <link rel="stylesheet" href="../styles/styles.css"> 
    <!-- Fuente Google encabezados -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@600&display=swap" rel="stylesheet">
    <!-- Fuente Google resto de contenido -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
    <!-- Script -->
    <script>
       $(document).ready(function() {
            $('#myTable').DataTable({
                responsive: true,
                language: {
                url: "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                },
            });

            //Cerrar modal
            $('.close').click(function() {
                $('#modal_comentario').modal('hide');    
            });  

            //Mover datos de cada fila al modal
            $(document).on('click','.comentadores',function() {
                // Obtener el valor del input dentro del botón
                var idReserva = $(this).find('input[name="id_reserva"]').val();
                console.log(idReserva);
                // Actualizar el valor del input en el div "modal-footer"
                $('#modal_comentario #espacio_id_reserva').val(idReserva);
                //Sacar modal 
                $('#modal_comentario').modal('show');
            });
        });
    </script>
</head>
<body>
    <header>
        <?php    
        sacarNav($user,"");
        ?>      
    </header>
    <main class="main_valoraciones" style="min-height: 75vh">
        <section>
        <div class="section-header" style="padding:2rem;">
          <h2>VALORACIONES PENDIENTES</h2>
        </div>

        <div class="container py-3 rounded shadow" style="background-color: aliceblue;">
        <div class="row mt-5">
            <div class="col-md-12">

        <?php

        // $identificacion

        $cual_es_id=$conexion->prepare("select id from usuario where email = ?");
        $cual_es_id->bind_param("s", $user);
        $cual_es_id->bind_result($id_usuario_reservante);
        $cual_es_id->execute();
        $cual_es_id->fetch();
        $cual_es_id->close();

        $hoy = new DateTime();
        $hoy = $hoy->format('Y-m-d');

        $sent_val_pend="select reserva.id id_reserva, reserva.fecha_ini, reserva.fecha_fin, pago.cuantia
        from reserva,pago where reserva.id_pago=pago.id and reserva.id_usuario = '$id_usuario_reservante'
        and reserva.estado = 1 and pago.estado = 1 and reserva.comentado = 0 and reserva.fecha_fin < $hoy";
             
        echo "<table id='myTable' class='table table-striped display responsive nowrap tabla_usuarios' style='width:100%'>
            <thead>
                <tr>
                    <th>Propietario</th>
                    <th>Lugar/Espacio</th> 
                    <th>Inicio</th> 
                    <th>Fin</th>
                    <th>Total</th>
                    <th>Comentar</th> 
                </tr>            
            </thead><tbody>";    

        $consulta_val_pend=$conexion->query($sent_val_pend);

        //Si no hay comentarios pendientes, vuelta al perfil
        if ($consulta_val_pend->num_rows == 0) {
            echo "<script>window.location.href='perfil_usuario.php'</script>";
        }

        while($fila_val_pend=$consulta_val_pend->fetch_array(MYSQLI_ASSOC)){

            $id_reserva = $fila_val_pend['id_reserva'];
            
            $fecha_ini = formateoFecha($fila_val_pend['fecha_ini']); //
            $fecha_fin = formateoFecha($fila_val_pend['fecha_fin']); //

            $fecha_ini_o = strtotime($fila_val_pend['fecha_ini']); //
            $fecha_fin_o = strtotime($fila_val_pend['fecha_fin']); //

            //---------------------------

            //Sacar lugar y datos de propietario aquí

            $sent_val_pend2=$conexion->prepare("select usuario.id id_propietario, usuario.nombre, usuario.apellidos,lugar.direccion, lugar.cp, lugar.ciudad, espacio.texto 
            from reserva,espacio,lugar,usuario where reserva.id_espacio=espacio.id and espacio.id_lugar = lugar.id 
            and lugar.id_usuario = usuario.id and reserva.id = ?");

            $sent_val_pend2->bind_param("s",$id_reserva);
            $sent_val_pend2->bind_result($id_propietario,$nombre_usu,$apellidos_usu, $direccion, $cod_post, $ciudad,$texto_espacio);
            $sent_val_pend2->execute();
            
            while($sent_val_pend2->fetch()){
                echo "<tr><td><form method='post' action='perfil_usuario.php'>
                        <input type='text' value='$id_propietario' name='id_usuario' hidden> 
                        <input type='text' value='' name='correo_prop' hidden>                         
                        <button type='submit' class='btn btn-link text-decoration-none' name='ver'/>
                            $nombre_usu $apellidos_usu
                        </button> 
                    </form>
                </td>
                <td>
                    $direccion
                    $cod_post
                    $ciudad<br>
                    $texto_espacio
                </td>
                <td>$fecha_ini</td>
                <td>$fecha_fin</td> 
                <td>$fila_val_pend[cuantia] €</td>
                <td>
                    <button class='comentadores btn btn-link btn-comentador'/>
                        <input type='text' value='$id_reserva' name='id_reserva' hidden>
                        <i class=\"fa-solid fa-pen text-success\"></i>
                    </button>                            
                
                    <form action='add_valoracion.php' method='post'>
                        <input type='text' value='$id_reserva' name='id_reserva' hidden>
                        <button type='submit' class='eliminadores btn btn-link' name='descartar_comentario'/>
                            <i class=\"fa-solid fa-xmark fa-lg text-danger \"></i>
                        </button>
                    </form>
                </td>
                </tr>";
            }        
            }
            echo"</tbody></table>";
                ?>
        </div>
            </div>
        </div>
        </section>

    </main>
    <?php
        require_once "footer.php";
    ?>

    <!-- ------------------------------------------------------------------------------- -->

    <!-- Modal AÑADIR COMENTARIO - -->

    <div id="modal_comentario" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <!--    Para centrado-->
    <div class="modal-dialog modal-dialog-centered" role="document">  

    <!--  <div class="modal-dialog" role="document">-->
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Deja tu valoración:</h5>
            <button type="button" class="close btn-close" data-dismiss="modal" aria-label="Close">
            </button>
        </div>
        <form action="add_valoracion.php" method='post'>
            <div class="modal-body">
                <div class="form-group">
                    <label for="nota_valoracion">Nota:</label>
                    <select name="nota_valoracion">
                        <option value='5'>5</option>
                        <option value='4'>4</option>
                        <option value='3'>3</option>
                        <option value='2'>2</option>
                        <option value='1'>1</option>
                        <option value='0'>0</option>
                    </select>
                </div>  
                <br>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Contenido valoración:</label>
                    <textarea class="form-control rounded-0 mt-2" name='texto_valoracion' id="exampleFormControlMensaje" rows="10" required></textarea>
                </div>
        <div class="modal-footer">
            <input type='text' name='identificacion' hidden value=<?php echo $id_usuario_reservante ?>>
            <input type='text' id='espacio_id_reserva' name='id_reserva'  value="<?php ?>" hidden>

            <?php $fecha_hoy=date('Y-m-d') ?>
            <input type='date' name='fecha_hoy' hidden value=<?php echo $fecha_hoy ?>>

            <button type="button" class="btn btn-secondary close" data-dismiss="modal">Cancelar</button>
            <button type="submit" name='comentar' class="btn btn-success">Enviar</button>
        </div>
        </form> 
        </div>
    </div>
    </div>

    <!-- ------------------------------------------------------------------------------- -->

    <script>
        const eliminadores=document.querySelectorAll(".eliminadores");

        eliminadores.forEach(eliminador=>{
            eliminador.addEventListener("click", (evento)=>{
                if(!confirm("Vas a descartar este comentario, ¿Estás seguro?")){
                evento.preventDefault();
            }     
            })
        })
    </script>

</body>
</html>