<?php
$pagina = "cntaingresos";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();
$fecha=date('Y-m-d');
if($_SESSION['id_obra'] != null){
    $id_obra=$_SESSION['id_obra'];
    $consulta = "SELECT * FROM vpagocxc WHERE id_obra='$id_obra' and estado_cxc=1 and estado_pagocxc=1 ORDER BY id_obra,folio_cxc,fecha_pagocxc";
}else{
    $consulta = "SELECT * FROM vpagocxc WHERE estado_pagocxc=1 and estado_cxc=1 ORDER BY id_obra,folio_cxc,fecha_pagocxc";
}

$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);





$message = "";



?>

<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">


<style>
  .starchecked
  { color:rgba( 255, 195, 0,100)}

  .multi-line {
  white-space: normal;
  width: 250px;
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
                <h1 class="card-title mx-auto">Ingresos</h1>
            </div>

            <div class="card-body">

            <div class="card">
                    <div class="card-header bg-gradient-green">
                        Filtro por rango de Fecha
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-lg-2">
                                <div class="form-group input-group-sm">
                                    <label for="fecha" class="col-form-label">Desde:</label>
                                    <input type="date" class="form-control" name="inicio" id="inicio">
                                    <input type="hidden" class="form-control" name="tipo_proy" id="tipo_proy" value=1>

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
                                <table name="tablaV" id="tablaV" class="table table-sm table-striped table-bordered table-condensed text-nowrap w-auto mx-auto" style="width:100%">
                                    <thead class="text-center bg-gradient-green">
                                        <tr>
                                            <th>FOLIO CXC</th>
                                            <th>OBRA</th>
                                            <th>FECHA FACT</th>
                                            <th>FACTURA</th>
                                            <th>CONCEPTO FACTURA</th>
                                            <th>MONTO FACTURA</th>
                                            <th>FECHA PAGO</th>
                                            <th>MONTO PAGO</th>
                                            <th>SALDO FACTURA</th>
                                            
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($data as $dat) {
                                        ?>
                                            <tr>
                                                <td><?php echo $dat['folio_cxc'] ?></td>
                                                <td><?php echo $dat['corto_obra'] ?></td>
                                                <td class="text-center"><?php echo $dat['fecha_cxc'] ?></td>
                                                <td><?php echo $dat['factura_cxc'] ?></td>
                                                <td><?php echo $dat['desc_cxc'] ?></td>
                                                <td class="text-right"><?php echo number_format($dat['monto_cxc'],2) ?></td>
                                                <td class="text-center"><?php echo $dat['fecha_pagocxc'] ?></td>
                                                <td class="text-right"><?php echo number_format($dat['monto_pagocxc'],2) ?></td>
                                                <td class="text-right"><?php echo number_format($dat['saldo_cxc'],2) ?></td>
                                                
             
                                            
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
                                    <th></th>
                                    <th ></th>
                                    <th class="text-right text-bold"></th>
                                    <th class="text-right text-bold"></th>
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
    
    

  


 
    <!-- /.content -->
</div>


<?php include_once 'templates/footer.php'; ?>
<script src="fjs/cntaingresos.js?v=<?php echo(rand()); ?>"></script>
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