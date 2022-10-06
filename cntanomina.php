<?php
$pagina = "nomina";

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
        $consultaobra = "SELECT corto_obra,monto_obra,duracion from w_obra where id_obra='$id_obra'";
        $resultadoobra = $conexion->prepare($consultaobra);
        $resultadoobra->execute();
        $dataobra = $resultadoobra->fetchAll(PDO::FETCH_ASSOC);
        foreach ($dataobra as $rowobra) {
            $obra = $rowobra['corto_obra'];
            $montoobra = $rowobra['monto_obra'];
            $duracion = $rowobra['duracion'];
        }

        //BUSCAR NOMBRE DE OBRA
        $consultanom = "SELECT * from vnomina where id_obra='$id_obra' AND estado_nom=1 order by id_nom";
        $resultadonom = $conexion->prepare($consultanom);
        $resultadonom->execute();
        if ($resultadonom->rowCount() > 0) {
            $datanom = $resultadonom->fetchAll(PDO::FETCH_ASSOC);
            $contador = 0;
            $ejecutado = 0;
            foreach ($datanom as $row) {
                $ejecutado += $row['monto_nom'];
                $contador++;
            }
            $promedionom = round($ejecutado / $contador, 2);
            $presupuesto = $duracion * $promedionom;
        } else {
            $ejecutado = 0;
            $presupuesto = 0;
        }
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

    //BUSCAR NOMBRE DE OBRA
    $consultanom = "SELECT * from vnomina where id_obra='$id_obra' AND estado_nom=1 order by id_nom";
    $resultadonom = $conexion->prepare($consultanom);
    $resultadonom->execute();
    $datanom = $resultadonom->fetchAll(PDO::FETCH_ASSOC);
}




$message = "";



?>

<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

