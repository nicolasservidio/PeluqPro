<?php 

session_start();

require_once 'funciones/corroborar_usuario.php'; 
Corroborar_Usuario(); // No se puede ingresar a la página php a menos que se haya iniciado sesión

require_once "conn/conexion.php";
$conexion = ConexionBD();


include('head.php');

?>

<body>
    <?php 
    if ($_SESSION['Cargo'] == "Administrador" || 
        $_SESSION['Cargo'] == "Gerente General" ||
        $_SESSION['Cargo'] == "Encargado de Administración" || 
        $_SESSION['Cargo'] == "Encargado de Finanzas" ||
        $_SESSION['Cargo'] == "Encargado de Compras") { ?>    

        <div class="wrapper">

            <?php 
            include('sidebarGOp.php');
             $tituloPagina = "INICIO";
            include('topNavBar.php');  
            ?>
            
            <div class="container">
                <div class="page-inner">
                    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                        
                        
                    </div>
                    <div class="row">
                        <div class=""> 
                            <a href="#">
                            <div class="card card-stats card-round">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <h5 style="color:rgb(11, 49, 83); padding-bottom: 20px;"><b>Esta página está en construcción</b></h5>
                                        <div class="col-icon">
                                            <div class="icon-big text-center icon-primary bubble-shadow-small">
                                                <i class="fas fa-exclamation-triangle"></i>
                                            </div>
                                        </div>
                                        <div class="col col-stats ms-3 ms-sm-0">
                                            <div class="numbers">
                                                <p class="card-category" style="padding-bottom: 20px; color:rgb(70, 67, 67);">
                                                    Ingresa a los diferentes módulos usando el menú lateral
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            </a>
                        </div> 
                    </div>
                </div>
            </div>

            <?php require_once "foot.php"?>

        </div>

    <?php 
    } 
    ?>

</body>

</html>