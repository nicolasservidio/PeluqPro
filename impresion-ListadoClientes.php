<?php
session_start();

require_once 'funciones/corroborar_usuario.php'; 
Corroborar_Usuario(); 

ob_start();

require_once "conn/conexion.php";
$conexion = ConexionBD();


// Obtener filtros del formulario
$filtros = [
    'documento' => isset($_GET['documento']) ? strip_tags(trim($_GET['documento'])) : '',
    'nombre' => isset($_GET['nombre']) ? strip_tags(trim($_GET['nombre'])) : '',
    'apellido' => isset($_GET['apellido']) ? strip_tags(trim($_GET['apellido'])) : '',
    'email' => isset($_GET['email']) ? strip_tags(trim($_GET['email'])) : '',
    'telefono' => isset($_GET['telefono']) ? strip_tags(trim($_GET['telefono'])) : '',
    'direccion' => isset($_GET['direccion']) ? strip_tags(trim($_GET['direccion'])) : '',
    'localidad' => isset($_GET['localidad']) ? strip_tags(trim($_GET['localidad'])) : '',
    'identificador' => isset($_GET['identificador']) ? strip_tags(trim($_GET['identificador'])) : '',
];

// Generar consulta filtrada
include('funciones/ListarClientes.php');
$ListadoClientes = Listar_Clientes($conexion, $filtros);
$CantidadClientes = count($ListadoClientes);

include('head.php');

?>

<body class="bg-light" style="margin-top: 2%; margin-bottom: 0;">

    <!-- Logo Header --> <!-- IMPORTANTE: Arroja error fatal si no tienen instalada la extensión "GD" de PHP en XAMPP. Para resolver el error, seguir instructivo: https://www.geeksforgeeks.org/how-to-install-php-gd-in-windows/ -->  
    <div style="margin: 0 auto; padding: 0 0 20px 90%;">
        <span style=""> 
            <img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/Proyectos/PeluqPro/assets/img/PeluqPro light.png" height="80" width="" alt="navbar brand" srcset="" /> 
        </span>
    </div>
    <!-- End Logo Header -->

    <div style="margin: 0 auto; max-width: 100%;">
        <div class="" style="">
            
            <div class="p-5 mb-4 bg-white shadow-sm" 
                 style="margin: 0; padding: 20px; ">

                <h4 class="mb-4 text-secondary" style="padding-bottom: 10px; font-family: Arial;">
                    <strong>Listado: Clientes registrados en la empresa </strong>
                </h4>
                
                <!-- Tabla con reporte de contratos -->
                <table class="table table-striped table-hover" id="tablaClientes">
                    <thead>
                        <tr>
                            <th style="margin: 0 auto; padding: 0 5px 0 0; color: #bd399e; font-size: 22px;">
                                <h3>N</h3>
                            </th>

                            <th style="margin: 0 auto; padding: 0 5px 0 5px; background-color: #a80a0a; color: white; font-size: 14px;">
                                ID cliente
                            </th>

                            <th style="margin: 0 auto; padding: 0 5px 0 5px; background-color: #a80a0a; color: white; font-size: 14px;">
                                Documento
                            </th>

                            <th style="margin: 0 auto; padding: 0 5px 0 5px; background-color: #a80a0a; color: white; font-size: 14px;">
                                Nombre
                            </th>

                            <th style="margin: 0 auto; padding: 0 5px 0 5px; background-color: #a80a0a; color: white; font-size: 14px;">
                                Apellido
                            </th>

                            <th style="margin: 0 auto; padding: 0 5px 0 5px; background-color: #a80a0a; color: white; font-size: 14px;">
                                Email
                            </th>

                            <th style="margin: 0 auto; padding: 0 5px 0 5px; background-color: #a80a0a; color: white; font-size: 14px;">
                                Teléfono
                            </th>

                            <th style="margin: 0 auto; padding: 0 5px 0 5px; background-color: #a80a0a; color: white; font-size: 14px;">
                                Dirección
                            </th>

                            <th style="margin: 0 auto; padding: 0 5px 0 5px; background-color: #a80a0a; color: white; font-size: 14px;">
                                Localidad
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $contador = 1; 

                        for ($i = 0; $i < $CantidadClientes; $i++) { ?>   

                            <tr>
                                <td>
                                    <span style='color:rgb(175, 33, 8); font-size: 17px; margin: 0 auto; padding: 0;'>
                                        <h4> <?php echo $contador; ?> </h4>
                                    </span>
                                </td>

                                <td style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; font-size: 14px; "> 
                                    <?php echo $ListadoClientes[$i]['id']; ?>
                                </td>

                                <td style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; font-size: 14px; "> 
                                    <?php echo $ListadoClientes[$i]['documento']; ?>
                                </td>

                                <td style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; font-size: 14px;"> 
                                    <?php echo $ListadoClientes[$i]['nombre']; ?>
                                </td>

                                <td style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; font-size: 14px;"> 
                                    <?php echo $ListadoClientes[$i]['apellido']; ?>
                                </td>

                                <td style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; font-size: 14px;"> 
                                    <?php echo $ListadoClientes[$i]['email']; ?>
                                </td>

                                <td style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; font-size: 14px;"> 
                                    <?php echo $ListadoClientes[$i]['telefono']; ?>
                                </td>

                                <td style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; font-size: 14px;"> 
                                    <?php echo $ListadoClientes[$i]['direccion']; ?>
                                </td>

                                <td style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; font-size: 12px;"> 
                                    <?php echo $ListadoClientes[$i]['localidad']; ?>
                                </td>
                            </tr>
                        <?php 

                        $contador++; 

                        } 
                        ?>
                    </tbody>
                </table>                    

            </div>
        </div>
    </div>


