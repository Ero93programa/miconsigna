<?php
    session_start(); 
     
    if(isset($_POST['logout'])){
        setcookie('sesion',"",time()-3600,'/');
        session_destroy();
        header ("location: ../index.php");
    }

    if(($_SESSION['user']==="admin") || (!isset($_SESSION['user'])) || ($_SESSION['user']==="")){
        header("Location:../index.php");
    }
        
    require_once "../functions.php";
    require_once "../conexion.php";
    require_once "header.php";

    $user = comprobarUsuario();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="../img/favicon.ico">
    <title>Nuevos reservas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">
    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    <!-- CDN font-awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Fuente Google encabezados -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@600&display=swap" rel="stylesheet">
    <!-- Fuente Google resto de contenido -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">   
    <!-- Styles -->
    <link rel="stylesheet" href="../styles/styles.css"> 
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                responsive:true,
                "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                }
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
    <main class="main_reservas" style="min-height: 68vh">
        <section>
        <div class="section-header">
            <img src="../img/icono_reserva.png" alt="" style="width:70px">
            <h2>HISTÓRICO RESERVAS</h2>
        </div>

        <div class="container py-2 rounded shadow" style="background-color: aliceblue;">
        <div class="row mt-5">
            <div class="col-md-12">

        <?php
        require_once "../conexion.php";


        $sent_rese="select reserva.id id_reserva, reserva.id_espacio, reserva.fecha_ini, reserva.fecha_fin, reserva.id_usuario id_usuario_solicitante, 
        reserva.estado estado_reserva, reserva.id_pago, lugar.direccion, lugar.ciudad, lugar.cp, espacio.texto texto_espacio, espacio.precio_d 
        from reserva,lugar,espacio,usuario where reserva.id_espacio=espacio.id and espacio.id_lugar=lugar.id and lugar.id_usuario=usuario.id and usuario.email = '$user'
        and reserva.estado = 1";
        $consulta_rese=$conexion->query($sent_rese);

        echo "<table id='myTable' class='table table-striped display responsive nowrap tabla_usuarios' style='width:100%'>
            <thead>
                <tr>
                    <th>Usuario solicitante</th> 
                    <th>Lugar</th>
                    <th>Inicio</th> 
                    <th>Fin</th>
                    <th>Total</th>
                </tr>            
            </thead><tbody>";  

while($fila_rese=$consulta_rese->fetch_array(MYSQLI_ASSOC)) {

    $id_usuario_solicitante=$fila_rese['id_usuario_solicitante'];


    $acortado_texto = substr($fila_rese['texto_espacio'], 0, 50);

    $fecha_ini = formateoFecha($fila_rese['fecha_ini']); //
    $fecha_fin = formateoFecha($fila_rese['fecha_fin']); //

    $fecha_ini_o = strtotime($fila_rese['fecha_ini']); //
    $fecha_fin_o = strtotime($fila_rese['fecha_fin']); //

    $diferencia=$fecha_fin_o - $fecha_ini_o;
    $total_dias=round($diferencia / (60 * 60 * 24));
    if($total_dias == 0){
        $total_dias= 1;
    } 
    $total_precio=$total_dias*$fila_rese['precio_d'];


    echo "";

    $sent_rese2="select distinct usuario.nombre nombre_usu,usuario.apellidos 
            from reserva,usuario where reserva.id_usuario = usuario.id and reserva.id_usuario = $id_usuario_solicitante";
    $consulta_rese2=$conexion->query($sent_rese2);

    while($fila_rese2=$consulta_rese2->fetch_array(MYSQLI_ASSOC)) {


        echo "<tr><td><form method='post' action='perfil_usuario.php'>
                        <input type='text' value='$id_usuario_solicitante' name='id_usuario' hidden> 
                        <input type='text' value='' name='correo_prop' hidden>                         
                        <button type='submit' class='btn btn-link text-decoration-none' name='ver'/>
                        
                        $fila_rese2[nombre_usu] $fila_rese2[apellidos]
                        </button> 
                    </form>
                </td>
                <td>$fila_rese[direccion]
                $fila_rese[cp]
                $fila_rese[ciudad]<br>
                \"$acortado_texto"."[...]\" 
                </td>
                <td>$fecha_ini</td>
                <td>$fecha_fin</td> 
                <td>$total_precio €</td>
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
        require "./footer.php";
    ?>
</body>
</html>


    