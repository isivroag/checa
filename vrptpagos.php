<?php
$pagina = "vrptpagos";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();


$fecha = date('Y-m-d');


$consultaprov = "SELECT * FROM semanal WHERE estado=1 and activo<>1 ORDER BY folio";
$resultadoprov = $conexion->prepare($consultaprov);
$resultadoprov->execute();
$data = $resultadoprov->fetchAll(PDO::FETCH_ASSOC);



$message = "";



?>

<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">


<style>
.swal-wide{
    width:850px !important;
}

td.details-control {
    background: url('img/details_open.png') no-repeat center center ;

    cursor: pointer;
}
tr.details td.details-control {
    background: url('img/details_close.png') no-repeat center center;

    
}
.borderless td,
    .borderless th {
        border: none;
    }
    .bg1{
      background-color: rgba(25,151,6,.6)!important;
      color: white;
    }
    .bg2{
      background-color: rgba(52,78,253,.85)!important;
      color: white;
    }
    .bg3{
      background-color: rgba(79,3,210,.6)!important;
      color: white;
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->


    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header bg-gradient-green text-light">
                <h1 class="card-title mx-auto">Consulta de Pagos Semanales</h1>
            </div>

            <div class="card-body">

                <div class="row">
                    <div class="col-lg-12">
                        <button id="btnNuevo" type="button" class="btn bg-gradient-green btn-ms" data-toggle="modal"><i class="fas fa-plus-square text-light"></i><span class="text-light"> Nuevo</span></button>
                    </div>
                </div>
                <br>

                <div class="container-fluid">


                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table name="tablaV" id="tablaV" class="table table-sm table-striped table-bordered table-condensed w-auto mx-auto " style="width:100%;font-size:15px">
                                    <thead class="text-center bg-gradient-green">
                                        <tr>
                                            <th></th>
                                            <th>ID</th>

                                            <th>FECHA</th>
                                            <th>FECHA INICIO</th>
                                            <th>FECHA FINAL</th>
                                            <th>MONTO</th>
                                            <th>ESTADO</th>
                                         

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($data as $dat) {
                                        ?>
                                            <tr>
                                                <td></td>
                                                <td><?php echo $dat['folio'] ?></td>
                                                <td><?php echo $dat['fecha'] ?></td>
                                                <td><?php echo $dat['fecha_ini'] ?></td>
                                                <td><?php echo $dat['fecha_fin'] ?></td>
                                                <td class="text-right"><?php echo number_format($dat['total'], 2) ?></td>
                                                <td><?php echo  $dat['activo'] ?></td>
                                              


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
            <!-- /.card-body -->

            <!-- /.card-footer-->
        </div>
        <!-- /.card -->

    </section>

  
</div>


<?php include_once 'templates/footer.php'; ?>
<script src="fjs/vrptpagos.js?v=<?php echo (rand()); ?>"></script>
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