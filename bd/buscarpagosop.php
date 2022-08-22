<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   


$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';


switch($opcion){
    case 1:
        $consulta = "SELECT w_pagors.folio_pagors,w_pagors.fecha_pagors,w_pagors.referencia_pagors,w_pagors.observaciones_pagors,w_pagors.metodo_pagors,w_pagors.monto_pagors FROM w_pagors JOIN w_reqsub ON w_pagors.id_req=w_reqsub.id_req
        WHERE w_pagors.estado_pagors=1 and w_reqsub.id_provs='$folio' order by w_pagors.fecha_pagors";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    break;
    case 2:
        $consulta = "SELECT * FROM w_pagors 
        WHERE estado_pagors=1 and id_req='$folio' order by fecha_pagors";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    break;
    case 3:
        $consulta = "SELECT * FROM w_pagocxp 
        WHERE estado_pagocxp=1 and folio_cxp='$folio' order by fecha_pagocxp";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    break;
    case 4:
        $consulta = "SELECT w_pagocxp.folio_pagocxp,w_pagocxp.fecha_pagocxp,w_pagocxp.referencia_pagocxp,w_pagocxp.observaciones_pagocxp,w_pagocxp.metodo_pagocxp,w_pagocxp.monto_pagocxp
        FROM w_pagocxp JOIN w_cxp ON w_pagocxp.folio_cxp=w_cxp.folio_cxp
        WHERE w_pagocxp.estado_pagocxp=1 and w_cxp.folio_provi ='$folio' order by w_pagocxp.fecha_pagocxp";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
      
    
}

print json_encode($data, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
