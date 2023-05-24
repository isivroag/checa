<?php
$pagina = "cntacobros";

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

        $consulta = "SELECT folio_cxc,folio_pagocxc,factura_cxc,fecha_pagocxc,monto_pagocxc,metodo_pagocxc,referencia_pagocxc FROM vpagocxc WHERE id_obra='$id_obra' and estado_cxc=1 and estado_pagocxc=1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        $pagadosub = 0;
        $saldosub = 0;

        foreach ($data as $dat) {
            $pagadosub += $dat['monto_pagocxc'];
        }
        $saldosub = $montoobra - $pagadosub;
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



$consultapartidacto = "SELECT * FROM partidacto WHERE estado_partidacto=1 ORDER BY id_partidacto";
$resultadopartidacto = $conexion->prepare($consultapartidacto);
$resultadopartidacto->execute();
$datapartidacto = $resultadopartidacto->fetchAll(PDO::FETCH_ASSOC);




$message = "";



?>

<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">


<div class="content-wrapper">



    <!-- TABLA PRINCIPAL -->
    <section class="content">


        <div class="card">
            <div class="card-header bg-green text-light">
                <h1 class="card-title mx-auto">CONSULTA DE PAGOS POR OBRA</h1>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">

                        <div class="card">
                            <div class="card-header bg-green">
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

                                                <span class="input-group-append">
                                                    <button id="bobra" type="button" class="btn btn-sm btn-primary"><i class="fas fa-search"></i></button>
                                                </span>

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
                                    <div class="card-header bg-green text-light">
                                        <h1 class="card-title mx-auto">DETALLE DE COBROS</h1>
                                    </div>

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <!-- <button id="btnNuevo" type="button" class="btn bg-gradient-secondary btn-ms" data-toggle="modal"><i class="fas fa-plus-square text-light"></i><span class="text-light"> Nuevo</span></button> -->
                                            </div>
                                        </div>
                                        <br>

                                        <div class="container-fluid">
                                            <div class="card">
                                                <div class="card-header bg-green">
                                                    <div class="row justify-content-sm-center">
                                                        <div class="col-sm-6">
                                                            <div class="form-group input-group-sm">
                                                                <label for="folio_sub" class="col-form-label">OBRA:</label>
                                                                <input type="text" class="form-control" name="folio_sub" id="folio_sub" value="<?php echo $obra ?>" disabled>

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
                                                                <input type="text" class="form-control text-right" name="montosub" id="montosub" value=<?php echo number_format($montoobra, 2) ?> disabled>
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

                                                <div class="card-body">
                                                    <div class="row">

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="table-responsive">
                                                                <table class="tablaV table table-sm table-striped table-bordered table-condensed w-auto mx-auto" style="width:100%">
                                                                    <thead class="text-center bg-green">
                                                                        <tr>
                                                                            <th>FOLIO CXC</th>
                                                                            <th>FOLIO PAGO CXC</th>
                                                                            <th>FACTURA</th>
                                                                            <th>FECHA</th>
                                                                            <th>MONTO</th>
                                                                            <th>METODO</th>
                                                                            <th>REFERENCIA</th>
                                                                            <th>ACCIONES</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                        foreach ($data as $dat) {
                                                                        ?>
                                                                            <tr>
                                                                                <td><?php echo $dat['folio_cxc'] ?></td>
                                                                                <td><?php echo $dat['folio_pagocxc'] ?></td>
                                                                                <td><?php echo $dat['factura_cxc'] ?></td>
                                                                                <td><?php echo $dat['fecha_pagocxc'] ?></td>
                                                                                <td class="text-right"><?php echo number_format($dat['monto_pagocxc'], 2) ?></td>
                                                                                <td><?php echo $dat['metodo_pagocxc'] ?></td>
                                                                                <td><?php echo $dat['referencia_pagocxc'] ?></td>
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
                                                                        <td class="text-bold">TOTAL PAGOS</td>
                                                                        <td class="text-bold"></td>
                                                                        <td></td>
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

    <!-- INICIA VER -->
    <section>
        <div class="container-fluid">

            <!-- Default box -->
            <div class="modal fade" id="modalVer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-md" role="document">
                    <div class="modal-content w-auto">
                        <div class="modal-header bg-gradient-green">
                            <h5 class="modal-title" id="exampleModalLabel">DETALLE DE COSTO</h5>

                        </div>
                        <br>
                        <div class="table-hover table-responsive w-auto" style="padding:15px">
                            <table name="tablaVer" id="tablaVer" class="table table-sm  table-striped table-bordered table-condensed" style="width:100%">
                                <thead class="text-center bg-gradient-green">
                                    <tr>
                                        <th>ID REG</th>
                                        <th>PARTIDA</th>
                                        <th>SUBPARTIDA</th>
                                        <th>MONTO</th>
                                        <th>ACCIONES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  
                                </tbody>
                                <tfoot>
                                    <td></td>
                                    <td></td>
                                    <td class="text-bold">TOTAL</td>
                                    <td class="text-bold text-right"></td>
                                    <td></td>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- TERMINA VER -->

    <section>
        <div class="modal fade" id="modalDetalle" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog " role="document">
                <div class="modal-content">
                    <div class="modal-header bg-green">
                        <h5 class="modal-title" id="exampleModalLabel">ESTABLECER MONTO SUBPARTIDA DE COSTO</h5>
                    </div>
                    <div class="card card-widget" style="margin: 10px;">
                        <form id="formDetalle" action="" method="POST">

                        <input type="hidden" id="cxc" name="cxc" class="form-control text-right" autocomplete="off" >
                        <input type="hidden" id="pago" name="pago" class="form-control text-right" autocomplete="off" >
                        

                        <div class="table-hover table-responsive w-auto" style="padding:15px">
                            <table name="tablaVer2" id="tablaVer2" class="table table-sm  table-striped table-bordered table-condensed" style="width:100%">
                                <thead class="text-center bg-gradient-green">
                                    <tr>
                                        <th>ID REG</th>
                                        <th>PARTIDA</th>
                                        <th>SUBPARTIDA</th>
                                        <th>MONTO</th>
                                  
                                    </tr>
                                </thead>
                                <tbody>
                                  
                                </tbody>
                                <tfoot>
                                    <td></td>
                                    <td></td>
                                    <td class="text-bold">TOTAL</td>
                                    <td class="text-bold text-right"></td>
                                   
                                </tfoot>
                            </table>
                        </div>
                            <div class="modal-body row justify-content-center">
                                <div class="col-sm-6">
                                    <div class="form-group input-group-sm auto">
                                        <label for="partidacto" class="col-form-label">PARTIDA:</label>
                                        <select class="form-control" name="partidacto" id="partidacto">
                                            <?php
                                            foreach ($datapartidacto as $dtt) {
                                            ?>
                                                <option id="<?php echo $dtt['id_partidacto'] ?>" value="<?php echo $dtt['id_partidacto'] ?>"> <?php echo $dtt['nom_partidacto'] ?></option>

                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group input-group-sm auto">
                                        <label for="subpartidacto" class="col-form-label">SUBPARTIDA:</label>
                                        <select class="form-control" name="subpartidacto" id="subpartidacto">
                                          
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-body row justify-content-center">

                                <div class="col-lg-8">
                                    <label for="montosubpartida" class="col-form-label">IMPORTE:</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-dollar-sign"></i>
                                            </span>

                                        </div>
                                       
                                        <input type="text" id="montosubpartida" name="montosubpartida" class="form-control text-right" autocomplete="off" placeholder="IMPORTE" onkeypress="return filterFloat(event,this);">
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
                        <button type="button" id="btnGuardarsub" name="btnGuardarsub" class="btn btn-success" value="btnGuardarcobro"><i class="far fa-save"></i> Guardar</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </section>


</div>


<?php include_once 'templates/footer.php'; ?>
<script src="fjs/cntacobros.js?v=<?php echo (rand()); ?>"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>
<script src="https://cdn.datatables.net/searchpanes/1.4.0/js/dataTables.searchPanes.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>