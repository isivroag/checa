<!-- CODIGO PHP-->
<?php
$pagina = "pres";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";


include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();





$message = "";


if ($_SESSION['id_obra'] == null) {
    $consultacon = "SELECT * FROM w_obra WHERE estado_obra=1 ORDER BY id_obra";
    $resultadocon = $conexion->prepare($consultacon);
    $resultadocon->execute();
    $datacon = $resultadocon->fetchAll(PDO::FETCH_ASSOC);
} else {
    $id_obra = $_SESSION['id_obra'];
    $obra = $_SESSION['nom_obra'];
}









?>

<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="css/estilo.css">
<style>
    .punto {
        height: 20px !important;
        width: 20px !important;

        border-radius: 50% !important;
        display: inline-block !important;
        text-align: center;
        font-size: 15px;
    }

    #div_carga {
        position: absolute;
        /*top: 50%;
    left: 50%;
    */

        width: 100%;
        height: 100%;
        background-color: rgba(60, 60, 60, 0.5);
        display: none;

        justify-content: center;
        align-items: center;
        z-index: 3;
    }

    #cargador {
        position: absolute;
        top: 50%;
        left: 50%;
        margin-top: -25px;
        margin-left: -25px;
    }

    #textoc {
        position: absolute;
        top: 50%;
        left: 50%;
        margin-top: 120px;
        margin-left: 20px;


    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->


    <!-- Main content -->
    <section class="content">


        <!-- Default box -->
        <div class="card">


            <div id="div_carga">

                <img id="cargador" src="img/loader.gif" />
                <span class=" " id="textoc"><strong>Cargando...</strong></span>

            </div>

            <div class="card-header bg-gradient-green text-light">
                <h1 class="card-title mx-auto">PRESUPUESTO</h1>
            </div>

            <div class="card-body">

                <div class="row">
                    <div class="col-lg-12">


                        <!--<button id="btnNuevo" type="button" class="btn bg-gradient-green btn-ms" data-toggle="modal"><i class="fas fa-plus-square text-light"></i><span class="text-light"> Nuevo</span></button>-->
                        <button type="button" id="btnGuardar" name="btnGuardar" class="btn btn-success" value="btnGuardar"><i class="far fa-save"></i> Guardar</button>
                        <!--<button id="btnNuevo" type="button" class="btn bg-gradient-primary btn-ms" data-toggle="modal"><i class="fas fa-envelope-square"></i> Enviar</button>-->
                    </div>
                </div>

                <br>


                <!-- Formulario Datos de Cliente -->
                <form id="formDatos" action="" method="POST">


                    <div class="content">

                        <div class="card card-widget" style="margin-bottom:0px;">

                            <div class="card-header bg-gradient-green " style="margin:0px;padding:8px">


                                <h1 class="card-title "> DATOS DE PRESUPUESTO</h1>
                            </div>

                            <div class="card-body" style="margin:0px;padding:1px;">



                                <div class=" row justify-content-sm-center">

                                    <div class="col-lg-6">
                                        <div class="input-group input-group-sm">
                                            <label for="empresa" class="col-form-label">OBRA:</label>
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
                                <div class="row justify-content-sm-center">
                                    <div class="col-sm-6">
                                        <div class="form-group ">
                                            <label for="exampleInputFile">Subir Archivo</label>
                                            <div class="input-group input-group-sm">
                                                <div class="custom-file">

                                                    <input type="file" class="custom-file-input" name="archivo" id="archivo" accept=".csv,.xls,.xlsx">

                                                    <label class="custom-file-label" for="archivo">Elegir Archivo</label>
                                                </div>
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary" id="upload">Subir</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="" id="tabla">

                                            </div>
                                        </div>




                                    </div>


                                </div>




                            </div>


                        </div>



                    </div>


                </form>


                <!-- /.card-body -->

                <!-- /.card-footer-->
            </div>
        </div>



        <!-- /.card -->

    </section>








</div>

<script>
    //window.addEventListener('beforeunload', function(event)  {

    // event.preventDefault();


    //event.returnValue ="";
    //});
</script>

<?php include_once 'templates/footer.php'; ?>
<script src="fjs/pres.js"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>