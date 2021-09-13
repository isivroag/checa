<?php
//filter.php  

include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';

$saldo = 0;

$consulta = "SELECT saldo_reg FROM registro WHERE folio_reg ='$folio' ";
$resultado = $conexion->prepare($consulta);
if ($resultado->execute()) {
    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
 
    foreach ($data as $reg) {
        $saldo = $reg['saldo_reg'];
    }
}
print json_encode($saldo, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
