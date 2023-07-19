<?php
if(!isset($_SESSION)) {
    session_start();
}
    if(isset($_POST['logout'])){
        session_destroy();
        echo "<meta http-equiv='refresh' content='0' url='#'>";
    }

    require_once "../functions.php";
    require_once "../conexion.php";

if(isset($_POST['add_lugar'])) {

    $direccion_nueva=$_POST['direccion_nueva'];
    $direccion_nueva=trim($direccion_nueva);

    $codpostal_nuevo=$_POST['codpostal_nuevo'];
    $codpostal_nuevo=trim($codpostal_nuevo);

    $ciudad_nueva=$_POST['ciudad_nueva'];
    $ciudad_nueva=trim($ciudad_nueva);

    $text_info_nueva=$_POST['text_info_nueva'];
    $text_info_nueva=trim($text_info_nueva);

    $identificacion=$_POST['identificacion'];

    $fecha_hoy=$_POST['fecha_hoy'];

    /*--------------*/

    if(isset($_FILES['foto_lugar_nueva'])) {
        $name=$_FILES['foto_lugar_nueva']['name'];
        $temp=$_FILES['foto_lugar_nueva']['tmp_name'];
        $tipos=$_FILES['foto_lugar_nueva']['type'];
        $tamano=$_FILES['foto_lugar_nueva']['size'];

        //Comprobacion archivo imagen

        $img_correcta=true;

        if($name != "") {
            if(!file_exists("../img_lugar")){
                mkdir("../img_lugar");
            }
            $ruta;
            $tamano_mb=$tamano/(1024*1024);

            if($tipos=="image/png" || $tipos=="image/jpeg" || $tipos=="image/gif") {
                if($tamano_mb<2) {
                    switch ($tipos) {
                        case 'image/png':
                            $ruta="../img_lugar/$identificacion.png";
                            break;
                        case 'image/jpeg':
                            $ruta="../img_lugar/$identificacion.png";
                            break;
                        case 'image/gif':
                            $ruta="../img_lugar/$identificacion.gif";
                            break;
                    }
                    move_uploaded_file($temp, $ruta);
                }
            } else {
                echo "<p style=\"color:#FF0000\">*Error: Tipo de imagen incorrecto</p>";
            }
        }else{
            $ruta = $_POST['foto_lugar_recibida'];
        }
    }
        /*--------------*/

        if(empty($direccion_nueva)||empty($codpostal_nuevo)||empty($ciudad_nueva)) {
            $campos_vacios=true;
        }else{
            $cero=0;

            $sent_add_lugar=$conexion->prepare("insert into lugar (id,direccion,cp,ciudad,texto,fecha_ad,id_usuario,foto) values (null,?,?,?,?,?,?,?)");
            $sent_add_lugar->bind_param("sisssis",$direccion_nueva,$codpostal_nuevo,$ciudad_nueva,$text_info_nueva,$fecha_hoy,
            $identificacion,$ruta);
            $sent_add_lugar->execute();
            $sent_add_lugar->close();  
        }

        echo "$direccion_nueva $codpostal_nuevo $ruta";
        
        echo "<meta http-equiv=\"refresh\"
            content=\"0; url=perfil_usuario.php\">";

}
?>