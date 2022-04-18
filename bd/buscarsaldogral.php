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
        
        break;
    case 2:
        $consulta = "SELECT saldo_cxp FROM vcxpgral WHERE folio_cxp ='$foliocxp' ORDER BY folio_cxp";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()) {
            $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

            foreach ($data as $reg) {
                $saldo = $reg['saldo_cxp'];
            }
        }
        break;

        case 3:
         
            break;
            
        case 4:
           
            break;

            case 5:
            
                break;
}

print json_encode($saldo, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
