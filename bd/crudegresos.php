<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   
$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';
$fecha = (isset($_POST['fecha'])) ? $_POST['fecha'] : '';
$uuid = (isset($_POST['uuid'])) ? $_POST['uuid'] : '';
$factura = (isset($_POST['factura'])) ? $_POST['factura'] : '';
$id_obra = (isset($_POST['id_obra'])) ? $_POST['id_obra'] : '';
$id_prov = (isset($_POST['id_prov'])) ? $_POST['id_prov'] : '';
$descripcion = (isset($_POST['descripcion'])) ? $_POST['descripcion'] : '';
$tipo = (isset($_POST['tipo'])) ? $_POST['tipo'] : '';
$subtotal = (isset($_POST['subtotal'])) ? $_POST['subtotal'] : '';
$iva = (isset($_POST['iva'])) ? $_POST['iva'] : '';
$monto = (isset($_POST['monto'])) ? $_POST['monto'] : '';
$ret1 = (isset($_POST['ret1'])) ? $_POST['ret1'] : '';
$ret2 = (isset($_POST['ret2'])) ? $_POST['ret2'] : '';
$ret3 = (isset($_POST['ret3'])) ? $_POST['ret3'] : '';

$importe = (isset($_POST['importe'])) ? $_POST['importe'] : '';
$descuento = (isset($_POST['descuento'])) ? $_POST['descuento'] : '';
$devolucion = (isset($_POST['devolucion'])) ? $_POST['devolucion'] : '';
//$ret4 = (isset($_POST['ret4'])) ? $_POST['ret4'] : '';
$montob = (isset($_POST['montob'])) ? $_POST['montob'] : '';

$folioprovi = (isset($_POST['folioprovi'])) ? $_POST['folioprovi'] : '';

$forigen = (isset($_POST['forigen'])) ? $_POST['forigen'] : '';

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$id_partidacto = (isset($_POST['id_partidacto'])) ? $_POST['id_partidacto'] : '';




