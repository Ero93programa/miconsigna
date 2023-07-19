<?php
    session_start(); 
     
    if(isset($_POST['logout'])){
      setcookie('sesion',"",time()-3600,'/');
      session_destroy();
      header ("location: ../index.php");
    }

    require_once "../functions.php";
    require_once "header.php";
    require_once "../conexion.php";

    $user = comprobarUsuario();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="../img/favicon.ico">
    <title>Búsqueda</title>
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

    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
    </script>
</head>
<body>
    <header>
    <?php    
      sacarNav($user,"");
    ?>  
    </header>
    <main class="main_lista_espacios">
        <section>
        <div class="section-header">
                <img src="" alt="">
                <h2>Resultados</h2>
            </div>
          <div class="container py-3 rounded shadow" style="background-color: aliceblue;">
          <div class="row mt-5">
              <div class="col-md-12 " style="background-color: aliceblue;">
                <table id='myTable' class='table table-striped display responsive nowrap tabla_resultados' style='width:100%;'>
                        <thead>
                          <tr>
                            <th data-priority='2'></th>
                            <th data-priority='1'>Lugar</th>
                            <th class="text-center">Añadido</th>
                            <th class="text-center">Propietario</th>                   
                            <th class='action text-center'>Acciones</th>      
                          </tr>
                        </thead>
                        <tbody>

        <?php 
        
