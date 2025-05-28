
<style>
    .sidebar {
        background-color: #222020; /* Fondo oscuro */
        color: white;
        border-right: 2px solid #333333;
        width: 270px; /* Ajuste de ancho */
    }

    .sidebar-logo .navbar-brand {
        color: rgb(198, 167, 31) !important;
        font-size: 26px;
        font-family: "Cambria Math", sans-serif;
        margin-top: 18px;
    }

    .nav-item a {
        display: flex;
        align-items: center;
        padding: 12px;        
        text-decoration: none;
        transition: all 0.3s ease-in-out;
    }

    .nav-item a p {
        color: rgb(162, 159, 159);
    }

    .nav-item a b {
        padding-left: 3px; 
        padding-right: 10px;
    }

    .nav-item a:hover {
        background-color: rgba(198, 167, 31, 0.66);
    }

    .nav-item a:hover p {
        color: black !important;
        text-shadow: none !important;
    }

    .nav-item.active a {
        background-color: rgb(198, 167, 31);
        color: #ffffff !important;
        font-weight: bold;
        border-radius: 5px;
    }

    .logo-header .logo {
        color: rgb(198, 167, 31) !important;
    }

    .sidebar .nav>.nav-item.active>a p, .sidebar[data-background-color=white] .nav>.nav-item.active>a p {
        color: rgb(198, 167, 31) !important;
        font-weight: 600;
    }
</style>

<div class="sidebar">
    <div class="sidebar-logo">
        <!-- Logo Header -->

        <div class="logo-header">
            <a href="#" class="logo">
                <p class="navbar-brand">PeluqPro </p>
            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar" >
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
        <!-- End Logo Header -->
    </div>

    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">

            <ul class="nav nav-secondary" >
                <li class="nav-item" id="inicio" onclick="activarItem(this, 'inicio')">
                    <a href="indexGOp.php" > 
                        <b>🏠</b>
                        <p>Inicio</p>
                    </a>
                </li>

                <li class="nav-item" id="empleados" onclick="activarItem(this, 'empleados')" >
                    <a href="empleados.php" >
                        <b>👨‍💼</b>
                        <p> Empleados </p>
                    </a>
                </li>

                <li class="nav-item" id="clientes" onclick="activarItem(this, 'clientes')" >
                    <a href="clientes.php" >
                        <b>💇</b>
                        <p> Clientes </p>
                    </a>
                </li>

                <li class="nav-item" id="turnos" onclick="activarItem(this, 'turnos')" >
                    <a href="turnos.php" >
                        <b>📅</b>
                        <p> Turnos </p>
                    </a>
                </li>

            </ul>
        </div>
    </div>
</div>
<!-- End Sidebar -->

<script>

function activarItem(element, id) {

    // Remover la clase "active" de todos los elementos
    const items = document.querySelectorAll('.nav-item');
    items.forEach(item => item.classList.remove('active'));

    // Agregar la clase "active" al elemento cliqueado
    element.classList.add('active');

    // Guardar el estado activo en localStorage 
    localStorage.setItem('activeItem', id);
}

// Restaurar el estado activo al cargar la página a la cual fuimos redirigidos 
document.addEventListener('DOMContentLoaded', () => {
    const activeItem = localStorage.getItem('activeItem');

    if (activeItem) { 
        const element = document.getElementById(activeItem);
        if (element) {
            element.classList.add('active');
        }
    }
});

</script>

