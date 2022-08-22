<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   


$obra = (isset($_POST['obra'])) ? $_POST['obra'] : '';
$inicio = (isset($_POST['inicio'])) ? $_POST['inicio'] : '';
$final = (isset($_POST['final'])) ? $_POST['final'] : '';

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';


switch($opcion){
    case 1:
        $consulta = " SELECT vrequisicion.id_obra,vrequisicion.clave_sub, vrequisicion.desc_sub,vrequisicion.razon_prov,vrequisicion.concepto_req,
        w_pagors.folio_pagors,w_pagors.fecha_pagors,w_pagors.referencia_pagors ,w_pagors.metodo_pagors,w_pagors.monto_pagors,w_pagors.observaciones_pagors 
        FROM w_pagors JOIN vrequisicion ON w_pagors.id_req = vrequisicion.id_req WHERE vrequisicion.id_obra='$obra' and w_pagors.fecha_pagors between '$inicio' and '$final' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    break;
    case 2:
        $consulta = "SELECT * FROM vpagocxp
        WHERE id_obra='$obra' and fecha_pagocxp between '$inicio' and '$final' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    break;
   
    
}

print json_encode($data, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
