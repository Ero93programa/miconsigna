<?php
  if(!isset($_SESSION)){ 
    session_start(); 
  }  

  if(isset($_POST['logout'])) {
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
    <title>Reserva</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <!-- Estilos -->
    <link rel="stylesheet" href="../styles/styles.css">
    <!-- Iconos bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" />
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
    <script>
        $(function() {
            $(document).ready(function () {
                //-----Impedir seleccion de fechas anteriores
                var todaysDate = new Date(); // Sacar fecha de hoy
                // Atributo de fecha máxima está en "YYYY-MM-DD". Formateo fecha de hoy
                var year = todaysDate.getFullYear(); 						// YYYY
                var month = ("0" + (todaysDate.getMonth() + 1)).slice(-2);	// MM
                var day = ("0" + todaysDate.getDate()).slice(-2);			// DD

                var minDate = (year +"-"+ month +"-"+ day); // Resultados en formato "YYYY-MM-DD" para hoy
                
                // Límite de valor para fecha máxima para hoy
                $('#fecha_1').attr('min',minDate);
                $('#fecha_2').attr('min',minDate);
                //-----------

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
    <main class="main_reserva py-5">
        <section>
            <div class="container">
    <?php

if(isset($_POST['reservar'])) {
    $id_espacio=$_POST['id_espacio'];

    $sent_info_lugesp=$conexion->prepare("select lugar.id id_lugar, lugar.direccion, lugar.cp, lugar.ciudad, lugar.texto, lugar.fecha_ad fecha_lugar, 
    lugar.foto foto_lugar, usuario.id id_propietario, usuario.nombre nombre_propietario,usuario.apellidos,usuario.foto foto_propietario,usuario.telefono, usuario.email, 
    espacio.texto, espacio.precio_d from lugar,espacio,usuario where espacio.id_lugar=lugar.id and lugar.id_usuario=usuario.id and espacio.id = ?");
    $sent_info_lugesp->bind_param("s", $id_espacio);
    $sent_info_lugesp->bind_result($id_lugar,$direccion,$cp,$ciudad,$lugar_texto,$fecha_lugar,$foto_lugar,$id_propietario,
    $nombre_propietario,$apellidos,$foto_propietario,$telefono,$email,$espacio_texto,$precio);
    $sent_info_lugesp->execute();

    while($sent_info_lugesp->fetch()) {
        echo "<div class='d-flex justify-content-center align-items-center' data-aos=\"fade-down\"> 
                <div class=\"position-relative imagen_reserva shadow\">
                    <img src=\"$foto_lugar\" class=\"w-100\">
                    <div class=\"z-2 position-absolute d-flex justify-content-center align-items-center w-100 text-white\" style=\"background: rgba(20,20,150,0.75); margin-top: -30%; height: 15%;\">
                    <p class=\"\" style=\"font-size: 1.3em;align-vertically:middle;\">Tu reserva<p>
                    </div>
                </div>
            </div>
        <div class=\"row gy-4 mt-4 p-1\">
            <div class=\"col-lg-4 rounded shadow caja_bordes bg-white\" data-aos=\"fade-right\" data-aos-delay=\"500\">
                <div class=\"info-item d-flex\">
                    <i class=\"bi bi-geo-alt flex-shrink-0\"></i>
                    <div>
                    <h4>Localización:</h4>
                    <p>$direccion $cp $ciudad</p>
                    </div>
                </div>
                <div class=\"info-item d-flex\">
                    <i class=\"bi bi-envelope flex-shrink-0\"></i>
                    <div>
                    <h4>Email:</h4>
                    <p>$email</p>
                    </div>
                </div>
                <div class=\"info-item d-flex\">
                    <i class=\"bi bi-phone flex-shrink-0\"></i>
                    <div>
                    <h4>Teléfono:</h4>
                    <p>$telefono</p>
                    </div>
                </div>
            </div>";            
    }
                $sent_info_lugesp->close();

                $sent_propio_id=$conexion->prepare("select id from usuario where email = ?");
                $sent_propio_id->bind_param("s", $user);
                $sent_propio_id->bind_result($id_propio);
                $sent_propio_id->execute();
                $sent_propio_id->fetch();
                $sent_propio_id->close();

                echo "<div class=\"col-lg-8 d-flex flex-column justify-content-around rounded shadow mt-3 caja_bordes caja2 bg-white\"  data-aos=\"fade-left\">
                        <div class=\"p-1\">
                            <h4>Detalles:</h4>
                            <p>$lugar_texto</p>
                            <p>$espacio_texto</p>
                        </div>
                        <div class=\"p-1\">
                        <h4>Precio:</h4>
                        <p>$precio €/día</p>

                    </div>
                        
                    <div class=\"p-3 my-2 rounded\" style=\"background-color:#d8e5ff\">
                        <form action=\"terminar.php\" method=\"post\" role=\"form\" class=\"php-email-form\" id=\"form_reserva\">
                            <div class=\"row\">
                                <div class=\"col-md-6 form-group\">
                                <label for=\"fecha_1\">Desde:</label>
                                    <input type=\"date\" name=\"fecha_1\" class=\"form-control shadow\" id=\"fecha_1\" required=\"\">
                                </div>
                                <div class=\"col-md-6 form-group\">
                                <label for=\"fecha_2\">A:</label>
                                    <input type=\"date\" name=\"fecha_2\" class=\"form-control shadow\" id=\"fecha_2\" required=\"\">
                                </div>
                            </div>

                            <input type=text name='id_lugar' value='$id_lugar' hidden>
                            <input type='text' id='id_propio' name='id_propio' value='$id_propio' hidden>
                            <input type='text' id='id_espacio' name='id_espacio' value='$id_espacio' hidden>
                            <input type='number' id='precio_dia' name='precio_dia' value='$precio' hidden>
                            <div class=\"row d-flex\">
                                <div class=\"text-center mt-2\">
                                    <p class=\"cuenta_total\">Total: </p>
                                </div>
                                <div class=\"text-center mt-2\">
                                    <button type='submit' class='btn terminar-boton shadow' name='terminar' id=\"terminar\">Terminar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                  </div>
                  </div>";
}
            ?>
            </div>
        </section>
    </main>
    <?php
        require "./footer.php";
    ?>
    <script>
        AOS.init();

        $(document).ready(function() {
            // Función para calcular la diferencia de días entre dos fechas
            function calcularDiferenciaFechas(fecha1, fecha2) {
                // Parsear las fechas en objetos de tipo Date
                var date1 = new Date(fecha1);
                var date2 = new Date(fecha2);

                // Calcular la diferencia en milisegundos
                var diferencia = Math.abs(date2 - date1);

                // Convertir la diferencia en días
                var dias = Math.ceil(diferencia / (1000 * 60 * 60 * 24));

                return dias;
            }

            // Manejar el evento de cambio de las fechas
            $("#fecha_1, #fecha_2").change(function() {
                var fecha1 = $("#fecha_1").val();
                var fecha2 = $("#fecha_2").val();

                if (fecha1 && fecha2) {
                    // Calcular la diferencia de días
                    var dias = calcularDiferenciaFechas(fecha1, fecha2);
                    console.log(dias);
                    if(dias == 0)
                        dias = 1;
                    // Obtener el precio
                    var precio = "<?= $precio ?>";

                    // Calcular el total
                    var total = dias * precio;
                    // Actualizar el contenido del elemento p
                    $(".cuenta_total").text("Total: " + total.toFixed(2) + " €");
                }
            });
            //Evitar fechas inversas "viaje tiempo"
            $('#fecha_1').on('change', function(e) {
                $('#fecha_2').prop('min', $(this).val());
                $('#fecha_2').val('');
            });
            $('#fecha_2').on('change', function(e) {
                $('#fecha_1').prop('max', $(this).val());
                
            });


            document.getElementById('form_reserva').onsubmit = function () {
                alert("Solicitud enviada.");
            };
        });
    </script>
</body>
</html>



