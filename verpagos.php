<?php
$pagina = "verpagosop";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

$datanom = 0;
$fecha = date('Y-m-d');





/*FECHA INICIO DE SEMANA */
$diaInicio = "Monday";
$diaFin = "Sunday";
$fechafun = date('Y-m-d');
$strFecha = strtotime($fechafun);

$fechaInicio = date('Y-m-d', strtotime('last ' . $diaInicio, $strFecha));
$fechaFin = date('Y-m-d', strtotime('next ' . $diaFin, $strFecha));

if (date("l", $strFecha) == $diaInicio) {
    $fechaInicio = date("Y-m-d", $strFecha);
}
if (date("l", $strFecha) == $diaFin) {
    $fechaFin = date("Y-m-d", $strFecha);
}


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



        $cons = " SELECT vrequisicion.id_obra,vrequisicion.clave_sub, vrequisicion.desc_sub,vrequisicion.razon_prov,vrequisicion.concepto_req,
                w_pagors.folio_pagors,w_pagors.fecha_pagors,w_pagors.referencia_pagors ,w_pagors.metodo_pagors,w_pagors.monto_pagors,w_pagors.observaciones_pagors 
                FROM w_pagors JOIN vrequisicion ON w_pagors.id_req = vrequisicion.id_req WHERE vrequisicion.id_obra='$id_obra' and w_pagors.fecha_pagors between '$fechaInicio' and '$fechaFin' ";

        $res = $conexion->prepare($cons);
        $res->execute();
        $data = $res->fetchAll(PDO::FETCH_ASSOC);

        $cons = " SELECT * FROM vpagocxp
       WHERE id_obra='$id_obra' and fecha_pagocxp between '$fechaInicio' and '$fechaFin' ";

        $res = $conexion->prepare($cons);
        $res->execute();
        $data2 = $res->fetchAll(PDO::FETCH_ASSOC);

        //BUSCAR NOMBRE DE OBRA

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

    $cons = " SELECT vrequisicion.id_obra,vrequisicion.clave_sub, vrequisicion.desc_sub,vrequisicion.razon_prov,vrequisicion.concepto_req,
    w_pagors.folio_pagors,w_pagors.fecha_pagors,w_pagors.referencia_pagors ,w_pagors.metodo_pagors,w_pagors.monto_pagors,w_pagors.observaciones_pagors 
    FROM w_pagors JOIN vrequisicion ON w_pagors.id_req = vrequisicion.id_req WHERE vrequisicion.id_obra='$id_obra' and w_pagors.fecha_pagors between '$fechaInicio' and '$fechaFin' ";

    $res = $conexion->prepare($cons);
    $res->execute();
    $data = $res->fetchAll(PDO::FETCH_ASSOC);

    $cons = " SELECT * FROM vpagocxp
       WHERE id_obra='$id_obra' and fecha_pagocxp between '$fechaInicio' and '$fechaFin' ";

    $res = $conexion->prepare($cons);
    $res->execute();
    $data2 = $res->fetchAll(PDO::FETCH_ASSOC);
}




$message = "";



?>

<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

