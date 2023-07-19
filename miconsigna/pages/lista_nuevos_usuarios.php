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
    <title>Nuevos espacios</title>
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
    <main class="main_nuevos_usuarios">
        <section class="section_usuarios">
        <div class="section-header">
            <img src="../img/icono_persona_nueva.png" alt="" style="width:75pxx; height:50px">
            <h2>NUEVOS USUARIOS</h2>
        </div>

        <div class="container py-4 rounded shadow" style="background-color: aliceblue;">
        <div class="row">
            <div class="col-md-12">

        <?php
        require_once "../conexion.php";
       
        $sent_all_usu="select id,apellidos,nombre,email,dni,telefono,fecha_nac from usuario where id>0 and activado=0";
        $consulta_all_usu=$conexion->query($sent_all_usu);
        
        echo "<table id='myTable' class='table table-striped display responsive nowrap tabla_usuarios' style='width:100%'>
            <thead>
                <tr>
                    <th>Apellidos</th> 
                    <th>Nombre</th>
                    <th>Correo electrónico</th> 
                    <th>DNI</th>
                    <th>Telefono</th>
                    <th>Fecha nacimiento</th> 
                    <th>Acción</th> 
                </tr>            
            </thead><tbody>";      
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
                    <td class=\"d-flex text-center\">
                        <form action='validacion.php' method='post'>
                            <input type=\"text\" value=\"$fila_all_usu[id]\" name=\"id_usuario\" hidden>
                            <button type='submit' class='validadores btn btn-link' name='validar' title=\"Validar a $fila_all_usu[nombre]\"/>
                                <i class='far fas fa-check text-success'></i>
                            </button>                            
                        </form>
                        <form action='eliminacion.php' method='post'>
                            <input type=\"text\" value=\"$fila_all_usu[id]\" name=\"id_usuario\" hidden>
                            <button type='submit' class='eliminadores btn btn-link' name='eliminar_usuario' title=\"Eliminar a $fila_all_usu[nombre]\"/>
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
        const validadores=document.querySelectorAll(".validadores");
        const eliminadores=document.querySelectorAll(".eliminadores");

        validadores.forEach(validador=>{
            validador.addEventListener("click", (evento)=>{
                if(!confirm("Vas a validar este usuario, ¿Estás seguro?")){
                evento.preventDefault();
            }     
            })
        })
        eliminadores.forEach(eliminador=>{
            eliminador.addEventListener("click", (evento)=>{
                if(!confirm("Vas a eliminar este usuario, ¿Estás seguro?")){
                evento.preventDefault();
            }     
            })
        })
    </script>
    <?php
        require "./footer.php";
    ?>
</body>
</html>

