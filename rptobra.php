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
        $ingresos = 0;
        $emitido = 0;
        $saldoin = 0;
        $pendiente = 0;

        if ($id_obra != null) {
            foreach ($datain as $dat) {
                $emitido += $dat['monto_cxc'];
                $saldoin += $dat['saldo_cxc'];
            }
        }
        $ingresos = $emitido - $saldoin;
        $pendiente = $montoobra - $emitido;


        // BUSCAR SUBCONTRATOS
        $consultasub = "SELECT * FROM vsubcontrato WHERE id_obra='$id_obra' and estado_sub=1 ORDER BY folio_sub";
        $resultadosub = $conexion->prepare($consultasub);
        $resultadosub->execute();
        $datasub = $resultadosub->fetchAll(PDO::FETCH_ASSOC);
        $montosub = 0;
        $saldosub = 0;
        $pagadosub = 0;
        foreach ($datasub as $rowsub) {
            $saldosub += $rowsub['saldo_sub'];
            $montosub += $rowsub['monto_sub'];
        }
        $pagadosub = $montosub - $saldosub;


        // BUSCAR CXP
        $consultacxp = "SELECT * FROM vcxp WHERE id_obra='$id_obra' and estado_cxp=1 ORDER BY folio_cxp";
        $resultadocxp = $conexion->prepare($consultacxp);
        $resultadocxp->execute();
        $datacxp = $resultadocxp->fetchAll(PDO::FETCH_ASSOC);
        $montocxp = 0;
        $saldocxp = 0;
        $pagadocxp = 0;
        foreach ($datacxp as $rowcxp) {
            $saldocxp += $rowcxp['saldo_cxp'];
            $montocxp += $rowcxp['monto_cxp'];
        }
        $pagadocxp = $montocxp - $saldocxp;

        // BUSCAR EGRESOS
        $consultaeg = "SELECT * FROM voperacioneseg WHERE id_obra='$id_obra' and estadoop=1 ORDER BY id_obra,fechaop";
        $resultadoeg = $conexion->prepare($consultaeg);
        $resultadoeg->execute();
        $dataeg = $resultadoeg->fetchAll(PDO::FETCH_ASSOC);
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


    // BUSCAR INGRESOS
    $consultain = "SELECT * FROM vcxc WHERE id_obra='$id_obra' and estado_cxc=1 ORDER BY id_obra,fecha_cxc,folio_cxc";
    $resultadoin = $conexion->prepare($consultain);
    $resultadoin->execute();
    $datain = $resultado->fetchAll(PDO::FETCH_ASSOC);

    $ingresos = 0;
    $emitido = 0;
    $saldoin = 0;
    $pendiente = 0;
    if ($id_obra != null) {
        foreach ($datain as $dat) {
            $emitido += $dat['monto_cxc'];
            $saldoin += $dat['saldo_cxc'];
        }
    }
    $ingresos = $emitido - $saldoin;
    $pendiente = $montoobra - $emitido;

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
                                    <div class="col-sm-5">
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

                                <div class="row justify-content-center">
                                    <div class="col-sm-12">
                                        <div class="card mt-4">
                                            <div class="card-header bg-gradient-green">
                                                RESUMEN DE OBRA
                                            </div>
                                            <br>
                                            <?php if ($id_obra != null) { ?>
                                                <div class="card-body">


                                                    <div>
                                                        <div class="row justify-content-center text-bold h2">
                                                            <span>INGRESOS</span>
                                                        </div>
                                                        <div class="row justify-content-center form-group">

                                                            <div class="col-sm-5">
                                                                <label for="montoobra" class="col-form-label">MONTO DE OBRA:</label>
                                                            </div>
                                                            <div class="col-sm-3">

                                                                <div class="input-group input-group-sm">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">
                                                                            <i class="fas fa-dollar-sign"></i>
                                                                        </span>
                                                                    </div>
                                                                    <input type="text" class="form-control text-right text-bold" style="font-size:20px" name="montoobra" id="montoobra" value="<?php echo number_format($montoobra, 2); ?>">
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <div class="row justify-content-center form-group">
                                                            <div class="col-sm-5">

                                                                <label for="temitidas" class="col-form-label">FACTURAS EMITIDAS:</label>


                                                            </div>

                                                            <div class="col-sm-3">

                                                                <div class="input-group input-group-sm">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">
                                                                            <i class="fas fa-dollar-sign"></i>
                                                                        </span>
                                                                    </div>
                                                                    <input type="text" class="form-control text-right text-bold" style="font-size:20px" name="temitidas" id="temitidas" value="<?php echo number_format($emitido, 2); ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row justify-content-center form-group">
                                                            <div class="col-sm-5">

                                                                <label for="tingresos" class="col-form-label">FACTURAS COBRADAS:</label>


                                                            </div>

                                                            <div class="col-sm-3">

                                                                <div class="input-group input-group-sm">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">
                                                                            <i class="fas fa-dollar-sign"></i>
                                                                        </span>
                                                                    </div>
                                                                    <input type="text" class="form-control text-right text-bold" style="font-size:20px" name="tingresos" id="tingresos" value="<?php echo number_format($ingresos, 2); ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row justify-content-center form-group ">
                                                            <div class="col-sm-5 ">
                                                                <label for="tsaldoin" class="col-form-label">SALDO DE FACTURAS PENDIENTE DE COBRAR :</label>


                                                            </div>

                                                            <div class="col-sm-3">

                                                                <div class="input-group input-group-sm">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">
                                                                            <i class="fas fa-dollar-sign"></i>
                                                                        </span>
                                                                    </div>
                                                                    <input type="text" class="form-control text-right text-bold" style="font-size:20px" name="tsaldoin" id="tsaldoin" value="<?php echo number_format($saldoin, 2); ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row justify-content-center form-group ">
                                                            <div class="col-sm-5">
                                                                <label for="tpendiente" class="col-form-label">MONTO PENDIENTE POR FACTURAR:</label>


                                                            </div>

                                                            <div class="col-sm-3">

                                                                <div class="input-group input-group-sm">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">
                                                                            <i class="fas fa-dollar-sign"></i>
                                                                        </span>
                                                                    </div>
                                                                    <input type="text" class="form-control text-right text-bold" style="font-size:20px" name="tpendiente" id="tpendiente" value="<?php echo number_format($pendiente, 2); ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div>
                                                        <div class="row justify-content-center text-bold h2">
                                                            <span>SUBCONTRATOS</span>
                                                        </div>

                                                        <div class="row justify-content-center form-group">
                                                            <div class="col-sm-5">

                                                                <label for="tsubcontrato" class="col-form-label">SUBCONTRATOS:</label>


                                                            </div>

                                                            <div class="col-sm-3">

                                                                <div class="input-group input-group-sm">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">
                                                                            <i class="fas fa-dollar-sign"></i>
                                                                        </span>
                                                                    </div>
                                                                    <input type="text" class="form-control text-right text-bold" style="font-size:20px" name="tsubcontrato" id="tsubcontrato" value="<?php echo number_format($montosub, 2); ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row justify-content-center form-group">
                                                            <div class="col-sm-5">

                                                                <label for="tpagadosub" class="col-form-label">MONTO PAGADO DE SUBCONTRATOS:</label>


                                                            </div>

                                                            <div class="col-sm-3">

                                                                <div class="input-group input-group-sm">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">
                                                                            <i class="fas fa-dollar-sign"></i>
                                                                        </span>
                                                                    </div>
                                                                    <input type="text" class="form-control text-right text-bold" style="font-size:20px" name="tpagadosub" id="tpagadosub" value="<?php echo number_format($pagadosub, 2); ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row justify-content-center form-group ">
                                                            <div class="col-sm-5 ">
                                                                <label for="tsaldosub" class="col-form-label">MONTO POR SUBCONTRATO PENDIENTE:</label>


                                                            </div>

                                                            <div class="col-sm-3">

                                                                <div class="input-group input-group-sm">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">
                                                                            <i class="fas fa-dollar-sign"></i>
                                                                        </span>
                                                                    </div>
                                                                    <input type="text" class="form-control text-right text-bold" style="font-size:20px" name="tsaldosub" id="tsaldosub" value="<?php echo number_format($saldosub, 2); ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div>
                                                        <div class="row justify-content-center text-bold h2">
                                                            <span>OTROS EGRESOS</span>
                                                        </div>

                                                        <div class="row justify-content-center form-group">
                                                            <div class="col-sm-5">

                                                                <label for="tcxp" class="col-form-label">FACTURAS DE PROVEEDORES:</label>


                                                            </div>

                                                            <div class="col-sm-3">

                                                                <div class="input-group input-group-sm">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">
                                                                            <i class="fas fa-dollar-sign"></i>
                                                                        </span>
                                                                    </div>
                                                                    <input type="text" class="form-control text-right text-bold" style="font-size:20px" name="tcxp" id="tcxp" value="<?php echo number_format($montocxp, 2); ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row justify-content-center form-group">
                                                            <div class="col-sm-5">

                                                                <label for="tpagadocxp" class="col-form-label">MONTO PAGADO DE FACTURAS:</label>


                                                            </div>

                                                            <div class="col-sm-3">

                                                                <div class="input-group input-group-sm">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">
                                                                            <i class="fas fa-dollar-sign"></i>
                                                                        </span>
                                                                    </div>
                                                                    <input type="text" class="form-control text-right text-bold" style="font-size:20px" name="tpagadocxp" id="tpagadocxp" value="<?php echo number_format($pagadocxp, 2); ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row justify-content-center form-group ">
                                                            <div class="col-sm-5 ">
                                                                <label for="tsaldocxp" class="col-form-label">SALDO POR PAGAR:</label>


                                                            </div>

                                                            <div class="col-sm-3">

                                                                <div class="input-group input-group-sm">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">
                                                                            <i class="fas fa-dollar-sign"></i>
                                                                        </span>
                                                                    </div>
                                                                    <input type="text" class="form-control text-right text-bold" style="font-size:20px" name="tsaldocxp" id="tsaldocxp" value="<?php echo number_format($saldocxp, 2); ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div>

                                                        <div class="row justify-content-center text-bold h2">
                                                            <span>RESULTADO</span>
                                                        </div>

                                                        <div class="row justify-content-center form-group">

                                                            <div class="col-sm-5">
                                                                <label for="montoobra" class="col-form-label">MONTO DE OBRA:</label>
                                                            </div>
                                                            <div class="col-sm-3">

                                                                <div class="input-group input-group-sm">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">
                                                                            <i class="fas fa-dollar-sign"></i>
                                                                        </span>
                                                                    </div>
                                                                    <input type="text" class="form-control text-right text-bold" style="font-size:20px" name="montoobra" id="montoobra" value="<?php echo number_format($montoobra, 2); ?>">
                                                                </div>
                                                            </div>

                                                        </div>


                                                        <div class="row justify-content-center form-group">
                                                            <div class="col-sm-5">

                                                                <label for="tsubcontrato" class="col-form-label">SUBCONTRATOS:</label>


                                                            </div>

                                                            <div class="col-sm-3">

                                                                <div class="input-group input-group-sm">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">
                                                                            <i class="fas fa-dollar-sign"></i>
                                                                        </span>
                                                                    </div>
                                                                    <input type="text" class="form-control text-right text-bold" style="font-size:20px" name="tsubcontrato" id="tsubcontrato" value="<?php echo number_format($montosub, 2); ?>">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row justify-content-center form-group">
                                                            <div class="col-sm-5">

                                                                <label for="tcxp" class="col-form-label">FACTURAS DE PROVEEDORES:</label>


                                                            </div>

                                                            <div class="col-sm-3">

                                                                <div class="input-group input-group-sm">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">
                                                                            <i class="fas fa-dollar-sign"></i>
                                                                        </span>
                                                                    </div>
                                                                    <input type="text" class="form-control text-right text-bold" style="font-size:20px" name="tcxp" id="tcxp" value="<?php echo number_format($montocxp, 2); ?>">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row justify-content-center form-group">
                                                            <div class="col-sm-5">

                                                                <label for="tresultado" class="col-form-label">RESULTADO DE OBRA:</label>


                                                            </div>

                                                            <div class="col-sm-3">

                                                                <div class="input-group input-group-sm">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">
                                                                            <i class="fas fa-dollar-sign"></i>
                                                                        </span>
                                                                    </div>
                                                                    <input type="text" class="form-control text-right text-bold" style="font-size:20px" name="tresultado" id="tresultado" value="<?php echo number_format($montoobra - ($montosub + $montocxp), 2); ?>">
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                            <?php } ?>


                                        </div>

                                    </div>
                                </div>


                                <div class="row justify-content-center">
                                    <div class="col-lg-12">
                                        <div class="card collapsed-card">
                                            <div class="card-header bg-gradient-green">
                                                VER DETALLE DE INGRESOS
                                                <div class="card-tools" style="margin:0px;padding:0px;">

                                                    <button type="button" class="btn bg-gradient-success btn-sm " href="#cuerpo" data-card-widget="collapse" aria-expanded="false" title="Collapsed">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="collapse card-body" id="cuerpo">

                                                <div class=" row justify-content-center">

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
                                                <!-- TERMINA TABLA INGRESOS-->
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row justify-content-center">
                                    <!--TABLA EGRESOS -->
                                    <div class="col-lg-12">
                                    <div class="card collapsed-card">
                                                <div class="card-header bg-gradient-info">
                                                    VER DETALLE DE SUBCONTRATOS
                                                    <div class="card-tools" style="margin:0px;padding:0px;">

                                                        <button type="button" class="btn bg-gradient-info btn-sm " href="#cuerpoeg" data-card-widget="collapse" aria-expanded="false" title="Collapsed">
                                                            <i class="fas fa-plus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="collapse card-body" id="cuerpoeg">
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
                                    <!--FIN EGRESOS -->

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