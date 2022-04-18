<?php
$pagina = "cntapagocxpgral";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();
$fecha = date('Y-m-d');


    $id_obra = $_SESSION['id_obra'];;
    $consulta = "SELECT * FROM vpreseleccion  UNION 
    SELECT * FROM vpreselecciongral ORDER BY razon_prov";





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
                <h1 class="card-title mx-auto">PREREPORTE DE PAGOS</h1>
            </div>

            <div class="card-body">

                <div class="card card-widget">
                    <div class="card-header bg-gradient-green">
                        <h3 class="card-title">DETALLE DE SALDOS</h3>
                    </div>
                    <div class="card-body">
                        <div class="container-fluid">

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <table name="tablaPs" id="tablaPs" class="table table-sm table-striped table-bordered table-condensed w-auto mx-auto" style="width:100%; font-size:15px">
                                            <thead class="text-center bg-gradient-green">
                                                <tr>
                                                    <th>TIPO</th>
                                                    <th>FOLIO</th>
                                                    <th>PROVEEDOR</th>
                                                    <th>FECHA</th>
                                                    <th>CONCEPTO</th>
                                                    <th>MONTO</th>
                                                    <th>SALDO</th>
                                                    <th>SELECCIONAR</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($data as $dat) {
                                                ?>
                                                    <tr>
                                                        <td><?php echo $dat['tipo'] ?></td>
                                                        <td><?php echo $dat['folio'] ?></td>
                                                        <td><?php echo $dat['razon_prov'] ?></td>
                                                        <td class="text-center"><?php echo $dat['fecha'] ?></td>
                                                        <td><?php echo $dat['concepto'] ?></td>
                                                        <td class="text-right"><?php echo number_format($dat['monto'], 2) ?></td>
                                                        <td class="text-right"><?php echo number_format($dat['saldo'], 2) ?></td>
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
                                                <th class="text-right text-bold">TOTALES:</th>
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
<script src="fjs/prerptpagosgral.js?v=<?php echo (rand()); ?>"></script>
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