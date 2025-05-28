
<div class="sidebar" style="color: white !important; background-color:rgb(34, 31, 31); margin: #333333; border: #333333;">
    <div class="sidebar-logo">
        <!-- Logo Header -->

        <div class="logo-header" style="background-color:rgb(34, 31, 31); margin: #333333; border: #333333;">
            <a href="#" class="logo">
                <p alt="navbar brand" class="navbar-brand" height="45" 
                   style="padding-top: 18px; font-size: 25px; font-family: Cambria Math; color:rgb(198, 167, 31);">
                    PeluqPro
                </p>
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
                    <a aria-expanded="false" href="indexGOp.php" > 
                        <b style="padding-left: 3px; padding-right: 10px;">🏠</b>
                        <p style="color: grey;">Inicio</p>
                    </a>
                </li>

                <li class="nav-item" id="empleados" onclick="activarItem(this, 'empleados')" >
                    <a aria-expanded="false" href="empleados.php" >
                        <b style="padding-left: 3px; padding-right: 10px;">👨‍💼</b>
                        <p style="color: grey;"> Empleados </p>
                    </a>
                </li>

                <li class="nav-item" id="clientes" onclick="activarItem(this, 'clientes')" >
                    <a aria-expanded="false" href="clientes.php" >
                        <b style="padding-left: 3px; padding-right: 10px;">💇</b>
                        <p style="color: grey;"> Clientes </p>
                    </a>
                </li>

                <li class="nav-item" id="turnos" onclick="activarItem(this, 'turnos')" >
                    <a aria-expanded="false" href="turnos.php" >
                        <b style="padding-left: 3px; padding-right: 10px;">📅</b>
                        <p style="color: grey;"> Turnos </p>
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

