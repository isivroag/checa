<?php
//filter.php  

include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$tipodoc = (isset($_POST['tipodoc'])) ? $_POST['tipodoc'] : '';
$id = (isset($_POST['id'])) ? $_POST['id'] : '';
$montopago = (isset($_POST['montopago'])) ? $_POST['montopago'] : '';


$saldo = 0;

switch ($tipodoc) {
    case 'PROVISION SUB':
        $consulta = "SELECT saldo_prov as saldo FROM w_provsub WHERE id_provs ='$id'";
        break;
    case 'REQUISICION':
        $consulta = "SELECT saldo_req as saldo FROM w_reqsub WHERE id_req ='$id'";
        break;
    case 'CXP':
        $consulta = "SELECT saldo_cxp as saldo FROM w_cxp WHERE folio_cxp ='$id'";
        break;
    case 'PROVISION':
        $consulta = "SELECT saldo_provi as saldo FROM w_provision WHERE folio_provi ='$id'";
        break;
    case 'CXP GRAL':
        $consulta = "SELECT saldo_cxp as saldo FROM w_cxpgral WHERE folio_cxp ='$id'";
        break;
    case 'PROVISION GRAL':
        $consulta = "SELECT saldo_provi as saldo FROM w_provisiongral WHERE folio_provi ='$id'";
        break;
}


$resultado = $conexion->prepare($consulta);
if ($resultado->execute()) {
    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

    foreach ($data as $reg) {
        $saldo = $reg['saldo'];
    }
}
print json_encode($saldo, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
