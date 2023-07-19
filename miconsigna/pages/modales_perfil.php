
    <!-- Modal denuncia - animado-->
    <div id="modal_denuncia" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <!--      Para centrado-->
    <div class="modal-dialog modal-dialog-centered" role="document">  

    <!--  <div class="modal-dialog" role="document">-->
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Informar a un moderador</h5>
            <button type="button" class="close2 btn-close" data-dismiss="modal" aria-label="Close">
            
            </button>
        </div>
        <form action="" method='post'>
        <input type='text' hidden value=<?php $identificacion ?> >  
        <div class="modal-body">
                <div class="modal-body">
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">¿Algún problema con este perfil? Haz aquí tu denuncia:</label>
                    <textarea class="form-control rounded-0 mt-2" id="exampleFormControlTextarea1" rows="10"></textarea>
                </div>
        </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary close2" data-dismiss="modal">Cancelar</button>
            <button type="submit" name='denunciar' class="btn btn-danger">Denunciar</button>
        </form> 
        </div>
        </div>
    </div>
    </div>

    <!-- Modal modificar perfil --->
    <div id="modal_modificacion" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <!--      Para centrado-->
    <div class="modal-dialog modal-dialog-centered" role="document">  

    <!--  <div class="modal-dialog" role="document">-->
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Introduce o cambia los datos del perfil</h5>
            <button type="button" class="close2 btn-close" data-dismiss="modal" aria-label="Close">
            
            </button>
        </div>
        <form action="modificacion_perfil.php" method='post' enctype='multipart/form-data'>
            <div class="modal-body">
                <div class="form-group">
                    <label for="exampleInputName">Nombre:</label>
                    <input type="text" class="form-control" name='nombre_nuevo' id="exampleInputName" value='<?php echo $nombre ?>'>
                </div>
                <div class="form-group">
                    <label for="exampleInputSurname">Apellidos:</label>
                    <input type="text" class="form-control" name='apellidos_nuevos' id="exampleInputSurname" value='<?php echo $apellidos ?>'>
                </div>    
                <div class="form-group">
                    <label for="exampleInputDate">Fecha de nacimiento</label>
                    <input type="date" class="form-control" name='fecha_nac_nueva' id="exampleInputDate" value='<?php echo $fecha_nac ?>'>
                </div>
                <div class="form-group">
                    <label for="exampleInputCellphone">Teléfono:</label>
                    <input type="text" class="form-control" name='telefono_nuevo' id="exampleInputCellphone" value='<?php echo $telefono ?>''>
                </div>
                <div class="form-group">
                    <label for="pass_usuario">Contraseña:</label>
                    <input type="password" class="form-control" name="pass_nueva" value="" placeholder="Introduce tu nueva contraseña">
                    <br>
                    <input type="password" class="form-control" name="pass_nueva2" value="" placeholder="Introdúcela otra vez">
                    <input hidden name="pass_original" value='<?php echo $pass_recibido ?>'>
                </div>  
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Descripcion:</label>
                    <textarea class="form-control rounded-0 mt-2" name='descripcion_nueva' id="exampleFormControlTextarea1" rows="10"><?php echo $descripcion ?></textarea>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Foto de perfil(< 2mb):</label>
                    <input type='file'name='foto_nueva'>
                    <input hidden value=<?php echo $foto ?> name='foto_recibida'>
                </div>
            </div>
        <div class="modal-footer">
            <input type='text' name='dni' hidden value=<?php echo $dni ?>>
            <input type='text' name='identificacion' hidden value=<?php echo $identificacion ?>>

            <button type="button" class="btn btn-secondary close2" data-dismiss="modal">Cancelar</button>
            <button type="submit" name='modificar' class="btn btn-warning">Actualizar</button>
        </div>
        </form> 
        </div>
    </div>
    </div>


    <!-- Modal AÑADIR LUGAR --->
    <div id="modal_add_lugar" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <!--      Para centrado-->
    <div class="modal-dialog modal-dialog-centered" role="document">  

    <!--  <div class="modal-dialog" role="document">-->
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Añade un nuevo lugar a tu lista:</h5>
            <button type="button" class="close2 btn-close" data-dismiss="modal" aria-label="Close">
            </button>
        </div>
        <form action="add_lugar.php" method='post' enctype='multipart/form-data'>
            <div class="modal-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">Dirección:</label>
                    <input type="text" class="form-control" name='direccion_nueva' id="exampleInputAddress" value=''>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Código Postal:</label>
                    <input type="text" class="form-control" name='codpostal_nuevo' id="exampleInputcodpost" value=''>
                </div>    
                <div class="form-group">
                    <label for="exampleInputEmail1">Ciudad:</label>
                    <input type="text" class="form-control" name='ciudad_nueva' id="exampleInputCity" value=''>
                </div>    
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Texto informativo:</label>
                    <textarea class="form-control rounded-0 mt-2" name='text_info_nueva' id="exampleFormControlTextarea2" rows="10"></textarea>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Foto del lugar(< 2mb):</label>
                    <input type='file'name='foto_lugar_nueva'>
                    <input hidden value=<?php echo $foto ?> name='foto_lugar_recibida'>

                </div>
            </div>
        <div class="modal-footer">
            <input type='text' name='identificacion' hidden value=<?php echo $identificacion ?>>
            <?php $fecha_hoy=date('Y-m-d') ?>
            <input type='date' name='fecha_hoy' hidden value=<?php echo $fecha_hoy ?>>

            <button type="button" class="btn btn-secondary close2" data-dismiss="modal">Cancelar</button>
            <button type="submit" name='add_lugar' class="btn btn-warning">Añadir</button>
            <?php
                if(isset($repetido)){
                    if($repetido==true){
                        echo "<div class='d-flex justify-content-center mt-2'><p class='alert alert-danger' style='display:inline-block;'>Usuario o contraseña incorrectos</p></div>"; 
                    }  
                }
            ?>
        </div>
        </form> 
        </div>
    </div>
    </div>

