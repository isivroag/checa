<!-- CODIGO PHP-->
<?php
$pagina = "registro";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";


include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();
$tokenid = md5($_SESSION['s_usuario']);
$usuario = $_SESSION['s_nombre'];


if (isset($_GET['folio'])) {
} else {
    $registro = 0;
    $idpx = "";
    $paciente = "";
    $fecha = date('Y-m-d');
    $folio = "";
    $idconcepto = "";
    $concepto = "";
    $precio = 0;
    $subtotal = 0;
    $descuento = 0;
    $total = 0;
}

$message = "";




$consultacon = "SELECT * FROM concepto WHERE estado_concepto=1 ORDER BY id_concepto";
$resultadocon = $conexion->prepare($consultacon);
$resultadocon->execute();
$datacon = $resultadocon->fetchAll(PDO::FETCH_ASSOC);



$consultadet = "SELECT * FROM paciente ORDER BY id_px";
$resultadodet = $conexion->prepare($consultadet);
$resultadodet->execute();
$datadet = $resultadodet->fetchAll(PDO::FETCH_ASSOC);




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
                <h1 class="card-title mx-auto">Registro de Ingreso</h1>
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
                               

                                <h1 class="card-title "> Datos del Registro</h1>
                            </div>

                            <div class="card-body" style="margin:0px;padding:1px;">

                                <div class="row justify-content-sm-center">

                                    <div class="col-lg-4">
                                        <div class="input-group input-group-sm">

                                            <input type="hidden" class="form-control" name="registro" id="registro" value="<?php echo $registro; ?>">
                                            <input type="hidden" class="form-control" name="tokenid" id="tokenid" value="<?php echo $tokenid; ?>">

                                            <input type="hidden" class="form-control" name="idpx" id="idpx">


                                            <label for="paciente" class="col-form-label">Paciente:</label>
                                            <div class="input-group input-group-sm">
                                                

                                                <input type="text" class="form-control" name="paciente" id="paciente" disabled placeholder="Seleccionar al Paciente">
                                                <span class="input-group-append">
                                                    <button id="bpaciente" type="button" class="btn btn-sm btn-primary"><i class="fas fa-search"></i></button>
                                                </span>
                                            </div>

                                        </div>
                                    </div>




                                    <div class="col-lg-2">
                                        <div class="form-group input-group-sm">
                                            <label for="fecha" class="col-form-label">Fecha:</label>
                                            <input type="date" class="form-control" name="fecha" id="fecha" value="<?php echo $fecha; ?>">
                                        </div>
                                    </div>


                                    <div class="col-lg-1">
                                        <div class="form-group input-group-sm">
                                            <label for="folio" class="col-form-label">Folio:</label>

                                            <input type="text" class="form-control" name="folio" id="folio" value="<?php echo  $folio; ?> " disabled>
                                        </div>
                                    </div>

                                </div>

                                <div class=" row justify-content-sm-center">
                                    <div class="col-lg-5">
                                        <div class="input-group input-group-sm">

                                            <input type="hidden" class="form-control" name="idconcepto" id="idconcepto">


                                            <label for="concepto" class="col-form-label">Concepto:</label>
                                            <div class="input-group input-group-sm">
                                                <input type="text" class="form-control" name="concepto" id="concepto" disabled placeholder="Seleccionar Concepto">
                                                <span class="input-group-append">
                                                    <button id="bconcepto" type="button" class="btn btn-sm btn-primary"><i class="fas fa-search"></i></button>
                                                </span>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-lg-2 ">

                                        <label for="precio" class="col-form-label ">Precio:</label>

                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-dollar-sign"></i>
                                                </span>
                                            </div>

                                            <input type="text" class="form-control text-right" name="precio" id="precio" value="<?php echo $precio; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="col-lg-7 ">
                                       <div class="form-group input-group-sm">
                                            <label for="obs" class="col-form-label">Observaciones:</label>
                                            <textarea rows="2" class="form-control" name="obs" id="obs" value="<?php echo $obs; ?>" placeholder="Observaciones"></textarea>
                                        </div>
                                    </div>



                                </div>
                                <div class="row justify-content-sm-center" style="margin-bottom: 10px;">

                                    <div class="col-lg-2">

                                        <label for="subtotal" class="col-form-label">Subtotal:</label>
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-dollar-sign"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control text-right" name="subtotal" id="subtotal" disabled>
                                        </div>
                                    </div>

                                    <div class="col-lg-2">

                                        <label for="descuento" class="col-form-label">Descuento:</label>
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-dollar-sign"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control text-right" name="descuento" id="descuento" >
                                        </div>
                                    </div>

                                    <div class="col-lg-2">

                                        <label for="total" class="col-form-label">Total:</label>

                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-dollar-sign"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control text-right" name="total" id="total" disabled>
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
            <div class="modal fade" id="modalPx" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-md" role="document">
                    <div class="modal-content w-auto">
                        <div class="modal-header bg-gradient-green">
                            <h5 class="modal-title" id="exampleModalLabel">BUSCAR PX</h5>

                        </div>
                        <br>
                        <div class="table-hover table-responsive w-auto" style="padding:15px">
                            <table name="tablaPx" id="tablaPx" class="table table-sm text-nowrap table-striped table-bordered table-condensed" style="width:100%">
                                <thead class="text-center bg-gradient-green">
                                    <tr>
                                        <th>Id</th>
                                        <th>PX</th>

                                        <th>Seleccionar</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($datadet as $datc) {
                                    ?>
                                        <tr>
                                            <td><?php echo $datc['id_px'] ?></td>
                                            <td><?php echo $datc['nom'] ?></td>

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
            <div class="modal fade" id="modalConcepto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-md" role="document">
                    <div class="modal-content w-auto">
                        <div class="modal-header bg-gradient-green">
                            <h5 class="modal-title" id="exampleModalLabel">BUSCAR CONCEPTO</h5>

                        </div>
                        <br>
                        <div class="table-hover table-responsive w-auto" style="padding:15px">
                            <table name="tablaCon" id="tablaCon" class="table table-sm table-striped table-bordered table-condensed " style="width:100%">
                                <thead class="text-center bg-gradient-green">
                                    <tr>
                                        <th>Id</th>
                                        <th>Concepto</th>
                                        <th>Precio</th>

                                        <th>Seleccionar</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($datacon as $datc) {
                                    ?>
                                        <tr>
                                            <td><?php echo $datc['id_concepto'] ?></td>
                                            <td><?php echo $datc['nom_concepto'] ?></td>
                                            <td><?php echo $datc['precio_concepto'] ?></td>

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
<script src="fjs/registro.js"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>