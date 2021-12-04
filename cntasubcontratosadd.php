<?php
$pagina = "extrasub";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();
$fecha = date('Y-m-d');

if ($_SESSION['id_obra'] != null) {
    $id_obra = $_SESSION['id_obra'];
    $consulta = "SELECT * FROM vsubcontrato WHERE id_obra='$id_obra' and estado_sub=1 ORDER BY id_obra,id_prov,fecha_sub,folio_sub";
} else {
    $id_obra = null;
    $obra = null;
    $consulta = "SELECT * FROM vsubcontrato WHERE estado_sub=1 ORDER BY id_obra,id_prov,fecha_sub,folio_sub";
}




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



$consultaprov = "SELECT * FROM w_proveedor WHERE estado_prov=1 ORDER BY id_prov";
$resultadoprov = $conexion->prepare($consultaprov);
$resultadoprov->execute();
$dataprov = $resultadoprov->fetchAll(PDO::FETCH_ASSOC);



$message = "";



?>


<style>
    .modal {
        overflow: hidden;
    }

    .modal.modal-fullscreen .modal-dialog {

        width: 90vw;

        height: 90vh;

        margin: auto;

        padding: 0;

        max-width: none;

    }



    .modal.modal-fullscreen .modal-content {

        height: auto;

        height: 100vh;

        border-radius: 0;

        border: none;

    }

    .modal.modal-fullscreen .modal-body {

        overflow-y: auto;

    }

    .w10{
        width: 8% !important;
    }
    .w40{
        width: 45% !important;
    }
</style>


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
                <h1 class="card-title mx-auto">SUBCONTRATOS</h1>
            </div>

            <div class="card-body">
<!--
                <div class="row">
                    <div class="col-lg-12">
                        <button id="btnNuevo" type="button" class="btn bg-gradient-green btn-ms" data-toggle="modal" <?php echo $_SESSION['s_rol'] == 1 ? 'disabled' : ''  ?>><i class="fas fa-plus-square text-light"></i><span class="text-light"> Nuevo</span></button>
                    </div>
                </div>
                <br>
