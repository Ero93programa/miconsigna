<?php
    if (!isset($_SESSION)) {
        session_start();
    }
    
    if(isset($_POST['logout'])){
        setcookie('sesion',"",time()-3600,'/');
        session_destroy();
        header ("location: ../index.php");
    }

    require_once "../functions.php";
    require_once "header.php";

    $user = comprobarUsuario();    
    
    if($_SESSION['user']!="admin"){
        header("Location:../index.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="../img/favicon.ico">
    <title>Total lugares</title>
    <!-- Bootstrap -->
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
    <!-- Script -->
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
    <main class="main_lugares">
        <section class="">
        <div class="section-header">
            <img src="../img/icono_lugar.png" alt="" style="width:70px">
          <h2>Total lugares</h2>
        </div>
            <div class="container py-2 rounded shadow" style="background-color: aliceblue;">
                <div class="row mt-5">
                    <div class="col-md-12">
        <?php
        require_once "../conexion.php";
       
        echo "<table id='myTable' class='table table-striped display responsive nowrap tabla_lugares' style='width:100%'>
                <thead>
                    <tr>
                        <th>Propietario</th> 
                        <th>Dirección</th> 
                        <th>Cod. Postal</th>
                        <th>Ciudad</th> 
                        <th>Nº espacios</th>
                        <th>Añadido</th> 
                        <th>Texto</th>
                        <th>Ver</th>
                        <th>Eliminar</th>

                    </tr>
                </thead><tbody>";
    
        $sent_all_lug="select usuario.id id_usuario,usuario.nombre,usuario.apellidos,lugar.id id_lugar,lugar.direccion,lugar.cp,lugar.ciudad,lugar.texto,
        lugar.fecha_ad,lugar.estado,lugar.foto from usuario,lugar where lugar.id_usuario=usuario.id and lugar.id>0 and lugar.estado=1";
        $consulta_all_lug=$conexion->query($sent_all_lug);
        
     
        while($fila_all_lug=$consulta_all_lug->fetch_array(MYSQLI_ASSOC)){
            $fecha=formateoFecha($fila_all_lug['fecha_ad']);
            $id_usuario=$fila_all_lug['id_usuario'];
            $id_lugar=$fila_all_lug['id_lugar'];

            $sent_num_esp="select count(id) as num_espacios from espacio where id_lugar='$id_lugar'";
            $consulta_num_esp=$conexion->query($sent_num_esp);
            $fila_num_esp=$consulta_num_esp->fetch_assoc();
            $total = $fila_num_esp['num_espacios'];



            echo "<tr>
                    <td>$fila_all_lug[nombre] $fila_all_lug[apellidos]</td>
                    <td>$fila_all_lug[direccion]</td>
                    <td>$fila_all_lug[cp]</td>
                    <td>$fila_all_lug[ciudad]</td>
                    <td>$total</td>
                    <td>$fecha</td>
                    <td>$fila_all_lug[texto]</td>
                    
                    <td class='text-center'>
                        <form method=\"post\" action='lugar.php'>
                            <input type=\"text\" value='$id_lugar' name='id_lugar' hidden>
                            <button type='submit' class='btn btn-link' name='reservar_espacio'/>
                                <i class='fa fa-eye text-primary'></i>
                            </button> 
                        </form>
                    </td>
                    <td class='text-center'>
                        <form action='eliminacion.php' method='post'>
                            <input type=\"text\" value='$id_lugar' name='id_lugar' hidden>
                            <button type='submit' class='eliminadores btn btn-link' name='eliminar_lugar_d'/>
                                <i class='far fa-trash-alt text-danger'></i>
                            </button>
                        </form>
                    </td>
                    </tr>";          
        }
        echo"</tbody></table>";
        ?>

                    </div>
                </div>
            </div>
        </section>
    </main>
    <script>
        if (window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }

        const eliminadores=document.querySelectorAll(".eliminadores");
        
        eliminadores.forEach(eliminador=>{
            eliminador.addEventListener("click", (evento)=>{
                if(!confirm("Vas a eliminar este lugar, ¿Estás seguro?")){
                evento.preventDefault();
            }     
            })
        })

        // eliminadores.each( function ( value, index ) {
         
        //     console.log("1");
        // })
 
    </script>
    <?php
        require "./footer.php";
    ?>  
</body>
</html>


