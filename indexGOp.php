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

                <!-- Estilo para el mensaje de bienvenida -->
                <style>
                    .text-title {
                        color: #4D311D !important; 
                        font-family: 'Cambria Math', serif;
                    }
                    .text-subtitle {
                        color:rgb(53, 21, 11) !important; 
                        font-family: 'Raleway', sans-serif;
                    }

                    .lead {
                        font-size: 1.3rem;
                        font-weight: 400;
                    }
                </style>

                <div class="text-center mt-5 page-inner">
                    <h1 class="display-4 fw-bold text-title">Bienvenido a PeluqPro</h1> <br>
                    <p class="lead text-muted text-subtitle">
                        Optimizá la gestión de tu peluquería con herramientas inteligentes para administrar empleados, clientes y turnos 
                        de manera eficiente. Usá los accesos rápidos a cada módulo y mejora la gestión de tu negocio.
                    </p>
                    <hr class="my-4">
                </div>

                
                <!-- Estilo para las tarjetas -->
                <style>
                    .card-flip {
                        perspective: 1000px;
                        text-decoration: none;
                    }

                    .card {
                        width: 100%;
                        height: 250px;
                        position: relative;
                        transform-style: preserve-3d;
                        transition: transform 0.5s ease;
                    }

                    .card-front, .card-back {
                        position: absolute;
                        width: 100%;
                        height: 100%;
                        backface-visibility: hidden;
                    }

                    .card-front img {
                        width: 100%;
                        height: 100%;
                        object-fit: cover;
                        border-radius: 10px;
                    }

                    .card-back {
                        background: rgba(77, 49, 29, 0.91);
                        color: white;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        border-radius: 10px;
                        transform: rotateY(180deg);
                    }

                    .card-flip:hover .card {
                        transform: rotateY(180deg);
                    }

                    .card-back h3 {
                        font-family: 'Montserrat', sans-serif; 
                    }
                </style>

                <div class="container">
                    <div class="row justify-content-center page-inner">
                        <!-- Tarjeta EMPLEADOS -->
                        <div class="col-md-4">
                            <a href="empleados.php" class="card-flip">
                                <div class="card">
                                    <div class="card-front">
                                        <img src="assets/img/empleados.png" class="img-fluid" alt="Empleados">
                                    </div>
                                    <div class="card-back">
                                        <h3>Empleados</h3>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <!-- Tarjeta CLIENTES -->
                        <div class="col-md-4">
                            <a href="clientes.php" class="card-flip">
                                <div class="card">
                                    <div class="card-front">
                                        <img src="assets/img/clientes.png" class="img-fluid" alt="Clientes">
                                    </div>
                                    <div class="card-back">
                                        <h3>Clientes</h3>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <!-- Tarjeta TURNOS -->
                        <div class="col-md-4">
                            <a href="turnos.php" class="card-flip">
                                <div class="card">
                                    <div class="card-front">
                                        <img src="assets/img/turnos.png" class="img-fluid" alt="Turnos">
                                    </div>
                                    <div class="card-back">
                                        <h3>Turnos</h3>
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