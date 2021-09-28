<!-- CODIGO PHP-->
<?php
$pagina = "egresos";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";


include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();



if (isset($_GET['id'])) {
    $folio_cxp = $_GET['id'];
    $consulta = "SELECT * FROM vcxp WHERE folio_cxp='$folio_cxp'";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();
    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    foreach ($data as $row) {
        $id_obra = $row['id_obra'];
        $obra = $row['corto_obra'];
        $id_prov = $row['id_prov'];
        $proveedor = $row['razon_prov'];
        $fecha_cxp = $row['fecha_cxp'];
        $clave_cxp = $row['clave_cxp'];
        $desc_cxp = $row['desc_cxp'];
        $monto_cxp = $row['monto_cxp'];
        $tipo_cxp = $row['tipo_cxp'];
    }
} else {
    $folio_cxp = 0;
    $id_obra = "";
    $obra = "";
    $id_prov = "";
    $proveedor = "";
    $fecha_cxp = date('Y-m-d');
    $clave_cxp = "";
    $desc_cxp = "";
    $tipo_cxp = "";
    $monto_cxp = 0;
}

$message = "";




if ($_SESSION['id_obra'] == null) {
    $consultacon = "SELECT * FROM w_obra WHERE estado_obra=1 ORDER BY id_obra";
    $resultadocon = $conexion->prepare($consultacon);
    $resultadocon->execute();
    $datacon = $resultadocon->fetchAll(PDO::FETCH_ASSOC);
} else {
    $id_obra = $_SESSION['id_obra'];
    $obra = $_SESSION['nom_obra'];
}



$consultaprov = "SELECT * FROM w_proveedor WHERE estado_prov=1 ORDER BY id_prov";
$resultadoprov = $conexion->prepare($consultaprov);
$resultadoprov->execute();
$dataprov = $resultadoprov->fetchAll(PDO::FETCH_ASSOC);






?>