$data = 0;
switch ($opcion) {
    case 1: //alta
        $consulta = "INSERT INTO w_cxp (id_obra,id_prov,fecha_cxp,factura_cxp,desc_cxp,monto_cxp,saldo_cxp,tipo_cxp,subtotal_cxp,iva_cxp,ret1,ret2,ret3,
        montob,importe,descuento,devolucion,uuid,id_partidacto) 
        VALUES('$id_obra','$id_prov','$fecha','$factura','$descripcion','$monto','$monto','$tipo','$subtotal','$iva','$ret1','$ret2','$ret3',
        '$montob','$importe','$descuento','$devolucion','$uuid','$id_partidacto') ";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()) {
            $data = 1;
        }


        break;
    case 2: //modificación
        $consulta = "UPDATE w_cxp SET  id_obra='$id_obra',id_prov='$id_prov',desc_cxp='$descripcion',clave_cxp='$clave',tipo_cxp='$tipo'.id_partidacto='$id_partidacto' WHERE folio_cxp='$folio' ";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()) {
            $data = 1;
        }


        break;
    case 3: //baja
        $consulta = "UPDATE w_cxp SET estado_cxp=0 WHERE folio_cxp='$folio'";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()) {
            $data = 1;
        }

        break;
    case 4:
        $consulta = "INSERT INTO w_cxp (id_obra,id_prov,fecha_cxp,factura_cxp,desc_cxp,monto_cxp,saldo_cxp,tipo_cxp,subtotal_cxp,iva_cxp,folio_provi,ret1,ret2,ret3,montob,importe,descuento,devolucion,uuid)
         VALUES('$id_obra','$id_prov','$fecha','$factura','$descripcion','$monto','$monto','$tipo','$subtotal','$iva','$folioprovi','$ret1','$ret2','$ret3','$montob','$importe','$descuento','$devolucion','$uuid') ";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()) {


            $abono=round($importe * 1.16,2,PHP_ROUND_HALF_UP);
            $consulta = "UPDATE w_provision SET saldo_provi=saldo_provi-'$abono' WHERE folio_provi='$folioprovi'";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();

            $consulta = "SELECT saldo_provi FROM w_provision WHERE folio_provi='$folioprovi'";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            $datos = $resultado->fetchAll(PDO::FETCH_ASSOC);;
            $saldoprov = 1;

            foreach ($datos as $row) {
                $saldoprov = $row['saldo_provi'];
            }

            if ($saldoprov == 0) {
                $consulta = "UPDATE w_provision SET estado=2 WHERE folio_provi='$folioprovi'";
                $resultado = $conexion->prepare($consulta);
                $resultado->execute();
            }


            $data = 1;
        }
        break;
        case 5:
            $consulta = "INSERT INTO w_cxp (id_obra,id_prov,fecha_cxp,factura_cxp,desc_cxp,monto_cxp,saldo_cxp,tipo_cxp,subtotal_cxp,iva_cxp,folio_provi,ret1,ret2,ret3,montob,importe,descuento,devolucion,uuid)
             VALUES('$id_obra','$id_prov','$fecha','$factura','$descripcion','$monto','$monto','$tipo','$subtotal','$iva','$folioprovi','$ret1','$ret2','$ret3','$montob','$importe','$descuento','$devolucion','$uuid') ";
            $resultado = $conexion->prepare($consulta);
            if ($resultado->execute()) {


                $consulta = "SELECT * from w_cxp where id_obra='$id_obra' ORDER BY folio_cxp DESC LIMIT 1 ";
                $resultado = $conexion->prepare($consulta);
                $resultado->execute();
                $datos = $resultado->fetchAll(PDO::FETCH_ASSOC);
                foreach($datos as $row){
                    $foliocxp=$row['folio_cxp'];
                  
                }
    
    
                $abono=round($importe * 1.16,0,PHP_ROUND_HALF_UP);
                $consulta = "UPDATE w_provision SET saldo_provi=saldo_provi-'$abono' WHERE folio_provi='$folioprovi'";
                $resultado = $conexion->prepare($consulta);
                $resultado->execute();
    
                $consulta = "SELECT saldo_provi FROM w_provision WHERE folio_provi='$folioprovi'";
                $resultado = $conexion->prepare($consulta);
                $resultado->execute();
                $datos = $resultado->fetchAll(PDO::FETCH_ASSOC);;
                $saldoprov = 1;
    
                foreach ($datos as $row) {
                    $saldoprov = $row['saldo_provi'];
                }
    
                if ($saldoprov == 0) {
                    $consulta = "UPDATE w_provision SET estado=2 WHERE folio_provi='$folioprovi'";
                    $resultado = $conexion->prepare($consulta);
                    $resultado->execute();
                }


                
                $fechavp = (isset($_POST['fechavp'])) ? $_POST['fechavp'] : '';
                $observacionesvp = (isset($_POST['observacionesvp'])) ? $_POST['observacionesvp'] : '';
                $referenciavp = (isset($_POST['referenciavp'])) ? $_POST['referenciavp'] : '';
              
                $montovp = (isset($_POST['montovp'])) ? $_POST['montovp'] : '';
              
                $metodovp = (isset($_POST['metodovp'])) ? $_POST['metodovp'] : '';
                $usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';
                $opcionpago = (isset($_POST['opcionpago'])) ? $_POST['opcionpago'] : '';


                $consulta = "INSERT INTO w_pagocxp (folio_cxp,fecha_pagocxp,referencia_pagocxp,observaciones_pagocxp,metodo_pagocxp,monto_pagocxp,usuario) 
                VALUES ('$foliocxp','$fechavp','$referenciavp','$observacionesvp','$metodovp','$montovp','$usuario')";
                $resultado = $conexion->prepare($consulta);


                if ($resultado->execute()) {

                    $consulta = "UPDATE w_cxp SET saldo_cxp=0 where folio_cxp='$foliocxp'";
                    $resultado = $conexion->prepare($consulta);
                    if ($resultado->execute()) {
                        
                       
                        
                        

                            $consulta = "UPDATE semanal_detalle SET aplicado=1 where id_reg='$forigen'";
                            $resultado = $conexion->prepare($consulta);
                            $resultado->execute();

                            $consulta = "SELECT folio_rpt from semanal_detalle WHERE id_reg='$forigen'";
                            $resultado = $conexion->prepare($consulta);
                            $resultado->execute();
                            $reg = $resultado->fetchAll(PDO::FETCH_ASSOC);
                            foreach($reg as $row){
                             $folioreporte=$row['folio_rpt'];
                            }
     
     
                            $consulta = "SELECT * FROM semanal_detalle where folio_rpt='$folioreporte' and aplicado=0";
                            $resultado = $conexion->prepare($consulta);
                            $resultado->execute();
                            if ($resultado->rowCount()==0){
                             $consulta = "UPDATE semanal SET activo=3 where folio='$folioreporte'";
                             $resultado = $conexion->prepare($consulta);
                             $resultado->execute();
                            }
                    } else {
                        $res = 2;
                    }
                }
    
                $data = 1;
            }
            break;
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
