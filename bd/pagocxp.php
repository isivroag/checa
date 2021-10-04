<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   



$foliocxp = (isset($_POST['foliocxp'])) ? $_POST['foliocxp'] : '';
$fechavp = (isset($_POST['fechavp'])) ? $_POST['fechavp'] : '';
$observacionesvp = (isset($_POST['observacionesvp'])) ? $_POST['observacionesvp'] : '';
$referenciavp = (isset($_POST['referenciavp'])) ? $_POST['referenciavp'] : '';
$saldovp = (isset($_POST['saldovp'])) ? $_POST['saldovp'] : '';
$montovp = (isset($_POST['montovp'])) ? $_POST['montovp'] : '';
$saldofin = (isset($_POST['saldofin'])) ? $_POST['saldofin'] : '';
$metodovp = (isset($_POST['metodovp'])) ? $_POST['metodovp'] : '';
$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$factura = (isset($_POST['factura'])) ? $_POST['factura'] : '';
$id_prov = (isset($_POST['id_prov'])) ? $_POST['id_prov'] : '';


$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';
$res = 0;


 
$consulta = "SELECT * FROM vcxp where estado_cxp = 1 and id_prov='$id_prov' and clave_cxp='$factura' and folio_cxp='$foliocxp'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
if($resultado->rowCount() == 0){

    $consulta = "SELECT * FROM vpagocxp where estado_pagocxp = 1 and estado_cxp = 1 and id_prov='$id_prov' and fact_pagocxp='$factura'";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();
    if($resultado->rowCount() == 0){

        $consulta = "INSERT INTO w_pagocxp (folio_cxp,fecha_pagocxp,referencia_pagocxp,observaciones_pagocxp,metodo_pagocxp,monto_pagocxp,usuario,fact_pagocxp) VALUES ('$foliocxp','$fechavp','$referenciavp','$observacionesvp','$metodovp','$montovp','$usuario','$factura')";
        $resultado = $conexion->prepare($consulta);
        
        if ($resultado->execute()) {
            
            $consulta = "UPDATE w_cxp SET saldo_cxp='$saldofin' where folio_cxp='$foliocxp'";
            $resultado = $conexion->prepare($consulta);
            if ($resultado->execute()) {
                $res = 1;
            }
        } else {
            $res = 2;
        }

    }else{
        $res=0;
    }

    
    
    
    
   

}else{
    $res=0;
}


print json_encode($res, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
