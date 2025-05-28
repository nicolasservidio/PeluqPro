<?php 

session_start();

include('head.php');

?>

<body>
<main class="d-flex flex-column justify-content-center align-items-center vh-100" style="background-color:rgb(238, 235, 233);" id="main">

    <div class="text-center mb-4" style="padding-bottom: 5%;">
        <img width="80" src="assets/img/PeluqPro light.png" alt="Logo" class="img-fluid">
    </div>

    <div class="card col-3 bg-light p-5 rounded shadow">

        <h4 class="text-center">Iniciar Sesión</h4>
        <p class="text-center" style="padding-bottom: 20px;">Ingrese sus credenciales</p>

        <form method="post" action="index.php">

            <div class="mb-3">
                <label for="userId" class="form-label">Usuario</label>
                <input type="text" class="form-control" placeholder="" name="userId" 
                       value="<?php echo isset($_POST['userId']) ? $_POST['userId'] : ''; ?>">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" placeholder="" name="password"
                       value="<?php echo isset($_POST['password']) ? $_POST['password'] : ''; ?>">
            </div>

            <div class="d-grid gap-2" style="padding-top: 20px;">
                <button type="submit" class="btn btn-warning" name="submitBtn">Iniciar Sesión</button> 
                <span style="text-align: center; padding-top: 10px;"> 
                    <a href="cerrarsesion.php"> Cerrar sesión previa</a> 
                </span>
            </div>
        </form>
    </div>
    
    <?php require_once "validar_login.php"?>
</main>
</body>

<?php require_once "foot.php"?>

