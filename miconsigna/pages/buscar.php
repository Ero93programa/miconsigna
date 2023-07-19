<?php
    session_start(); 
    
    if(isset($_POST['logout'])){
        setcookie('sesion',"",time()-3600,'/');
        session_destroy();
        header ("location: buscar.php");
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
    <title>Buscar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="../styles/styles.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
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
<body>
    <header>
    <?php    
      sacarNav($user,"");
    ?>
    </header>

    <main class="main_buscador">
    <section class="section_buscador">
        <div class="section-header">
            <h2>Buscar</h2>
        </div>
        <div data-aos="fade-up" class="d-flex justify-content-center h-100 search py-5 m-auto rounded shadow div_buscar">
            <div  class="form-container ">
                <form action="lista_espacios.php" method="post" class="">
                    <div class="d-flex justify-content-center flex-wrap mb-3 input-container">
                        <input class="p-2 form-control input-direccion" type="text" name="direccion" placeholder="Ciudad, localidad o código postal..." style="width:270px;">
                        <button class="p-2 btn btn-primary m-2 p-2 btn-buscar" type="submit" name="buscar_completo"><i class="fa fa-search"></i></button>
                    </div>
                    <div class="d-flex justify-content-center flex-column mt-2">
                        <div class="text-center">
                            <label for="">Min. valoración propietarios:</label> 
                            <input type="checkbox" id="con_valoracion" name="con_valoracion" value="0">                              
                        </div>
                        <div class="d-flex align-items-center m-auto">
                            <span style="font-weight: bold; margin-right: 10px;">0</span>
                            <input type="range" id="txtValProp" name="valoracion_propietario" min="0" max="4" value="4" class="form-range" >
                            <span id="txtRangeSelected" style="font-weight: bold; margin-left: 10px;">4</span>
                        </div>
                    </div>  
                </form>
            </div>  
        </div>    
    </section>
</main>


    <?php
        require "./footer.php";
    ?>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <script>
        $(function(e) {
            $('#txtValProp').on('change', function(e) {
                let newVal = $(this).val();
                $('#txtRangeSelected').text(newVal);
            });
        });

        AOS.init();

    </script>
</body>
</html>
