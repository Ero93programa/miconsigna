
<?php
    $hoy = new DateTime();
    $hoy = $hoy->format('Y-m-d');
    $sent_comentarios_pendientes = "select reserva.id from reserva where id_usuario = $identificacion and estado = 1 and comentado = 0 and reserva.fecha_fin < $hoy";
    $consulta_comentarios_pendientes = $conexion->query($sent_comentarios_pendientes);

    $numero_comentarios_pendientes = $consulta_comentarios_pendientes->num_rows;

    if ($numero_comentarios_pendientes >= 1) {
        echo "<div class=\"btn-container-val-pendientes\">
                <button class=\"shadow zoom my-button\" id='btn_val_pendientes' onclick=\"location.href='comentarios_pendientes.php'\" type=\"button\" title=\"Tienes valoraciones pendientes\">
                    <span class=\"material-symbols-outlined\">
                    rate_review
                    </span>
                </button>
                <span class=\"comentarios_pendientes\">$numero_comentarios_pendientes</span>
            </div>";
    }
?>