<!-- -----------------------MODAL AÑADIR ESPACIO------------------------ -->


    <!-- Modal AÑADIR ESPACIO --->
    <div id="modal_add_espacio" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <!--      Para centrado-->
    <div class="modal-dialog modal-dialog-centered" role="document">  

    <!--  <div class="modal-dialog" role="document">-->
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Elige lugar para añadir un espacio:</h5>
            <button type="button" class="close2 btn-close" data-dismiss="modal" aria-label="Close">
            </button>
        </div>
        <form action="add_espacio.php" method='post' enctype='multipart/form-data'>
            <div class="modal-body">
                <div class="form-group">
                    <label for="lugar_espacio">Lugar:</label>
                    <select name="lugar_espacio">
                        <?php 
                            $sent_lugar="select lugar.id,direccion from lugar,usuario 
                            where lugar.id_usuario = usuario.id and usuario.id=$identificacion and lugar.estado = 1";
                            $consulta_lugar=$conexion->query($sent_lugar);
                            
                            while($fila_lugar=$consulta_lugar->fetch_array(MYSQLI_ASSOC)){
                                $id_fila=$fila_lugar['id'];
                                $direccion_fila=$fila_lugar['direccion'];
                                echo "<option value='$id_fila'>$direccion_fila</option>";
                            }
                        ?>
                    </select>
                </div>
                <br>
                <div class="form-group">
                    <label for="exampleInputEmail1">Texto:</label>
                    <input type="text" class="form-control" name='texto_espacio' id="exampleInputText" value=''>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Precio:</label>
                    <input type="number" class="form-control" name='precio_espacio' id="exampleInputPrice" value=''>
                </div>
            </div>
        <div class="modal-footer">
            <input type='text' name='identificacion' hidden value=<?php echo $identificacion ?>>
            <?php $fecha_hoy=date('Y-m-d') ?>
            <input type='date' name='fecha_hoy' hidden value=<?php echo $fecha_hoy ?>>

            <button type="button" class="btn btn-secondary close2" data-dismiss="modal">Cancelar</button>
            <button type="submit" name='add_espacio' class="btn btn-warning">Añadir</button>
        </div>
        </form> 
        </div>
    </div>
    </div>

<!-- -----------------------MODAL AÑADIR MENSAJE------------------------ -->

    <!-- Modal AÑADIR MENSAJE - animado-->
    <div id="modal_add_mensaje" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <!--      Para centrado-->
    <div class="modal-dialog modal-dialog-centered" role="document">  

    <!--  <div class="modal-dialog" role="document">-->
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Escribe tu mensaje:</h5>
            <button type="button" class="close2 btn-close" data-dismiss="modal" aria-label="Close">
            </button>
        </div>
        <form action="add_mensaje.php" method='post' enctype='multipart/form-data'>
            <div class="modal-body">
                <div class="form-group">
                    <label for="exampleInputAsunto">Asunto:</label>
                    <input type="text" class="form-control" name='asunto' id="exampleInputAsunto" value='' required>
                </div>    
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Mensaje:</label>
                    <textarea class="form-control rounded-0 mt-2" name='mensaje' id="exampleFormControlMensaje" rows="10" required></textarea>
                </div>
        <div class="modal-footer">
            <input type='text' name='identificacion' hidden value=<?php echo $identificacion ?>>
            <?php $fecha_hoy=date('Y-m-d') ?>
            <input type='date' name='fecha_hoy' hidden value=<?php echo $fecha_hoy ?>>

            <button type="button" class="btn btn-secondary close2" data-dismiss="modal">Cancelar</button>
            <button type="submit" name='add_mensaje_p' class="btn btn-warning">Enviar</button>
        </div>
        </form> 
        </div>
    </div>
    </div>