<div class="content-wrapper">



    <section class="content">


        <div class="card">
            <div class="card-header bg-gradient-secondary text-light">
                <h1 class="card-title mx-auto">NOMINAS</h1>
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

                                <?php if ($id_obra != null) { ?>
                                    <div class="row justify-content-center mb-3 border-top">
                                        <div class="col-sm-2">
                                            <div class="form-group input-group-sm">
                                                <label for="duracion" class="col-form-label">DURACION:</label>
                                                <input type="text" class="form-control" name="duracion" id="duracion" value="<?php echo $duracion ?>" disabled>

                                            </div>
                                        </div>


                                        <div class="col-sm-2 ">
                                            <div class="form-group input-group-sm">
                                                <label for="presupuesto" class="col-form-label">PRESUPUESTO:</label>
                                                <input type="text" class="form-control text-right" name="presupuesto" id="presupuesto" value="<?php echo '$ '.number_format($presupuesto,2); ?>" disabled>
                                            </div>
                                        </div>



                                        <div class="col-sm-2 ">
                                            <div class="form-group input-group-sm">
                                                <label for="ejecutado" class="col-form-label">EJECUTADO:</label>
                                                <input type="text" class="form-control text-right" name="ejecutado" id="ejecutado" value="<?php echo '$ '. number_format($ejecutado,2); ?>" disabled>
                                            </div>
                                        </div>
                                    </div>

                                <?php } ?>
                            </div>
                        </div>


                        <?php

                        if ($id_obra != null) { ?>


                            <section class="content">

                                <!-- Default box -->
                                <div class="card">
                                    <div class="card-header bg-gradient-secondary text-light">
                                        <h1 class="card-title mx-auto">INFORMACION DE NOMINAS</h1>
                                    </div>

                                    <div class="card-body">

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <button id="btnNuevo" type="button" class="btn bg-gradient-secondary btn-ms" data-toggle="modal"><i class="fas fa-plus-square text-light"></i><span class="text-light"> Nuevo</span></button>
                                            </div>
                                        </div>
                                        <br>

                                        <div class="card">
                                            <div class="card-header bg-gradient-secondary">
                                                Filtro por rango de Fecha
                                            </div>
                                            <div class="card-body">
                                                <div class="row justify-content-center">
                                                    <div class="col-lg-2">
                                                        <div class="form-group input-group-sm">
                                                            <label for="fecha" class="col-form-label">Desde:</label>
                                                            <input type="date" class="form-control" name="inicio" id="inicio">


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
                                                        <table name="tablaV" id="tablaV" class="table table-sm table-striped table-bordered table-condensed text-nowrap w-auto mx-auto" style="width:100%; font-size:15px">
                                                            <thead class="text-center bg-gradient-secondary">
                                                                <tr>
                                                                    <th>ID</th>
                                                                    <th>ID OBRA</th>
                                                                    <th>OBRA</th>
                                                                    <th>INICIO</th>
                                                                    <th>FIN</th>
                                                                    <th>CONCEPTO</th>
                                                                    <th>MONTO</th>
                                                                    <th>ACCIONES</th>

                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                foreach ($datanom as $dat) {
                                                                ?>
                                                                    <tr>
                                                                        <td><?php echo $dat['id_nom'] ?></td>
                                                                        <td><?php echo $dat['id_obra'] ?></td>
                                                                        <td><?php echo $dat['corto_obra'] ?></td>
                                                                        <td class="text-center"><?php echo $dat['fecha_ini'] ?></td>
                                                                        <td class="text-center"><?php echo $dat['fecha_fin'] ?></td>
                                                                        <td><?php echo $dat['desc_nom'] ?></td>
                                                                        <td class="text-right"><?php echo number_format($dat['monto_nom'], 2) ?></td>
                                                                        <td></td>


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
                                                                <th class="text-right text-bold">TOTAL</th>
                                                                <th></th>
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



    <!-- INICIA ALTA NOMINA -->

    <section>
        <div class="modal fade" id="modalReq" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content w-auto">
                    <div class="modal-header bg-gradient-secondary">
                        <h5 class="modal-title" id="exampleModalLabel">ALTA DE NOMINA</h5>

                    </div>
                    <form id="formReq" action="" method="POST" autocomplete="off">
                        <div class="card card-widget" style="margin: 10px;">

                            <div class="modal-body">
                                <div class="row justify-content-sm-center">

                                    <div class="col-sm-2">
                                        <div class="form-group input-group-sm">
                                            <label for="folionom" class="col-form-label">ID NOM:</label>
                                            <input type="text" class="form-control" name="folionom" id="folionom" disabled>

                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                    </div>

                                    <div class="col-sm-3 ">
                                        <div class="form-group input-group-sm">
                                            <label for="fechaini" class="col-form-label">FECHA INICIAL:</label>
                                            <input type="date" class="form-control" name="fechaini" id="fechaini" value="<?php echo $fecha; ?>">
                                        </div>
                                    </div>



                                    <div class="col-sm-3 ">
                                        <div class="form-group input-group-sm">
                                            <label for="fechafin" class="col-form-label">FECHA FINAL:</label>
                                            <input type="date" class="form-control" name="fechafin" id="fechafin" value="<?php echo $fecha; ?>">
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





                                </div>

                                <div class=" row justify-content-sm-center">

                                    <div class="col-sm-12">
                                        <div class="form-group input-group-sm">
                                            <label for="descripcion" class="col-form-label">CONCEPTO:</label>
                                            <textarea row="2" type="text" class="form-control" name="descripcion" id="descripcion" placeholder="CONCEPTO"></textarea>
                                        </div>
                                    </div>

                                </div>

                                <div class="row justify-content-sm-center" style="margin-bottom: 10px;">

                                    <div class="col-sm-4 ">

                                    </div>
                                    <div class=" col-sm-4 ">

                                    </div>
                                    <div class=" col-sm-4 ">
                                        <label for=" montonom" class="col-form-label">MONTO:</label>
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-dollar-sign"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control text-right" name="montonom" id="montonom" onkeypress="return filterFloat(event,this);">
                                        </div>
                                    </div>

                                </div>

                            </div>

                            <div class=" modal-footer">
                                <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fas fa-ban"></i> Cancelar</button>
                                <button type="button" id="btnGuardarnom" name="btnGuardarnom" class="btn btn-success" value="btnGuardarnom"><i class="far fa-save"></i> Guardar</button>
                            </div>


                    </form>
                </div>
            </div>
        </div>
    </section>


    <!-- TERMINA ALTA NOMINA -->



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

</div>


<?php include_once 'templates/footer.php'; ?>
<script src="fjs/cntanomina.js?v=<?php echo (rand()); ?>"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>
<script src="plugins/chart.js/Chart.min.js"></script>