<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="css/estilo.css">
<style>
    .punto {
        height: 20px !important;
        width: 20px !important;

        border-radius: 50% !important;
        display: inline-block !important;
        text-align: center;
        font-size: 15px;
    }

    #div_carga {
        position: absolute;
        /*top: 50%;
    left: 50%;
    */

        width: 100%;
        height: 100%;
        background-color: rgba(60, 60, 60, 0.5);
        display: none;

        justify-content: center;
        align-items: center;
        z-index: 3;
    }

    #cargador {
        position: absolute;
        top: 50%;
        left: 50%;
        margin-top: -25px;
        margin-left: -25px;
    }

    #textoc {
        position: absolute;
        top: 50%;
        left: 50%;
        margin-top: 120px;
        margin-left: 20px;


    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->


    <!-- Main content -->
    <section class="content">


        <!-- Default box -->
        <div class="card">


            <div id="div_carga">

                <img id="cargador" src="img/loader.gif" />
                <span class=" " id="textoc"><strong>Cargando...</strong></span>

            </div>

            <div class="card-header bg-gradient-green text-light">
                <h1 class="card-title mx-auto">REGISTRO DE EGRESOS</h1>
            </div>

            <div class="card-body">

                <div class="row">
                    <div class="col-lg-12">


                        <!--<button id="btnNuevo" type="button" class="btn bg-gradient-green btn-ms" data-toggle="modal"><i class="fas fa-plus-square text-light"></i><span class="text-light"> Nuevo</span></button>-->
                        <button type="button" id="btnGuardar" name="btnGuardar" class="btn btn-success" value="btnGuardar"><i class="far fa-save"></i> Guardar</button>
                        <!--<button id="btnNuevo" type="button" class="btn bg-gradient-primary btn-ms" data-toggle="modal"><i class="fas fa-envelope-square"></i> Enviar</button>-->
                    </div>
                </div>

                <br>


                <!-- Formulario Datos de Cliente -->
                <form id="formDatos" action="" method="POST">


                    <div class="content">

                        <div class="card card-widget" style="margin-bottom:0px;">

                            <div class="card-header bg-gradient-green " style="margin:0px;padding:8px">


                                <h1 class="card-title "> DATOS DE EGRESOS</h1>
                            </div>

                            <div class="card-body" style="margin:0px;padding:1px;">

                                <div class="row justify-content-sm-center">


                                    <div class="col-lg-1">
                                        <div class="form-group input-group-sm">
                                            <label for="folio" class="col-form-label">ID:</label>

                                            <input type="text" class="form-control" name="folio" id="folio" value="<?php echo  $folio_cxp; ?> " disabled>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group input-group-sm">
                                            <label for="tipo_cxp" class="col-form-label">Tipo:</label>
                                            <select class="form-control" name="tipo_cxp" id="tipo_cxp">

                                                <option id="SUBCONTRATO" value="SUBCONTRATO">SUBCONTRATO</option>
                                                <option id="FACTURA" value="FACTURA">FACTURA</option>

                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-lg-2">
                                        <div class="form-group input-group-sm">
                                            <label for="clave" class="col-form-label">#FACTURA o SUBCONTRATO:</label>
                                            <input type="text" class="form-control" name="clave" id="clave" value="<?php echo  $clave_cxp; ?>" placeholder="No. FACTURA O SUBCONTRATO">
                                        </div>
                                    </div>

                                    <div class="col-lg-2 ">
                                        <div class="form-group input-group-sm">
                                            <label for="fecha" class="col-form-label">FECHA:</label>
                                            <input type="date" class="form-control" name="fecha" id="fecha" value="<?php echo $fecha_cxp; ?>">
                                        </div>
                                    </div>






                                </div>

                                <div class=" row justify-content-sm-center">

                                    <div class="col-lg-8">
                                        <div class="input-group input-group-sm">
                                            <label for="obra" class="col-form-label">OBRA:</label>
                                            <div class="input-group input-group-sm">
                                                <input type="hidden" class="form-control" name="id_obra" id="id_obra" value="<?php echo $id_obra; ?>">
                                                <input type="text" class="form-control" name="obra" id="obra" disabled placeholder="SELECCIONAR OBRA" value="<?php echo $obra; ?>">
                                                <?php
                                                if ($id_obra == null) {
                                                ?>
                                                    <span class="input-group-append">
                                                        <button id="bobra" type="button" class="btn btn-sm btn-primary"><i class="fas fa-search"></i></button>
                                                    </span>
                                                <?php } ?>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-lg-8">
                                        <div class="input-group input-group-sm">
                                            <label for="proveedor" class="col-form-label">PROVEEDOR:</label>
                                            <div class="input-group input-group-sm">
                                                <input type="hidden" class="form-control" name="id_prov" id="id_prov" value="<?php echo $id_prov; ?>">
                                                <input type="text" class="form-control" name="proveedor" id="proveedor" disabled placeholder="SELECCIONAR PROVEEDOR" value="<?php echo $proveedor; ?>">
                                                <span class="input-group-append">
                                                    <button id="bproveedor" type="button" class="btn btn-sm btn-primary"><i class="fas fa-search"></i></button>
                                                </span>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="form-group input-group-sm">
                                            <label for="descripcion" class="col-form-label">DESCRIPCION:</label>
                                            <input type="text" class="form-control" name="descripcion" id="descripcion" value="<?php echo  $desc_cxp; ?>" placeholder="DESCRIPCION/CONCEPTO">
                                        </div>
                                    </div>


                                </div>
                                <div class="row justify-content-sm-center" style="margin-bottom: 10px;">
                                    <div class="col-lg-3">

                                    </div>
                                    <div class="col-lg-2 offset-lg-3">
                                        <label for="monto" class="col-form-label">MONTO TOTAL:</label>
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-dollar-sign"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control text-right" name="monto" id="monto" value="<?php echo number_format($monto_cxp, 2); ?>" pattern="[0-9]*">
                                        </div>
                                    </div>
                                </div>
                                <!-- modificacion Agregar notas a presupuesto-->


                            </div>
                            <!--fin modificacion agregar vendedor a presupuesto -->

                        </div>
                        <!-- Formulario Agrear Item -->


                    </div>


                </form>


                <!-- /.card-body -->

                <!-- /.card-footer-->
            </div>
        </div>



        <!-- /.card -->

    </section>






    <section>
        <div class="container">

            <!-- Default box -->
            <div class="modal fade" id="modalObra" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-md" role="document">
                    <div class="modal-content w-auto">
                        <div class="modal-header bg-gradient-green">
                            <h5 class="modal-title" id="exampleModalLabel">BUSCAR OBRA</h5>

                        </div>
                        <br>
                        <div class="table-hover table-responsive w-auto" style="padding:15px">
                            <table name="tablaObra" id="tablaObra" class="table table-sm text-nowrap table-striped table-bordered table-condensed" style="width:100%">
                                <thead class="text-center bg-gradient-green">
                                    <tr>
                                        <th>ID</th>
                                        <th>CLAVE</th>
                                        <th>NOMBRE CORTO</th>
                                        <th>ACCIONES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($datacon as $datc) {
                                    ?>
                                        <tr>
                                            <td><?php echo $datc['id_obra'] ?></td>
                                            <td><?php echo $datc['clave_obra'] ?></td>
                                            <td><?php echo $datc['corto_obra'] ?></td>
                                            <td></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">

            <!-- Default box -->
            <div class="modal fade" id="modalProveedor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-md" role="document">
                    <div class="modal-content w-auto">
                        <div class="modal-header bg-gradient-green">
                            <h5 class="modal-title" id="exampleModalLabel">BUSCAR OBRA</h5>

                        </div>
                        <br>
                        <div class="table-hover table-responsive w-auto" style="padding:15px">
                            <table name="tablaProveedor" id="tablaProveedor" class="table table-sm text-nowrap table-striped table-bordered table-condensed" style="width:100%">
                                <thead class="text-center bg-gradient-green">
                                    <tr>
                                        <th>ID</th>
                                        <th>RFC</th>
                                        <th>RAZON SOCIAL</th>
                                        <th>ACCIONES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($dataprov as $datp) {
                                    ?>
                                        <tr>
                                            <td><?php echo $datp['id_prov'] ?></td>
                                            <td><?php echo $datp['rfc_prov'] ?></td>
                                            <td><?php echo $datp['razon_prov'] ?></td>
                                            <td></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>

<script>
    //window.addEventListener('beforeunload', function(event)  {

    // event.preventDefault();


    //event.returnValue ="";
    //});
</script>

<?php include_once 'templates/footer.php'; ?>
<script src="fjs/egresos.js"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>