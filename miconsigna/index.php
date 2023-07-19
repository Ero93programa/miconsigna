<?php
if(!isset($_SESSION)) {
    session_start();
}  
  if(isset($_POST['logout'])){
    setcookie('sesion',"",time()-3600,'/');
    session_destroy();
    header ("location: index.php");
  }
  
  require_once "functions.php";
  require_once "conexion.php";
  require_once "pages/header.php";
  require "pages/totales_web_index.php";

  codificacion_utf($conexion);
    
  $user = comprobarUsuario();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="./img/favicon.ico">
    <title>Principal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="styles/styles.css">
    <!-- API EXTERNA GEOPLUGIN -->
    <script language="JavaScript" src="http://www.geoplugin.net/javascript.gp" type="text/javascript"></script>
    <!-- AOS  -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <!-- Purecounter -->
    <script src="https://cdn.jsdelivr.net/npm/@srexi/purecounterjs/dist/purecounter_vanilla.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <!-- Fuente Google encabezados -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@600&display=swap" rel="stylesheet">
    <!-- Fuente Google resto de contenido -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
  </head>
<body class="body_index">

  <header>
    <?php    
      sacarNav($user,"index");
    ?>
  </header>
  <main>
    <section id="hero" class="hero d-flex align-items-center py-4" style="background-color: #0e1d34;color:white;">
    <div class="container">
      <div class="row gy-4 d-flex justify-content-between">
        <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center">
          <h2 data-aos="fade-up" class="">Encuentra donde dejar tu equipaje</h2>
          <p data-aos="fade-up" data-aos-delay="100" class="">Regístrate y accede a una comunidad donde te quitarán un peso de encima. 
            Deja tus maletas, tu equipaje o tus cargas, y disfruta de tu tiempo. Alquila tus espacios, y obtén una remuneración</a></p>

          <form method="post" action="pages/lista_espacios.php" class="form-search d-flex align-items-stretch mb-3 aos-init aos-animate" data-aos="fade-up" data-aos-delay="200">
            <input type="text" class="form-control" name="direccion" placeholder="Ciudad, población o Código Postal">
            <button type="submit" class="btn btn-primary" name="buscar">Buscar</button>
          </form>

          <div class="row gy-4 aos-init aos-animate" data-aos="fade-up" data-aos-delay="40">

            <div class="col-lg-3 col-6" data-aos="fade-up" data-aos-duration="1500">
              <div class="stats-item text-center w-100 h-100">
                <span data-purecounter-start="0"  data-purecounter-end=<?php echo $count_usuario ?> data-purecounter-duration="2" class="purecounter">0</span>
                <p>Usuarios</p>
              </div>
            </div><!-- End Stats Item -->

            <div class="col-lg-3 col-6" data-aos="fade-up" data-aos-duration="1500">
              <div class="stats-item text-center w-100 h-100">
                <span data-purecounter-start="0" data-purecounter-end=<?php echo $count_lugar ?> data-purecounter-duration="2" class="purecounter">0</span>
                <p>Lugares</p>
              </div>
            </div><!-- End Stats Item -->

            <div class="col-lg-3 col-6" data-aos="fade-up" data-aos-duration="1500">
              <div class="stats-item text-center w-100 h-100">
                <span data-purecounter-start="0" data-purecounter-end=<?php echo $count_espacios ?> data-purecounter-duration="2" class="purecounter">0</span>
                <p>Espacios</p>
              </div>
            </div><!-- End Stats Item -->

            <div class="col-lg-3 col-6" data-aos="fade-up" data-aos-duration="1500">
              <div class="stats-item text-center w-100 h-100">
                <span data-purecounter-start="0" data-purecounter-end=<?php echo $count_valoraciones ?>  data-purecounter-duration="2" class="purecounter">0</span>
                <p>Valoraciones</p>
              </div>
            </div><!-- End Stats Item -->

          </div>
        </div>

        <div class="col-lg-5 order-1 order-lg-2 hero-img d-flex justify-content-center" data-aos="zoom-out" data-aos-duration="2000">
          <img src="img/primera_index.png" class="img-fluid mb-3 mb-lg-0" alt="">
        </div>

      </div>
    </div>
  </section>

  
  <section class="py-5 el_carrusel" style="height: fit-content;">
        <div id="carouselExampleFade" class="carousel slide carousel-fade h-500px" data-bs-ride="carousel" style="height: fit-content;">
            <div class="carousel-inner" style="height: fit-content;">
                <div class="carousel-item active h-500px" style="height: fit-content;">
                <img src="img/pareja_turismo-transformed.webp" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Las maletas a buen recaudo</h5>
                        <p>Disfruta tus vacaciones sin preocuparte por las maletas en el checkout </p>
                    </div>
                </div>
                <div class="carousel-item" style="height: fit-content;">
