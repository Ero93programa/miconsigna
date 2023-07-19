
<?php


function sacarNav($user, $ruta){
    if($ruta == "index") {
        //LOCALIZACION EN INDEX
        if($user === "admin") {
            echo "<nav class='navbar navbar-expand-lg nav-orange'>
            <div class='container-fluid'>
                <a class='navbar-brand' href='index.php'>
                    <img class='logo_web' src='img/logo1.png' alt=''>
                </a>
                <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarSupportedContent' aria-controls='navbarSupportedContent' aria-expanded='false' aria-label='Toggle navigation'>
                <span class='navbar-toggler-icon'></span>
                </button>
                <div class='collapse navbar-collapse' id='navbarSupportedContent'>
                <ul class='navbar-nav me-auto mb-2 mb-lg-0'>
                    <li class='nav-item'>
                        <a class='nav-link active' aria-current='page' href='index.php'>Principal</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link active' aria-current='page' href='pages/buscar.php'>Buscar</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' href='pages/mensajes.php'>Mensajes</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' href='pages/informes.php'>Informes</a>
                    </li>

                    <li>
                        <li class='nav-item dropdown'>
                        <a class='nav-link dropdown-toggle' href='#' role='button' data-bs-toggle='dropdown' aria-expanded='false'>
                            Lugares
                        </a>
                        <ul class='dropdown-menu despl_nav'>
                            <li><a class='dropdown-item' href='pages/lista_nuevos_lugares.php'>Nuevos</a></li>
                            <li><hr class='dropdown-divider'></li>
                            <li><a class='dropdown-item' href='pages/lista_lugares.php'>Total</a></li>
                        </ul>
                        </li>
                        </li>
                            <li class='nav-item dropdown'>
                            <a class='nav-link dropdown-toggle' href='#' role='button' data-bs-toggle='dropdown' aria-expanded='false'>
                                Usuarios
                            </a>
                            <ul class='dropdown-menu despl_nav'>
                                <li><a class='dropdown-item' href='pages/lista_nuevos_usuarios.php'>Nuevos</a></li>
                                <li><hr class='dropdown-divider'></li>
                                <li><a class='dropdown-item' href='pages/lista_usuarios.php'>Total</a></li>
                            </ul>
                            </li>
                            <form method='post' action='index.php' class='boton_logout m-auto'>
                                <input class='alert alert-danger m-auto' type='submit' name='logout' value='Desconectar $user'>
                            </form>
                </ul>
                </div>
            </div>
        </nav>";
        }elseif(isset($_SESSION['user'])){
            echo "<nav class='navbar navbar-expand-lg nav-orange'>
            <div class='container-fluid'>
                <a class='navbar-brand' href='index.php'>
                    <img class='logo_web' src='img/logo1.png' alt=''>
                </a>
                <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarSupportedContent' aria-controls='navbarSupportedContent' aria-expanded='false' aria-label='Toggle navigation'>
                <span class='navbar-toggler-icon'></span>
                </button>
                <div class='collapse navbar-collapse' id='navbarSupportedContent'>
                <ul class='navbar-nav me-auto mb-2 mb-lg-0'>
                    <li class='nav-item'>
                        <a class='nav-link active' aria-current='page' href='index.php'>Principal</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link active' aria-current='page' href='pages/buscar.php'>Buscar</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' href='pages/perfil_usuario.php'>Perfil</a>
                    </li>
                    <li class='nav-item dropdown'>
                        <a class='nav-link dropdown-toggle' href='#' role='button' data-bs-toggle='dropdown' aria-expanded='false'>
                            Reservas
                        </a>
                        <ul class='dropdown-menu despl_nav'>
                            <li><a class='dropdown-item' href='pages/lista_nuevas_reservas.php'>Nuevas reservas</a></li>
                            <li><hr class='dropdown-divider'></li>
                            <li><a class='dropdown-item' href='pages/lista_reservas.php'>Total</a></li>
                        </ul>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' href='pages/mensajes.php'>Mensajes</a>
                    </li>
                    <form method='post' action='index.php' class='boton_logout m-auto'>
                        <input class='alert alert-danger m-auto' type='submit' name='logout' value='Desconectar $user'>
                    </form>
                </ul>
                </div>
            </div>
        </nav>";
        }else{
            echo "<nav class='navbar navbar-expand-lg nav-orange'>
            <div class='container-fluid'>
                <a class='navbar-brand' href='index.php'>
                    <img class='logo_web' src='img/logo1.png' alt=''>
                </a>
                <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarSupportedContent' aria-controls='navbarSupportedContent' aria-expanded='false' aria-label='Toggle navigation'>
                <span class='navbar-toggler-icon'></span>
                </button>
                <div class='collapse navbar-collapse' id='navbarSupportedContent'>
                <ul class='navbar-nav me-auto mb-2 mb-lg-0'>
                    <li class='nav-item'>
                        <a class='nav-link active' aria-current='page' href='index.php'>Principal</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link active' aria-current='page' href='pages/buscar.php'>Buscar</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' href='pages/registro.php'>Registro</a>
                    </li>
                    <li class=\"nav-item\">
                        <a class=\"nav-link\" href=\"pages/acceder.php\">Acceso</a>
                    </li>
                </ul>
                </div>
            </div>
        </nav>";
        }
    }else{
        //LOCALIZACION EN PAGES
        if($user === "admin") {
            echo "<nav class='navbar navbar-expand-lg nav-orange'>
            <div class='container-fluid'>
                <a class='navbar-brand' href='../index.php'>
                    <img class='logo_web' src='../img/logo1.png' alt=''>
                </a>
                <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarSupportedContent' aria-controls='navbarSupportedContent' aria-expanded='false' aria-label='Toggle navigation'>
                <span class='navbar-toggler-icon'></span>
                </button>
                <div class='collapse navbar-collapse' id='navbarSupportedContent'>
                <ul class='navbar-nav me-auto mb-2 mb-lg-0'>
                    <li class='nav-item'>
                        <a class='nav-link active' aria-current='page' href='../index.php'>Principal</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link active' aria-current='page' href='buscar.php'>Buscar</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' href='mensajes.php'>Mensajes</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' href='informes.php'>Informes</a>
                    </li>

                    <li>
                        <li class='nav-item dropdown'>
                        <a class='nav-link dropdown-toggle' href='#' role='button' data-bs-toggle='dropdown' aria-expanded='false'>
                            Lugares
                        </a>
                        <ul class='dropdown-menu despl_nav'>
                            <li><a class='dropdown-item' href='lista_nuevos_lugares.php'>Nuevos</a></li>
                            <li><hr class='dropdown-divider'></li>
                            <li><a class='dropdown-item' href='lista_lugares.php'>Total</a></li>
                        </ul>
                    </li>
                    <li class='nav-item dropdown'>
                            <a class='nav-link dropdown-toggle' href='#' role='button' data-bs-toggle='dropdown' aria-expanded='false'>
                                Usuarios
                            </a>
                            <ul class='dropdown-menu despl_nav'>
                                <li><a class='dropdown-item' href='lista_nuevos_usuarios.php'>Nuevos</a></li>
                                <li><hr class='dropdown-divider'></li>
                                <li><a class='dropdown-item' href='lista_usuarios.php'>Total</a></li>
                            </ul>
                    </li>
                            <form method='post' action='../index.php' class='boton_logout m-auto'>
                                <input class='alert alert-danger m-auto' type='submit' name='logout' value='Desconectar $user'>
                            </form>
                </ul>
                </div>
            </div>
        </nav>";
        }elseif(isset($_SESSION['user'])){
            echo "<nav class='navbar navbar-expand-lg nav-orange'>
            <div class='container-fluid'>
                <a class='navbar-brand' href='../index.php'>
                    <img class='logo_web' src='../img/logo1.png' alt=''>
                </a>
                <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarSupportedContent' aria-controls='navbarSupportedContent' aria-expanded='false' aria-label='Toggle navigation'>
                <span class='navbar-toggler-icon'></span>
                </button>
                <div class='collapse navbar-collapse' id='navbarSupportedContent'>
                <ul class='navbar-nav me-auto mb-2 mb-lg-0'>
                    <li class='nav-item'>
                        <a class='nav-link active' aria-current='page' href='../index.php'>Principal</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link active' aria-current='page' href='buscar.php'>Buscar</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' href='perfil_usuario.php'>Perfil</a>
                    </li>
                    <li class='nav-item dropdown'>
                        <a class='nav-link dropdown-toggle' href='#' role='button' data-bs-toggle='dropdown' aria-expanded='false'>
                            Reservas
                        </a>
                        <ul class='dropdown-menu despl_nav'>
                            <li><a class='dropdown-item' href='lista_nuevas_reservas.php'>Nuevas reservas</a></li>
                            <li><hr class='dropdown-divider'></li>
                            <li><a class='dropdown-item' href='lista_reservas.php'>Total</a></li>
                        </ul>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' href='mensajes.php'>Mensajes</a>
                    </li>
                    <form method='post' action='../index.php' class='boton_logout m-auto'>
                        <input class='alert alert-danger m-auto' type='submit' name='logout' value='Desconectar $user'>
                    </form>
                </ul>
                </div>
            </div>
        </nav>";
        }else{
            echo "<nav class='navbar navbar-expand-lg nav-orange'>
            <div class='container-fluid'>
                <a class='navbar-brand' href='../index.php'>
                    <img class='logo_web' src='../img/logo1.png' alt=''>
                </a>
                <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarSupportedContent' aria-controls='navbarSupportedContent' aria-expanded='false' aria-label='Toggle navigation'>
                <span class='navbar-toggler-icon'></span>
                </button>
                <div class='collapse navbar-collapse' id='navbarSupportedContent'>
                <ul class='navbar-nav me-auto mb-2 mb-lg-0'>
                    <li class='nav-item'>
                        <a class='nav-link active' aria-current='page' href='../index.php'>Principal</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link active' aria-current='page' href='buscar.php'>Buscar</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' href='registro.php'>Registro</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' href='acceder.php'>Acceso</a>
                    </li>
                </ul>
                </div>
            </div>
        </nav>";
        }       
    }
}
?>
