<?php
$pagina = "saldoseggral";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();
$fecha = date('Y-m-d');


    $id_obra = $_SESSION['id_obra'];;
    $consulta = "SELECT * FROM vprovisiongral WHERE estado_provi= 1 and estado=1 and edorpt=0 ORDER BY fecha_provi";
    $consulta2 = "SELECT * FROM vcxpgral WHERE estado_cxp=1 and saldo_cxp>0 and edorpt=0 ORDER BY fecha_cxp";
   




$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);

$resultado2 = $conexion->prepare($consulta2);
$resultado2->execute();
$data2 = $resultado2->fetchAll(PDO::FETCH_ASSOC);




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
                <h1 class="card-title mx-auto">SALDOS PENDIENTES</h1>
            </div>

            <div class="card-body">

                <div class="card card-widget">
                    <div class="card-header bg-gradient-green">
                        <h3 class="card-title">COTIZACIONES</h3>
                    </div>
                    <div class="card-body">
                        <div class="container-fluid">

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <table name="tablaPs" id="tablaPs" class="table table-sm table-striped table-bordered table-condensed w-auto mx-auto" style="width:100%; font-size:15px">
                                            <thead class="text-center bg-gradient-green">
                                                <tr>
                                                    <th>FOLIO</th>
                                                    
                                                    <th>FECHA</th>
                                                    
                                                    <th>PROVEEDOR</th>
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
                                                        <td><?php echo $dat['folio_provi'] ?></td>
                                                        <td class="text-center"><?php echo $dat['fecha_provi'] ?></td>
                                                        
                                                        <td><?php echo $dat['razon_prov'] ?></td>
                                                        <td><?php echo $dat['concepto_provi'] ?></td>
                                                        <td class="text-right"><?php echo number_format($dat['monto_provi'], 2) ?></td>
                                                        <td class="text-right"><?php echo number_format($dat['saldo_provi'], 2) ?></td>
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

                <div class="card card-widget">
                    <div class="card-header bg-gradient-green">
                        <h3 class="card-title">CUENTAS X PAGAR</h3>
                    </div>
                    <div class="card-body">
                        <div class="container-fluid">

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <table name="tablaRq" id="tablaRq" class="table table-sm table-striped table-bordered table-condensed w-auto mx-auto" style="width:100%; font-size:15px">
                                            <thead class="text-center bg-gradient-green">
                                                <tr>
                                                    <th>FOLIO</th>
                                                   
                                                    <th>FACTURA</th>
                                                    <th>FECHA</th>
                                                   
                                                    <th>PROVEEDOR</th>
                                                    <th>CONCEPTO</th>
                                                    <th>MONTO</th>
                                                    <th>SALDO</th>
                                                    <th>SELECCIONAR</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($data2 as $dat) {
                                                ?>
                                                    <tr>
                                                        <td><?php echo $dat['folio_cxp'] ?></td>
                                                        <td><?php echo $dat['factura_cxp'] ?></td>
                                                        <td class="text-center"><?php echo $dat['fecha_cxp'] ?></td>
                                                        
                                                        <td><?php echo $dat['razon_prov'] ?></td>
                                                        <td><?php echo $dat['desc_cxp'] ?></td>
                                                        <td class="text-right"><?php echo number_format($dat['monto_cxp'], 2) ?></td>
                                                        <td class="text-right"><?php echo number_format($dat['saldo_cxp'], 2) ?></td>
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
<script src="fjs/cntasaldoseggral.js?v=<?php echo (rand()); ?>"></script>
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