<footer id="footer" class="footer" style="margin-top: 80px; background: #b54d0d; margin: #333333; border: #333333; ">
    
    <div style="color: white; background: #b54d0d; margin: #333333; border: #333333; text-align: center; padding-top: 2%; padding-bottom: 2%; ">
        <div class="copyright">
        &copy; Copyright <strong><span>PeluqPro</span></strong>. All Rights Reserved
        </div>
        <div class="credits">
        Developed by <span style="color: white;">PeluqPro Team</span>: <a href="https://www.linkedin.com/in/nicolas-servidio-del-monte/" style="color: black;" >NS</a> - <a href="https://www.linkedin.com/in/AQUI/" style="color: black;" >LM</a> - <a href="https://www.linkedin.com/in/AQUI/" style="color: black;" >JA</a>
        </div>
    </div>
</footer><!-- End Footer -->

</body>
</html>

<?php
$html = ob_get_clean();
// echo $html; // La variable $html ahora contiene la totalidad de la página. Imprimo en pantalla para que se continue viendo la página web

// Creando un objeto de tipo Dompdf para trabajar con todas las funcionalidades de conversión del documento HTML a PDF
require_once 'administrador/dompdf/autoload.inc.php';
use Dompdf\Dompdf;
$dompdf = new Dompdf();  // Este objeto me permitirá trabajar con todas las funcionalidades de conversión de HTML a PDF

// Activamos la opción que nos permite mostrar imágenes, por si la tabla llegara a contenerlas
$options = $dompdf->getOptions();  // solo recupero la opción
$options->set(array('isRemoteEnabled' => true));  // estoy activando con true esa opción, que es "isRemoteEnabled" 
$dompdf->setOptions($options);  // y se lo estoy pasando nuevamente al objeto $dompdf, para que se pueda mostrar dicha imagen

// Probemos:
$dompdf->loadHtml($html);

// genero el documento PDF:
$dompdf->setPaper('A4', 'landscape');  // el formato entre paréntesis. Probar "letter" en lugar de los dos argumentos que se usan aquí

// Hacemos el render, es decir todo lo que le asignamos al objeto $dompdf se renderiza, se hace visible
$dompdf->render();

// Pero, para que podamos ver el documento en el navegador y para que podamos descargarlo desde el navegador, necesitamos trabajar con "dompdf" y "stream" señalando el nombre del archivo:

$dompdf->stream("listado-clientes", array("Attachment" => false)); // false es para que se abra directamente en el navegador. True es para que se descargue

?>