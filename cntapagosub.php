<?php
$pagina = "cntapagosub";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();



$datanom = 0;
$fecha = date('Y-m-d');

$resultado = 0;

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

        //BUSCAR DATOS DE SUBCONTRATO, REQUISICION Y PAGO

        $consulta = "SELECT folio_sub,clave_sub,id_prov,razon_prov,monto_sub,desc_sub,saldo_sub,sum(monto_pagors) as pagado_sub FROM vpagosubcontrato WHERE id_obra='$id_obra' group by folio_sub";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $datasub = $resultado->fetchAll(PDO::FETCH_ASSOC);
    }
} else {

    $id_obra = $_SESSION['id_obra'];
    $obra = $_SESSION['nom_obra'];

    //BUSCAR NOMBRE DE OBRA
    $consultaobra = "SELECT corto_obra,monto_obra from w_obra where id_obra='$id_obra'";
    $resultadoobra = $conexion->prepare($consultaobra);
    $resultadoobra->execute();
    $dataobra = $resultadoobra->fetchAll(PDO::FETCH_ASSOC);
    foreach ($dataobra as $rowobra) {
        $obra = $rowobra['corto_obra'];
        $montoobra = $rowobra['monto_obra'];
    }
}








$message = "";



?>

<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">


<div class="content-wrapper">



    <!-- TABLA PRINCIPAL -->
    <section class="content">


        <div class="card">
            <div class="card-header bg-gradient-secondary text-light">
                <h1 class="card-title mx-auto">CONSULTA DE PAGOS POR SUBCONTRATO</h1>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">

                        <div class="card">
                            <div class="card-header bg-gradient-secondary">
                                SELECCIONAR OBRA
                            </div>

                            <div class="card-body ">
                                <div class="row justify-content-center mb-3">
                                    <div class="col-sm-5">
                                        <div class="input-group input-group-sm">
                                            <label for="obra" class="col-form-label">OBRA:</label>
                                            <div class="input-group input-group-sm">
                                                <input type="hidden" class="form-control" name="id_obra" id="id_obra" value="<?php echo $id_obra; ?>">
                                                <input type="text" class="form-control" name="obra" id="obra" disabled placeholder="SELECCIONAR OBRA" value="<?php echo $obra; ?>">
                                                <?php if ($id_obra == null) { ?>
                                                    <span class="input-group-append">
                                                        <button id="bobra" type="button" class="btn btn-sm btn-primary"><i class="fas fa-search"></i></button>
                                                    </span>
                                                <?php } ?>
                                            </div>

                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>


                        <?php

                        if ($id_obra != null) { ?>


                            <section class="content">

                                <div class="card">
                                    <div class="card-header bg-gradient-secondary text-light">
                                        <h1 class="card-title mx-auto">DETALLE DE PAGOS</h1>
                                    </div>

                                    <div class="card-body">

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <!-- <button id="btnNuevo" type="button" class="btn bg-gradient-secondary btn-ms" data-toggle="modal"><i class="fas fa-plus-square text-light"></i><span class="text-light"> Nuevo</span></button> -->
                                            </div>
                                        </div>
                                        <br>
                                        <?php
                                        foreach ($datasub as $row) {
                                            $folio_sub = $row['folio_sub'];
                                            $proveedor = $row['razon_prov'];
                                            $clave = $row['clave_sub'];
                                            $descsub = $row['desc_sub'];
                                            $montosub = $row['monto_sub'];
                                            $saldosub=$row['saldo_sub'];
                                            $pagadosub=$row['pagado_sub'];
                                        ?>
                                            <div class="container-fluid">
                                                <div class="card">
                                                    <div class="card-header bg-secondary">
                                                    <div class="row justify-content-sm-center">
                                                        <div class="col-sm-1">
                                                            <div class="form-group input-group-sm">
                                                                <label for="folio_sub" class="col-form-label">SUBCONTRATO:</label>
                                                                <input type="text" class="form-control" name="folio_sub" id="folio_sub" value="<?php echo $folio_sub ?>" disabled>

                                                            </div>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <div class="form-group input-group-sm">
                                                                <label for="clave" class="col-form-label">CLAVE:</label>
                                                                <input type="text" class="form-control" name="clave" id="clave" value="<?php echo $clave ?>" disabled>

                                                            </div>
                                                        </div>
                                                        <div class="col-sm-7">
                                                            <div class="form-group input-group-sm">
                                                                <label for="descsub" class="col-form-label">CONCEPTO SUBCONTRATO:</label>
                                                                <input type="text" class="form-control" name="descsub" id="descsub" value="<?php echo $descsub ?>" disabled>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row justify-content-sm-center">
                                                        <div class="col-sm-4">
                                                            <div class="form-group input-group-sm">
                                                                <label for="proveedor" class="col-form-label">PROVEEDOR:</label>
                                                                <input type="text" class="form-control" name="proveedor" id="proveedor" value="<?php echo $proveedor ?>" disabled>

                                                            </div>
                                                        </div>
                                                        <div class=" col-sm-2">
                                                            <label for="montosub" class="col-form-label">MONTO:</label>
                                                            <div class="input-group input-group-sm">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">
                                                                        <i class="fas fa-dollar-sign"></i>
                                                                    </span>
                                                                </div>
                                                                <input type="text" class="form-control text-right" name="montosub" id="montosub" value=<?php echo number_format($montosub, 2) ?> disabled>
                                                            </div>
                                                        </div>
                                                        <div class=" col-sm-2">
                                                            <label for="pagadosub" class="col-form-label">PAGADO:</label>
                                                            <div class="input-group input-group-sm">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">
                                                                        <i class="fas fa-dollar-sign"></i>
                                                                    </span>
                                                                </div>
                                                                <input type="text" class="form-control text-right" name="pagadosub" id="pagadosub" value=<?php echo number_format($pagadosub, 2) ?> disabled>
                                                            </div>
                                                        </div>
                                                        <div class=" col-sm-2">
                                                            <label for="saldosub" class="col-form-label">SALDO:</label>
                                                            <div class="input-group input-group-sm">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">
                                                                        <i class="fas fa-dollar-sign"></i>
                                                                    </span>
                                                                </div>
                                                                <input type="text" class="form-control text-right" name="saldosub" id="saldosub" value=<?php echo number_format($saldosub, 2) ?> disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    </div>
                                                    


                                                    <?php
                                                    $consulta = "SELECT * FROM vpagosubcontrato WHERE id_obra='$id_obra' and folio_sub='$folio_sub'";
                                                    $resultado = $conexion->prepare($consulta);
                                                    $resultado->execute();
                                                    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
                                                    ?>
                                                    <div class="card-body">
                                                        <div class="row">

                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="table-responsive">
                                                                    <table class="tablaV table table-sm table-striped table-bordered table-condensed w-auto mx-auto" style="width:100%">
                                                                        <thead class="text-center bg-gradient-secondary">
                                                                            <tr>
                                                                                <th>FOLIO SUB</th>
                                                                                <th>FOLIO REQUISICION</th>
                                                                                <th>FOLIO PAGO</th>
                                                                                <th>FACTURA</th>
                                                                                <th>FECHA</th>
                                                                                <th>MONTO</th>
                                                                                <th>REFERENCIA</th>
                                                                                <th>ACCIONES</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                            foreach ($data as $dat) {
                                                                            ?>
                                                                                <tr>
                                                                                    <td><?php echo $dat['folio_sub'] ?></td>
                                                                                    <td><?php echo $dat['id_req'] ?></td>
                                                                                    <td><?php echo $dat['folio_pagors'] ?></td>
                                                                                    <td><?php echo $dat['factura_req'] ?></td>
                                                                                    <td><?php echo $dat['fecha_pagors'] ?></td>
                                                                                    <td class="text-right"><?php echo number_format($dat['monto_pagors']) ?></td>
                                                                                    <td><?php echo $dat['referencia_pagors'] ?></td>
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
                                                                            <td class="text-bold">TOTAL PAGOS</td>
                                                                            <td class="text-bold"></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                        </tfoot>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </div>

                                </div>


                            </section>




                        <?php } ?>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- TERMINA TABLA PRINCIPAL -->


    <!-- INICIA OBRA -->
    <section>
        <div class="container-fluid">

            <!-- Default box -->
            <div class="modal fade" id="modalObra" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-md" role="document">
                    <div class="modal-content w-auto">
                        <div class="modal-header bg-gradient-green">
                            <h5 class="modal-title" id="exampleModalLabel">BUSCAR OBRA</h5>

                        </div>
                        <br>
                        <div class="table-hover table-responsive w-auto" style="padding:15px">
                            <table name="tablaObra" id="tablaObra" class="table table-sm  table-striped table-bordered table-condensed" style="width:100%">
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
<script src="fjs/cntapagosub.js?v=<?php echo (rand()); ?>"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>
<script src="https://cdn.datatables.net/searchpanes/1.4.0/js/dataTables.searchPanes.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>