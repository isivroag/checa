<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   


$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';


switch($opcion){
    case 1:
        $consulta = "SELECT * FROM w_pagocxcgral WHERE folio_cxc='$folio' and estado_pagocxc=1 ORDER BY folio_pagocxc,fecha_pagocxc";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    break;
    case 2:
        $consulta = "SELECT * FROM w_pagocxpgral WHERE folio_cxp='$folio' and estado_pagocxp=1 ORDER BY folio_pagocxp,fecha_pagocxp";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    break;
    case 3:
       
    break;
    case 4:
       
        break;
        case 5:
       
            break;
    
}

print json_encode($data, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
