<?php
    $sent_totales_web="select count(usuario.id)count_usuario from usuario where usuario.id > 0 and usuario.activado = 1";
    $consulta_totales_web=$conexion->query($sent_totales_web);
    $fila_totales_web=$consulta_totales_web->fetch_array(MYSQLI_ASSOC);
    $count_usuario=$fila_totales_web['count_usuario'];
    
    $sent_totales_web2="select count(lugar.id)count_lugar from lugar where lugar.estado = 1";
    $consulta_totales_web2=$conexion->query($sent_totales_web2);
    $fila_totales_web2=$consulta_totales_web2->fetch_array(MYSQLI_ASSOC);
    $count_lugar=$fila_totales_web2['count_lugar'];

    $sent_totales_web3="select count(espacio.id)count_espacios from espacio where espacio.estado = 1";
    $consulta_totales_web3=$conexion->query($sent_totales_web3);
    $fila_totales_web3=$consulta_totales_web3->fetch_array(MYSQLI_ASSOC);
    $count_espacios=$fila_totales_web3['count_espacios'];

    $sent_totales_web4="select count(valoracion.id)count_valoraciones from valoracion";
    $consulta_totales_web4=$conexion->query($sent_totales_web4);
    $fila_totales_web4=$consulta_totales_web4->fetch_array(MYSQLI_ASSOC);
    $count_valoraciones=$fila_totales_web4['count_valoraciones'];
  ?>