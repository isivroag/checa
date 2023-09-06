<?php
$pagina = "requisicion";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();
$fecha = date('Y-m-d');
$id_prov = "";
$proveedor = "";
$nreq = 0;



$id_obra = null;
$obra = null;

if (isset($_GET['folio'])){
    $folio =  $_GET['folio'];
    $consulta="SELECT * FROM reportereq WHERE folio_rpt='$folio'";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();
    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    foreach ($data as $row){
        $fecha=$row['fecha'];
        $importe=$row['importe'];
    }
    $consulta = "SELECT * FROM vreq WHERE estado_req=1 and generado=1 and folio_rpt='$folio' and seleccion=2 ORDER BY id_obra,id_prov,fecha,folio_req";    

}else{
    $folio=0;
    $consulta = "SELECT * FROM vreq WHERE estado_req=1 and generado=0 and seleccion=1 ORDER BY id_obra,id_prov,fecha,folio_req";
}





$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);







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
                <h1 class="card-title mx-auto">REQUISICIONES</h1>
            </div>

            <div class="card-body">

                <div class="row justify-content-between">
                    <div class="col-sm-3">
                        <?php if($folio==0){?>
                        <button id="btnGuardar" type="button" class="btn bg-gradient-green btn-ms" data-toggle="modal"><i class="fa-solid fa-floppy-disk text-light"></i><span class="text-light"> Aplicar y Guardar Reporte</span></button>
                        <?php }?>
                        <button id="btnImprimir" type="button" class="btn bg-gradient-danger btn-ms" style="display:none;" data-toggle="modal"><i class="fa-solid fa-file-pdf text-light"></i><span class="text-light"> Exportar Reporte</span></button>
                    </div>

                </div>

                <br>

                <div class="row justify-content-center">
                    <div class="col-sm-2">
                        <div class="form-group input-group-sm">
                            <label for="foliorpt" class="col-form-label">Folio Reporte:</label>
                            <input type="text" class="form-control" name="foliorpt" id="foliorpt" value="<?php echo ($folio!=0) ?  $folio: ''?>" disabled>

                        </div>
                    </div>
                    <div class="col-sm-1"></div>

                    <div class="col-sm-2">
                        <div class="form-group input-group-sm">
                            <label for="fecharpt" class="col-form-label">Fecha Reporte:</label>
                            <input type="date" class="form-control" name="fecharpt" id="fecharpt" value="<?php echo ($folio!=0) ?  $fecha: date('Y-m-d')?>">
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group input-group-sm">
                            <label for="importerpt" class="col-form-label">Importe Reporte:</label>
                            <input type="text " class="form-control text-right text-bold" name="importerpt" id="importerpt" value="<?php echo ($folio!=0) ?  $importe: ''?>">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table name="tablaV" id="tablaV" class="table table-sm table-striped table-bordered table-condensed w-auto mx-auto " style="width:100%;font-size:15px">
                                <thead class="text-center bg-gradient-green">
                                    <tr>
                                        <th>FOLIO</th>
                                        <th>ID OBRA</th>
                                        <th>OBRA</th>
                                        <th>ID PROV</th>
                                        <th>PROVEEDOR</th>
                                        <th>FECHA</th>
                                        <th>CONCEPTO</th>
                                        <th>MONTO</th>
                                        <th>DETALLE</th>



                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($data as $dat) {
                                    ?>
                                        <tr>
                                            <td><?php echo $dat['folio_req'] ?></td>
                                            <td><?php echo $dat['id_obra'] ?></td>
                                            <td><?php echo $dat['corto_obra'] ?></td>
                                            <td><?php echo $dat['id_prov'] ?></td>
                                            <td><?php echo $dat['razon_prov'] ?></td>
                                            <td class="text-center"><?php echo $dat['fecha'] ?></td>
                                            <td><?php echo $dat['desc_req'] ?></td>
                                            <td class="text-right"><?php echo number_format($dat['monto_req'], 2) ?></td>
                                            <td></td>



                                        </tr>
                                    <?php
                                    }
                                    ?>
                                <tfoot>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-bold">TOTAL</td>
                                    <td class="text-bold"></td>
                                    <td></td>
                                </tfoot>
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.card-body -->

        <!-- /.card-footer-->

        <!-- /.card -->

    </section>



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
    <!-- INICIA VER -->
    <section>
        <div class="modal fade" id="modalVer" tabindex="-2" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-green">
                        <h5 class="modal-title" id="exampleModalLabel">DETALLE REQUISICION</h5>

                    </div>
                    <form id="formDatos" action="" method="POST">


                        <div class="content" disab>

                            <div class="card card-widget" style="margin-bottom:0px;">



                                <div class="card-body" style="margin:0px;padding:1px;">

                                    <div class="row justify-content-sm-around">



                                        <div class="col-sm-3">
                                            <div class="form-group input-group-sm">
                                                <label for="folio" class="col-form-label">Folio:</label>
                                                <input type="text" class="form-control" name="folio" id="folio" disabled>

                                            </div>
                                        </div>
                                        <div class="col-sm-3"></div>

                                        <div class="col-sm-3">
                                            <div class="form-group input-group-sm">
                                                <label for="fecha" class="col-form-label">Fecha:</label>
                                                <input type="date" class="form-control" name="fecha" id="fecha" disabled>
                                            </div>
                                        </div>







                                        <div class="col-sm-11">
                                            <div class="form-group">

                                                <input type="hidden" class="form-control" name="id_obra" id="id_obra" disabled>
                                                <label for="obra" class="col-form-label">Obra:</label>

                                                <div class="input-group input-group-sm">

                                                    <input type="text" class="form-control" name="obra" id="obra" disabled>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-11">
                                            <div class="form-group">


                                                <input type="hidden" class="form-control" name="id_prov" id="id_prov" disabled>
                                                <label for="nombre" class="col-form-label">Proveedor:</label>

                                                <div class="input-group input-group-sm">

                                                    <input type="text" class="form-control" name="nombre" id="nombre" disabled>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-11">
                                            <div class="form-group">

                                                <input type="hidden" class="form-control" name="id_sol" id="id_sol" disabled>
                                                <label for="solicitante" class="col-form-label">Solicitante:</label>

                                                <div class="input-group input-group-sm">

                                                    <input type="text" class="form-control" name="solicitante" id="solicitante" disabled>

                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class=" row justify-content-sm-center">
                                        <div class="col-sm-11">

                                            <div class="form-group">
                                                <label for="concepto" class="col-form-label">Descripción:</label>
                                                <textarea rows="2" class="form-control" name="concepto" id="concepto" disabled></textarea>
                                            </div>

                                        </div>



                                    </div>
                                    <div class="row justify-content-sm-center m-auto" style="padding:5px 0px;margin-bottom:5px">
                                        <div class="col-sm-12">
                                            <div class="card ">

                                                <div class="card-header bg-gradient-green " style="margin:0px;padding:8px">
                                                    <div class="card-tools" style="margin:0px;padding:0px;">


                                                    </div>
                                                    <h1 class="card-title text-light">DETALLE DE CONCEPTO</h1>
                                                    <div class="card-tools" style="margin:0px;padding:0px;">


                                                    </div>
                                                </div>

                                                <div class="card-body" style="margin:0px;padding:3px;">



                                                    <div class="row">

                                                        <div class="col-lg-12 mx-auto">
                                                            <div class="table-responsive" style="padding:5px;">
                                                                <table name="tablaDet" id="tablaDet" class="table table-sm table-striped table-bordered table-condensed text-nowrap mx-auto" style="width:100%;font-size:15px">
                                                                    <thead class="text-center bg-gradient-green">
                                                                        <tr>
                                                                            <th>Id</th>
                                                                            <th>Concepto </th>
                                                                            <th>Unidad</th>
                                                                            <th>Precio U.</th>
                                                                            <th>Volumen</th>
                                                                            <th>Importe</th>

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
                                        </div>
                                    </div>


                                    <div class="row justify-content-sm-around" style="padding:5px 0px;margin-bottom:5px">

                                        <div class="col-sm-8 ">


                                        </div>



                                        <div class="col-sm-3 ">
                                            <label for="total" class="col-form-label ">Total:</label>

                                            <div class="input-group input-group-sm">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-dollar-sign"></i>
                                                    </span>
                                                </div>

                                                <input type="text" class="form-control text-right text-bold" name="total" id="total" disabled>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- INICIA VER -->







</div>


<?php include_once 'templates/footer.php'; ?>
<script src="fjs/cntareqrpt.js?v=<?php echo (rand()); ?>"></script>
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
<script src="https://cdn.datatables.net/plug-ins/1.10.21/sorting/formatted-numbers.js"></script>