<div class="content-wrapper">



    <section class="content">


        <div class="card">
            <div class="card-header bg-gradient-secondary text-light">
                <h1 class="card-title mx-auto">PAGOS</h1>
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

                                <!-- Default box -->
                                <div class="card">
                                    <div class="card-header bg-gradient-secondary text-light">
                                        <h1 class="card-title mx-auto">INFORMACION DE PAGOS</h1>
                                    </div>

                                    <div class="card-body">



                                        <div class="card">
                                            <div class="card-header bg-gradient-secondary">
                                                Filtro por rango de Fecha
                                            </div>
                                            <div class="card-body">
                                                <div class="row justify-content-center">
                                                    <div class="col-lg-2">
                                                        <div class="form-group input-group-sm">
                                                            <label for="fecha" class="col-form-label">Desde:</label>
                                                            <input type="date" class="form-control" name="inicio" id="inicio" value="<?php echo $fechaInicio ?>">


                                                        </div>
                                                    </div>

                                                    <div class="col-lg-2">
                                                        <div class="form-group input-group-sm">
                                                            <label for="fecha" class="col-form-label">Hasta:</label>
                                                            <input type="date" class="form-control" name="final" id="final" value="<?php echo $fechaFin ?>">
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
                                                        <table name="tablaV" id="tablaV" class="table table-sm table-striped table-bordered table-condensed text-nowrap w-auto mx-auto" style="width:100%; font-size:15px">
                                                            <thead class="text-center bg-gradient-secondary">
                                                                <tr>
                                                                    <th>CLAVE SUB</th>
                                                                    <th>DESC SUB</th>
                                                                    <th>PROVEEDOR</th>
                                                                    <th>CONCEPTO</th>
                                                                    <th>FECHA</th>
                                                                    <th>REFERENCIA</th>
                                                                    <th>METODO</th>
                                                                    <th>MONTO</th>

                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                foreach ($data as $dat) {
                                                                ?>
                                                                    <tr>
                                                                        <td><?php echo $dat['clave_sub'] ?></td>
                                                                        <td><?php echo $dat['desc_sub'] ?></td>
                                                                        <td><?php echo $dat['razon_prov'] ?></td>
                                                                        <td><?php echo $dat['concepto_req'] ?></td>
                                                                        <td><?php echo $dat['fecha_pagors'] ?></td>
                                                                        <td><?php echo $dat['referencia_pagors'] ?></td>
                                                                        <td><?php echo $dat['metodo_pagors'] ?></td>
                                                                        <td class="text-right"><?php echo number_format($dat['monto_pagors'], 2) ?></td>



                                                                    </tr>
                                                                <?php
                                                                }
                                                                ?>
                                                            </tbody>
                                                            <tfoot>
                                                                <th></th>
                                                                <th></th>
                                                                <th></th>
                                                                <th></th>
                                                                <th></th>
                                                                <th></th>
                                                                <th class="text-right text-bold">TOTAL</th>
                                                                <th></th>

                                                            </tfoot>

                                                        </table>
                                                    </div>
                                                </div>
                                            </div>



                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="table-responsive">
                                                        <table name="tablaV2" id="tablaV2" class="table table-sm table-striped table-bordered table-condensed text-nowrap w-auto mx-auto" style="width:100%; font-size:15px">
                                                            <thead class="text-center bg-gradient-secondary">
                                                                <tr>

                                                                    <th>PROVEEDOR</th>
                                                                    <th>CONCEPTO</th>
                                                                    <th>FECHA</th>
                                                                    <th>REFERENCIA</th>
                                                                    <th>METODO</th>
                                                                    <th>MONTO</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                foreach ($data2 as $dat) {
                                                                ?>
                                                                    <tr>
                                                                        <td><?php echo $dat['razon_prov'] ?></td>
                                                                        <td><?php echo $dat['desc_cxp'] ?></td>
                                                                        <td><?php echo $dat['fecha_pagocxp'] ?></td>
                                                                        <td><?php echo $dat['referencia_pagocxp'] ?></td>
                                                                        <td><?php echo $dat['metodo_pagocxp'] ?></td>
                                                                        <td class="text-right"><?php echo number_format($dat['monto_pagocxp'], 2) ?></td>



                                                                    </tr>
                                                                <?php
                                                                }
                                                                ?>
                                                            </tbody>
                                                            <tfoot>
                                                                <th></th>
                                                                <th></th>

                                                                <th></th>
                                                                <th></th>
                                                                <th class="text-right text-bold">TOTAL</th>
                                                                <th></th>



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




                        <?php } ?>
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


<?php include_once 'templates/footer.php'; ?>
<script src="fjs/verpagos.js?v=<?php echo (rand()); ?>"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>
<script src="plugins/chart.js/Chart.min.js"></script>