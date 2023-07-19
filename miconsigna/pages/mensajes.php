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
    
    if($user===""){
        header ("location: ../index.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="../img/favicon.ico">
    <title>Mensajes</title>
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
    <script src="https://cdn.datatables.net/datetime/1.1.1/js/dataTables.dateTime.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
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
        //--Interfaz español
        $(document).ready(function() {
            $('#myTable').DataTable({
                "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                },"columnDefs": [
            {
                "targets": 2,  // Índice de la columna "Fecha_recibido"
                "render": function(data, type, row) {
                    if (type === 'sort') {
                        // Convertir la fecha al formato ISO 8601 (año-mes-día) para ordenar correctamente
                        return moment(data, 'DD-MM-YYYY').format('YYYY-MM-DD');
                    }
                    return data;
                }
            }
            ],
            "order": [[2, 'desc']]
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

            $('.responder').on('click', function () {
                $('#modal_add_mensaje').modal("show");
            
                $('input[name=identificacion]').val($(this).data('who'));

                //  // Obtener el valor del atributo data-asunto
                 let asunto = $(this).data('asunto');

                // // Establecer el valor del campo de asunto en el modal
                 $('input[name=asunto]').val('RE: ' + asunto);
               
            });

            //Cerrar modal
            $(".close").click(function(){
                $('#modal_contenido').modal('hide');
                $('#modal_add_mensaje').modal('hide');
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
                })
            })
        });

        function hazSobreCerrado(idM) {
            $.post("../src/backend/update_message.php", {id: idM})
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
    <main class="mis_mensajes">
        <section class="section_mensajes">
        <div class="section-header">
          <img src="../img/sobre_correo.png" alt="" style="width:70px">
          <h2>Mensajería</h2>
        </div>

        <div class="container py-2 rounded shadow" style="background-color: aliceblue;">
        <div class="row mt-5">
            <div class="col-md-12">

        <?php
        require_once "../conexion.php";

        $lista_mensajes="select m.id id_mensaje, m.asunto, m.texto, m.fecha, m.leido,
        m.id_emisor,m.id_receptor, uemi.nombre,uemi.apellidos from mensaje m inner join usuario urec on urec.id=m.id_receptor inner join usuario uemi on m.id_emisor=uemi.id where urec.email='$user' 
        order by fecha desc";
        
        $consulta_lista_mensajes=$conexion->query($lista_mensajes);
        
        echo " <table id=\"myTable\" class=\"table table-striped display responsive nowrap tabla_informes\" style=\"width:100%\">
            <thead>
                <tr>
                    <th>Autor</th>
                    <th>Asunto</th>
                    <th>Fecha_recibido</th>
                    <th class='text-center'>Leer</th>
                    <th class='text-center'>Responder</th>
                    <th class='text-center'>Eliminar</th>
                </tr>
            </thead>";

        while($fila_lista_mensajes=$consulta_lista_mensajes->fetch_array(MYSQLI_ASSOC)){
            $fecha=formateoFecha($fila_lista_mensajes['fecha']);
    
            echo "<tr>
                    <td>";
                    //CONTROLAR QUE NO SE PUEDA ACCEDER A "PERFIL DE ADMINISTRADOR"

                    if($fila_lista_mensajes['id_emisor']!=0){
                        echo "<form method=\"post\" action=\"perfil_usuario.php\">
                                <input type='text' value='c' name='id_usuario' hidden>
                                <button type='submit' class='btn btn-link text-decoration-none' name='ver'/>
                                    $fila_lista_mensajes[nombre]
                                    $fila_lista_mensajes[apellidos]
                                </button>
                            </form>";                        
                    }else{
                        echo "<img src='../img/favicon.ico' alt='icono miconsigna'>
                        Miconsigna";
                    }
                    echo "</td>
        
                    <td>{$fila_lista_mensajes['asunto']}</td>
                    <td>{$fecha}</td>
        
                    <td class='text-center'>
                        <p class='texto_lectura' hidden>$fila_lista_mensajes[texto]</p>   
                        <button id='leer' class='btn btn-link leer' data-id_message='{$fila_lista_mensajes['id_mensaje']}'>";
                            if($fila_lista_mensajes['leido']==0){
                                echo "<i class='fa-solid fa-envelope'></i>";
                            }else{
                                echo "<i class='fas fa-envelope-open'></i>";
                            }
                        echo "</button>
                    </td>
                
                    <td class='text-center'>"; 
                        echo "<button class='btn btn-link responder responder-btn' title=\"Responder a $fila_lista_mensajes[nombre]\" data-who='{$fila_lista_mensajes['id_emisor']}' data-asunto='{$fila_lista_mensajes['asunto']}'>
                            <i class=\"fa fa-reply\" aria-hidden=\"true\"></i>
                        </button>";
                    echo "</td>
                
                    <td class='text-center'>
                    <a href='#' class='text-danger' data-toggle='tooltip' title='' data-original-title='Delete'></a>
                        <form action='eliminacion.php' method='post'>
                            <input type='text' value='$fila_lista_mensajes[id_mensaje]' name='id_mensaje' hidden>
                            <button type='submit' class='eliminadores btn btn-link' name='eliminacion_mensaje'/>
                                <i class='far fa-trash-alt text-danger'></i>
                            </button>
                        </form>
                    </td>
                </tr>";
        }
        echo"</table>"; 
 
        ?>

        </div>
            </div>
        </div>

        </section>
    </main>

    <?php
        require "footer.php";
    ?>
 <!-- ---------------------------MODAL CON MENSAJE--------------------------  -->

    <div id="modal_contenido" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <!--      Para centrado-->
    <div class="modal-dialog modal-dialog-centered" role="document">

    <!--  <div class="modal-dialog" role="document">-->
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Mensaje</h5>
            <button type="button" class="close btn-close" data-dismiss="modal" aria-label="close">
            </button>
        </div>
        <div class="modal-body" id="modal-body-id">
                <p class="text-center texto_modal" id='texto_modal'></p>
        </div>
        </div>
    </div>
    </div>

<!------------------------------ Modal AÑADIR MENSAJE ------------------------->

<div id="modal_add_mensaje" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <!--      Para centrado-->
    <div class="modal-dialog modal-dialog-centered" role="document">  

    <!--  <div class="modal-dialog" role="document">-->
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Escribe tu mensaje:</h5>
            <button type="button" class="close btn-close" data-dismiss="modal" aria-label="Close">
            </button>
        </div>
        <form action="add_mensaje.php" method='post' enctype='multipart/form-data'>
            <div class="modal-body">
                <div class="form-group">
                    <label for="exampleInputAsunto">Asunto:</label>
                    <input type="text" class="form-control" name='asunto' id="exampleInputAsunto" value='' required>
                </div>    
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Mensaje:</label>
                    <textarea class="form-control rounded-0 mt-2" name='mensaje' id="exampleFormControlMensaje" rows="10" required></textarea>
                </div>
        <div class="modal-footer">
            <input type='hidden' name='identificacion'>
            <?php $fecha_hoy=date('Y-m-d') ?>
            <input type='hidden' name='fecha_hoy'  value="<?php echo $fecha_hoy ?>">

            <button type="button" class="btn btn-secondary close" data-dismiss="modal">Cancelar</button>
            <button type="submit" name='add_mensaje_m' class="btn btn-warning">Enviar</button>
        </div>
        </form> 
        </div>
    </div>
    </div>

   

<script>
    const eliminadores=document.querySelectorAll(".eliminadores");
    eliminadores.forEach(eliminador=>{
        eliminador.addEventListener("click", (evento)=>{
            if(!confirm("Vas a eliminar este mensaje, ¿Estás seguro?")){
            evento.preventDefault();
            }
        })
    })
</script>
</body>
</html>



