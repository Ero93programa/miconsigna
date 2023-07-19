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
    <!-- AOS  -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
</head>
<body class='body_misespacios'>
    <header>
        <?php    
        sacarNav($user,"");
        ?>       
    </header>
    <main class="main_misespacios">
    <?php

if($user==""){
    echo "<META HTTP-EQUIV='Refresh' CONTENT='0; url=../index.php'>";    
}else{
    //SI ACCEDES DESDE BOTON DE PROPIETARIO PARA VER SUS LUGARES
    if(isset($_POST['ver_mislugares'])) {
        $identificacion=$_POST['identificacion'];
        $nom_usu=$_POST['nom_usu'];
        $apell_usu=$_POST['apell_usu'];
        $foto_usu=$_POST['foto_usu'];
    }else{
        //SI ACCEDES DESDE URL O SECCION PERFIL PROPIO PARA VER TUS LUGARES
        if($user=="admin"){
            echo "<META HTTP-EQUIV='Refresh' CONTENT='0; url=../index.php'>";   
        }else{
            $sent_identificacion=$conexion->prepare("select usuario.id, usuario.nombre, usuario.apellidos,usuario.foto
            from usuario where usuario.email = ? ");

            $sent_identificacion->bind_param("s",$user);
            $sent_identificacion->bind_result($identificacion,$nom_usu,$apell_usu,$foto_usu);
            $sent_identificacion->execute();
            $sent_identificacion->fetch();
            $sent_identificacion->close();            
        }
    }
}

        echo "<div class='container'>
    
            <div class='row py-5'>
                <div class='col-lg-9 mx-auto text-white text-center'>
                <h1 class='display-4'>Total de lugares y espacios</h1>
                <img src='$foto_usu' class='rounded-circle' alt='Foto usuario' width='100' height='100'> 
                <p class='lead mb-0'>$nom_usu $apell_usu</p>
                </div>
            </div>
            <div class='accordion-group'>
            ";

            /*----------Sacar lugares para el usuario en la página----*/

            $sent_misespacios=$conexion->prepare("select distinct lugar.id, lugar.direccion, lugar.cp, lugar.ciudad, lugar.texto, lugar.fecha_ad, lugar.foto, usuario.email
            from lugar,espacio,usuario where lugar.id_usuario=usuario.id and lugar.estado = 1 and lugar.id_usuario = ?");

            $sent_misespacios->bind_param("s",$identificacion);
            $sent_misespacios->bind_result($id_lugar,$direccion,$cp,$ciudad,$texto,$fecha_ad,$foto,$correo_prop);
            $sent_misespacios->execute();
            $sent_misespacios->store_result();
            $num=0;

            if($sent_misespacios->num_rows()==0){
                echo "<h3 class='text-center'>No hay aún lugares</h3>";
            }else{  
                while($sent_misespacios->fetch()) {
                    $num++;
                    $numw= strval($num);
                    echo "<div class='row'>
                            <div class='col-lg-9 mx-auto'>
                               <div id='accordionExample".$numw."' class='accordion shadow mt-2' data-aos=\"fade-up\" data-aos-duration=\"1500\">
                                    <div class='card' data-aos=\"fade-up\">
                                        <div id='heading".$numw."' class='card-header shadow-sm border-0 rnv text-light encabezado_lugar d-flex align-items-center'>
                                                <img src='$foto' class='foto_lugar mr-4' alt='$foto'>
                                                <p>$direccion $cp $ciudad</p>
                                        </div>";            
                                            
                                        /*----------Sacar espacios para cada lugar, y hacer desplegable si hay filas----*/

                                        $sent_misespacios2="select distinct espacio.id, espacio.texto, espacio.precio_d from lugar,espacio,usuario
                                        where espacio.id_lugar=lugar.id and lugar.id='$id_lugar' and espacio.estado = 1";
                                        $consulta_misespacios2=$conexion->query($sent_misespacios2);
                                        $numero_filas=$consulta_misespacios2->num_rows;
                                        $cuenta=0;

                                        if($numero_filas>=1){
                                        
                                            echo "<div class='card-header bg-white shadow-sm border-0'>
                                                    <h6 class='mb-0 font-weight-bold'><a href='#' data-toggle='collapse' data-target='#collapse".$numw."' aria-expanded='false' aria-controls='collapse".$numw."' class='d-block position-relative text-dark text-uppercase collapsible-link py-2'>Espacios:</a></h6>
                                                </div>
                                            <div id='collapse".$numw."' aria-labelledby='heading".$numw."' data-parent='#accordionExample".$numw."' class='collapse'>
                                                <div class='card-body p-5' table-container>
                                                    <table class='table_misespacios' style='width: 100%'>
                                                
                                                <thead class='head_espacios_pc' style='width:100%'>
                                                    <tr style='width:100%;background-color: lightblue;'>
                                                        <th><b>Nº</b></th>
                                                        <th class=\"text-left\"><b>Descripción</b></th>
                                                        <th class=\"text-center\"><b>€/día</b></th>
                                                        <th> </th>";
                                                        
                                                    echo "</tr>
                                                </thead>                                                               
                                                <tbody>";
                                                     
                                            while ($fila_misespacios2=$consulta_misespacios2->fetch_array(MYSQLI_ASSOC)) {
                                                $id_espacio=$fila_misespacios2['id'];
                                                
                                                $cuenta++;
                                                $texto_espacio=$fila_misespacios2['texto'];
                                                $precio_d_espacio=$fila_misespacios2['precio_d'];


                                                echo "<tr style='width:100%' class='fila_espacios'>
                                                    <td><b>$cuenta</b></td>
                                                    <td>$texto_espacio</td>
                                                    <td class=\"text-center\">$precio_d_espacio"."€</td>
                                                    <td class=\"text-center\">";
                                                    if($user!="admin" && $user!=$correo_prop){
                                                        echo "<form method='post' action='reserva.php'>
                                                                <input type='text' value='$id_espacio' name='id_espacio' hidden> 
                                                                <input type='submit' class='rounded' name='reservar' value='Reserva' style='color:white; background-color:#0a2261'>
                                                            </form>";
                                                    }else{
                                                        echo "<form method='post' action='eliminacion.php'>
                                                                <input type='text' value='$id_espacio' name='id_espacio' hidden> 
                                                                <input type='submit' class='rounded' name='eliminar_espacio' value='Eliminar' style='color:white; background-color:red'>
                                                            </form>";
                                                    }
                                                    echo "</td>";
                                                echo "</tr>";

                                            }
                                            echo "</tbody>
                                            </table>
                                            </div>
                                        </div>";
                                        }
                                    echo "</div>
                                </div>
                            </div>
                        </div>";
                    }
                }
                echo "</div></div>";
        $sent_misespacios->close();

    ?>

    </main>
    <?php
        require "footer.php";
    ?>
    <script>
    AOS.init();
   </script>
</body>
</html>




