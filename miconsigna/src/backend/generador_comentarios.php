<?php
session_start();
require_once __DIR__ . "/../../conexion.php";
require_once __DIR__ . "/../../functions.php";

const PAGINATE = true;
const PER_PAGE = 4;

if(isset($_GET['idUsuario']) && is_numeric($_GET['idUsuario'])) {
    //Voy a rescaatar los comentarios delusuario recibido, no del logueado
    $identificacion = $_GET['idUsuario'];
}
else {
    $identificacion = dbGetUserId($_SESSION['user']);
}

if(is_null($identificacion)) {
    die("ERROR: No user id");
}

//----------

$query = "SELECT SQL_CALC_FOUND_ROWS valoracion.id_usuario id_val_usu, valoracion.texto texto_val, valoracion.puntuacion puntuacion_val, valoracion.fecha fecha_val
FROM valoracion, reserva, espacio, lugar, usuario
WHERE valoracion.id_reserva = reserva.id
AND reserva.id_espacio = espacio.id
AND espacio.id_lugar = lugar.id
AND lugar.id_usuario = usuario.id
AND usuario.id = ?
ORDER BY fecha_val DESC";

if(PAGINATE) {
    $paginaActual = 1;
    $offset = 0;
    
    if(isset($_GET['page']) && is_numeric($_GET['page'])) {
        $offset = ($_GET['page']-1)*PER_PAGE;
        $paginaActual = $_GET['page'];
    }
    
    $query .= " LIMIT {$offset}," . PER_PAGE;
}


$sent_sacar_comentarios = $conexion->prepare($query);

$sent_sacar_comentarios->bind_param("s", $identificacion);
$sent_sacar_comentarios->bind_result($id_val_usu, $texto_val, $puntuacion_val, $fecha_val);
$sent_sacar_comentarios->execute();
$sent_sacar_comentarios->store_result();

if(PAGINATE) {
    $queryTotal = "SELECT FOUND_ROWS() AS total";
    $res = $conexion->query($queryTotal);
    $row = $res->fetch_object();
    
    $numPaginas = ceil($row->total/PER_PAGE);
    
}

if ($sent_sacar_comentarios->num_rows() == 0) {
    echo "<section class='shadow rounded mt-4 col-md-7 m-auto py-3' style='background-color: #e7effd;'>
            <h3 class='text-center'>No hay comentarios o críticas aún para este usuario</h3>
        </section>";
} else {
    echo "<section class='shadow rounded mt-4 col-md-7 m-auto' style='background-color: #e7effd;'>
        <h2 class='text-center pt-5'>Co<u class='underline'>mentar</u>ios</h2>";

    $filasMostradas = 0;

    while ($sent_sacar_comentarios->fetch()) {
        // if ($filasMostradas < $elementosPorPagina) {
            $fecha_val = formateoFecha($fecha_val);
            //------------
            $sent_datos_comentario = "SELECT distinct usuario.nombre nombre_val, usuario.apellidos apellidos_val, usuario.foto foto_val 
                FROM usuario, valoracion
                WHERE valoracion.id_usuario = usuario.id
                AND valoracion.id_usuario = '$id_val_usu'";
            $consulta_datos_comentario = $conexion->query($sent_datos_comentario);
            //------------

            echo "<div class='container my-5 text-dark'>
                        <div class='row d-flex justify-content-center'>
                        <div class='col-md-9 col-lg-9 col-xl-7'>";
            //--COMENTARIO INDIVIDUAL
            while ($fila_datos_comentario = $consulta_datos_comentario->fetch_array(MYSQLI_ASSOC)) {
                $nombre_val = $fila_datos_comentario['nombre_val'];
                $apellidos_val = $fila_datos_comentario['apellidos_val'];

                echo "<div class='d-flex flex-start mb-4 CUERPO COMENTARIO COMPLETO'>";
                echo "<img class='rounded-circle shadow-1-strong me-3'
                                src='$fila_datos_comentario[foto_val]' alt='avatar' width='65'
                                height='65' />";

                echo "<div class='card w-100'>
                                    <div class='card-body p-4'>
                                        <div class=''>
                                            <h5>$nombre_val $apellidos_val</h5>
                                            <p class='small'>$fecha_val</p>
                                            <p>$texto_val</p>
                                            <div class='d-flex justify-content-between align-items-center'>
                                                <div class='d-flex align-items-center'>
                                                    <a href='javascript:;' class='link-muted me-2'>Nota: $puntuacion_val</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>";
                echo "</div>";
            }
            //--FIN COMENTARIO INDIVIDUAL
            echo "</div>";
            echo "</div>";
            echo "</div>";
        //}
        $filasMostradas++;
    }
    if(PAGINATE) {
        echo "<div class='pagination justify-content-center mt-4'>
        <ul class='pagination'>";
       

        for ($i = 1; $i <= $numPaginas; $i++) {
            echo '<li class="page-item';
            if ($i == $paginaActual) {
                echo ' active';
            }
            echo '"><a class="page-link" href="javascript:;" data-page="'. $i . '">' . $i . '</a></li>';
        } 
        echo "</ul></div>";

    }   
       
    echo "<section>";
    $sent_sacar_comentarios->close();

}
?>
<script>
 $('.page-link').click(function(e) {
    console.log(e);
    loadComments($(this).data('page'));
});
</script>
<?php
$conexion->close();