<img src="img/maletas_incordio.jpg" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>¿Equipaje incordiando?</h5>
                        <p>¿No sabes donde dejar las maletas?</p>
                    </div>
                    
                </div>
                <div class="carousel-item" style="height: fit-content;">
                    <img src="img/garaje.jpg" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Tu garaje te servirá para ganar dinero</h5>
                        <p>Emplea cualquier espacio vacío de tu hogar para almacenar productos, y gana dinero con ello</p>
                    </div>
                </div>
                <div class="carousel-item" style="height: fit-content;">
                    <img src="img/pareja_maleta.jpg" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>¿Alguien de confianza?</h5>
                        <p>Conoce otros usuarios, y haz amistades nuevas</p>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button> 
        </div>
      </section>
      <section class="sugerencias py-5">
        <?php

        //Saco dirección IP
        $ip = $_SERVER['REMOTE_ADDR'];

        // API con dirección IP
        $url = "http://www.geoplugin.net/json.gp?ip=".$ip;
        
        //Peticion de datos
        $userInfo = file_get_contents($url);
        
        // pasar JSON a array
        $result = json_decode($userInfo,true);
        
        
        //echo "<b>IP Address : </b>".$result['geoplugin_request']."<br>";
        //echo "<b>Ciudad : </b>".$result['geoplugin_city']."<br>";

       
        $ciudad_b=$result['geoplugin_city'];

        if($ciudad_b==""){
          echo "<h2 class='text-center p-3 bg-white rounded m-auto' style='max-width:fit-content;'>Algunas sugerencias:</h2>";
        }else{
          echo "<h2 class='text-center p-3 bg-white rounded m-auto' style='max-width:fit-content;''>Sugerencias para $ciudad_b</h2>";
        }
       
        /*-------------------------------------------*/
        $ciudad_b="%".$ciudad_b."%";

        if($ciudad_b != ""){

            $sent_busqueda_espacio=$conexion->prepare("select usuario.id, lugar.id, lugar.direccion, lugar.cp, lugar.ciudad,
            lugar.texto,lugar.fecha_ad,lugar.foto from lugar,usuario where lugar.id_usuario=usuario.id and
            usuario.estado = 1 and usuario.email != ? and ciudad like ? limit 3");
            $ciudad_b="%".$ciudad_b."%";

            $sent_busqueda_espacio->bind_param("ss",$user,$ciudad_b);
            $sent_busqueda_espacio->bind_result($id_usuario,$id_lugar,$direccion,$cp,$ciudad,$texto,$fecha_ad,$foto);
            $sent_busqueda_espacio->execute();
            $sent_busqueda_espacio->store_result();

            echo "<div class='container py-2'>
                    <div class='row d-flex justify-content-center'>";

            if($sent_busqueda_espacio->num_rows()==0){
                echo "<p>No hay sugerencias para su área</p>";
            }else{
                while($sent_busqueda_espacio->fetch()){
                  $foto=preg_replace("`^[.]{2}/`","",$foto);

                $fecha=formateoFecha($fecha_ad);

                echo "<div data-aos=\"zoom-in\" data-aos-duration=\"1500\" class='col-md-4 '>
                    <div class='card-columns'>
                        <div class='card text-center border border-primary shadow' style='height:304px;'>
                            <div class='bg-image' style='background-color: rgba(251, 251, 251, 0.15)'>
                            <img src='$foto' class='img-fluid foto_sugerencia' style='width:100%; height:200px' />
                                <div class='w-100' '>
                            </div>
                            </a>
                        </div>
                    
                        <div class='card-body'>
                          <form action='pages/lugar.php' method='post'>
                            <h5 class='card-title'>$direccion $cp $ciudad</h5>
                            <input type=text name='id_lugar' value='$id_lugar' hidden>
                            <button type='submit' class='btn btn-primary' name='reservar_espacio'>Reservar</button>
                          </form>  
                        </div>
                    </div>
                  </div>
                  </div>";
                }
            }
        echo "</div>
        </div>"; 

        }

        ?>
      </section>
    </main>

  <?php
    require "pages/footer.php";
  ?>
  <script>
    AOS.init();

    new PureCounter({
      selector: '.purecounter',
      duration: 1,
      delay: 5,
      once: true,
      repeat: false,
      decimals: 0,
      legacy: true,
      filesizing: false,
      currency: false,
      separator: false,
    });
    </script>


</body>
</html>


