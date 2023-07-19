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

    $soyVisitante = (isset($_POST['id_usuario']) && is_numeric($_POST['id_usuario']));
    if($soyVisitante) {
        $idUsuarioQueVisito = $_POST['id_usuario'];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="../img/favicon.ico">
    <title>PERFIL DE USUARIO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js" integrity="sha256-xLD7nhI62fcsEZK2/v8LsBcb4lG7dgULkuXoXB/j91c=" crossorigin="anonymous"></script>
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
    <!-- AOS  -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <!-- Script -->
    <script>
        $(document).ready(function(){     
            $("#btn_denunciar").click(function(){
                $('#modal_denuncia').modal('show');
            });

            $("#btn_modificar").click(function(){
                $('#modal_modificacion').modal('show');
            });

            $("#btn_add_lugar").click(function(){
                $('#modal_add_lugar').modal('show');
            });

            $("#btn_add_mensaje").click(function(){
                $('#modal_add_mensaje').modal('show');
            });

            $("#btn_add_espacio").click(function(){
                $('#modal_add_espacio').modal('show');
            });

            $('.close2').click(function() {
                $('#modal_denuncia').modal('hide');
                $('#modal_modificacion').modal('hide');
                $('#modal_add_lugar').modal('hide');
                $('#modal_add_mensaje').modal('hide');
                $('#modal_add_espacio').modal('hide');
            });
           
            loadComments(1);
            
        });
        <?php if($soyVisitante):?>
        function loadComments(page) {
            $.get('../src/backend/generador_comentarios.php', {page: page, idUsuario: <?=$idUsuarioQueVisito?>})
            .done(function(res) {
                $('#content-comments').html(res);
            });
        }
        <?php else:?>
        function loadComments(page) {
            $.get('../src/backend/generador_comentarios.php', {page: page})
            .done(function(res) {
                $('#content-comments').html(res);
            });
        }
        <?php endif;?>
    </script>
</head>
<body class='body_perfil_usuario'>
    <header>
    <?php    
      sacarNav($user,"");
    ?>          
    </header>
    <main class="main_perfil_usuario" class="pb-3">
    <section>
        <?php
            if((isset($user) && $user=='') || ($user=="admin" && !isset($_POST['ver']))){
                echo "<script>window.location.href='../index.php'</script>";
            }else{
                if((isset($user) && $user!='admin')||(isset($_POST['ver']))){
                /*-Visto por el usuario-*/
                if (isset($user) && $user!='admin') {
                    $sent_info_usuario="select usuario.id identificacion,usuario.nombre nombre,usuario.apellidos apellidos, usuario.email email,
                    usuario.fecha_nac fecha_nac, usuario.pass, usuario.telefono telefono, usuario.dni dni, usuario.foto foto, usuario.descripcion, usuario.penalizacion 
                    from usuario where usuario.email='$user'";
                    $consulta_info_usuario=$conexion->query($sent_info_usuario);

                    $sent_val_usuario="select avg(puntuacion) media_valoracion from valoracion,reserva,lugar,espacio,usuario
                    where valoracion.id_reserva=reserva.id and reserva.id_espacio=espacio.id and 
                    espacio.id_lugar=lugar.id and lugar.id_usuario=usuario.id and usuario.email='$user'";
                }

                /*-Visto por administrador u otro usuario-*/
                if (isset($_POST['ver'])) {
                    $id_usuario=$_POST['id_usuario'];
                    if(isset($correo_prop)){
                        $correo_prop=$_POST['correo_prop'];
                    }

                    $sent_info_usuario="select usuario.id identificacion,usuario.nombre nombre,usuario.apellidos apellidos, usuario.email email, 
                    usuario.fecha_nac fecha_nac, usuario.pass, usuario.telefono telefono, usuario.dni dni, usuario.foto foto, usuario.descripcion, usuario.penalizacion
                    from usuario where usuario.id='$id_usuario'";
                    $consulta_info_usuario=$conexion->query($sent_info_usuario);

                    $sent_val_usuario="select avg(puntuacion) media_valoracion from valoracion,reserva,lugar,espacio,usuario
                    where valoracion.id_reserva=reserva.id and reserva.id_espacio=espacio.id and 
                    espacio.id_lugar=lugar.id and lugar.id_usuario=usuario.id and usuario.id='$id_usuario'";
                }

                $consulta_val_usuario=$conexion->query($sent_val_usuario);

                while ($fila_info_usuario=$consulta_info_usuario->fetch_array(MYSQLI_ASSOC)) {
                    while ($fila_val_usuario=$consulta_val_usuario->fetch_array(MYSQLI_ASSOC)) {
                        $media_val=$fila_val_usuario['media_valoracion'];
                        $media_val = sprintf("%.2f", $media_val);

                        $identificacion=$fila_info_usuario['identificacion'];

                        $nombre=$fila_info_usuario['nombre'];
                        $apellidos=$fila_info_usuario['apellidos'];
                        $email=$fila_info_usuario['email'];
                        $fecha_nac=$fila_info_usuario['fecha_nac'];
                        $pass_recibido=$fila_info_usuario['pass'];

                        $telefono=$fila_info_usuario['telefono'];
                        $penalizacion=$fila_info_usuario['penalizacion'];

                        $dni=$fila_info_usuario['dni'];
                        $descripcion=$fila_info_usuario['descripcion'];
                        $foto=$fila_info_usuario['foto'];

                        echo "<div data-aos=\"fade-up\" class='container'>
    <div class='row justify-content-center'>
        <div class='col-md-7 col-lg-4 mb-5 mb-lg-0'>
            <div class='card border-0 shadow'>
                <img src='$foto' alt='...'>
                <div class='card-body p-1-9 p-xl-5'>
                    <div class='mb-4'>
                        <h3 class='h4 mb-0'>$nombre $apellidos</h3>
                        <span class='text-primary'>Usuario</span>
                    </div>
                    <ul class='list-unstyled p-4 mb-4 lista_caracteristicas'>
                        <p class='display-25 me-3 text-secondary'>";
                         $fecha_nac2 = new DateTime($fecha_nac); 
                            $hoy = new Datetime(date('y.m.d'));
                            $diff = $hoy->diff($fecha_nac2);
                            echo "<li><p><b>Edad:</b> $diff->y</p></li>";
                           
                            if ($media_val==0 ) {
                                echo "<li><b>No hay aún valoraciones</b></p></li>";
                            } else {
                                if($media_val>=0 && $media_val<1){
                                    echo "<li><b>Valoración: </b><u style='color:red'><b class='h5' style='color:red'>$media_val</b></u></li>";
                                }elseif($media_val>=1 && $media_val<2){
                                    echo "<li><b>Valoración: </b><u style='color: #ffb300' ><b class='h5' style='color: #ffb300'>$media_val</b></u></li>";

                                }elseif($media_val>=3 && $media_val<4){
                                    echo "<li><b>Valoración: </b><u style='color: #c6ce00'><b class='h5' style='color: #c6ce00'>$media_val</b></u></li>";
                                }else{
                                    echo "<li><b>Valoración: </b><u style='color: #205b29'><b class='h5' style='color: #205b29'>$media_val</b></u></li>";
                                }
                            }

                        if($penalizacion>=1){
                            echo "<p class='display-25 me-3 text-secondary'>";
                            
                            if ($penalizacion==1) {
                                echo "<li><b>Penalización:</b> <img src='../img/tarjeta_amarilla.svg' alt=''></p></li>";
                            }elseif ($penalizacion==2){
                                echo "<li><b>Penalizaciones:</b> <img src='../img/tarjeta_amarilla.svg' alt=''><img src='../img/tarjeta_roja.svg' alt=''></p></li>";
                            }elseif ($penalizacion==3){
                                echo "<li><i class='fas fa-ban btn btn-link' style='color: #c02121;'></i> Bloqueado indefinidamente</p></li>";
                            }                        
                        }

                    echo "</ul>";

                    if ($user!=$email) {
                        if($penalizacion==3){
                            echo "<button class='m-1 shadow' id='btn_add_mensaje' disabled>Contactar</button>";
                        }else{
                            echo "<button class='m-1 shadow zoom'  id='btn_add_mensaje'>Contactar</button>";
                        }
                    }

                    if ($user=="admin" || $user==$email) {
                        echo "<button class='shadow zoom' id='btn_modificar'>
                                <i class=\"fa-regular fa-id-badge\"></i> Modificar perfil
                            </button>";
                    }

                    if ($user!="admin" && $user==$email) {
                        require "../src/backend/alerta_mensajes.php";
                        require "../src/backend/alerta_comentarios.php";
                    }

                        

                        if ($user!="admin" && $user!=$email) {
                            if($penalizacion==3){
                                echo "<button class='shadow bg-danger m-1' id='btn_denunciar' disabled>Denunciar perfil</button>";
                            }else{
                                echo "<button class='shadow bg-danger m-1 zoom' id='btn_denunciar'>Denunciar perfil</button>";
                            }       
                        }

                        echo "</div></div></div>";
                    }

                    echo "<div class='col-lg-8 rounded shadow d-flex align-items-center align-self-center' style='background-color:#e7effd;height:fit-content;'> 
                            <div class='ps-lg-1-6 ps-xl-5 m-auto'>
                                <div class='mb-5'>
                                    <div class='text-start mb-1-6'>
                                        <h2 class='h1 mt-3 mb-0 text-center' style='color: #0b2c7f'>So<u class=\"underline\">bre </u>mí</h2>
                                    </div>
                                    <br>  
                                    <p class='text-center'>$fila_info_usuario[descripcion]</p>
                                </div>                
                            <div class='mb-5'>
                                <div class='text-start mb-1-6 pb-2'>
                                    <h2 class='h1 mb-0 text-center' style='color: #0b2c7f'>Mi<u class=\"underline\">s lugar</u>es</h2>
                                </div>
                             <div class='d-flex justify-content-around mt-4'>";
                    
                    if($user==$email){
                        echo "<button type='input' class='shadow zoom' id='btn_add_lugar' name='add_lugar'>
                            <i class=\"fa-solid fa-plus\" style=\"color: #76481e;\"></i> Añadir lugar
                        </button>";
                        $sent_hay_lug="select lugar.id from lugar,usuario where lugar.id_usuario=usuario.id and usuario.email='$user' and lugar.estado = 1";
                        $consulta_hay_lug=$conexion->query($sent_hay_lug);
                        $numero_filas_e=$consulta_hay_lug->num_rows;

                        if($numero_filas_e>=1) {
                            echo "<button type='input' class='shadow zoom' id='btn_add_espacio' name='add_espacio'>
                                <i class=\"fa-solid fa-plus\" style=\"color: #76481e;\"></i>Añadir espacio
                            </button>";
                        }
                    }                    

                    $sent_comp_esp="select lugar.id from lugar,usuario where lugar.id_usuario=usuario.id and usuario.email='$email' and lugar.estado = 1";
                    $consulta_comp_esp=$conexion->query($sent_comp_esp);
                    $numero_filas=$consulta_comp_esp->num_rows;

                    if($numero_filas>=1){
                        echo "<form method='post' action='misespacios.php'>
                            <input type='text'name='identificacion' value='$identificacion' hidden>
                            <input type='text'name='nom_usu' value=' $nombre' hidden>
                            <input type='text'name='apell_usu' value='$apellidos' hidden>
                            <input type='text' name='foto_usu' value='$foto' hidden>
                            <button type='input' class='shadow zoom' id='btn_vermislugares' name='ver_mislugares'"; if($penalizacion==3){echo "disabled";} echo ">Ver todos</button>
                        </form>";  
                    }
                    echo "</div></div>
                        <div class='mb-5 fadeIn'><div class=\"d-flex flex-wrap justify-content-center\">";
                        $sent_tres_lug ="select lugar.id,lugar.direccion,lugar.foto from lugar,usuario where lugar.id_usuario=usuario.id 
                        and usuario.email='$email' and lugar.estado = 1 limit 3";
                        $consulta_tres_lug=$conexion->query($sent_tres_lug);
                        while ($fila_tres_lug=$consulta_tres_lug->fetch_array(MYSQLI_ASSOC)) {
                            echo "<figure class=\"m-1\">
                                    <img class=\"m-1\" style=\"height:190px; width:220px\" src=\"$fila_tres_lug[foto]\" alt=\"$fila_tres_lug[direccion]\">
                                    <figcaption class=\"text-center\">$fila_tres_lug[direccion]</figcaption>
                                </figure>";
                        }
                        echo "</div></div>
                        </div>
                    </div>
                </div>
                </div>
            </div>";
                }
            }
        }
       
?>
    </section>
<?php
    if ($user=="admin" || $user==$email || (isset($correo_prop) && $user==$correo_prop)){
        require "servicios_contratados.php";  
    }
    echo "<div id=\"content-comments\"></div>";

    require "modales_perfil.php";
?>

</main>

<?php
    require "./footer.php";
?>
<script>
    AOS.init();
</script>
</body>
</html>