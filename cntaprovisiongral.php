<?php
$pagina = "egresosgral";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();
$fecha = date('Y-m-d');
$id_prov = "";
$proveedor = "";


$consultaprov = "SELECT * FROM vprovisiongral WHERE estado_provi=1 ORDER BY folio_provi";
$resultadoprov = $conexion->prepare($consultaprov);
$resultadoprov->execute();
$data = $resultadoprov->fetchAll(PDO::FETCH_ASSOC);


$consultaprov = "SELECT * FROM w_proveedor WHERE estado_prov=1 ORDER BY id_prov";
$resultadoprov = $conexion->prepare($consultaprov);
$resultadoprov->execute();
$dataprov = $resultadoprov->fetchAll(PDO::FETCH_ASSOC);



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
                <h1 class="card-title mx-auto">PROVISIONES</h1>
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
                                    <input type="hidden" class="form-control" name="tipo_proy" id="tipo_proy" value=1>

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
                                <table name="tablaV" id="tablaV" class="table table-sm table-striped table-bordered table-condensed w-auto mx-auto " style="width:100%;font-size:15px">
                                    <thead class="text-center bg-gradient-green">
                                        <tr>
                                            <th>FOLIO</th>
                                            <th>ID PROV</th>
                                            <th>PROVEEDOR</th>
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
                                                <td><?php echo $dat['folio_provi'] ?></td>
                                                <td><?php echo $dat['id_prov'] ?></td>
                                                <td><?php echo $dat['razon_prov'] ?></td>
                                                <td class="text-center"><?php echo $dat['fecha_provi'] ?></td>
                                                <td><?php echo $dat['concepto_provi'] ?></td>
                                                <td class="text-right"><?php echo number_format($dat['monto_provi'], 2) ?></td>
                                                <td class="text-right"><?php echo number_format($dat['saldo_provi'], 2) ?></td>
                                             
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
                        <h5 class="modal-title" id="exampleModalLabel">ALTA DE PROVISIONES</h5>

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
<!--
                                    <div class=" col-sm-4 ">

                                    </div>


                                    <div class="col-sm-4"></div>

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

                                    -->

                                    
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

   

    <!-- INICIA PROVEEDOR -->
    <section>
        <div class="container">

            <!-- Default box -->
            <div class="modal fade" id="modalProveedor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-md" role="document">
                    <div class="modal-content w-auto">
                        <div class="modal-header bg-gradient-green">
                            <h5 class="modal-title" id="exampleModalLabel">BUSCAR PROVEEDOR</h5>

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
    <!-- TERMINA PROVEEDOR -->

    <!-- INICIA RESUMEN DE CXP -->
    <section>
        <div class="container">


            <!-- Default box -->
            <div class="modal fade" id="modalResumen" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-md" role="document">
                    <div class="modal-content w-auto">
                        <div class="modal-header bg-gradient-green">
                            <h5 class="modal-title" id="exampleModalLabel">Relación de CXP</h5>

                        </div>
                        <br>
                        <div class="table-hover responsive w-auto " style="padding:10px">
                            <table name="tablaResumen" id="tablaResumen" class="table table-sm table-striped table-bordered table-condensed display compact" style="width:100%">
                                <thead class="text-center bg-gradient-green">
                                    <tr>
                                        <th>FOLIO</th>
                                        <th>FECHA</th>
                                        <th>FACTURA</th>
                                        <th>MONTO</th>
                                        <th>SALDO</th>

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
                                    <th class="text-right"></th>
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
    <!-- TERMINA RESUMEN DE CXP -->

    <!-- INICIA TRASLADAR A CXP -->
    <section>
        <div class="modal fade" id="modalPago" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-green">
                        <h5 class="modal-title" id="exampleModalLabel">TRASLADAR A CXP</h5>

                    </div>
                    <form id="formPago" action="" method="POST">
                        <div class="modal-body">
                            <div class="row justify-content-sm-center">

                                <div class="col-sm-2">
                                    <div class="form-group input-group-sm">
                                        <label for="folioreq2" class="col-form-label">FOLIO:</label>
                                        <input type="text" class="form-control" name="folioreq2" id="folioreq2" disabled>
                                        <input type="hidden" class="form-control" name="folioprovi" id="folioprovi" disabled>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group input-group-sm">
                                        <label for="facturareq2" class="col-form-label">FACTURA:</label>
                                        <input type="text" class="form-control" name="facturareq2" id="facturareq2" placeholder="FACTURA">
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group input-group-sm">
                                        <label for="uuid" class="col-form-label">UUID FACTURA:</label>
                                        <input type="text" class="form-control" name="uuid" id="uuid" placeholder="UUID FACTURA" minlength="36" maxlength="36">
                                    </div>

                                </div>

                                <div class="col-sm-3 ">
                                    <div class="form-group input-group-sm">
                                        <label for="fechareq2" class="col-form-label">FECHA:</label>
                                        <input type="date" class="form-control" name="fechareq2" id="fechareq2" value="<?php echo $fecha; ?>">
                                    </div>
                                </div>

                            </div>

                            <div class=" row justify-content-sm-center">

                      

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

                                <div class=" col-sm-4 ">

                                </div>


                                <div class="col-sm-4"></div>

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
    <!-- TERMINA TRASLADAR A CXP -->

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


    <!-- INICIA RESUMEN DE PAGOS -->
    <section>
        <div class="container">


            <!-- Default box -->
            <div class="modal fade" id="modalResumenp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-md" role="document">
                    <div class="modal-content w-auto">
                        <div class="modal-header bg-gradient-green">
                            <h5 class="modal-title" id="exampleModalLabel">Resumen de Pagos</h5>

                        </div>
                        <br>
                        <div class="table-hover responsive w-auto " style="padding:10px">
                            <table name="tablaResumenp" id="tablaResumenp" class="table table-sm table-striped table-bordered table-condensed display compact" style="width:100%">
                                <thead class="text-center bg-gradient-green">
                                    <tr>
                                        <th>FOLIO</th>
                                        <th>FECHA</th>
                                        <th>REFERENCIA</th>
                                        <th>MONTO</th>
                                        <th>METODO</th>

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

         <!-- INICIA SALDAR PROV -->
         <section>
        <div class="modal fade" id="modalsaldar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog " role="document">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-success">
                        <h5 class="modal-title" id="exampleModalLabel">SALDAR PROVISION</h5>
                    </div>
                    <div class="card card-widget" style="margin: 10px;">
                        <form id="formsaldar" action="" method="POST">
                            <div class="modal-body row justify-content-center">

                                <div class="col-lg-8">
                                    <label for="saldopendiente" class="col-form-label">SALDO PENDIENTE:</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-dollar-sign"></i>
                                            </span>

                                        </div>
                                        <input type="hidden" id="folioprovs" name="folioprovs">
                                        <input type="text" id="saldopendiente" name="saldopendiente" class="form-control text-right" autocomplete="off" placeholder="IMPORTE" onkeypress="return filterFloat(event,this);" disabled>
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
                        <button type="button" id="btnGuadarsaldar" name="btnGuadarsaldar" class="btn btn-success" value="btnSaldarprov"><i class="far fa-save"></i> Guardar</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- TERMINA SALDAR PROV -->
    <!-- /.content -->
</div>


<?php include_once 'templates/footer.php'; ?>
<script src="fjs/cntaprovisiongral.js?v=<?php echo (rand()); ?>"></script>
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