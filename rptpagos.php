<?php
$pagina = "reportepagos";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";


include_once 'bd/conexion.php';

$folio = (isset($_GET['folio'])) ? $_GET['folio'] : '';
$objeto = new conn();
$conexion = $objeto->connect();
$usuario = $_SESSION['s_nombre'];

if ($folio != "") {

    $opcion = 2;
    $consulta = "SELECT * FROM semanal where folio='$folio'";

    $resultado = $conexion->prepare($consulta);
    $resultado->execute();


    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

    foreach ($data as $dt) {
        $folio =  $dt['folio'];;

        $fecha =   $dt['fecha'];;

        $fecha_ini = $dt['fecha_ini'];
        $fecha_fin = $dt['fecha_fin'];
        $total = $dt['total'];
        $activo = $dt['activo'];
    }





    $message = "";
} else {


    //BUSCAR CUENTA ABIERTA


    $consultatmp = "SELECT * FROM semanal WHERE activo='1' ORDER BY folio DESC LIMIT 1";
    $resultadotmp = $conexion->prepare($consultatmp);
    $resultadotmp->execute();
    if ($resultadotmp->rowCount() >= 1) {
        $datatmp = $resultadotmp->fetchAll(PDO::FETCH_ASSOC);
    } else {

        // INSERTAR FOLIO NUEVO

        $fecha = date('Y-m-d');
        $consultatmp = "INSERT INTO semanal (fecha,fecha_ini,fecha_fin,usuario,total) VALUES('$fecha','$fecha','$fecha','$usuario','0')";
        $resultadotmp = $conexion->prepare($consultatmp);
        $resultadotmp->execute();
        $opcion = 1;


        $consultatmp = "SELECT * FROM semanal WHERE activo='1' ORDER BY folio DESC LIMIT 1";
        $resultadotmp = $conexion->prepare($consultatmp);
        $resultadotmp->execute();
        $datatmp = $resultadotmp->fetchAll(PDO::FETCH_ASSOC);
    }





    foreach ($datatmp as $dt) {

        $folio =  $dt['folio'];;
        $opcion = 1;
        $fecha =   $dt['fecha'];;

        $fecha_ini = $dt['fecha_ini'];
        $fecha_fin = $dt['fecha_fin'];
        $total = $dt['total'];
        $activo = $dt['activo'];
    }
}

$consultac = "SELECT * FROM proveedor WHERE estado_prov=1 ORDER BY id_prov";
$resultadoc = $conexion->prepare($consultac);
$resultadoc->execute();
$datac = $resultadoc->fetchAll(PDO::FETCH_ASSOC);


?>

<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

