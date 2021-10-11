<?php
$pagina = "rptobra";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

if ($_SESSION['id_obra'] == null) {
    $id_obra = null;
    $obra = null;
    $consultacon = "SELECT * FROM w_obra WHERE estado_obra=1 ORDER BY id_obra";
    $resultadocon = $conexion->prepare($consultacon);
    $resultadocon->execute();
    $datacon = $resultadocon->fetchAll(PDO::FETCH_ASSOC);

    if (isset($_GET['id_obra'])) {
        $id_obra = $_GET['id_obra'];

        //BUSCAR NOMBRE DE OBRA
        $consultaobra = "SELECT corto_obra,monto_obra from w_obra where id_obra='$id_obra'";
        $resultadoobra = $conexion->prepare($consultaobra);
        $resultadoobra->execute();
        $dataobra = $resultadoobra->fetchAll(PDO::FETCH_ASSOC);
        foreach ($dataobra as $rowobra) {
            $obra = $rowobra['corto_obra'];
            $montoobra = $rowobra['monto_obra'];
         
        }

        // BUSCAR INGRESOS
        $consultain = "SELECT * FROM vcxc WHERE id_obra='$id_obra' and estado_cxc=1 ORDER BY id_obra,fecha_cxc,folio_cxc";
        $resultadoin = $conexion->prepare($consultain);
        $resultadoin->execute();
        $datain = $resultadoin->fetchAll(PDO::FETCH_ASSOC);

        // BUSCAR EGRESOS
        $consultaeg = "SELECT * FROM voperacioneseg WHERE id_obra='$id_obra' and estadoop=1 ORDER BY id_obra,fechaop";
        $resultadoeg = $conexion->prepare($consultaeg);
        $resultadoeg->execute();
        $dataeg = $resultadoeg->fetchAll(PDO::FETCH_ASSOC);
    }
} else {

    $id_obra = $_SESSION['id_obra'];
    $obra = $_SESSION['nom_obra'];


    // BUSCAR INGRESOS
    $consultain = "SELECT * FROM vcxc WHERE id_obra='$id_obra' and estado_cxc=1 ORDER BY id_obra,fecha_cxc,folio_cxc";
    $resultadoin = $conexion->prepare($consultain);
    $resultadoin->execute();
    $datain = $resultado->fetchAll(PDO::FETCH_ASSOC);

    // BUSCAR EGRESOS
    $consultaeg = "SELECT * FROM voperacioneseg WHERE id_obra='$id_obra' and estado_op=1 ORDER BY id_obra,fechaop";
    $resultadoeg = $conexion->prepare($consultaeg);
    $resultadoeg->execute();
    $dataeg = $resultadoeg->fetchAll(PDO::FETCH_ASSOC);
}




$message = "";



?>

<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

<div class="content-wrapper">



    <section class="content">


        <div class="card">
            <div class="card-header bg-gradient-green text-light">
                <h1 class="card-title mx-auto">REPORTE DE OBRA</h1>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">

                        <div class="card">
                            <div class="card-header bg-gradient-green">
                                SELECCIONAR OBRA
                            </div>
                            <div class="card-body ">
                                <div class="row justify-content-center">
                                    <div class="col-sm-6">
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
                                    <?php if ($id_obra != null) { ?>
                                        <div class="col-sm-2">
                                        <label for="montoobra" class="col-form-label">MONTO DE OBRA:</label>
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-dollar-sign"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control text-right" name="montoobra" id="montoobra" value="<?php echo number_format($montoobra,2); ?>">
                                        </div>

                                           
                                        </div>
                                        <!--
                                        <div class="col-sm-2">
                                            <label for="saldoobra" class="col-form-label">SALDO ACTUAL:</label>
                                            <div class="input-group input-group-sm">

                                                <input type="text" class="form-control" name="saldoobra" id="saldoobra" value="<?php echo $saldoobra; ?>">

                                            </div>
                                        </div>
                                    -->
                                    <?php } ?>


                                </div>

                                <div class="row justify-content-center mt-3 mb-3 p-1">
                                    <div class="col-sm-12">
                                        <div class="container-fluid">

                                            <div class="row justify-content-center">
                                                <div class="col-lg-12">
                                                    <div class="table-responsive">
                                                        <table name="tablaV" id="tablaV" class="table table-sm table-striped table-bordered table-condensed  text-nowrap w-auto mx-auto" style="width:100%">
                                                            <thead class="text-center bg-gradient-green">
                                                                <tr>
                                                                    <th>FOLIO</th>
                                                                    <th>FACTURA</th>
                                                                    <th>FECHA</th>
                                                                    <th>CONCEPTO</th>
                                                                    <th>MONTO</th>
                                                                    <th>SALDO</th>


                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                if ($id_obra != null) {
                                                                    foreach ($datain as $dat) {
                                                                ?>
                                                                        <tr>
                                                                            <td><?php echo $dat['folio_cxc'] ?></td>
                                                                            <td><?php echo $dat['factura_cxc'] ?></td>
                                                                            <td class="text-center"><?php echo $dat['fecha_cxc'] ?></td>
                                                                            <td><?php echo $dat['desc_cxc'] ?></td>
                                                                            <td class="text-right"><?php echo number_format($dat['monto_cxc'], 2) ?></td>
                                                                            <td class="text-right"><?php echo number_format($dat['saldo_cxc'], 2) ?></td>



                                                                        </tr>
                                                                <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </tbody>
                                                            <tfoot>

                                                                <th></th>
                                                                <th></th>
                                                                <th></th>
                                                                <th class="text-right text-bold">TOTALES:</th>
                                                                <th class="text-right text-bold"></th>
                                                                <th class="text-right text-bold"></th>
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                                <div class="row justify-content-center mt-3 mb-3 p-1">
                                    <div class="col-sm-12">
                                        <div class="container-fluid">

                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="table-responsive">
                                                        <table name="tablaEg" id="tablaEg" class="table table-sm table-striped table-bordered table-condensed w-auto mx-auto" style="width:100%">
                                                            <thead class="text-center bg-gradient-info">
                                                                <tr>
                                                                    <th>ORIGEN</th>
                                                                    <th>FACTURA</th>
                                                                    <th>PROVEEDOR</th>
                                                                    <th>FECHA</th>
                                                                    <th>CONCEPTO</th>
                                                                    <th>MONTO</th>
                                                                    <th>SALDO</th>


                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                if ($id_obra != null) {
                                                                    foreach ($dataeg as $dat) {
                                                                ?>
                                                                        <tr>
                                                                            <td><?php echo $dat['tipoop'] ?></td>
                                                                            <td><?php echo $dat['facturaop'] ?></td>

                                                                            <td><?php echo $dat['razon_prov'] ?></td>
                                                                            <td class="text-center"><?php echo $dat['fechaop'] ?></td>
                                                                            <td><?php echo $dat['conceptoop'] ?></td>
                                                                            <td class="text-right"><?php echo number_format($dat['montoop'], 2) ?></td>
                                                                            <td class="text-right"><?php echo number_format($dat['saldoop'], 2) ?></td>




                                                                        </tr>
                                                                <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </tbody>
                                                            <tfoot>

                                                                <th></th>
                                                                <th></th>

                                                                <th></th>
                                                                <th></th>
                                                                <th class="text-right text-bold">TOTALES:</th>
                                                                <th class="text-right text-bold"></th>
                                                                <th class="text-right text-bold"></th>
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>


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

</div>


<?php include_once 'templates/footer.php'; ?>
<script src="fjs/rptobra.js"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>