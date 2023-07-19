<?php
    if (!isset($_SESSION)) {
        session_start();
    }

    if (isset($_POST['logout'])) {
        setcookie('sesion', "", time()-3600, '/');
        session_destroy();
        header ("location: ../index.php");
    }

    require_once "../functions.php";
    require_once "../conexion.php";
    require_once "header.php";

    codificacion_utf($conexion);

    $user = comprobarUsuario();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="../img/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js" integrity="sha256-xLD7nhI62fcsEZK2/v8LsBcb4lG7dgULkuXoXB/j91c=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script> 
    <!-- CDN font-awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
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
    <style>
       .table-container {
            overflow-x: auto;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 8px;
        }

        /* Media query para dispositivos con pantallas de hasta 600px */
        @media (max-width: 600px) {
            .table thead {
                display: none;
            }

            .table tr {
                display: block;
                margin-bottom: 10px;
            }

            .table td {
                display: block;
                text-align: left;
            }

            tbody>tr{
                border-bottom: 2px solid black;
                }

            tr.fila_espacios>td:first-child {
                background-color: lightblue;
            }

            tr.fila_espacios>td:nth-child(3) {
               border-bottom: none;
            }
        }

    </style>
</head>
<body class='body_misespacios'>
    <header>
        <?php    
        sacarNav($user,"");
        ?>       
    </header>
    <main class="main_lugar">
    <?php

   if(isset($_POST['reservar_espacio'])){

        $id_lugar=$_POST['id_lugar'];
       
        echo "<div class='container'>
            <div>";

            /*----------Sacar lugar----------*/
        
            $sent_espacios=$conexion->prepare("select lugar.id, lugar.direccion, lugar.cp, lugar.ciudad, lugar.texto, lugar.fecha_ad, lugar.foto,
            usuario.foto foto_usuario from lugar,usuario where lugar.id_usuario=usuario.id and usuario.estado = 1 and lugar.estado = 1 and lugar.id = ?");
            $sent_espacios->bind_param("s",$id_lugar);
            $sent_espacios->bind_result($id_lugar,$direccion,$cp,$ciudad,$texto,$fecha_ad,$foto_lugar,$foto_usuario);
            $sent_espacios->execute();
            $sent_espacios->fetch();

            echo "<div class='row my-4'>
                    <div class='col-lg-9 mx-auto py-5'>
                        <div id='accordionExample' class='shadow my-5'>
                            <div class='card'>
                                <div id='heading' class='card-header shadow-sm border-0 rnv text-light encabezado_lugar d-flex align-items-center p-3'>
                                    <img src='$foto_lugar' class='foto_lugar mr-4' alt='$foto_lugar'>
                                    <p class='ml-2 align-middle'>$direccion $cp $ciudad</p>
                                </div>
                                <div class='card-header bg-white shadow-sm border-0'>
                                    <h5 class='mb-0 font-weight-bold'>Espacios:</a></h5>
                                </div>
                                <div aria-labelledby='heading'>
                                    <div class='card-body p-5'>
                                        <table class='table' style='width: 100%'>
                                        <thead class='head_espacios' style='width:100%'>
                                            <tr style='width:100%;background-color: lightblue;'>
                                                <th><b>Nº</b></th>
                                                <th class='text-left'><b>Descripción</b></th>
                                                <th class='text-center'><b>€/día</b></th>
                                                <th class='text-center'>Acción</th>";
                                                
                                            echo "</tr>
                                        </thead>                                                               
                                        <tbody>";
            $sent_espacios->close();
            //-----------------------------------------//
            $sent_espacios2=$conexion->prepare("select id,texto,precio_d from espacio where espacio.estado = 1 and espacio.id_lugar = ?");
            $sent_espacios2->bind_param("s",$id_lugar);
            $sent_espacios2->bind_result($id_espacio,$espacio_texto,$precio_espacio);
            $sent_espacios2->execute();
            $cuenta=0;
            while($sent_espacios2->fetch()) {
                $cuenta++;

                                echo "<tr style='width:100%' class='fila_espacios'>
                                    <td><b>$cuenta</b></td>
                                    <td>$espacio_texto</td>
                                    <td class='text-center'>$precio_espacio"."€
                                    <td class=\"text-center\">";
                                    if($user!="admin" && $user!=""){
                                        echo "<form method='post' action='reserva.php'>
                                                <input type='text' value='$id_espacio' name='id_espacio' hidden> 
                                                <input type='submit' class='rounded' name='reservar' value='Reserva' style='color:white; background-color:#0a2261'>
                                            </form>";
                                    }
                                    if($user==""){
                                        echo "<button' class='rounded btn btn-warning text-white '>
                                                <a class=\"text-decoration-none\" href=\"registro.php\">Regístrate</a>
                                            </button>";
                                    }
                                    if($user=="admin"){
                                        echo "<form method='post' action='eliminacion.php'>
                                        <input type='text' value='$id_espacio' name='id_espacio' hidden> 
                                        <input type='submit' class='rounded bg-danger' name='eliminar_espacio' value='Eliminación' style='color:white;'>
                                    </form>";
                                    }



                                echo "</td></tr>";
                            }
                            echo "</tbody>
                            </table>
                            </div>
                        </div>";
                        
                    echo "</div>
                </div>
            </div>
        </div>";
        }
        
        echo "</div></div>";

    ?>

</main>
    <?php
        require "footer.php";
    ?>
</body>
</html>


