<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   


$folioprov = (isset($_POST['folioprov'])) ? $_POST['folioprov'] : '';
$saldopendiente = (isset($_POST['saldopendiente'])) ? $_POST['saldopendiente'] : '';


$res=0;
$consulta = "UPDATE w_provision SET saldado_prov=saldo_provi,saldo_provi='0',estado='2' WHERE folio_provi='$folioprov'";
$resultado = $conexion->prepare($consulta);
if ($resultado->execute()) {

   
    
    $res = 1;
} else {
    $res = 0;
}




print json_encode($res, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
