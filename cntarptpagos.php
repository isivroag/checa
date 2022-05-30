<?php
$pagina = "reportepagos";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();


$fecha = date('Y-m-d');


$consultaprov = "SELECT * FROM semanal WHERE estado=1 ORDER BY folio";
$resultadoprov = $conexion->prepare($consultaprov);
$resultadoprov->execute();
$data = $resultadoprov->fetchAll(PDO::FETCH_ASSOC);



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
                <h1 class="card-title mx-auto">Consulta de Pagos Semanales</h1>
            </div>

            <div class="card-body">

                <div class="row">
                    <div class="col-lg-12">
                        <button id="btnNuevo" type="button" class="btn bg-gradient-green btn-ms" data-toggle="modal"><i class="fas fa-plus-square text-light"></i><span class="text-light"> Nuevo</span></button>
                    </div>
                </div>
                <br>

                <div class="container-fluid">


                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table name="tablaV" id="tablaV" class="table table-sm table-striped table-bordered table-condensed w-auto mx-auto " style="width:100%;font-size:15px">
                                    <thead class="text-center bg-gradient-green">
                                        <tr>
                                            <th>ID</th>

                                            <th>FECHA</th>
                                            <th>FECHA INICIO</th>
                                            <th>FECHA FINAL</th>
                                            <th>MONTO</th>
                                            <th>ESTADO</th>
                                            <th>ACCIONES</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($data as $dat) {
                                        ?>
                                            <tr>
                                                <td><?php echo $dat['folio'] ?></td>
                                                <td><?php echo $dat['fecha'] ?></td>
                                                <td><?php echo $dat['fecha_ini'] ?></td>
                                                <td><?php echo $dat['fecha_fin'] ?></td>
                                                <td class="text-right"><?php echo number_format($dat['total'], 2) ?></td>
                                                <td><?php echo  $dat['activo'] ?></td>
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
                            <table name="tablac" id="tablac" class="table table-sm table-striped table-bordered table-condensed w-auto, mx-auto" style="width:100%">
                                <thead class="text-center bg-gradient-purple">
                                    <tr>
                                        <th>Id</th>
                                        <th>Folio Rpt</th>
                                        <th>Tipo Op</th>
                                        <th>Folio Op</th>
                                        <th>Obra</th>
                                        <th>Proveedor</th>
                                        <th>Concepto</th>
                                        <th>Observaciones</th>
                                        <th>Importe</th>
                                        <th>Aplicado</th>
                                        <th>Acciones</th>
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

    <!-- INICIA ALTA DE REQUISICION -->
    <section>
        <div class="modal fade" id="modalReq" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content w-auto">
                    <div class="modal-header bg-gradient-green">
                        <h5 class="modal-title" id="exampleModalLabel">ALTA DE REQUISICIONES</h5>

                    </div>
                    <form id="formReq" action="" method="POST" autocomplete="off">
                        <div class="card card-widget" style="margin: 10px;">

                            <div class="modal-body">
                                <div class="row justify-content-sm-center">

                                    <div class="col-sm-2">
                                        <div class="form-group input-group-sm">
                                            <label for="folioreq" class="col-form-label">FOLIO REQ:</label>
                                            <input type="text" class="form-control" name="folioreq" id="folioreq" disabled>
                                            <input type="hidden" class="form-control" name="foliosubcontrato" id="foliosubcontrato" disabled>
                                            <input type="hidden" class="form-control" name="idprovreq" id="idprovreq" disabled>
                                            <input type="hidden" class="form-control" name="idprovision" id="idprovision" disabled>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group input-group-sm">
                                            <label for="clavereq" class="col-form-label">FACTURA:</label>
                                            <input type="text" class="form-control" name="clavereq" id="clavereq" placeholder="FACTURA">
                                        </div>
                                    </div>

                                   

                                    <div class="col-sm-3 ">
                                        <div class="form-group input-group-sm">
                                            <label for="fechareq" class="col-form-label">FECHA REQ:</label>
                                            <input type="date" class="form-control" name="fechareq" id="fechareq" value="<?php echo $fecha; ?>">
                                        </div>
                                    </div>

                                    <div class="col-sm-3 my-auto">
                                        <div class="form-group input-group-sm">
                                            <label for="fechavp" class="col-form-label ">FECHA DE PAGO:</label>
                                            <input type="date" id="fechavp" name="fechavp" class="form-control text-right" autocomplete="off" value="<?php echo date("Y-m-d") ?>" placeholder="FECHA">
                                        </div>
                                    </div>

                                </div>

                                <div class=" row justify-content-sm-center">

                                    <div class="col-sm-12">
                                        <div class="form-group input-group-sm">
                                            <label for="descripcionreq" class="col-form-label">CONCEPTO:</label>
                                            <textarea row="2" type="text" class="form-control" name="descripcionreq" id="descripcionreq" placeholder="CONCEPTO" disabled></textarea>
                                        </div>
                                    </div>

                                </div>

                                <div class="row justify-content-sm-center" style="margin-bottom: 10px;">

                                    <div class="col-sm-4 ">
                                        <label for="importe" class="col-form-label">IMPORTE:</label>
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-dollar-sign"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control text-right" name="importe" id="importe" onkeypress="return filterFloat(event,this);">
                                        </div>
                                    </div>

                                    <div class="col-sm-4 ">
                                        <label for="descuento" class="col-form-label">AMORT. (DESC):</label>
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-dollar-sign"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control text-right" name="descuento" id="descuento" onkeypress="return filterFloat(event,this);">
                                        </div>
                                    </div>

                                    <div class="col-sm-4 ">
                                        <label for="devolucion" class="col-form-label">DEVOLUCIÓN:</label>
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-dollar-sign"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control text-right" name="devolucion" id="devolucion" onkeypress="return filterFloat(event,this);">
                                        </div>
                                    </div>



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
                                        <label for=" montoreqa" class="col-form-label">TOTAL:</label>
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-dollar-sign"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control text-right" name="montoreqa" id="montoreqa" onkeypress="return filterFloat(event,this);">
                                        </div>
                                    </div>

                                </div>
                                <div class="row justify-content-sm-between" style="margin-bottom: 10px;">

                                    <div class="col-sm-4 ">
                                        <label for="ret1" class="col-form-label">RET1:</label>
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-dollar-sign"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control text-right" name="ret1" id="ret1" onkeypress="return filterFloat(event,this);">
                                        </div>
                                    </div>
                                    <div class=" col-sm-4 ">
                                        <label for="ret2" class="col-form-label">RET2:</label>
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-dollar-sign"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control text-right" name="ret2" id="ret2" onkeypress="return filterFloat(event,this);">
                                        </div>
                                    </div>
                                    <div class=" col-sm-4 ">
                                        <label for=" ret3" class="col-form-label">RET3:</label>
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-dollar-sign"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control text-right" name="ret3" id="ret3" onkeypress="return filterFloat(event,this);">
                                        </div>
                                    </div>

                                </div>


                                <div class="row justify-content-sm-center" style="margin-bottom: 10px;">

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

                                    <div class="col-sm-4"></div>


                                    <div class=" col-sm-4 ">
                                        <label for=" montoreq" class="col-form-label">GRAN TOTAL:</label>
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-dollar-sign"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control text-right" name="montoreq" id="montoreq" onkeypress="return filterFloat(event,this);" disabled>
                                        </div>
                                    </div>

                                </div>

                                <div class="row justify-content-sm-center">
                                    <div class="col-sm-12">
                                        <div class="form-group input-group-sm">
                                            <label for="referenciavp" class="col-form-label">REFERENCIA DE PAGO</label>
                                            <input type="text" class="form-control" name="referenciavp" id="referenciavp" autocomplete="off" placeholder="REFERENCIA (CHEQUE,#AUTORIZACIÓN)">
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
    <!-- TERMINA ALTA DE REQUISICION -->
</div>


<?php include_once 'templates/footer.php'; ?>
<script src="fjs/cntarptpagos.js?v=<?php echo (rand()); ?>"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
<script src="http://cdn.datatables.net/plug-ins/1.10.21/sorting/formatted-numbers.js"></script>