<style>
    .borde-titulogris {
        border-left: grey;
        border-style: outset;
        ;
    }

    .fondogris {
        background-color: rgba(183, 185, 187, .8);
    }

    .borde-titulazul {
        border-left: rgb(117, 74, 195);
        border-style: outset;
        ;
    }

    .fondoazul {
        background-color: rgba(117, 74, 195, 0.8);
    }

    .borde-titulinfo {
        border-left: rgb(23, 162, 184);
        border-style: outset;
        ;
    }

    .fondoinfo {
        background-color: rgba(23, 162, 184, .8);
    }

    .borde-titulpur {
        border-left: rgb(117, 74, 195);
        border-style: outset;
        ;
    }

    .fondopur {
        background-color: rgba(117, 74, 195, .8);
    }




    .punto {
        height: 20px !important;
        width: 20px !important;

        border-radius: 50% !important;
        display: inline-block !important;
        text-align: center;
        font-size: 15px;
    }

    .div_carga {
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

    .cargador {
        position: absolute;
        top: 50%;
        left: 50%;
        margin-top: -25px;
        margin-left: -25px;
    }

    .textoc {
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


    <!-- FOMRULARIO ALTA CXP -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header bg-gradient-purple text-light">
                <h1 class="card-title mx-auto">Pagos Semanal</h1>
            </div>

            <div class="card-body">

                <div class="row">
                    <div class="col-lg-12">
                        <?php if ($activo == 1) { ?>
                            <button type="button" id="btnGuardar" name="btnGuardar" class="btn btn-primary" value="btnGuardar"><i class="far fa-save"></i> Guardar</button>
                            <button type="button" id="btnGuardaryc" name="btnGuardaryc" class="btn btn-success" value="btnGuardaryc"><i class="far fa-save "></i> <i class="fa-solid fa-lock"></i> Guardar y Cerrar</button>
                            <!--<button type="button" id="btnGuardarya" name="btnGuardarya" class="btn btn-success" value="btnGuardarya"><i class="far fa-save "></i> <i class="fa-solid fa-circle-check"></i> Guardar y Aplicar</button>-->
                        <?php } ?>

                    </div>
                </div>

                <br>



                <form id="formDatos" action="" method="POST">


                    <div class="content" disab>

                        <div class="card card-widget" style="margin-bottom:0px;">

                            <div class="card-header bg-gradient-purple " style="margin:0px;padding:8px">

                                <h1 class="card-title ">Datos Generales</h1>
                            </div>

                            <div class="card-body" style="margin:0px;padding:1px;">

                                <div class="row justify-content-sm-center">







                                    <div class="col-lg-2">
                                        <div class="form-group input-group-sm">
                                            <input type="hidden" class="form-control" name="opcion" id="opcion" value="<?php echo $opcion; ?>">

                                            <label for="folio" class="col-form-label">Folio:</label>
                                            <input type="text" class="form-control" name="folio" id="folio" value="<?php echo   $folio; ?>">
                                        </div>
                                    </div>

                                    <div class="col-lg-2">
                                        <div class="form-group input-group-sm">

                                            <label for="fecha" class="col-form-label">Fecha de Creación:</label>
                                            <input type="date" class="form-control" name="fecha" id="fecha" value="<?php echo $fecha; ?>" disabled>
                                        </div>
                                    </div>


                                    <div class="col-lg-2">
                                        <div class="form-group input-group-sm">

                                            <label for="fechaini" class="col-form-label">Fecha Inicio:</label>
                                            <input type="date" class="form-control" name="fechaini" id="fechaini" value="<?php echo $fecha_ini; ?>">
                                        </div>
                                    </div>


                                    <div class="col-lg-2">
                                        <div class="form-group input-group-sm">

                                            <label for="fechafin" class="col-form-label">Fecha Final:</label>
                                            <input type="date" class="form-control" name="fechafin" id="fechafin" value="<?php echo $fecha_fin; ?>">
                                        </div>
                                    </div>




                                </div>

                                <div class="card">

                                    <div class="card-header fondopur " style="margin:0px;padding:8px">
                                        <div class="card-tools" style="margin:0px;padding:0px;">


                                        </div>
                                        <h1 class="card-title text-light">Detalle de Reporte</h1>
                                        <div class="card-tools" style="margin:0px;padding:0px;">


                                        </div>
                                    </div>

                                    <div class="card-body" style="margin:0px;padding:3px;">
                                        <?php if ($activo == 1) { ?>
                                            <div class="card card-widget collapsed-card " style="margin:2px;padding:5px;">

                                                <div class="card-header " style="margin:0px;padding:8px;">

                                                    <button type="button" id="btnAgregar" class="btn bg-gradient-purple btn-sm">
                                                        Agregar Detalle <i class="fas fa-plus"></i>
                                                    </button>

                                                </div>



                                            </div>
                                        <?php } ?>

                                        <div class="row">

                                            <div class="col-lg-12 mx-auto">
                                                <div class="table-responsive" style="padding:5px;">
                                                    <table name="tablav" id="tablav" class="table table-sm table-striped table-bordered table-condensed mx-auto" style="width:100%;font-size:15px">
                                                        <thead class="text-center bg-gradient-purple">
                                                            <tr>
                                                                <th>Id</th>
                                                                <th>Folio Rpt</th>
                                                                <th>Tipo Op</th>
                                                                <th>Folio Op</th>
                                                                <th>Obra</th>
                                                                <th>Proveedor</th>
                                                                <th>Concepto</th>
                                                                <th>Banco</th>
                                                                <th>Cuenta</th>
                                                                <th>Clabe</th>
                                                                <th>Tarjeta</th>
                                                                <th>Observaciones</th>
                                                                <th>Importe</th>
                                                                <th>Aplicado</th>
                                                                <th>Acciones</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $consultadeto = "SELECT * FROM vdetallesemanal where folio_rpt='$folio' and estado=1 order by id_reg";
                                                            $resultadodeto = $conexion->prepare($consultadeto);
                                                            $resultadodeto->execute();
                                                            $datadeto = $resultadodeto->fetchAll(PDO::FETCH_ASSOC);
                                                            foreach ($datadeto as $rowdet) {
                                                            ?>
                                                                <tr>
                                                                    <td><?php echo $rowdet['id_reg'] ?></td>
                                                                    <td><?php echo $rowdet['folio_rpt'] ?></td>
                                                                    <td><?php echo $rowdet['tipo'] ?></td>
                                                                    <td><?php echo $rowdet['folio'] ?></td>
                                                                    <td><?php echo $rowdet['corto_obra'] ?></td>
                                                                    <td><?php echo $rowdet['razon_prov'] ?></td>
                                                                    <td><?php echo $rowdet['concepto'] ?></td>
                                                                    <td><?php echo $rowdet['banco'] ?></td>
                                                                    <td><?php echo $rowdet['cuenta'] ?></td>
                                                                    <td><?php echo $rowdet['clabe'] ?></td>
                                                                    <td><?php echo $rowdet['tarjeta'] ?></td>

                                                                    <td><?php echo $rowdet['observaciones'] ?></td>
                                                                    <td class="text-right"><?php echo number_format($rowdet['montoautorizado'], 2) ?></td>
                                                                    <td><?php echo $rowdet['aplicado'] ?></td>
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


                                <div class="row justify-content-sm-center" style="padding:5px 0px;margin-bottom:5px">

                                    <div class="col-sm-5 ">


                                    </div>

                                    <div class="col-sm-5 ">

                                    </div>

                                    <div class="col-sm-2 ">
                                        <label for="total" class="col-form-label ">Total:</label>

                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-dollar-sign"></i>
                                                </span>
                                            </div>

                                            <input type="text" class="form-control text-right" name="total" id="total" value="<?php echo number_format($total, 2); ?>" onkeypress="return filterFloat(event,this);" disabled>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>



                <!-- MATERIALES USADOS-->

                <!-- TERMINA MATERIALES USADOS -->
            </div>

        </div>
    </section>
    <!-- TERMINA ALTA CXP -->

    <!-- INICIA TABLA CUENTAS-->
    <section>
        <div class="container">
            <div class="modal fade" id="modalcuentas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content w-auto">
                        <div class="modal-header bg-gradient-purple">
                            <h5 class="modal-title" id="exampleModalLabel">Cuentas Autorizadas</h5>

                        </div>
                        <br>
                        <div class="table-hover table-responsive w-auto " style="padding:10px">
                            <table name="tablaC" id="tablaC" class="table table-sm table-striped table-bordered table-condensed w-auto, mx-auto" style="width:100%">
                                <thead class="text-center bg-gradient-purple">
                                    <tr>
                                        <th>TIPO</th>
                                        <th>FOLIO</th>
                                        <th>ID OBRA</th>
                                        <th>OBRA</th>
                                        <th>PROVEEDOR</th>
                                        <th>FECHA</th>
                                        <th>CONCEPTO</th>
                                        <th>MONTO</th>
                                        <th>SALDO</th>
                                        <th>ACCIONES</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- TERMINA TABLA PROVEEDOR-->


    <section>
        <div class="modal fade" id="modalPago" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog " role="document">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-purple">
                        <h5 class="modal-title" id="exampleModalLabel">Confirmar Monto del Pago</h5>

                    </div>
                    <form id="formPago" action="" method="POST">
                        <div class="modal-body">


                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group input-group-sm">
                                        <label for="obspago" class="col-form-label">Observaciones</label>
                                        <input type="hidden" class="form-control" name="tipocuenta" id="tipocuenta" autocomplete="off" placeholder="Concepto de Pago">
                                        <input type="hidden" class="form-control" name="foliocuenta" id="foliocuenta" autocomplete="off" placeholder="Concepto de Pago">
                                        <textarea row='3' class="form-control" name="obspago" id="obspago" autocomplete="off" placeholder="Observaciones"></textarea>
                                    </div>
                                </div>
                            </div>


                            <div class="row justify-content-sm-center">

                                <div class="col-lg-6 ">
                                    <label for="saldo" class="col-form-label ">Saldo:</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-dollar-sign"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control text-right" name="saldo" id="saldo" value="<?php echo $saldo; ?>" disabled>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <label for="montopago" class="col-form-label">Pago:</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-dollar-sign"></i>
                                            </span>

                                        </div>
                                        <input type="text" id="montopago" name="montopago" class="form-control text-right" autocomplete="off" placeholder="Monto del Pago">
                                    </div>
                                </div>



                            </div>

                        </div>





                        <div class="modal-footer">
                            <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fas fa-ban"></i> Cancelar</button>
                            <button type="button" id="btnguardarpago" name="btnguardarpago" class="btn btn-success" value="btnGuardar"><i class="far fa-save"></i> Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>


    <!-- /.content -->
</div>



<?php include_once 'templates/footer.php'; ?>
<script src="fjs/rptpagos.js?v=<?php echo (rand()); ?>"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>
<script src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>