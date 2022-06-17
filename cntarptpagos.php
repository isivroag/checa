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
                        <h5 class="modal-title" id="exampleModalLabel">TRASLADO A REQUISICION</h5>

                    </div>
                    <form id="formReq" action="" method="POST" autocomplete="off">
                        <div class="card card-widget" style="margin: 10px;">

                            <div class="modal-body">
                                <div class="row justify-content-sm-center">
                                    <!--    
                                    <div class="col-sm-2">
                                        <div class="form-group input-group-sm">
                                            <label for="folioreq" class="col-form-label">FOLIO REQ:</label>
                                            <input type="text" class="form-control" name="folioreq" id="folioreq" disabled>
                                            <input type="hidden" class="form-control" name="foliosubcontrato" id="foliosubcontrato" disabled>
                                            <input type="hidden" class="form-control" name="idprovreq" id="idprovreq" disabled>
                                            <input type="hidden" class="form-control" name="idprovision" id="idprovision" disabled>
                                        </div>
                                    </div>
                                    -->
                                    <div class="col-sm-2">
                                        <div class="form-group input-group-sm">
                                            <label for="clavereq" class="col-form-label">FACTURA:</label>
                                            <input type="text" class="form-control" name="clavereq" id="clavereq" placeholder="FACTURA">
                                            <input type="hidden" class="form-control" name="folioreq" id="folioreq" disabled>
                                            <input type="hidden" class="form-control" name="foliosubcontrato" id="foliosubcontrato" disabled>
                                            <input type="hidden" class="form-control" name="idprovreq" id="idprovreq" disabled>
                                            <input type="hidden" class="form-control" name="idprovision" id="idprovision" disabled>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group input-group-sm">
                                            <label for="uuid1" class="col-form-label">UUID FACTURA:</label>
                                            <input type="text" class="form-control" name="uuid1" id="uuid1" placeholder="UUID FACTURA" minlength="36" maxlength="36">
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

                                    <div class="col-sm-4">
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

    <!-- INICIA PAGAR-->
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
                                        <label for="foliovp1" class="col-form-label">FOLIO REQUISICION:</label>
                                        <input type="hidden" class="form-control" name="tipopago" id="tipopago" disabled>
                                        <input type="text" class="form-control" name="foliovp1" id="foliovp1" disabled>
                                        <input type="hidden" class="form-control" name="id_prov1" id="id_prov1" disabled>
                                    </div>
                                </div>




                                <div class="col-sm-3 my-auto">
                                    <div class="form-group input-group-sm">
                                        <label for="fechavp1" class="col-form-label ">FECHA DE PAGO:</label>
                                        <input type="date" id="fechavp1" name="fechavp1" class="form-control text-right" autocomplete="off" value="<?php echo date("Y-m-d") ?>" placeholder="FECHA">
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group input-group-sm">
                                        <label for="referenciavp1" class="col-form-label">REFERENCIA DE PAGO</label>
                                        <input type="text" class="form-control" name="referenciavp1" id="referenciavp1" autocomplete="off" placeholder="REFERENCIA (CHEQUE,#AUTORIZACIÓN)">
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-sm-center">
                                <div class="col-sm-12">
                                    <div class="form-group input-group-sm">
                                        <label for="observacionesvp1" class="col-form-label">OBSERVACIONES:</label>
                                        <textarea class="form-control" name="observacionesvp1" id="observacionesvp1" rows="3" autocomplete="off" placeholder="OBSERVACIONES"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-sm-center">

                                <div class="col-lg-4 ">
                                    <label for="saldovp1" class="col-form-label ">SALDO ACTUAL:</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-dollar-sign"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control text-right" name="saldovp1" id="saldovp1" disabled>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <label for="montopagovp1" class="col-form-label">MONTO DE PAGO:</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-dollar-sign"></i>
                                            </span>

                                        </div>
                                        <input type="text" id="montopagovp1" name="montopagovp1" class="form-control text-right" autocomplete="off" placeholder="MONTO DEL PAGO" onkeypress="return filterFloat(event,this);">
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="input-group-sm">
                                        <label for="metodovp1" class="col-form-label">METODO DE PAGO:</label>

                                        <select class="form-control" name="metodovp1" id="metodovp1">
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
                            <button type="button" id="btnGuardarp" name="btnGuardarp" class="btn btn-success" value="btnGuardarp"><i class="far fa-save"></i> Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- TERMINA PAGAR -->

    <!-- INICIA PROVISION A CXP -->
    <section>
        <div class="modal fade" id="modaltprov" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-green">
                        <h5 class="modal-title" id="exampleModalLabel">TRASLADO A CXP</h5>

                    </div>
                    <form id="formtprov" action="" method="POST">
                        <div class="modal-body">
                            <div class="row justify-content-sm-center">
                                <!--
                                <div class="col-sm-2">
                                    <div class="form-group input-group-sm">
                                        <label for="folioreq2" class="col-form-label">FOLIO:</label>
                                        <input type="text" class="form-control" name="folioreq2" id="folioreq2" disabled>
                                        <input type="hidden" class="form-control" name="folioprovi" id="folioprovi" disabled>
                                    </div>
                                </div>
                                    -->
                                <div class="col-sm-2">
                                    <div class="form-group input-group-sm">
                                        <label for="facturareq2" class="col-form-label">FACTURA:</label>
                                        <input type="text" class="form-control" name="facturareq2" id="facturareq2" placeholder="FACTURA">
                                        <input type="hidden" class="form-control" name="folioreq2" id="folioreq2" disabled>
                                        <input type="hidden" class="form-control" name="folioprovi" id="folioprovi" disabled>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group input-group-sm">
                                        <label for="uuid2" class="col-form-label">UUID FACTURA:</label>
                                        <input type="text" class="form-control" name="uuid2" id="uuid2" placeholder="UUID FACTURA" minlength="36" maxlength="36">
                                    </div>

                                </div>

                                <div class="col-sm-3 ">
                                    <div class="form-group input-group-sm">
                                        <label for="fechareq2" class="col-form-label">FECHA:</label>
                                        <input type="date" class="form-control" name="fechareq2" id="fechareq2" value="<?php echo $fecha; ?>">
                                    </div>
                                </div>
                                <div class="col-sm-3 my-auto">
                                    <div class="form-group input-group-sm">
                                        <label for="fechavp2" class="col-form-label ">FECHA DE PAGO:</label>
                                        <input type="date" id="fechavp2" name="fechavp2" class="form-control text-right" autocomplete="off" value="<?php echo date("Y-m-d") ?>" placeholder="FECHA">
                                    </div>
                                </div>

                            </div>

                            <div class=" row justify-content-sm-center">

                                <div class="col-sm-12">
                                    <div class="input-group input-group-sm">
                                        <label for="obra2" class="col-form-label">OBRA:</label>
                                        <div class="input-group input-group-sm">
                                            <input type="hidden" class="form-control" name="id_obra2" id="id_obra2">
                                            <input type="text" class="form-control" name="obra2" id="obra2" disabled placeholder="SELECCIONAR OBRA">


                                        </div>

                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="input-group input-group-sm">
                                        <label for="proveedor2" class="col-form-label">PROVEEDOR:</label>
                                        <div class="input-group input-group-sm">
                                            <input type="hidden" class="form-control" name="id_prov2" id="id_prov2" value="<?php echo $id_prov; ?>">
                                            <input type="text" class="form-control" name="proveedor2" id="proveedor2" disabled placeholder="SELECCIONAR PROVEEDOR" value="<?php echo $proveedor; ?>">

                                        </div>

                                    </div>
                                </div>



                            </div>

                            <div class=" row justify-content-sm-center">

                                <div class="col-sm-12">
                                    <div class="form-group input-group-sm">
                                        <label for="descripcionreq2" class="col-form-label">CONCEPTO:</label>
                                        <textarea row="2" type="text" class="form-control" name="descripcionreq2" id="descripcionreq2" placeholder="CONCEPTO"></textarea>
                                    </div>
                                </div>

                            </div>
                            <!--
                            <div class="row justify-content-sm-center" style="margin-bottom: 10px;">

                                <div class="col-sm-4 ">
                                    <label for="subtotalreq2" class="col-form-label">SUBTOTAL:</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-dollar-sign"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control text-right" name="subtotalreq2" id="subtotalreq2" onkeypress="return filterFloat(event,this);">
                                    </div>
                                </div>
                                <div class=" col-sm-4 ">
                                    <label for=" ivareq2" class="col-form-label">IVA:</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-dollar-sign"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control text-right" name="ivareq2" id="ivareq2" onkeypress="return filterFloat(event,this);">
                                    </div>
                                </div>
                                <div class=" col-sm-4 ">
                                    <label for=" montoreq2" class="col-form-label">TOTAL:</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-dollar-sign"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control text-right" name="montoreq2" id="montoreq2" onkeypress="return filterFloat(event,this);">
                                    </div>
                                </div>

                            </div>
                                            -->
                            <div class="row justify-content-sm-center" style="margin-bottom: 10px;">

                                <div class="col-sm-4 ">
                                    <label for="importe2" class="col-form-label">IMPORTE:</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-dollar-sign"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control text-right" name="importe2" id="importe2" onkeypress="return filterFloat(event,this);">
                                    </div>
                                </div>

                                <div class="col-sm-4 ">
                                    <label for="descuento2" class="col-form-label">AMORT. (DESC):</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-dollar-sign"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control text-right" name="descuento2" id="descuento2" onkeypress="return filterFloat(event,this);">
                                    </div>
                                </div>

                                <div class="col-sm-4 ">
                                    <label for="devolucion2" class="col-form-label">DEVOLUCIÓN:</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-dollar-sign"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control text-right" name="devolucion2" id="devolucion2" onkeypress="return filterFloat(event,this);">
                                    </div>
                                </div>

                                <div class="col-sm-4 ">
                                    <label for="subtotalreq2" class="col-form-label">SUBTOTAL:</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-dollar-sign"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control text-right" name="subtotalreq2" id="subtotalreq2" onkeypress="return filterFloat(event,this);">
                                    </div>
                                </div>

                                <div class=" col-sm-4 ">
                                    <label for=" ivareq2" class="col-form-label">IVA:</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-dollar-sign"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control text-right" name="ivareq2" id="ivareq2" onkeypress="return filterFloat(event,this);">
                                    </div>
                                </div>


                                <div class=" col-sm-4 ">
                                    <label for=" montoreqa2" class="col-form-label">TOTAL:</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-dollar-sign"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control text-right" name="montoreqa2" id="montoreqa2" onkeypress="return filterFloat(event,this);">
                                    </div>
                                </div>

                            </div>

                            <div class="row justify-content-sm-between" style="margin-bottom: 10px;">

                                <div class="col-sm-4 ">
                                    <label for="ret12" class="col-form-label">RET1:</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-dollar-sign"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control text-right" name="ret12" id="ret12" onkeypress="return filterFloat(event,this);">
                                    </div>
                                </div>
                                <div class=" col-sm-4 ">
                                    <label for="ret22" class="col-form-label">RET2:</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-dollar-sign"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control text-right" name="ret22" id="ret22" onkeypress="return filterFloat(event,this);">
                                    </div>
                                </div>
                                <div class=" col-sm-4 ">
                                    <label for="ret32" class="col-form-label">RET3:</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-dollar-sign"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control text-right" name="ret32" id="ret32" onkeypress="return filterFloat(event,this);">
                                    </div>
                                </div>

                            </div>

                            <div class="row justify-content-sm-center" style="margin-bottom: 10px;">

                                <div class="col-sm-4">
                                    <div class="input-group-sm">
                                        <label for="metodovp2" class="col-form-label">METODO DE PAGO:</label>

                                        <select class="form-control" name="metodovp2" id="metodovp2">
                                            <option id="EFECTIVO" value="EFECTIVO">EFECTIVO</option>
                                            <option id="TRANSFERENCIA" value="TRANSFERENCIA">TRANSFERENCIA</option>
                                            <option id="DEPOSITO" value="DEPOSITO">DEPOSITO</option>
                                            <option id="CHEQUE" value="CHEQUE">CHEQUE</option>
                                            <option id="TARJETA DE CREDITO" value="TARJETA DE CREDITO">TARJETA DE CREDITO</option>
                                            <option id="TARJETA DE DEBITO" value="TARJETA DE DEBITO">TARJETA DE DEBITO</option>

                                        </select>
                                    </div>
                                </div>

                                <div class=" col-sm-4 ">

                                </div>




                                <div class=" col-sm-4 ">
                                    <label for="montoreq2" class="col-form-label">GRAN TOTAL:</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-dollar-sign"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control text-right" name="montoreq2" id="montoreq2" onkeypress="return filterFloat(event,this); " disabled>
                                    </div>
                                </div>

                            </div>

                            <div class="row justify-content-sm-center">
                                <div class="col-sm-12">
                                    <div class="form-group input-group-sm">
                                        <label for="referenciavp2" class="col-form-label">REFERENCIA DE PAGO</label>
                                        <input type="text" class="form-control" name="referenciavp2" id="referenciavp2" autocomplete="off" placeholder="REFERENCIA (CHEQUE,#AUTORIZACIÓN)">
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-sm-center">
                                <div class="col-sm-12">
                                    <div class="form-group input-group-sm">
                                        <label for="observacionesvp2" class="col-form-label">OBSERVACIONES:</label>
                                        <textarea class="form-control" name="observacionesvp2" id="observacionesvp2" rows="3" autocomplete="off" placeholder="OBSERVACIONES"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-sm-center">





                            </div>
                        </div>





                        <div class="modal-footer">
                            <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fas fa-ban"></i> Cancelar</button>
                            <button type="button" id="btnGuardarvp2" name="btnGuardarvp2" class="btn btn-success" value="btnGuardar"><i class="far fa-save"></i> Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- TERMINA TRASLADAR A CXP -->

    <!-- INICIA TRASLADAR A CXP ADM -->
    <section>
        <div class="modal fade" id="modaltprovgral" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-green">
                        <h5 class="modal-title" id="exampleModalLabel">TRASLADO A CXP GRAL</h5>

                    </div>
                    <form id="formtprovgral" action="" method="POST">
                        <div class="modal-body">
                            <div class="row justify-content-sm-center">
                                <!--
                                <div class="col-sm-2">
                                    <div class="form-group input-group-sm">
                                          <label for="folioreq3" class="col-form-label">FOLIO:</label>
                                        <input type="hidden" class="form-control" name="folioreq3" id="folioreq3" disabled>
                                        <input type="hidden" class="form-control" name="folioprovi3" id="folioprovi3" disabled>
                                    </div>
                                </div>
                                    -->
                                <div class="col-sm-2">
                                    <div class="form-group input-group-sm">
                                        <label for="facturareq3" class="col-form-label">FACTURA:</label>
                                        <input type="text" class="form-control" name="facturareq3" id="facturareq3" placeholder="FACTURA">

                                        <input type="hidden" class="form-control" name="folioreq3" id="folioreq3" disabled>
                                        <input type="hidden" class="form-control" name="folioprovi3" id="folioprovi3" disabled>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group input-group-sm">
                                        <label for="uuid3" class="col-form-label">UUID FACTURA:</label>
                                        <input type="text" class="form-control" name="uuid3" id="uuid3" placeholder="UUID FACTURA" minlength="36" maxlength="36">
                                    </div>

                                </div>

                                <div class="col-sm-3 ">
                                    <div class="form-group input-group-sm">
                                        <label for="fechareq3" class="col-form-label">FECHA:</label>
                                        <input type="date" class="form-control" name="fechareq3" id="fechareq3" value="<?php echo $fecha; ?>">
                                    </div>
                                </div>

                                <div class="col-sm-3 my-auto">
                                    <div class="form-group input-group-sm">
                                        <label for="fechavp3" class="col-form-label ">FECHA DE PAGO:</label>
                                        <input type="date" id="fechavp3" name="fechavp3" class="form-control text-right" autocomplete="off" value="<?php echo date("Y-m-d") ?>" placeholder="FECHA">
                                    </div>
                                </div>

                            </div>

                            <div class=" row justify-content-sm-center">



                                <div class="col-sm-12">
                                    <div class="input-group input-group-sm">
                                        <label for="proveedor3" class="col-form-label">PROVEEDOR:</label>
                                        <div class="input-group input-group-sm">
                                            <input type="hidden" class="form-control" name="id_prov3" id="id_prov3" value="<?php echo $id_prov; ?>">
                                            <input type="text" class="form-control" name="proveedor3" id="proveedor3" disabled placeholder="SELECCIONAR PROVEEDOR" value="<?php echo $proveedor; ?>">

                                        </div>

                                    </div>
                                </div>



                            </div>

                            <div class=" row justify-content-sm-center">

                                <div class="col-sm-12">
                                    <div class="form-group input-group-sm">
                                        <label for="descripcionreq3" class="col-form-label">CONCEPTO:</label>
                                        <textarea row="2" type="text" class="form-control" name="descripcionreq3" id="descripcionreq3" placeholder="CONCEPTO"></textarea>
                                    </div>
                                </div>

                            </div>

                            <div class="row justify-content-sm-center" style="margin-bottom: 10px;">

                                <div class="col-sm-4 ">
                                    <label for="importe3" class="col-form-label">IMPORTE:</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-dollar-sign"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control text-right" name="importe3" id="importe3" onkeypress="return filterFloat(event,this);">
                                    </div>
                                </div>

                                <div class="col-sm-4 ">
                                    <label for="descuento3" class="col-form-label">AMORT. (DESC):</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-dollar-sign"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control text-right" name="descuento3" id="descuento3" onkeypress="return filterFloat(event,this);">
                                    </div>
                                </div>

                                <div class="col-sm-4 ">
                                    <label for="devolucion3" class="col-form-label">DEVOLUCIÓN:</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-dollar-sign"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control text-right" name="devolucion3" id="devolucion3" onkeypress="return filterFloat(event,this);">
                                    </div>
                                </div>

                                <div class="col-sm-4 ">
                                    <label for="subtotalreq3" class="col-form-label">SUBTOTAL:</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-dollar-sign"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control text-right" name="subtotalreq3" id="subtotalreq3" onkeypress="return filterFloat(event,this);">
                                    </div>
                                </div>

                                <div class=" col-sm-4 ">
                                    <label for=" ivareq3" class="col-form-label">IVA:</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-dollar-sign"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control text-right" name="ivareq3" id="ivareq3" onkeypress="return filterFloat(event,this);">
                                    </div>
                                </div>


                                <div class=" col-sm-4 ">
                                    <label for=" montoreqa3" class="col-form-label">TOTAL:</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-dollar-sign"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control text-right" name="montoreqa3" id="montoreqa3" onkeypress="return filterFloat(event,this);">
                                    </div>
                                </div>

                            </div>

                            <div class="row justify-content-sm-between" style="margin-bottom: 10px;">

                                <div class="col-sm-4 ">
                                    <label for="ret13" class="col-form-label">RET1:</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-dollar-sign"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control text-right" name="ret13" id="ret13" onkeypress="return filterFloat(event,this);">
                                    </div>
                                </div>
                                <div class=" col-sm-4 ">
                                    <label for="ret23" class="col-form-label">RET2:</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-dollar-sign"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control text-right" name="ret23" id="ret23" onkeypress="return filterFloat(event,this);">
                                    </div>
                                </div>
                                <div class=" col-sm-4 ">
                                    <label for="ret33" class="col-form-label">RET3:</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-dollar-sign"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control text-right" name="ret33" id="ret33" onkeypress="return filterFloat(event,this);">
                                    </div>
                                </div>

                            </div>

                            <div class="row justify-content-sm-center" style="margin-bottom: 10px;">


                                <div class="col-sm-4">
                                    <div class="input-group-sm">
                                        <label for="metodovp3" class="col-form-label">METODO DE PAGO:</label>

                                        <select class="form-control" name="metodovp3" id="metodovp3">
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
                                    <label for="montoreq3" class="col-form-label">GRAN TOTAL:</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-dollar-sign"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control text-right" name="montoreq3" id="montoreq3" onkeypress="return filterFloat(event,this); " disabled>
                                    </div>
                                </div>

                            </div>



                            <div class="row justify-content-sm-center">
                                <div class="col-sm-12">
                                    <div class="form-group input-group-sm">
                                        <label for="referenciavp3" class="col-form-label">REFERENCIA DE PAGO</label>
                                        <input type="text" class="form-control" name="referenciavp3" id="referenciavp3" autocomplete="off" placeholder="REFERENCIA (CHEQUE,#AUTORIZACIÓN)">
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-sm-center">
                                <div class="col-sm-12">
                                    <div class="form-group input-group-sm">
                                        <label for="observacionesvp3" class="col-form-label">OBSERVACIONES:</label>
                                        <textarea class="form-control" name="observacionesvp3" id="observacionesvp3" rows="3" autocomplete="off" placeholder="OBSERVACIONES"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-sm-center">





                            </div>

                        </div>





                        <div class="modal-footer">
                            <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fas fa-ban"></i> Cancelar</button>
                            <button type="button" id="btnGuardarvp3" name="btnGuardarvp3" class="btn btn-success" value="btnGuardarvp3"><i class="far fa-save"></i> Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- TERMINA TRASLADAR A CXP -->
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