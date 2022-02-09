<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   
$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';
$fecha = (isset($_POST['fecha'])) ? $_POST['fecha'] : '';
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



$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';



$data = 0;
switch ($opcion) {
    case 1: //alta
        $consulta = "INSERT INTO w_cxp (id_obra,id_prov,fecha_cxp,factura_cxp,desc_cxp,monto_cxp,saldo_cxp,tipo_cxp,subtotal_cxp,iva_cxp,ret1,ret2,ret3,montob,importe,descuento,devolucion) 
        VALUES('$id_obra','$id_prov','$fecha','$factura','$descripcion','$monto','$monto','$tipo','$subtotal','$iva','$ret1','$ret2','$ret3','$montob','$importe','$descuento','$devolucion') ";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()) {
            $data = 1;
        }


        break;
    case 2: //modificación
        $consulta = "UPDATE w_cxp SET  id_obra='$id_obra',id_prov='$id_prov',desc_cxp='$descripcion',clave_cxp='$clave',tipo_cxp='$tipo' WHERE folio_cxp='$folio' ";
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
        $consulta = "INSERT INTO w_cxp (id_obra,id_prov,fecha_cxp,factura_cxp,desc_cxp,monto_cxp,saldo_cxp,tipo_cxp,subtotal_cxp,iva_cxp,folio_provi,ret1,ret2,ret3,montob,importe,descuento,devolucion)
         VALUES('$id_obra','$id_prov','$fecha','$factura','$descripcion','$monto','$monto','$tipo','$subtotal','$iva','$folioprovi','$ret1','$ret2','$ret3','$montob','$importe','$descuento','$devolucion') ";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()) {

            $consulta = "UPDATE w_provision SET saldo_provi=saldo_provi-'$monto' WHERE folio_provi='$folioprovi'";
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
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
