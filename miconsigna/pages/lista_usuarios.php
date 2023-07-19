<?php
    session_start(); 
    
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
    <title>Usuarios</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>   
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">
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
<body>
    <header>
        <?php    
            sacarNav($user,"");
        ?>  
    </header>
    <main class="main_usuarios">
        <section class="section_usuarios">
        <div class="section-header">
            <img src="../img/icono_persona.png" alt="" style="width:75pxx; height:50px">
            <h2>TOTAL USUARIOS</h2>
        </div>
            <div class="container py-4 rounded shadow" style="background-color: aliceblue;">
                <div class="row">
                    <div class="col-md-12">
        <?php
        require_once "../conexion.php";
       
        echo "<table id='myTable' class='table table-striped display responsive nowrap tabla_usuarios' style='width:100%'>
                <thead>
                    <tr>
                        <th>Apellidos</th> 
                        <th>Nombre</th>
                        <th>Correo electrónico</th> 
                        <th>DNI</th> 
                        <th>Telefono</th>
                        <th>Fecha nacimiento</th>     
                        <th>Ver</th> 
                        <th>Liberar</th> 
                        <th>Penalizar</th> 
                    </tr>
                </thead><tbody>";
    
        $sent_all_usu="select id,apellidos,nombre,email,dni,telefono,fecha_nac,estado,penalizacion from usuario where id>0 and activado=1";
        $consulta_all_usu=$conexion->query($sent_all_usu);
        
     
        while($fila_all_usu=$consulta_all_usu->fetch_array(MYSQLI_ASSOC)){
            $fecha=formateoFecha($fila_all_usu['fecha_nac']);
            $id_usuario=$fila_all_usu['id'];

            echo "<tr>
                    <td>$fila_all_usu[apellidos]</td>
                    <td>$fila_all_usu[nombre]</td>
                    <td>$fila_all_usu[email]</td>
                    <td>$fila_all_usu[dni]</td>
                    <td>$fila_all_usu[telefono]</td>
                    <td>$fecha</td>
                    <td class='text-center'>
                            <form method=\"post\" action=\"perfil_usuario.php\">
                                <input type=\"text\" value=\"$fila_all_usu[id]\" name=\"id_usuario\" hidden>
                                <input type=\"text\" value='$fila_all_usu[email]' name='correo_prop' hidden>                         
                                <button type='submit' class='btn btn-link' name='ver'/>
                                    <i class='fa fa-eye text-primary'></i>
                                </button> 
                            </form>
                    </td>
                    <td class='text-center'>";

                        if($fila_all_usu['estado']==0 && $fila_all_usu['penalizacion']<=2){
                            echo "<form method=\"post\" action=\"sist_penalizacion.php\">
                                    <input type=\"text\" value=\"$fila_all_usu[id]\" name=\"id_usuario\" hidden>
                                    <button type='submit' class='btn btn-link text-center liberadores' name='liberar' title=\"Liberar a $fila_all_usu[nombre]\"/>
                                        <img src='../img/tarjeta_azul.svg' alt=''>
                                    </button></form>";
                        }

                        if($fila_all_usu['penalizacion']==3){
                            echo "<button class='btn btn-link'><i class='fas fa-ban btn btn-link' style='color: #c02121;'></i></button>";
                        }

                    echo "</td>
                    <td>";
                        
                    if($fila_all_usu['estado']==1){
                        echo "<form method=\"post\" action=\"sist_penalizacion.php\">
                            <input type=\"text\" value=\"$fila_all_usu[id]\" name=\"id_usuario\" hidden>
                            <input type=\"text\" value=\"$fila_all_usu[estado]\" name=\"estado_usuario\" hidden>
                            <button type='submit' class='btn btn-link d-flex justify-content-center penalizadores' name='penalizar' title=\"Penalizar a $fila_all_usu[nombre]\"/>";
                            
                            if($fila_all_usu['penalizacion']==0){
                                echo "<img src='../img/tarjeta_amarilla.svg' alt=''>";
                            }elseif($fila_all_usu['penalizacion']==1){
                                echo "<img src='../img/tarjeta_roja.svg' alt=''>";
                            }elseif($fila_all_usu['penalizacion']==2){
                                echo "<img src='../img/tarjeta_negra.svg' alt=''>";
                            }
                            echo "</button></form>";  
                    }else{
                        if($fila_all_usu['penalizacion']==3){
                            echo "<button class='btn btn-link'><i class='fas fa-ban btn btn-link' style='color: #c02121;'></i></button>";
                        }
                    }
                    echo "</td></tr>";          
        }
        echo"</tbody></table>";


        ?>

                    </div>
                </div>
            </div>
        </section>
    </main>
    <?php
        require "footer.php";
    ?>
    <script>
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }

        const liberadores=document.querySelectorAll(".liberadores");
        const penalizadores=document.querySelectorAll(".penalizadores");


        liberadores.forEach(liberador=>{
            liberador.addEventListener("click", (evento)=>{
                if(!confirm("Vas a liberar este usuario, ¿Estás seguro?")){
                evento.preventDefault();
            }     
            })
        })

        penalizadores.forEach(penalizador=>{
            penalizador.addEventListener("click", (evento)=>{
                if(!confirm("Vas a penalizar este usuario, ¿Estás seguro?")){
                evento.preventDefault();
            }     
            })
        })
    </script>
    
</body>
</html>


