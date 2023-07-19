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
    require_once "../conexion.php";
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
    <title>Nuevos lugares</title>
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                },
               order: [[4, 'desc']]
            });

            $('#myTable').DataTable();
            
            $('#myTable').on('click','.ver_foto',function () {
                var imageUrl = $(this).closest('tr').find('img').attr('src');
                $('#imagen_modal').attr('src', imageUrl);
                $('#modal_foto').modal("show");
            });

            $(".close").click(function(){
                $('#modal_foto').modal('hide');
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
    <main  class="main_lugares">
        <section>
          <div class="section-header">
            <img src="../img/icono_lugar_nuevo.png" alt="" style="width:70px">
          <h2>Nuevos lugares</h2>
        </div>

        <div class="container py-2 rounded shadow" style="background-color: aliceblue;">
        <div class="row mt-5">
            <div class="col-md-12">
        <?php
       
        $sent_nuev_lug="select usuario.id id_usuario,usuario.nombre,usuario.apellidos,lugar.id id_lugar,lugar.direccion,lugar.cp,lugar.ciudad,lugar.texto,
        lugar.fecha_ad,lugar.estado,lugar.foto from usuario,lugar where lugar.id_usuario=usuario.id and lugar.id>0 and lugar.estado=0";
        $consulta_nuev_lug=$conexion->query($sent_nuev_lug);
        
        echo "<table id='myTable' class='table table-striped display responsive nowrap tabla_lugares' style='width:100%'>
            <thead>
                <tr>
                    <th>Dirección</th> 
                    <th>Cod. Postal</th>
                    <th>Ciudad</th> 
                    <th>Texto</th>
                    <th>Añadido</th> 
                    <th>Foto</th> 
                    <th>Acción</th> 
                </tr>            
            </thead><tbody>";      
        while($fila_nuev_lug=$consulta_nuev_lug->fetch_array(MYSQLI_ASSOC)){
            $fecha=formateoFecha($fila_nuev_lug['fecha_ad']);
            $id_usuario=$fila_nuev_lug['id_usuario'];
            $id_lugar=$fila_nuev_lug['id_lugar'];

            echo "<tr>

                    <td>$fila_nuev_lug[direccion]</td>
                    <td>$fila_nuev_lug[cp]</td>
                    <td>$fila_nuev_lug[ciudad]</td>
                    <td>$fila_nuev_lug[texto]</td>
                    <td>$fecha</td>
                    <td>
                        <img src='$fila_nuev_lug[foto]' alt=\"\" style=\"display:none\">                   
                        <button type='submit' class='ver_foto btn btn-link' name='ver' onclick='showImage(\"{$fila_nuev_lug['foto']}\")'>
                            <i class='fa fa-eye text-primary'></i>
                        </button> 
                    </td>
                    <td class=\"d-flex text-center\">
                        <form action='validacion.php' method='post'>
                            <input type=\"text\" value='$id_lugar' name='id_lugar' hidden>
                            <button type='submit' class='validadores btn btn-link' name='validar_lugar'>
                                <i class='far fas fa-check text-success'></i>
                            </button>                            
                        </form>
                        <form action='eliminacion.php' method='post'>
                            <input type=\"text\" value='$id_lugar' name='id_lugar' hidden>
                            <button type='submit' class='eliminadores btn btn-link' name='eliminar_lugar'>
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

     <!-- ---------------------------MODAL CON FOTO--------------------------  -->

<div id="modal_foto" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <!--      Para centrado-->
  <div class="modal-dialog modal-dialog-centered" role="document">

<!--  <div class="modal-dialog" role="document">-->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Foto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modal-body-id">
        <?php
            echo "<img src=\"\" alt=\"\" class=\"imagen_modal w-100\" id='imagen_modal'>";
        ?>
      </div>
    </div>
  </div>
</div>

    <script>
   
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
        const validadores = document.querySelectorAll(".validadores");
        const eliminadores = document.querySelectorAll(".eliminadores");

    
        validadores.forEach(validador=>{
            validador.addEventListener("click", (evento)=>{
                if(!confirm("Vas a validar este lugar, ¿Estás seguro?")){
                evento.preventDefault();
            }     
            })
        })

        eliminadores.forEach(eliminador=>{
            eliminador.addEventListener("click", (evento)=>{
                if(!confirm("Vas a eliminar este lugar, ¿Estás seguro?")){
                evento.preventDefault();
            }     
            })
        })

        //poner fotografia segun direccion metida en input al clickar boton
        //     botones.forEach(boton=>{
        //     boton.addEventListener("click", (evento)=>{
        //         let pulsado = evento.target
        //         let valor = pulsado.previousElementSibling.value
        //         pulsado.nextElementSibling.setAttribute("src", valor)
                
        //     })
        // })


        //-------ANTES--------//

        //La clase de los botones que pulso
        const visualizadores = document.querySelectorAll(".ver_foto");
        //La clase de la imagen del modal donde mostraré la imagen
        const imagen_modal = document.getElementById("imagen_modal");
       
        let imagen_sacada;

        visualizadores.forEach(function(visualizador) {
           
            visualizador.addEventListener("click", function(){
                //-
                console.log("Has pulsado");
        
                imagen_sacada = visualizador.previousElementSibling.value;
                imagen_modal.setAttribute("src", imagen_sacada);

                //-
                console.log(`La imagen modal es ${imagen_modal}`);
                console.log(`La imagen sacada es ${imagen_sacada}`);

            })
        })
        function showImage(imgSrc) {
            console.log(imgSrc);
            imagen_modal.setAttribute("src", imgSrc);

        }
   
    </script>
    <?php
        require "./footer.php";
    ?>
</body>
</html>

