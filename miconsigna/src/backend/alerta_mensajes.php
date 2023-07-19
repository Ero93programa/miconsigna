
<?php
    $sent_mensj_nuevos = "select mensaje.id from mensaje where id_receptor = $identificacion and leido = 0";
    $consulta_mensj_nuevos = $conexion->query($sent_mensj_nuevos);

    $numero_menj_nuevos = $consulta_mensj_nuevos->num_rows;

    if ($numero_menj_nuevos >= 1) {
        echo "<div class=\"btn-container-mensj_nuevos\">
                <button class=\"shadow zoom\" id='btn_mensj_nuevos' onclick=\"location.href='mensajes.php'\" type=\"button\" title=\"Tienes mensajes sin abrir\">
                    <ion-icon name=\"mail-unread-outline\" data-count=\"8\" style=\"zoom:1.3;\"></ion-icon>
                </button>
                <span class=\"menj_nuevos\">$numero_menj_nuevos</span>
            </div>";
    }
?>

<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
