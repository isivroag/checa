<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();
ini_set('precision', 6);
// Recepción de los datos enviados mediante POST desde el JS   

$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';
$obra = (isset($_POST['obra'])) ? $_POST['obra'] : '';
$partida = (isset($_POST['partida'])) ? $_POST['partida'] : '';
$subpartida = (isset($_POST['subpartida'])) ? $_POST['subpartida'] : '';
$monto = (isset($_POST['monto'])) ? $_POST['monto'] : '';
$id = (isset($_POST['id'])) ? $_POST['id'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';


$res = 0;

switch($opcion){
    case 1:
        $consulta = "INSERT INTO cxpcto (folio_cxp,id_obra,id_partidacto,id_subpartidacto,monto) 
        VALUES ('$folio','$obra','$partida','$subpartida','$monto')";
        break;

    case 2:
        $consulta = "DELETE FROM cxpcto WHERE id_reg='$id'";
        break;


}



$resultado = $conexion->prepare($consulta);

if ($resultado->execute()) {
    $res = 1;
} else {
    $res = 0;
}
print json_encode($res, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