if(isset($_POST['buscar']) || !isset($_POST['con_valoracion'])) {

    $direccion_b=$_POST['direccion'];

    if(empty(trim($direccion_b))||!isset($direccion_b)) {
      echo "<script>window.location.href='../index.php'</script>";
    }

    echo 'Resultados para: ' .'"'.$direccion_b.'"<br>';

    $sent_busqueda_espacio=$conexion->prepare("select usuario.id,usuario.nombre,usuario.apellidos,usuario.email correo_prop,
    lugar.id,lugar.direccion,lugar.ciudad,lugar.cp,lugar.texto,lugar.foto,lugar.fecha_ad from lugar,usuario 
    where lugar.id_usuario=usuario.id and lugar.estado = 1 and (ciudad like ? or cp like ?)order by fecha_ad desc");
    

    //Si se envía un código postal, se reduce a las dos primeras cifras para buscar similares
    if(is_numeric($direccion_b)){
      $direccion_b=substr($direccion_b, 0, 2);
      $direccion_b=$direccion_b."%";
    }else{
      $direccion_b="%".$direccion_b."%";
    }

    $sent_busqueda_espacio->bind_param("ss", $direccion_b,$direccion_b);
    $sent_busqueda_espacio->bind_result($id_usuario, $nombre, $apellidos, $correo_prop, $id_lugar, $direccion, $ciudad, $cod_post, $texto, $foto, $fecha_ad);
    $sent_busqueda_espacio->execute();
    $sent_busqueda_espacio->store_result();

    if($sent_busqueda_espacio->num_rows()==0) {
        echo "No se han hallado resultados";
    //header( "refresh:5;url=../index.php" );
    } else {
        while($sent_busqueda_espacio->fetch()) {

            $fecha_ad=formateoFecha($fecha_ad);

            $acortado_nombre=$nombre[0]. '.';
            $acortado_apellido=$apellidos[0]. '.';
            echo "<tr class='candidates-list'>
                        <td> 
                          <div class='thumb w-25'>
                            <img class='img-fluid' src='$foto' alt=''>
                          </div>
                        </td>
                        <td class='title'>    
                          <div class='candidate-list-details'>
                            <div class='candidate-list-info'>
                              <div class='candidate-list-title'>
                                <h5 class='mb-0 text-primary'>$direccion</h5>
                              </div>
                              <div class='candidate-list-option mt-2'>
                                <ul class='list-unstyled'>
                                  <li><p><b>$ciudad</b> $cod_post</p></li>
                                </ul>
                              </div>
                            </div>
                          </div>
                        </td>
                        <td class='text-center'>
                        
                            <span class='candidate-list-time order-1'>$fecha_ad</span>
                        </td>
                        <td class='candidate-list-favourite-time text-center'> 
                            <form method=\"post\" action='perfil_usuario.php'>
                                <input type='text' value=$id_usuario name='id_usuario' hidden>
                                <input type='text' value=$correo_prop name='correo_prop' hidden>";
                                if($user==='admin' || $user!="" ) {
                                    echo "<input type='submit' class='mask rounded' style='color:white; background-color:#0a2261' name='ver' value='$acortado_nombre $acortado_apellido'>";
                                }else{
                                    echo "<input type='submit' class='mask rounded' value='$acortado_nombre $acortado_apellido' disabled>";
                                }
                            echo "</form>";          
                        echo "</td>";
                        echo "<td class='text-center'>";
                        if($user!='admin' && $user!=$correo_prop && $user!="") {
                            echo "<form action='lugar.php' method='post'>
                                <input type='text' value='$id_lugar' name='id_lugar' hidden>
                                <input type='submit' class='mask rounded' style='color:white; background-color:#0a2261' name='reservar_espacio' value='Reservar espacio'/>
                            </form>";
                        }
                        if($user==""){
                          echo "<button' class='rounded btn btn-warning text-white '>
                                <a class=\"text-decoration-none\" href=\"registro.php\">Regístrate</a>
                                </button>";
                        }

      
                      echo " </td></tr>";
            }
        }

   /*----------------------------BUSQUEDA COMPLETA----------------------------------*/     

}elseif(isset($_POST['buscar_completo'])){
    
      $direccion_b=$_POST['direccion'];
      $valoracion_propietario=$_POST['valoracion_propietario'];
      $nomios=isset($_POST['no_mios']);

      if(empty(trim($direccion_b))||!isset($direccion_b)) {
        echo "<script>window.location.href='../index.php'</script>";
      }

      echo 'Resultados para: ' .'"'.$direccion_b.'"<br>';

    $query = "
      SELECT
      u.id, u.nombre, u.apellidos, u.email, l.id, l.direccion, l.cp, l.ciudad, l.texto, l.foto, l.fecha_ad
    FROM
      lugar l 
        INNER JOIN
      espacio e
        ON
      l.id=e.id_lugar
        INNER JOIN
      reserva r
        ON
      e.id=r.id_espacio
        INNER JOIN
      valoracion v
        ON
      r.id=v.id_reserva
        INNER JOIN
      usuario u
        ON
      l.id_usuario=u.id
    WHERE
      l.ciudad LIKE ?
      or l.cp LIKE ?
    GROUP BY
      l.id
    HAVING
      AVG(v.puntuacion) >= ? ";
      $sent_busqueda_espacio=$conexion->prepare($query);
      
      //Si se envía un código postal, se reduce a las dos primeras cifras para buscar similares
      if(is_numeric($direccion_b)){
        $direccion_b=substr($direccion_b, 0, 2);
        $direccion_b=$direccion_b."%";
      }else{
        $direccion_b="%".$direccion_b."%";
      }

    
      $sent_busqueda_espacio->bind_param("ssi", $direccion_b, $direccion_b, $valoracion_propietario);
 
    $sent_busqueda_espacio->bind_result($id_usuario, $nombre, $apellidos, $correo_prop, $id_lugar, $direccion, $ciudad, $cod_post, $texto, $foto, $fecha_ad);
    $sent_busqueda_espacio->execute();
    $sent_busqueda_espacio->store_result();

    if($sent_busqueda_espacio->num_rows()==0) {
        echo "No se han hallado resultados";
    //header( "refresh:5;url=../index.php" );
    } else {
        while($sent_busqueda_espacio->fetch()) {

          $fecha_ad=formateoFecha($fecha_ad);
          $acortado_nombre=$nombre[0]. '.';
          $acortado_apellido=$apellidos[0]. '.';

          echo "<tr class='candidates-list'>
                      <td> 
                        <div class='thumb'>
                          <img class='img-fluid' src='$foto' alt=''>
                        </div>
                      </td>
                      <td class='title'>    
                        <div class='candidate-list-details'>
                          <div class='candidate-list-info'>
                            <div class='candidate-list-title'>
                              <h5 class='mb-0'><a href='#'>$direccion</a></h5>
                            </div>
                            <div class='candidate-list-option mt-2'>
                              <ul class='list-unstyled'>
                                <li><p><b>$ciudad</b> $cod_post</p></li>
                              </ul>
                            </div>
                          </div>
                        </div>
                      </td>
                      <td class='text-center'>
                      
                          <span class='candidate-list-time order-1'>$fecha_ad</span>
                      </td>
                      <td class='candidate-list-favourite-time text-center'> 
                          <form method=\"post\" action='perfil_usuario.php'>
                              <input type='text' value=$id_usuario name='id_usuario' hidden>
                              <input type='text' value=$correo_prop name='correo_prop' hidden>";
                              if($user==='admin' || $user!="" ) {
                                  echo "<input type='submit' class='mask rounded' style='color:white; background-color:#0a2261' name='ver' value='$acortado_nombre $acortado_apellido'>";
                              }else{
                                  echo "<input type='submit' class='mask rounded' value='$acortado_nombre $acortado_apellido' disabled>";
                              }
                          echo "</form>";          
                      echo "</td>";
                      echo "<td class='text-center'>";
                      if($user!='admin' && $user!=$correo_prop && $user!="") {
                          echo "<form action='lugar.php' method='post'>
                              <input type='text' value='$id_lugar' name='id_lugar' hidden>
                              <input type='submit' class='mask rounded' style='color:white; background-color:#0a2261' name='reservar_espacio' value='Reservar espacio'/>
                          </form>";
                      }
                      if($user==""){
                        echo "<button' class='rounded btn btn-warning text-white '>
                              <a class=\"text-decoration-none\" href=\"registro.php\">Regístrate</a>
                              </button>";
                      }
                    echo " </td></tr>";
          }
        }
      
    
  }else{
        echo "<meta http-equiv='refresh' content='0; url=../index.php'>";
    }
                ?>
  
                    </tbody>
                  </table>
                  </div>
                </div>
            </div>      
        </section>
    </main>
    <?php
        require "./footer.php";
    ?>
</body>
</html>