-->
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table name="tablaV" id="tablaV" class="table table-sm table-striped table-bordered table-condensed w-auto mx-auto" style="width:100%; font-size:15px">
                                    <thead class="text-center bg-gradient-green">
                                        <tr>
                                            <th>FOLIO</th>

                                            <th>CLAVE</th>
                                            <th>OBRA</th>
                                            <th>ID PROV</th>
                                            <th>PROVEEDOR</th>
                                            <th>FECHA</th>
                                            <th>CONCEPTO</th>
                                            <th>MONTO</th>
                                            <th>SALDO</th>
                                            <?php if($_SESSION['s_rol'] == '3' || $_SESSION['s_rol'] == '2'){ ?>
                                            <th>COBRADO</th>
                                            <?php }?>
                                            <th>ACCIONES</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($data as $dat) {
                                        ?>
                                            <tr>
                                                <td><?php echo $dat['folio_sub'] ?></td>

                                                <td><?php echo $dat['clave_sub'] ?></td>
                                                <td><?php echo $dat['corto_obra'] ?></td>
                                                <td><?php echo $dat['id_prov'] ?></td>
                                                <td><?php echo $dat['razon_prov'] ?></td>
                                                <td class="text-center"><?php echo $dat['fecha_sub'] ?></td>
                                                <td><?php echo $dat['desc_sub'] ?></td>
                                                <td class="text-right"><?php echo number_format($dat['monto_sub'], 2) ?></td>
                                                <td class="text-right"><?php echo number_format($dat['saldo_sub'], 2) ?></td>
                                                <?php if($_SESSION['s_rol'] == '3' || $_SESSION['s_rol'] == '2'){ ?>
                                                <td class="text-right"><?php echo number_format($dat['cobrado_sub'], 2) ?></td>
                                                
                                                <?php }?>
                                                <td></td>


                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-bold text-right">TOTALES</td>
                                        <td class="text-bold text-right"></td>
                                        <td class="text-bold text-right"></td>
                                        <?php if($_SESSION['s_rol'] == '3' || $_SESSION['s_rol'] == '2'){ ?>
                                        <td class="text-bold text-right"></td>
                                        <?php }?>
                                        <td></td>
                                    </tfoot>
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

    <!-- INICIA ALTA DE SUBCONTRATOS -->
    <section>
        <div class="modal fade" id="modalAlta" tabindex="-1">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content w-auto">
                    <div class="modal-header bg-gradient-green">
                        <h5 class="modal-title" id="exampleModalLabel">ALTA DE SUBCONTRATO</h5>

                    </div>


                    <form id="formAlta" action="" method="POST" autocomplete="off">
                        <div class="card card-widget" style="margin: 10px;">
                            <div class="modal-body ">
                                <div class="row justify-content-sm-center">

                                    <div class="col-sm-2">
                                        <div class="form-group input-group-sm">
                                            <label for="folio" class="col-form-label">ID:</label>
                                            <input type="text" class="form-control" name="folio" id="folio" disabled>
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group input-group-sm">
                                            <label for="clave" class="col-form-label">CLAVE:</label>
                                            <input type="text" class="form-control" name="clave" id="clave" placeholder="CLAVE SUBCONTRATO">
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                    </div>

                                    <div class="col-sm-3  ">
                                        <div class="form-group input-group-sm">
                                            <label for="fecha" class="col-form-label">FECHA:</label>
                                            <input type="date" class="form-control" name="fecha" id="fecha" value="<?php echo $fecha; ?>">
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

                                    <div class="col-sm-12">
                                        <div class="input-group input-group-sm">
                                            <label for="proveedor" class="col-form-label">PROVEEDOR:</label>
                                            <div class="input-group input-group-sm">
                                                <input type="hidden" class="form-control" name="id_prov" id="id_prov">
                                                <input type="text" class="form-control" name="proveedor" id="proveedor" disabled placeholder="SELECCIONAR PROVEEDOR">
                                                <span class="input-group-append">
                                                    <button id="bproveedor" type="button" class="btn btn-sm btn-primary"><i class="fas fa-search"></i></button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group input-group-sm">
                                            <label for="descripcion" class="col-form-label">CONCEPTO:</label>
                                            <textarea rows="2" class="form-control" name="descripcion" id="descripcion" placeholder="CONCEPTO"></textarea>
                                        </div>
                                    </div>

                                </div>

                                <div class="row justify-content-sm-center" style="margin-bottom: 10px;">
                                    <div class="col-sm-4 ">
                                        <label for="subtotal" class="col-form-label">SUBTOTAL:</label>
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-dollar-sign"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control text-right" name="subtotal" id="subtotal" onkeypress="return filterFloat(event,this);">
                                        </div>
                                    </div>
                                    <div class="col-sm-4 ">
                                        <label for="iva" class="col-form-label">IVA:</label>
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-dollar-sign"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control text-right" name="iva" id="iva" onkeypress="return filterFloat(event,this);">
                                        </div>
                                    </div>

                                    <div class="col-sm-4 ">
                                        <label for="monto" class="col-form-label">TOTAL:</label>
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-dollar-sign"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control text-right" name="monto" id="monto" onkeypress="return filterFloat(event,this);">
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class=" modal-footer">
                            <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fas fa-ban"></i> Cancelar</button>
                            <button type="button" id="btnGuardar" name="btnGuardar" class="btn btn-success" value="btnGuardar"><i class="far fa-save"></i> Guardar</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </section>
    <!-- TERMINA ALTA DE SUBCONTRATOS -->

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

                                    <div class="col-sm-3">
                                        <div class="form-group input-group-sm">
                                            <label for="clavereq" class="col-form-label">FACTURA:</label>
                                            <input type="text" class="form-control" name="clavereq" id="clavereq" placeholder="FACTURA">
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
    <!-- TERMINA ALTA DE REQUISICION -->


    <!-- INICIA ALTA DE PROVISION -->
    <section>
        <div class="modal fade" id="modalProv" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content w-auto">
                    <div class="modal-header bg-gradient-green">
                        <h5 class="modal-title" id="exampleModalLabel">ALTA DE PROVISIÓN</h5>

                    </div>
                    <form id="formProv" action="" method="POST" autocomplete="off">
                        <div class="card card-widget" style="margin: 10px;">

                            <div class="modal-body">
                                <div class="row justify-content-sm-center">

                                    <div class="col-sm-3">
                                        <div class="form-group input-group-sm">
                                            <label for="folioprov" class="col-form-label">FOLIO PROVISIÓN:</label>
                                            <input type="text" class="form-control" name="folioprov" id="folioprov" disabled>
                                            <input type="hidden" class="form-control" name="foliosubcontratop" id="foliosubcontratop" disabled>
                                            <input type="hidden" class="form-control" name="idprovp" id="idprovp" disabled>

                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                    </div>

                                    <div class="col-sm-4">
                                    </div>

                                    <div class="col-sm-3 ">
                                        <div class="form-group input-group-sm">
                                            <label for="fechaprov" class="col-form-label">FECHA:</label>
                                            <input type="date" class="form-control" name="fechaprov" id="fechaprov" value="<?php echo $fecha; ?>">
                                        </div>
                                    </div>

                                </div>

                                <div class=" row justify-content-sm-center">

                                    <div class="col-sm-12">
                                        <div class="form-group input-group-sm">
                                            <label for="descripcionprov" class="col-form-label">CONCEPTO:</label>
                                            <textarea row="2" type="text" class="form-control" name="descripcionprov" id="descripcionprov" placeholder="CONCEPTO"></textarea>
                                        </div>
                                    </div>

                                </div>

                                <div class="row justify-content-sm-center" style="margin-bottom: 10px;">

                                    <div class="col-sm-4 ">
                                        <label for="subtotalprov" class="col-form-label">SUBTOTAL:</label>
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-dollar-sign"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control text-right" name="subtotalprov" id="subtotalprov" onkeypress="return filterFloat(event,this);">
                                        </div>
                                    </div>
                                    <div class=" col-sm-4 ">
                                        <label for=" ivaprov" class="col-form-label">IVA:</label>
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-dollar-sign"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control text-right" name="ivaprov" id="ivaprov" onkeypress="return filterFloat(event,this);">
                                        </div>
                                    </div>
                                    <div class=" col-sm-4 ">
                                        <label for="montoprov" class="col-form-label">TOTAL:</label>
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-dollar-sign"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control text-right" name="montoprov" id="montoprov" onkeypress="return filterFloat(event,this);">
                                        </div>
                                    </div>

                                </div>

                            </div>

                            <div class=" modal-footer">
                                <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fas fa-ban"></i> Cancelar</button>
                                <button type="button" id="btnGuardarprov" name="btnGuardarprov" class="btn btn-success" value="btnGuardarprov"><i class="far fa-save"></i> Guardar</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- TERMINA ALTA DE PROVISION -->


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

    <!-- INICIA PROVEEDOR -->
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
    <!-- TERMINA PROVEEDOR -->


    <!-- INICIA VER REQUISICIONES -->
    <section>
        <div class="container">



            <div class="modal fade " id="modalResumen" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl " role="document">
                    <div class="modal-content w-auto">
                        <div class="modal-header bg-gradient-green">
                            <h5 class="modal-title" id="exampleModalLabel">RESUMEN DE REQUISICIONES</h5>

                        </div>
                        <br>
                        <div class="table-hover table-responsive " style="padding:10px; font-size:15px">
                            <table name="tablaResumen" id="tablaResumen" class="table table-sm table-striped table-bordered table-condensed " style="width:100%">
                                <thead class="text-center bg-gradient-green">
                                    <tr>
                                        <th class="w10" >FOLIO</th>
                                        <th class="w10">FACTURA</th>
                                        <th class="w10" >FECHA</th>
                                        <th class="w40">CONCEPTO</th>
                                        <th class="w10">MONTO</th>
                                        <th class="w10">SALDO</th>
                                        <th class="w10" >ACCIONES</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>

                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th class="text-right text-bold">TOTALES</th>
                                    <th class="text-right text-bold"></th>
                                    <th class="text-right text-bold"></th>
                                    <th></th>
                                </tfoot>
                            </table>
                        </div>


                    </div>

                </div>

            </div>


        </div>
    </section>
    <!-- TERMINA VER REQUISICIONES -->


    <!-- INICIA VER PROVISIONES -->
    <section>
        <div class="container">



            <div class="modal fade" id="modalVerprov" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-md" role="document">
                    <div class="modal-content w-auto">
                        <div class="modal-header bg-gradient-green">
                            <h5 class="modal-title" id="exampleModalLabel">RESUMEN DE PROVISIONES</h5>

                        </div>
                        <br>
                        <div class="table-hover responsive w-auto " style="padding:10px">
                            <table name="tablaVerprov" id="tablaVerprov" class="table table-sm table-striped table-bordered table-condensed display compact" style="width:100%">
                                <thead class="text-center bg-gradient-green">
                                    <tr>
                                        <th>FOLIO</th>
                                        <th>SUBCONTRATO</th>
                                        <th>FECHA</th>
                                        <th>CONCEPTO</th>
                                        <th>SUBTOTAL</th>
                                        <th>IVA</th>
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
                                    <th class="text-right text-bold">TOTALES</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th class="text-right text-bold"></th>
                                    <th class="text-right text-bold"></th>
                                    <th></th>

                                </tfoot>
                            </table>
                        </div>


                    </div>

                </div>

            </div>


        </div>
    </section>
    <!-- TERMINA VER PROVISIONES -->


    <!-- INICIA VER PAGOS -->
    <section>
        <div class="container">



            <div class="modal fade myModal" id="modalResumenp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-md" role="document">
                    <div class="modal-content w-auto">
                        <div class="modal-header bg-gradient-primary">
                            <h5 class="modal-title" id="exampleModalLabel">Resumen de Pagos</h5>

                        </div>
                        <br>
                        <div class="table-hover responsive w-auto " style="padding:10px">
                            <table name="tablaResumenp" id="tablaResumenp" class="table table-sm table-striped table-bordered table-condensed display compact" style="width:100%">
                                <thead class="text-center bg-gradient-primary">
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
                                    <th class="text-right text-bold">TOTAL</th>
                                    <th class="text-right text-bold"></th>
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
    <!-- TERMINA VER PAGOS-->

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
                                        <label for="foliovp" class="col-form-label">FOLIO REQUISICION:</label>
                                        <input type="text" class="form-control" name="foliovp" id="foliovp" disabled>
                                        <input type="hidden" class="form-control" name="id_prov" id="id_prov" disabled>
                                    </div>
                                </div>




                                <div class="col-sm-3 my-auto">
                                    <div class="form-group input-group-sm">
                                        <label for="fechavp" class="col-form-label ">FECHA DE PAGO:</label>
                                        <input type="date" id="fechavp" name="fechavp" class="form-control text-right" autocomplete="off" value="<?php echo date("Y-m-d") ?>" placeholder="FECHA">
                                    </div>
                                </div>

                            </div>

                            <div class="row">
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
                                        <input type="text" id="montopagovp" name="montopagovp" class="form-control text-right" autocomplete="off" placeholder="MONTO DEL PAGO" onkeypress="return filterFloat(event,this);">
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

    <!-- INICIA CANCELAR -->
    <section>
        <div class="modal fade" id="modalcan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog " role="document">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-danger">
                        <h5 class="modal-title" id="exampleModalLabel">CANCELAR REGISTRO</h5>
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

   <!-- INICIA CANCELAR -->
   <section>
        <div class="modal fade" id="modalcobrar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog " role="document">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-success">
                        <h5 class="modal-title" id="exampleModalLabel">ESTABLECER MONTO COBRADO A CLIENTE</h5>
                    </div>
                    <div class="card card-widget" style="margin: 10px;">
                        <form id="formcobrar" action="" method="POST">
                            <div class="modal-body row justify-content-center">
                                
                                <div class="col-lg-8">
                                <label for="montocobrado" class="col-form-label">IMPORTE COBRADO:</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-dollar-sign"></i>
                                            </span>

                                        </div>
                                        <input type="hidden" id="foliosubcob" name="foliosubcob">
                                        <input type="text" id="montocobrado" name="montocobrado" class="form-control text-right" autocomplete="off" placeholder="IMPORTE" onkeypress="return filterFloat(event,this);">
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
                        <button type="button" id="btnGuardarcobro" name="btnGuardarcobro" class="btn btn-success" value="btnGuardarcobro"><i class="far fa-save"></i> Guardar</button>
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
<script src="fjs/cntasubcontratoadd.js?v=<?php echo (rand()); ?>"></script>
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