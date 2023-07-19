<?php

    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 


    require_once "../functions.php";
    require_once "header.php";

    $user = comprobarUsuario();

    if($user != ""){
        header("location:../index.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="../img/favicon.ico">
    <title>Acceso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../styles/styles.css">
    <!-- Fuente Google encabezados -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@600&display=swap" rel="stylesheet">
    <!-- Fuente Google resto de contenido -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
    <!-- AOS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
</head>
<body>
    <header>
    <?php    
      sacarNav($user,"");
    ?>
    </header>

    <main class="main_acceder mb-5">
        <section class="">
		<div class="container">
			<div class="row justify-content-sm-center">
				<div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9">
					<div data-aos="flip-left" data-aos-duration="1500" class="text-center my-4">
						<img class='logo_web' src="../img/logo_login.png" alt="logo" width="100">
					</div>
					<div class="card shadow-lg" data-aos="fade-down" data-aos-duration="1500">
						<div class="card-body p-5">
							<h1 class="fs-4 card-title fw-bold mb-4">Acceso identificado</h1>
							<form method="post" action="identificacion.php" class="needs-validation" novalidate="" autocomplete="off">
								<div class="mb-3">
									<label class="mb-2 text-muted" for="email">E-Mail usuario</label>
									<input id="email" type="email" class="form-control" name="user" value="" required autofocus>
								</div>

								<div class="mb-3">
									<div class="mb-2 w-100">
										<label class="text-muted" for="password">Contraseña</label>
									</div>
									<input id="password" type="password" class="form-control" name="pass" required>
								</div>

								<div class="d-flex align-items-center">
									<div class="form-check">
										<input type="checkbox" name="guardar" id="guardar" class="form-check-input" value="0">
										<label for="guardar" class="form-check-label">¿Recordarme?</label>
									</div>

									<input type="submit" name="enviar" value="Entrar" class="btn btn-primary ms-auto">
								</div>
							</form>
						</div>
						<div class="card-footer py-3 border-0">
							<div class="text-center">
								¿No tienes cuenta? <a href="registro.php" class="text-dark">Crea una aquí</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

        <?php
            if(isset($comprobante_datos_correctos)){
                if($usuario_correcto==false){
                    echo "<div class='d-flex justify-content-center mt-2'><p class='alert alert-danger' style='display:inline-block;'>Usuario o contraseña incorrectos</p></div>"; 
                }  
                if($usuario_activado==false){
                    echo "<div class='d-flex justify-content-center mt-2'><p class='alert alert-danger' style='display:inline-block;'>El usuario no está activado</p></div>"; 
                } 
                if($usuario_expulsado){
                    echo "<div class='d-flex justify-content-center mt-2'><p class='alert alert-danger' style='display:inline-block;'>El usuario no está disponible</p></div>"; 
                } 
            }
        ?>
	</section>
    </main>
    <?php
        require "./footer.php";
    ?>
        <script>
        AOS.init();
        </script>
</body>
</html>
<div></div>

