<?php
$pagina = "diario";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();
$fecha = date('Y-m-d');
$consulta = "SELECT * FROM v_ingresos WHERE fecha='$fecha' ORDER BY folio_pago";
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
                <h1 class="card-title mx-auto">Ingresos</h1>
            </div>

            <div class="card-body">
                <?php if ($_SESSION['s_rol'] == '2') { ?>
                    <div class="card">
                        <div class="card-header bg-gradient-green">
                            Filtro por rango de Fecha
                        </div>
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="col-lg-2">
                                    <div class="form-group input-group-sm">
                                        <label for="fecha" class="col-form-label">Desde:</label>
                                        <input type="date" class="form-control" name="inicio" id="inicio" value="<?php echo $fecha ?>">


                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <div class="form-group input-group-sm">
                                        <label for="fecha" class="col-form-label">Hasta:</label>
                                        <input type="date" class="form-control" name="final" id="final" value="<?php echo $fecha ?>">
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

                <?php } ?>

                <div class="container-fluid">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table name="tablaV" id="tablaV" class="table table-sm table-striped table-bordered table-condensed text-nowrap w-auto mx-auto" style="width:100%">
                                    <thead class="text-center bg-gradient-green">
                                        <tr>
                                            <th>Folio Pago</th>
                                            <th>Folio Reg</th>
                                            <th>Fecha</th>
                                            <th>PX</th>
                                            <th>Concepto Reg</th>
                                            <th>Concepto Pago</th>
                                            <th>Monto</th>
                                            <th>Método de Pago</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $efectivo = 0;
                                        $otros = 0;
                                        $total = 0;
                                        foreach ($data as $dat) {

                                            $total += $dat['monto'];
                                            if ($dat['metodo'] == 'Efectivo') {
                                                $efectivo += $dat['monto'];
                                            } else {
                                                $otros += $dat['monto'];
                                            }

                                        ?>
                                            <tr>
                                                <td><?php echo $dat['folio_pago'] ?></td>
                                                <td><?php echo $dat['folio_reg'] ?></td>
                                                <td><?php echo $dat['fecha'] ?></td>
                                                <td><?php echo $dat['nom'] ?></td>
                                                <td><?php echo $dat['nom_concepto'] ?></td>
                                                <td><?php echo $dat['concepto'] ?></td>
                                                <td><?php echo $dat['monto'] ?></td>
                                                <td><?php echo $dat['metodo'] ?></td>


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
                                        <th class="text-right">TOTAL DE INGRESOS</th>
                                        <th class="text-right"></th>
                                        <th></th>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-2">
                            <div class="form-group input-group-sm">
                                <label for="efectivo" class="col-form-label">EFECTIVO:</label>
                                <input type="text" class="form-control bg-white text-bold" name="efectivo" id="efectivo" value="<?php echo "$ ". number_format($efectivo,2)?>" disabled>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group input-group-sm">
                                <label for="otros" class="col-form-label">OTROS:</label>
                                <input type="text" class="form-control bg-white text-bold" name="otros" id="otros" value="<?php echo "$ ". number_format($otros,2)?>" disabled>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group input-group-sm">
                                <label for="total" class="col-form-label">TOTAL:</label>
                                <input type="text" class="form-control bg-white text-bold" name="total" id="total" value="<?php echo "$ ". number_format($total,2)?>" disabled>
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







    <!-- /.content -->
</div>


<?php include_once 'templates/footer.php'; ?>
<script src="fjs/cortediario.js"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>