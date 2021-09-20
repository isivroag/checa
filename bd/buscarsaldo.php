<?php
//filter.php  

include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$foliocxc = (isset($_POST['foliocxc'])) ? $_POST['foliocxc'] : '';
$foliocxp = (isset($_POST['foliocxp'])) ? $_POST['foliocxp'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';

$saldo = 0;
switch ($opcion) {
    case 1:
        $consulta = "SELECT saldo_cxc FROM vcxc WHERE folio_cxc ='$foliocxc' ORDER BY folio_cxc";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()) {
            $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

            foreach ($data as $reg) {
                $saldo = $reg['saldo_cxc'];
            }
        }
        break;
    case 2:
        $consulta = "SELECT saldo_cxp FROM vcxp WHERE folio_cxp ='$foliocxp' ORDER BY folio_cxp";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()) {
            $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

            foreach ($data as $reg) {
                $saldo = $reg['saldo_cxp'];
            }
        }
        break;
}

print json_encode($saldo, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
