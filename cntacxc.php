<?php
$pagina = "cntacxc";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();
$fecha = date('Y-m-d');

if($_SESSION['id_obra'] != null){
    $id_obra=$_SESSION['id_obra'];
    $consulta = "SELECT * FROM vcxc WHERE id_obra='$id_obra' and estado_cxc=1 ORDER BY id_obra,fecha_cxc,folio_cxc";
}else{
    $id_obra=null;
    $obra=null;
    $consulta = "SELECT * FROM vcxc WHERE estado_cxc=1 ORDER BY id_obra,fecha_cxc,folio_cxc";
}
//$consulta = "SELECT * FROM vcxc WHERE estado_cxc=1 ORDER BY id_obra,fecha_cxc,folio_cxc";


$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);

if ($_SESSION['id_obra'] == null) {
    $consultacon = "SELECT * FROM w_obra WHERE estado_obra=1 ORDER BY id_obra";
    $resultadocon = $conexion->prepare($consultacon);
    $resultadocon->execute();
    $datacon = $resultadocon->fetchAll(PDO::FETCH_ASSOC);
} else {
    $id_obra = $_SESSION['id_obra'];
    $obra = $_SESSION['nom_obra'];
}



$message = "";



?>

<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->


    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header bg-gradient-green text-light">
                <h1 class="card-title mx-auto">Ingresos</h1>
            </div>

            <div class="card-body">

            <div class="row">
                    <div class="col-lg-12">
                        <button id="btnNuevo" type="button" class="btn bg-gradient-green btn-ms" data-toggle="modal"><i class="fas fa-plus-square text-light"></i><span class="text-light"> Nuevo</span></button>
                    </div>
                </div>
                <br>

                <div class="card">
                    <div class="card-header bg-gradient-green">
                        Filtro por rango de Fecha
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-lg-2">
                                <div class="form-group input-group-sm">
                                    <label for="fecha" class="col-form-label">Desde:</label>
                                    <input type="date" class="form-control" name="inicio" id="inicio">
                                    

                                </div>
                            </div>

                            <div class="col-lg-2">
                                <div class="form-group input-group-sm">
                                    <label for="fecha" class="col-form-label">Hasta:</label>
                                    <input type="date" class="form-control" name="final" id="final">
                                </div>
                            </div>

                            <div class="col-lg-1 align-self-end text-center">
                                <div class="form-group input-group-sm">
                                    <button id="btnBuscar" name="btnBuscar" type="button" class="btn bg-gradient-success btn-ms"><i class="fas fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container-fluid">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table name="tablaV" id="tablaV" class="table table-sm table-striped table-bordered table-condensed text-nowrap w-auto mx-auto" style="width:100%; font-size:15px">
                                    <thead class="text-center bg-gradient-green">
                                        <tr>
                                            <th>FOLIO</th>
                                            <th>FACTURA</th>
                                            <th>OBRA</th>
                                            <th>FECHA</th>
                                            <th>CONCEPTO</th>
                                            <th>MONTO</th>
                                            <th>SALDO</th>
                                            <th>ACCIONES</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($data as $dat) {
                                        ?>
                                            <tr>
                                                <td><?php echo $dat['folio_cxc'] ?></td>
                                                <td><?php echo $dat['factura_cxc'] ?></td>
                                                <td><?php echo $dat['corto_obra'] ?></td>
                                                <td class="text-center"><?php echo $dat['fecha_cxc'] ?></td>
                                                <td><?php echo $dat['desc_cxc'] ?></td>
                                                <td class="text-right"><?php echo number_format($dat['monto_cxc'], 2) ?></td>
                                                <td class="text-right"><?php echo number_format($dat['saldo_cxc'], 2) ?></td>
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
            <!-- /.card-body -->

            <!-- /.card-footer-->
        </div>
        <!-- /.card -->

    </section>


        <!-- INICIA ALTA DE FACTURAS -->
        <section>
        <div class="modal fade" id="modalReq" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content w-auto">
                    <div class="modal-header bg-gradient-green">
                        <h5 class="modal-title" id="exampleModalLabel">ALTA DE FACTURAS</h5>

                    </div>
                    <form id="formReq" action="" method="POST" autocomplete="off">
                        <div class="card card-widget" style="margin: 10px;">

                            <div class="modal-body">
                                <div class="row justify-content-sm-center">

                                    <div class="col-sm-2">
                                        <div class="form-group input-group-sm">
                                            <label for="folioreq" class="col-form-label">FOLIO:</label>
                                            <input type="text" class="form-control" name="folioreq" id="folioreq" disabled>
                                            <input type="hidden" class="form-control" name="foliosubcontrato" id="foliosubcontrato" disabled>
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group input-group-sm">
                                            <label for="facturareq" class="col-form-label">FACTURA:</label>
                                            <input type="text" class="form-control" name="facturareq" id="facturareq" placeholder="FACTURA">
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                    </div>

                                    <div class="col-sm-3 ">
                                        <div class="form-group input-group-sm">
                                            <label for="fechareq" class="col-form-label">FECHA:</label>
                                            <input type="date" class="form-control" name="fechareq" id="fechareq" value="<?php echo $fecha; ?>">
                                        </div>
                                    </div>

                                </div>

                                <div class=" row justify-content-sm-center">

                                    <div class="col-sm-12">
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

                              
                               


                                </div>

                                <div class=" row justify-content-sm-center">

                                    <div class="col-sm-12">
                                        <div class="form-group input-group-sm">
                                            <label for="descripcionreq" class="col-form-label">CONCEPTO:</label>
                                            <textarea row="2" type="text" class="form-control" name="descripcionreq" id="descripcionreq" placeholder="CONCEPTO"></textarea>
                                        </div>
                                    </div>

                                </div>

                                <div class="row justify-content-sm-center" style="margin-bottom: 10px;">

                                    <div class="col-sm-4 ">
                                        <label for="subtotalreq" class="col-form-label">SUBTOTAL:</label>
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-dollar-sign"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control text-right" name="subtotalreq" id="subtotalreq" onkeypress="return filterFloat(event,this);">
                                        </div>
                                    </div>
                                    <div class=" col-sm-4 ">
                                        <label for=" ivareq" class="col-form-label">IVA:</label>
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-dollar-sign"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control text-right" name="ivareq" id="ivareq" onkeypress="return filterFloat(event,this);">
                                        </div>
                                    </div>
                                    <div class=" col-sm-4 ">
                                        <label for=" montoreq" class="col-form-label">TOTAL:</label>
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-dollar-sign"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control text-right" name="montoreq" id="montoreq" onkeypress="return filterFloat(event,this);">
                                        </div>
                                    </div>

                                </div>

                            </div>

                            <div class=" modal-footer">
                                <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fas fa-ban"></i> Cancelar</button>
                                <button type="button" id="btnGuardarreq" name="btnGuardarreq" class="btn btn-success" value="btnGuardarreq"><i class="far fa-save"></i> Guardar</button>
                            </div>


                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- TERMINA ALTA DE FACTURAS -->

    <!-- INICIA RESUMEN DE PAGOS -->
    <section>
        <div class="container">


            <!-- Default box -->
            <div class="modal fade" id="modalResumen" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-md" role="document">
                    <div class="modal-content w-auto">
                        <div class="modal-header bg-gradient-green">
                            <h5 class="modal-title" id="exampleModalLabel">Resumen de Pagos</h5>

                        </div>
                        <br>
                        <div class="table-hover responsive w-auto " style="padding:10px">
                            <table name="tablaResumen" id="tablaResumen" class="table table-sm table-striped table-bordered table-condensed display compact" style="width:100%">
                                <thead class="text-center bg-gradient-green">
                                    <tr>
                                        <th>FOLIO</th>
                                        <th>FECHA</th>
                                        <th>REFERENCIA</th>
                                        <th>MONTO</th>
                                        <th>METODO</th>
                                        <th>ACCIONES</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>

                                    <th></th>
                                    <th></th>
                                    <th class="text-right">TOTAL</th>
                                    <th class="text-right"></th>
                                    <th></th>
                                    <th></th>
                                </tfoot>
                            </table>
                        </div>


                    </div>

                </div>
                <!-- /.card-body -->

                <!-- /.card-footer-->
            </div>
            <!-- /.card -->

        </div>
    </section>
    <!-- TERMINA RESUMEN DE PAGOS -->
        <!-- INICIA PAGAR -->
    <section>
        <div class="modal fade" id="modalPago" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-green">
                        <h5 class="modal-title" id="exampleModalLabel">REGISTRAR PAGO</h5>

                    </div>
                    <form id="formPago" action="" method="POST">
                        <div class="modal-body">
                            <div class="row justify-content-sm-between my-auto">




                                <div class="col-sm-3 my-auto">
                                    <div class="form-group input-group-sm">
                                        <label for="foliovp" class="col-form-label">Folio Cxc:</label>
                                        <input type="text" class="form-control" name="foliovp" id="foliovp" disabled>
                                    </div>
                                </div>




                                <div class="col-sm-3 my-auto">
                                    <div class="form-group input-group-sm">
                                        <label for="fechavp" class="col-form-label ">Fecha de Pago:</label>
                                        <input type="date" id="fechavp" name="fechavp" class="form-control text-right" autocomplete="off" value="<?php echo date("Y-m-d") ?>" placeholder="FECHA">
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group input-group-sm">
                                        <label for="referenciavp" class="col-form-label">REFERENCIA DE PAGO</label>
                                        <input type="text" class="form-control" name="referenciavp" id="referenciavp" autocomplete="off" placeholder="REFERENCIA">
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-sm-center">
                                <div class="col-sm-12">
                                    <div class="form-group input-group-sm">
                                        <label for="observacionesvp" class="col-form-label">OBSERVACIONES:</label>
                                        <textarea class="form-control" name="observacionesvp" id="observacionesvp" rows="3" autocomplete="off" placeholder="OBSERVACIONES"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-sm-center">

                                <div class="col-lg-4 ">
                                    <label for="saldovp" class="col-form-label ">SALDO ACTUAL:</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-dollar-sign"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control text-right" name="saldovp" id="saldovp" disabled>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <label for="montopagovp" class="col-form-label">MONTO DE PAGO:</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-dollar-sign"></i>
                                            </span>

                                        </div>
                                        <input type="text" id="montopagovp" name="montopagovp" class="form-control text-right" autocomplete="off" placeholder="MONTO DEL PAGO">
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="input-group-sm">
                                        <label for="metodovp" class="col-form-label">METODO DE PAGO:</label>

                                        <select class="form-control" name="metodovp" id="metodovp">
                                            <option id="EFECTIVO" value="EFECTIVO">EFECTIVO</option>
                                            <option id="TRANSFERENCIA" value="TRANSFERENCIA">TRANSFERENCIA</option>
                                            <option id="DEPOSITO" value="DEPOSITO">DEPOSITO</option>
                                            <option id="CHEQUE" value="CHEQUE">CHEQUE</option>
                                            <option id="TARJETA DE CREDITO" value="TARJETA DE CREDITO">TARJETA DE CREDITO</option>
                                            <option id="TARJETA DE DEBITO" value="TARJETA DE DEBITO">TARJETA DE DEBITO</option>

                                        </select>
                                    </div>
                                </div>

                            </div>


                        </div>





                        <div class="modal-footer">
                            <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fas fa-ban"></i> Cancelar</button>
                            <button type="button" id="btnGuardarvp" name="btnGuardarvp" class="btn btn-success" value="btnGuardar"><i class="far fa-save"></i> Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- TERMINA PAGAR -->

      <!-- INICIA OBRA -->
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
    <!-- TERMINA OBRA -->

    <!-- INICIA CANCELAR -->
    <section>
        <div class="modal fade" id="modalcan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog " role="document">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-danger">
                        <h5 class="modal-title" id="exampleModalLabel">CANCELAR</h5>
                    </div>
                    <div class="card card-widget" style="margin: 10px;">
                        <form id="formcan" action="" method="POST">
                            <div class="modal-body row">
                                <div class="col-sm-12">
                                    <div class="form-group input-group-sm">
                                        <label for="motivo" class="col-form-label">Motivo de Cancelacioón:</label>
                                        <textarea rows="3" class="form-control" name="motivo" id="motivo" placeholder="Motivo de Cancelación"></textarea>
                                        <input type="hidden" id="fecha" name="fecha" value="<?php echo $fecha ?>">
                                        <input type="hidden" id="foliocan" name="foliocan">
                                        <input type="hidden" id="tipodoc" name="tipodoc">
                                    </div>
                                </div>
                            </div>
                    </div>
                    <?php
                    if ($message != "") {
                    ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <span class="badge "><?php echo ($message); ?></span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                        </div>
                    <?php
                    }
                    ?>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fas fa-ban"></i> Cancelar</button>
                        <button type="button" id="btnGuardarCAN" name="btnGuardarCAN" class="btn btn-success" value="btnGuardarCAN"><i class="far fa-save"></i> Guardar</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
<!-- TERMINA CANCELAR -->
    <!-- /.content -->
</div>


<?php include_once 'templates/footer.php'; ?>
<script src="fjs/cntacxc.js"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>