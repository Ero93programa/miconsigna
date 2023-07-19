<?php
    if(!isset($_SESSION)) 
    { 
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
    <title>Informes/Reportes</title>
    <script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
        //--Ordenar inicialmente por fecha
        $(document).ready(function() {
            $('#myTable').DataTable({
                "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                },
               order: [[2, 'desc']]
            });
       
            $('#myTable').DataTable();
            $('#myTable').on('click','.leer',function () {
                $('#modal_contenido').modal("show");
                let elementoSobre = $(this).children();
                if(elementoSobre.hasClass('fa-envelope')) { //Si el icono del sobre está cerrado...
                    //...lo abro
                    elementoSobre.attr('class', '');
                    elementoSobre.addClass('fas fa-envelope-open');
                    hazSobreCerrado($(this).data('id_message'));
                }
            });
            
            //Cerrar modal
            $(".close").click(function(){
                $('#modal_contenido').modal('hide');
            });
        
            //La clase del p de los botones que pulso
            const botones = document.querySelectorAll(".leer");
            //La clase del p del modal donde mostraré el texto
            const texto_modal = document.getElementById("texto_modal");

            let texto_sacado;

            botones.forEach(boton=>{
                boton.addEventListener("click", ()=>{
                    texto_sacado = boton.previousElementSibling;

                    texto_modal.textContent = texto_sacado.textContent
                    
                    console.log(texto_sacado);
                })
            })
    
        });

        function hazSobreCerrado(idM) {
            $.post("../src/backend/update_informe.php", {id: idM})
            .done(function(res) {
                console.log(res);
            })
            .error(function(){
                console.log(arguments);
            });
        }
    </script>
</head>
<body>
    <header>
        <?php    
            sacarNav($user,"");
        ?>
    </header>
    <main class="mis_informes">
        <section>
        <div class="section-header">
            <img src="../img/alerta.png" alt="" style="width:70px">
            <h2>Informes</h2>
        </div>

        <div class="container py-3 rounded" style="background-color: aliceblue;">
        <div class="row mt-5">
            <div class="col-md-12">

        <?php
        require_once "../conexion.php";

        $lista_informes="select informe.id id, informe.asunto,informe.contenido,informe.fecha,informe.leido,
        informe.id_emisor,informe.id_denunciada id_denunciada, usuario.id id_usuario,usuario.nombre,usuario.apellidos from informe,usuario where usuario.id=informe.id_emisor order by fecha desc";
        $consulta_lista_informes=$conexion->query($lista_informes);

        echo "<table id='myTable' class='table table-striped display responsive nowrap tabla_informes' style='width:100%'>
            <thead>
                <tr>
                    <th>Autor</th>
                    <th>Asunto</th>
                    <th>Fecha_recibido</th>
                    <th>Leer</th>
                    <th>Enlace</th>
                    <th>Eliminar</th>
                </tr>
            </thead><tbody>";
        while($fila_lista_informes=$consulta_lista_informes->fetch_array(MYSQLI_ASSOC)){
            $fecha=formateoFecha($fila_lista_informes['fecha']);

            echo "<tr>
                    <td>
                    <form method=\"post\" action=\"perfil_usuario.php\">
                            <input type='text' value='$fila_lista_informes[id_usuario]' name='id_usuario' hidden>
                            <button type='submit' class='btn btn-link' name='ver'/>
                              $fila_lista_informes[nombre]
                              $fila_lista_informes[apellidos]
                            </button>
                        </form>
                    </td>
                    <td>$fila_lista_informes[asunto]</td>
                    <td>$fecha</td>

                    <td>
                        <p class='texto_lectura' hidden>$fila_lista_informes[contenido]</p>
                        <button id='leer' class='btn btn-link leer' data-id_message='{$fila_lista_informes['id']}'>";
                            if($fila_lista_informes['leido']==0){
                                echo "<i class='fa-solid fa-envelope'></i>";
                            }else{
                                echo "<i class='fas fa-envelope-open'></i>";
                            }
                        echo "</button>
                    </td>

                    <td>
                        <form method=\"post\" action=\"perfil_usuario.php\">
                            <input type='text' value='$fila_lista_informes[id_denunciada]' name='id_usuario' hidden>
                            <button type='submit' class='btn btn-link' name='ver'/>
                                <i class='fa fa-eye text-primary'></i>
                            </button>
                        </form>
                    </td>
                    <td>
                    <a href='#' class='text-danger' data-toggle='tooltip' title='' data-original-title='Delete'></a>
                        <form action='eliminacion.php' method='post'>
                            <input type='text' value='$fila_lista_informes[id]' name='id_informe' hidden>
                            <button type='submit' class='eliminadores btn btn-link' name='eliminacion_informe'/>
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


    <!-- ---------------------------MODAL CON INFORME--------------------------  -->

    <div id="modal_contenido" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <!--      Para centrado-->
    <div class="modal-dialog modal-dialog-centered" role="document">

    <!--  <div class="modal-dialog" role="document">-->
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Mensaje</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" id="modal-body-id">
                <p class="text-center texto_modal" id='texto_modal'></p>
        </div>
        </div>
    </div>
    </div>


    </main>
    <?php
        require "./footer.php";
    ?>
    <script>
        const eliminadores=document.querySelectorAll(".eliminadores");
        eliminadores.forEach(eliminador=>{
            eliminador.addEventListener("click", (evento)=>{
                if(!confirm("Vas a eliminar este informe, ¿Estás seguro?")){
                evento.preventDefault();
                }
            })
        })
    </script>
</body>
</html>

