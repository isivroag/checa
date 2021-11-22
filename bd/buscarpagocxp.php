<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   


$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';


switch($opcion){
    case 1:
        $consulta = "SELECT * FROM w_pagocxc WHERE folio_cxc='$folio' and estado_pagocxc=1 ORDER BY folio_pagocxc,fecha_pagocxc";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    break;
    case 2:
        $consulta = "SELECT * FROM w_pagocxp WHERE folio_cxp='$folio' and estado_pagocxp=1 ORDER BY folio_pagocxp,fecha_pagocxp";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    break;
    case 3:
        $consulta = "SELECT * FROM w_pagors WHERE id_req='$folio' and estado_pagors=1 ORDER BY folio_pagors,fecha_pagors";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    break;
    case 4:
        $consulta = "SELECT * FROM w_pagootro WHERE id_otro='$folio' and estado_pagoo=1 ORDER BY folio_pagoo,fecha_pagoo";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
        case 5:
            $consulta = "SELECT * FROM w_pagogasto WHERE folio_gto='$folio' and estado_pagogto=1 ORDER BY folio_pagogto,fecha_pagogto";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
            break;
    
}

print json_encode($data, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
