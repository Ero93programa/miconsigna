<?php
    if(!isset($_SESSION)) {
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
    <title>Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <!-- Estilos -->
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
<body class='body_registro'>
<header>
    <?php    
      sacarNav($user,"");
    ?>       
</header>
    <main class='main_registro'>
    <div data-aos="fade-down" class="container register">
                <div class="row">
                    <div class="col-md-3 register-left">
                        <img src="../img/icono_registro.svg" alt=""/>
                        <h3>¡Bienvenido!</h3>
                        <p>Estás a un paso de disfrutar todos los servicios</p>
                        <a href="acceder.php">
                            <input type="submit" name="" value="Acceso"/><br/>
                        </a>
                    </div>
                    <div class="col-md-9 register-right">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <h3 class="register-heading">Registra tu perfil</h3>
                                <form action="add_usuario.php" method="post">
                                <div class="row register-form">                                                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Nombre *" name="nombre" value="" />
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Apellidos *" name="apellidos" value="" />
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control" placeholder="Contraseña *" name="pass" value="" />
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control"  placeholder="Confirma tu contraseña *" name="pass2" value="" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="email" class="form-control" placeholder="Correo electrónico *" name="correo" value="" />
                                        </div>
                                        <div class="form-group">
                                            <input type="text" minlength="9" maxlength="9" name="telefono" class="form-control" placeholder="Teléfono *" name="telefono" value="" />
                                        </div>
                                        <div class="form-group">
                                            <!-- <input type="date" name="" class="form-control" placeholder="Fecha de nacimiento *" value="" /> -->
                                            <input class="form-control input100"  type="text" name="f_nac" placeholder="Fecha de Nacimiento *" onclick="ocultarError();" onfocus="(this.type='date')" onblur="(this.type='text')">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="DNI (números+letra) *" name="dni" value="" />
                                        </div>
                                        <input type="submit" class="btnRegister" name="registrarse" value="Registrarse"/>
                                    </div>
                                    </form>
                                    <?php

                                    if(isset($_POST['registrarse'])){

                                        if($campos_vacios){
                                            echo "<p class='alert alert-danger mt-2'>*Error: Han de rellenarse todos los campos</p>"; 
                                        }

                                        if($menor){
                                            echo "<p class='alert alert-danger mt-2'>*Error: El usuario no puede ser menor de edad</p>"; 
                                        }

                                        if($repetido){
                                            echo "<p class='alert alert-danger mt-2'>*Error: Ya hay un usuario con el mismo DNI y/o correo electrónico</p>"; 
                                        }

                                        if($contraseña_diferente){
                                            echo "<p class='alert alert-danger mt-2'>*Error: Las contraseñas no coinciden</p>"; 
                                        }

                                        if($terminado){
                                            echo "<p class='alert alert-success mt-2'>Registro exitoso. Espere su aprobación por el administrador</p>"; 
                                        }     
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>        
    </main>
    <?php
        require "./footer.php";
    ?>
    <script>
        AOS.init();
    </script>
</body>
</html>
