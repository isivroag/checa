<?php
//filter.php  

include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$foliocxc = (isset($_POST['foliocxc'])) ? $_POST['foliocxc'] : '';
$foliocxp = (isset($_POST['foliocxp'])) ? $_POST['foliocxp'] : '';
$folioreq = (isset($_POST['folioreq'])) ? $_POST['folioreq'] : '';
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

        case 3:
            $consulta = "SELECT saldo_req FROM w_reqsub WHERE id_req ='$folioreq' ORDER BY id_req";
            $resultado = $conexion->prepare($consulta);
            if ($resultado->execute()) {
                $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    
                foreach ($data as $reg) {
                    $saldo = $reg['saldo_req'];
                }
            }
            break;
            
        case 4:
            $consulta = "SELECT saldo_otro FROM w_otro WHERE id_otro ='$folioreq' ORDER BY id_otro";
            $resultado = $conexion->prepare($consulta);
            if ($resultado->execute()) {
                $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    
                foreach ($data as $reg) {
                    $saldo = $reg['saldo_otro'];
                }
            }
            break;

            case 5:
                $consulta = "SELECT saldo_gto FROM w_gasto WHERE folio_gto ='$folioreq' ORDER BY folio_gto";
                $resultado = $conexion->prepare($consulta);
                if ($resultado->execute()) {
                    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        
                    foreach ($data as $reg) {
                        $saldo = $reg['saldo_gto'];
                    }
                }
                break;
                case 6:
                    $consulta = "SELECT saldo_provi FROM w_provision WHERE folio_provi ='$foliocxp' ORDER BY folio_provi";
                    $resultado = $conexion->prepare($consulta);
                    if ($resultado->execute()) {
                        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
            
                        foreach ($data as $reg) {
                            $saldo = $reg['saldo_provi'];
                        }
                    }
                    break;
}

print json_encode($saldo, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
