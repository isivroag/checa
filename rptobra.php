<?php
$pagina = "rptobra";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

$montocxp = 0;
$montoobra = 0;
$montosub = 0;

$resultado = 0;

if ($_SESSION['id_obra'] == null) {
    $id_obra = null;
    $obra = null;
    $consultacon = "SELECT * FROM w_obra WHERE estado_obra=1 ORDER BY id_obra";
    $resultadocon = $conexion->prepare($consultacon);
    $resultadocon->execute();
    $datacon = $resultadocon->fetchAll(PDO::FETCH_ASSOC);
    $ingresos = 0;
    $emitido = 0;
    $saldoin = 0;
    $pendiente = 0;
    $montonom = 0;
    $pagadootros = 0;
    $montoobra = 0;
    $montosub = 0;
    $montocxp = 0;
    $gastos = 0;
    $otros = 0;



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


        $resultadopagado = 0;
        $resultadopagado = $ingresos - ($pagadosub + $pagadocxp);

        // BUSCAR EGRESOS
        $consultaeg = "SELECT * FROM voperacioneseg WHERE id_obra='$id_obra' and estadoop=1 ORDER BY id_obra,fechaop";
        $resultadoeg = $conexion->prepare($consultaeg);
        $resultadoeg->execute();
        $dataeg = $resultadoeg->fetchAll(PDO::FETCH_ASSOC);


        $consnom = "SELECT monto_nom as nomina from w_nomina where id_obra='$id_obra' and estado_nom='1'";
        $resnom = $conexion->prepare($consnom);
        $resnom->execute();
        $datanom = $resnom->fetchAll(PDO::FETCH_ASSOC);
        $montonom = 0;
        foreach ($datanom as $rownom) {
            $montonom += $rownom['nomina'];
        }


        $consultanom = "SELECT * from w_datos where id_obra='$id_obra' ";
        $resultadonom = $conexion->prepare($consultanom);
        $resultadonom->execute();
        if ($resultadonom->rowCount() > 0) {
            $databd = $resultadonom->fetchAll(PDO::FETCH_ASSOC);

            $ejecutadobd = 0;
            foreach ($databd as $row) {
            
                $presupuestadonom = $row['nompres'];
                $presupuestadocaja = $row['cajapres'];
            }
        } else {
          
            $presupuestadonom = 0;
            $presupuestadocaja = 0;
        }

        $cons = "SELECT monto_otro,saldo_otro, monto_otro-saldo_otro as pagado_otro from w_otro where id_obra='$id_obra' and estado_otro='1'";
        $res = $conexion->prepare($cons);
        $res->execute();
        $datares = $res->fetchAll(PDO::FETCH_ASSOC);
        $otros = 0;
        $saldootros = 0;
        $pagadootros = 0;

        foreach ($datares as $rowres) {
            $otros += $rowres['monto_otro'];
            $saldootros += $rowres['saldo_otro'];
            $pagadootros += $rowres['pagado_otro'];
        }

        if ($otros == 0) {
            $porcentajeotros = 0;
        } else {
            $porcentajeotros = $pagadootros / $otros;
        }

        $cons = "SELECT monto_gto,saldo_gto, monto_gto-saldo_gto as pagado_gto from w_gasto where id_obra='$id_obra' and estado_gto='1'";
        $res = $conexion->prepare($cons);
        $res->execute();
        $datares = $res->fetchAll(PDO::FETCH_ASSOC);
        $gastos = 0;
        $saldogastos = 0;
        $pagadogastos = 0;

        foreach ($datares as $rowres) {
            $gastos += $rowres['monto_gto'];
            $saldogastos += $rowres['saldo_gto'];
            $pagadogastos += $rowres['pagado_gto'];
        }

        if ($gastos == 0) {
            $porcentajegastos = 0;
        } else {
            $porcentajegastos = $pagadogastos / $gastos;
        }

        $resultado = 0;
        $resultado = $montoobra - ($montosub + $montocxp + $presupuestadonom + $gastos + $presupuestadocaja );

        $resultadopagado = 0;
        $resultadopagado = $ingresos - ($pagadosub + $pagadocxp + $pagadogastos + $pagadootros + $montonom);
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
    $resultado = 0;
    $resultado = $montoobra - ($montosub + $montocxp);
    $resultadopagado = 0;
    $resultadopagado = $ingresos - ($pagadosub + $pagadocxp);

    // BUSCAR EGRESOS
    $consultaeg = "SELECT * FROM voperacioneseg WHERE id_obra='$id_obra' and estadoop=1 ORDER BY id_obra,fechaop";
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



                                <?php

                                if ($id_obra != null) { ?>

                                    <div class="row justify-content-center">
                                        <div class="col-lg-12">
                                            <div class="card ">
                                                <div class="card-header bg-gradient-primary">
                                                    <h3 class="card-title">
                                                        <i class="fas fa-chart-bar mr-1"></i>
                                                        REPORTE GRAFICO
                                                    </h3>

                                                    <div class="card-tools" style="margin:0px;padding:0px;">

                                                        <button type="button" class="btn bg-gradient-primary btn-sm " href="#cuerpoG" data-card-widget="collapse" aria-expanded="false" title="Collapsed">
                                                            <i class="fas fa-minus"></i>
                                                        </button>
                                                    </div>
                                                </div>

                                                <div class=" card-body" id="cuerpoG">

                                                    <div class=" row justify-content-center">

                                                        <div class="col-sm-12">
                                                            <div class="container-fluid">

                                                                <div class="card">
                                                                    <div class="card-header bg-gradient-navy">
                                                                        <h3 class="card-title">COMPARATIVO CONTRATOS VS SUBCONTRATOS+CXP+INDIRECTOS+OTROS GASTOS </h3>
                                                                    </div>
                                                                    <div class="card-body">
                                                                        <div class="row justify-content-center">
                                                                            <div class="col-lg-10">
                                                                                <canvas class="chart" id="resumenobra" name="resumenobra" style="min-height: 400px; height: 400px; max-height: 400px; max-width: 100%;"></canvas>

                                                                            </div>



                                                                            <div class="row justify-content-center mt-4">
                                                                                <div class="col-lg-12">
                                                                                    <div class="table-responsive">
                                                                                        <table class="table table-responsive table-bordered table-hover table-sm" style="font-size: 15px;">
                                                                                            <thead class="text-center bg-gradient-primary">
                                                                                                <tr>
                                                                                                    <th>CONCEPTO</th>
                                                                                                    <th>IMPORTE CONTRATADO</th>
                                                                                                    <th>IMPORTE PAGADO</th>
                                                                                                    <th>% PAGADO</th>
                                                                                                    <th>% INCIDENCIA</th>
                                                                                                </tr>
                                                                                            </thead>
                                                                                            <tbody>
                                                                                                <tr>
                                                                                                    <td>IMPORTE CONT/PRES</td>
                                                                                                    <td class="text-right"><?php echo number_format($montoobra, 2) ?></td>
                                                                                                    <td class="text-right"><?php echo number_format($ingresos, 2)   ?></td>
                                                                                                    <td class="text-right"><?php echo number_format(($ingresos / $montoobra) * 100, 2) . '%' ?></td>
                                                                                                    <td class="text-right"><?php echo number_format(($montoobra / $montoobra) * 100, 3) . '%' ?></td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td>TOTAL SUBCONTRATOS</td>
                                                                                                    <td class="text-right"><?php echo number_format($montosub, 2) ?></td>
                                                                                                    <td class="text-right"><?php echo number_format($pagadosub, 2)   ?></td>
                                                                                                    <td class="text-right"><?php echo number_format(($pagadosub / $montosub) * 100, 2) . '%' ?></td>
                                                                                                    <td class="text-right"><?php echo number_format(($montosub / $montoobra) * 100, 3) . '%' ?></td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td>TOTAL FACTURAS DE PROVEEDORES </td>
                                                                                                    <td class="text-right"><?php echo number_format($montocxp, 2) ?></td>
                                                                                                    <td class="text-right"><?php echo number_format($pagadocxp, 2)   ?></td>
                                                                                                    <td class="text-right"><?php echo number_format(($pagadocxp / $montocxp) * 100, 2). '%' ?></td>
                                                                                                    <td class="text-right"><?php echo number_format(($montocxp / $montoobra) * 100, 3) . '%' ?></td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td>OTROS GASTOS </td>
                                                                                                    <td class="text-right"><?php echo number_format($gastos, 2) ?></td>
                                                                                                    <td class="text-right"><?php echo number_format($pagadogastos, 2)   ?></td>
                                                                                                    <td class="text-right"><?php echo number_format(($porcentajegastos) * 100, 2). '%' ?></td>
                                                                                                    <td class="text-right"><?php echo number_format(($gastos / $montoobra) * 100, 3) . '%' ?></td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td>NOMINAS </td>
                                                                                                    <td class="text-right"><?php echo number_format($presupuestadonom, 2) ?></td>
                                                                                                    <td class="text-right"><?php echo number_format($montonom, 2)   ?></td>
                                                                                                    <td class="text-right"><?php echo number_format(( $montonom/$presupuestadonom) * 100, 2). '%' ?></td>
                                                                                                    <td class="text-right"><?php echo number_format(($presupuestadonom / $montoobra) * 100, 3) . '%' ?></td>
                                                                                                </tr>

                                                                                                <tr>
                                                                                                    <td>GASTOS DE OBRA </td>
                                                                                                    <td class="text-right"><?php echo number_format($presupuestadocaja, 2) ?></td>
                                                                                                    <td class="text-right"><?php echo number_format($pagadootros, 2)   ?></td>
                                                                                                    <td class="text-right"><?php echo number_format(($pagadootros/$presupuestadocaja) * 100, 2). '%' ?></td>
                                                                                                    <td class="text-right"><?php echo number_format(($presupuestadocaja / $montoobra) * 100, 3) . '%' ?></td>

                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td class="text-bold">RESULTADO </td>
                                                                                                    <td class="text-right text-bold"><?php echo number_format($resultado, 2) ?></td>
                                                                                                    <td class="text-right text-bold"><?php echo number_format($resultadopagado, 2)   ?></td>
                                                                                                    <td class="text-right text-bold"><?php //echo number_format(($resultadopagado / $resultado) * 100, 2) . '%' 
                                                                                                                                        ?></td>
                                                                                                    <td class="text-right text-bold"><?php echo number_format(($resultado / $montoobra) * 100, 3) . '%' ?></td>
                                                                                                </tr>

                                                                                            </tbody>

                                                                                        </table>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>


                                                                <div class="card">
                                                                    <div class="card-header bg-navy">
                                                                        <h3 class="card-title">COMPARATIVO CONTRATO VS EJECUCIÓN AL MOMENTOS</h3>
                                                                    </div>
                                                                    <div class="card-body">
                                                                        <div class="row justify-content-center">

                                                                            <div class="col-lg-4">
                                                                                <canvas class="chart " id="resumenobrapie" name="resumenobrapie" style="min-height: 350px; height: 350px; max-height: 350px; max-width: 100%;"></canvas>

                                                                            </div>
                                                                            <div class="col-lg-4">
                                                                                <canvas class="chart " id="resumenliquido" name="resumenliquido" style="min-height: 350px; height: 350px; max-height: 350px; max-width: 100%;"></canvas>
                                                                            </div>
                                                                            <div class="col-lg-4">
                                                                                <div class="table-responsive">
                                                                                    <table class="table table-responsive table-bordered table-hover table-sm" style="font-size: 15px;">
                                                                                        <thead class="text-center bg-gradient-primary">
                                                                                            <tr>
                                                                                                <th>CONCEPTO</th>
                                                                                                <th>IMPORTE CONTRATADO</th>
                                                                                                <th>IMPORTE LIQUIDO</th>

                                                                                            </tr>
                                                                                        </thead>
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td>OBRA/INGRESO</td>
                                                                                                <td class="text-right"><?php echo number_format($montoobra, 2) ?></td>
                                                                                                <td class="text-right"><?php echo number_format($ingresos, 2)   ?></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>EGRESOS</td>

                                                                                                <td class="text-right"><?php echo number_format($montosub + $montocxp + $montonom + $otros + $gastos, 2)   ?></td>
                                                                                                <td class="text-right"><?php echo number_format($pagadosub + $pagadocxp + $pagadogastos + $montonom + $pagadootros, 2) ?></td>

                                                                                            </tr>

                                                                                            <tr>
                                                                                                <td class="text-bold">RESULTADO </td>
                                                                                                <td class="text-right text-bold"><?php echo number_format($resultado, 2) ?></td>

                                                                                                <td class="text-right text-bold"><?php echo number_format(($ingresos - ($pagadosub + $pagadocxp + $pagadogastos + $montonom + $pagadootros)), 3)  ?></td>
                                                                                            </tr>

                                                                                        </tbody>

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
                                                <!-- TERMINA TABLA INGRESOS-->
                                            </div>
                                        </div>
                                    </div>




                                    <div class="row justify-content-center">
                                        <div class="col-sm-12">
                                            <div class="card ">
                                                <div class="card-header bg-gradient-green">
                                                    <h3 class="card-title">
                                                        <i class="fas fa-file-invoice mr-1"></i>
                                                        RESUMEN DE OBRA
                                                    </h3>

                                                </div>
                                                <br>

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


                                            </div>
                                        </div>
                                    </div>

                                <?php } ?>
                                <?php if ($id_obra != null) { ?>
                                    <div class="row justify-content-center">
                                        <div class="col-lg-12">
                                            <div class="card ">
                                                <div class="card-header bg-gradient-green">
                                                    <h3 class="card-title">
                                                        <i class="fas fa-search-dollar mr-1"></i>
                                                        DETALLE DE INGRESOS
                                                    </h3>

                                                    <div class="card-tools" style="margin:0px;padding:0px;">

                                                        <button type="button" class="btn bg-gradient-green btn-sm " href="#cuerpo" data-card-widget="collapse" aria-expanded="false" title="Collapsed">
                                                            <i class="fas fa-minus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class=" card-body" id="cuerpo">

                                                    <div class=" row justify-content-center">

                                                        <div class="col-sm-12">
                                                            <div class="container-fluid">

                                                                <div class="row justify-content-center">
                                                                    <div class="col-lg-12">
                                                                        <div class="table-responsive">
                                                                            <table name="tablaV" id="tablaV" class="table table-sm table-striped table-bordered table-condensed   mx-auto" style="width:100%">
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
                                            <div class="card ">
                                                <div class="card-header bg-gradient-info">
                                                    <h3 class="card-title">
                                                        <i class="fas fa-search-dollar mr-1"></i>
                                                        DETALLE DE SUBCONTRATOS
                                                    </h3>

                                                    <div class="card-tools" style="margin:0px;padding:0px;">

                                                        <button type="button" class="btn bg-gradient-info btn-sm " href="#cuerpoeg" data-card-widget="collapse" aria-expanded="false" title="Collapsed">
                                                            <i class="fas fa-minus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="card-body" id="cuerpoeg">
                                                    <div class="row justify-content-center">

                                                        <div class="col-sm-12">
                                                            <div class="container-fluid">
                                                                <div class="row justify-content-center">
                                                                    <div class="col-lg-12">
                                                                        <div class="table-responsive">
                                                                            <table name="tablaEg" id="tablaEg" class="table table-sm table-striped table-bordered table-condensed  mx-auto" style="width:100%">
                                                                                <thead class="text-center bg-gradient-info">
                                                                                    <tr>
                                                                                        <th>FOLIO</th>
                                                                                        <th>CLAVE</th>
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
                                                                                        foreach ($datasub as $dat) {
                                                                                    ?>
                                                                                            <tr>
                                                                                                <td><?php echo $dat['folio_sub'] ?></td>
                                                                                                <td><?php echo $dat['clave_sub'] ?></td>

                                                                                                <td><?php echo $dat['razon_prov'] ?></td>
                                                                                                <td class="text-center"><?php echo $dat['fecha_sub'] ?></td>
                                                                                                <td><?php echo $dat['desc_sub'] ?></td>
                                                                                                <td class="text-right"><?php echo number_format($dat['monto_sub'], 2) ?></td>
                                                                                                <td class="text-right"><?php echo number_format($dat['saldo_sub'], 2) ?></td>




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
                                        <!--FIN EGRESOS -->

                                    </div>

                                    <div class="row justify-content-center">
                                        <!--TABLA EGRESOS -->
                                        <div class="col-lg-12">
                                            <div class="card ">
                                                <div class="card-header bg-gradient-purple">
                                                    <h3 class="card-title">
                                                        <i class="fas fa-search-dollar mr-1"></i>
                                                        DETALLE DE FACTURAS DE PROVEEDORES
                                                    </h3>

                                                    <div class="card-tools" style="margin:0px;padding:0px;">

                                                        <button type="button" class="btn bg-gradient-purple btn-sm " href="#cuerpocxp" data-card-widget="collapse" aria-expanded="false" title="Collapsed">
                                                            <i class="fas fa-minus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="card-body" id="cuerpocxp">
                                                    <div class="row justify-content-center">

                                                        <div class="col-sm-12">
                                                            <div class="container-fluid">
                                                                <div class="row justify-content-center">
                                                                    <div class="col-lg-12">
                                                                        <div class="table-responsive">
                                                                            <table name="tablacxp" id="tablacxp" class="table table-sm table-striped table-bordered table-condensed  mx-auto" style="width:100%">
                                                                                <thead class="text-center bg-gradient-purple">
                                                                                    <tr>
                                                                                        <th>FOLIO</th>
                                                                                        <th>CLAVE</th>
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
                                                                                        foreach ($datacxp as $dat) {
                                                                                    ?>
                                                                                            <tr>
                                                                                                <td><?php echo $dat['folio_cxp'] ?></td>
                                                                                                <td><?php echo $dat['factura_cxp'] ?></td>

                                                                                                <td><?php echo $dat['razon_prov'] ?></td>
                                                                                                <td class="text-center"><?php echo $dat['fecha_cxp'] ?></td>
                                                                                                <td><?php echo $dat['desc_cxp'] ?></td>
                                                                                                <td class="text-right"><?php echo number_format($dat['monto_cxp'], 2) ?></td>
                                                                                                <td class="text-right"><?php echo number_format($dat['saldo_cxp'], 2) ?></td>




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
                                        <!--FIN EGRESOS -->

                                    </div>

                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>




    </section>

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

<script>
    function grafica() {
        /*GRAFICA 2*/

        /*GRAFICA METROS*/
        var barresumen = $('#resumenobra').get(0).getContext('2d')

        var barmetrosdata = {
            labels: ["CONTRATO", "SUBCONTRATOS", "FACTURAS", "OTROS GASTOS", "NOMINA",'GASTOS OBRA'],
            datasets: [{
                    label: 'MONTO CONTRATADO',
                    fill: true,
                    borderWidth: 1,
                    lineTension: 0,
                    spanGaps: true,
                    borderColor: '#000000',
                    pointRadius: 3,
                    pointHoverRadius: 7,
                    pointColor: '#A248FA',
                    pointBackgroundColor: '#A248FA',

                    data: [

                        <?php echo $montoobra ?>,
                        <?php echo $montosub ?>,
                        <?php echo $montocxp ?>,
                        <?php echo $gastos ?>,
                        <?php echo $presupuestadonom ?>,
                        <?php echo $presupuestadocaja ?>




                    ],
                    backgroundColor: [

                        'rgb(35, 148, 71)',
                        'rgb(7, 11, 159)',
                        'rgb(241, 134, 12)',
                        'rgb(241, 1, 12)',
                        'rgb(24, 134, 12)',
                        'rgb(120, 50, 12)'


                    ],
                    borderColor: [

                        'rgb(35, 148, 71)',
                        'rgb(7, 11, 159)',
                        'rgb(241, 134, 12)'


                    ],
                    borderWidth: 1
                },
                {
                    label: 'IMPORTE PAGADO',
                    fill: true,
                    borderWidth: 1,
                    lineTension: 0,
                    spanGaps: true,
                    borderColor: '#000000',
                    pointRadius: 3,
                    pointHoverRadius: 7,
                    pointColor: '#A248FA',
                    pointBackgroundColor: '#A248FA',

                    data: [
                        <?php echo $ingresos ?>,
                        <?php echo $pagadosub ?>,
                        <?php echo $pagadocxp ?>,
                        <?php echo $pagadogastos ?>,
                        <?php echo $montonom  ?>,
                        <?php echo  $pagadootros ?>

                    ],
                    backgroundColor: [


                        'rgba(35, 148, 71,.5)',
                        'rgba(7, 11, 159,.5)',
                        'rgba(241, 134, 12,.5)'

                    ],
                    borderColor: [


                        'rgb(35, 148, 71)',
                        'rgb(7, 11, 159)',
                        'rgb(241, 134, 12)'

                    ],
                    borderWidth: 1
                },

            ]
        }



        var metrosGraphChartOptions = {
            animationEnabled: true,
            maintainAspectRatio: false,
            responsive: true,
            legend: {
                display: false,
                position: 'bottom',
                labels: {
                    fontColor: '#000000'
                }
            },
            scales: {
                x: {
                    min: 0,
                    display: true,
                    color: '#A248FA',
                    drawBorder: true,
                    zeroLineColor: '#A248FA'
                },
                y: {
                    min: 0,
                    max: <?php echo $montoobra ?>,
                    beginAtZero: true
                },
                xAxes: [{
                    ticks: {
                        fontColor: '#000000',
                    },
                    gridLines: {
                        display: false,
                        color: '#A248FA',
                        drawBorder: true,
                        zeroLineColor: '#A248FA'
                    }
                }],

                yAxes: [{

                    ticks: {

                        beginAtZero: true,
                        stepSize: 1000000
                    },
                    gridLines: {
                        display: true,
                        color: '#A248FA',
                        drawBorder: true,
                        zeroLineColor: '#A248FA'
                    }
                }]
            }
        }



        var barresumen = new Chart(barresumen, {
            type: 'bar',
            data: barmetrosdata,
            options: metrosGraphChartOptions
        })


        // grafica de pie
        var pieChartCanvas = $('#resumenobrapie').get(0).getContext('2d')

        var pieData = {
            labels: ["TOTAL EGRESOS", "RESULTADO"],
            datasets: [{

                    data: [
                        <?php echo $montocxp + $montosub + $montonom + $otros + $gastos ?>,
                        <?php echo ($montoobra - ($montocxp + $montosub + $montonom + $otros + $gastos)) ?>
                    ],
                    backgroundColor: [

                        'rgb(235, 48, 71)',
                        'rgb(35, 148, 71)'

                    ],
                },


            ]
        }
        var pieOptions = {
            maintainAspectRatio: false,
            responsive: true,
        }

        var pieChart = new Chart(pieChartCanvas, {
            type: 'pie',
            data: pieData,
            options: pieOptions
        })



        //GRAFICA DE LIQUIDO
        var barresumenl = $('#resumenliquido').get(0).getContext('2d')

        var barmetrosdatal = {
            labels: ["INGRESOS COBRADOS", "EGRESOS PAGADOS"],
            datasets: [{
                    label: 'INGRESO',
                    fill: true,
                    borderWidth: 1,
                    lineTension: 0,
                    spanGaps: true,
                    borderColor: '#000000',
                    pointRadius: 3,
                    pointHoverRadius: 7,
                    pointColor: '#A248FA',
                    pointBackgroundColor: '#A248FA',

                    data: [

                        <?php echo $ingresos ?>,
                        <?php echo $pagadosub + $pagadocxp + $pagadogastos + $montonom + $pagadootros ?>

                    ],
                    backgroundColor: [



                        'rgb(35, 148, 71)',
                        'rgb(235, 48, 71)'



                    ],
                    borderColor: [

                        'rgb(35, 148, 71)',
                        'rgb(235, 48, 71)'



                    ],
                    borderWidth: 1
                },


            ]
        }



        var metrosGraphChartOptionsl = {
            animationEnabled: true,
            maintainAspectRatio: false,
            responsive: true,
            legend: {
                display: false,
                position: 'bottom',
                labels: {
                    fontColor: '#000000'
                }
            },
            scales: {
                x: {
                    min: 0,
                    display: true,
                    color: '#A248FA',
                    drawBorder: true,
                    zeroLineColor: '#A248FA'
                },
                y: {
                    min: 0,
                    max: <?php echo $montoobra ?>,
                    beginAtZero: true
                },
                xAxes: [{
                    ticks: {
                        fontColor: '#000000',
                    },
                    gridLines: {
                        display: false,
                        color: '#A248FA',
                        drawBorder: true,
                        zeroLineColor: '#A248FA'
                    }
                }],

                yAxes: [{

                    ticks: {

                        beginAtZero: true,
                        stepSize: 1000000
                    },
                    gridLines: {
                        display: true,
                        color: '#A248FA',
                        drawBorder: true,
                        zeroLineColor: '#A248FA'
                    }
                }]
            }
        }



        var barresumenl = new Chart(barresumenl, {
            type: 'bar',
            data: barmetrosdatal,
            options: metrosGraphChartOptionsl
        })


    }
    /*GRAFICA 2*/
</script>
<?php include_once 'templates/footer.php'; ?>
<script src="fjs/rptobra.js?v=<?php echo (rand()); ?>"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>
<script src="plugins/chart.js/Chart.min.js"></script>