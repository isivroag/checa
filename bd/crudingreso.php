<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   
$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';
$fecha = (isset($_POST['fecha'])) ? $_POST['fecha'] : '';
$factura = (isset($_POST['factura'])) ? $_POST['factura'] : '';
$id_obra = (isset($_POST['id_obra'])) ? $_POST['id_obra'] : '';
$descripcion = (isset($_POST['descripcion'])) ? $_POST['descripcion'] : '';
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



$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';



$data=0;
switch($opcion){
    case 1: //alta
        $consulta = "INSERT INTO w_cxc (id_obra,fecha_cxc,factura_cxc,desc_cxc,monto_cxc,saldo_cxc,subtotal_cxc,iva_cxc,ret1,ret2,ret3,montob,importe,descuento,devolucion) 
        VALUES('$id_obra','$fecha','$factura','$descripcion','$monto','$monto','$subtotal','$iva','$ret1','$ret2','$ret3','$montob','$importe','$descuento','$devolucion')";
        $resultado = $conexion->prepare($consulta);
        if($resultado->execute()){
            $data=1;
        } 

        
        break;
    case 2: //modificación
        $consulta = "UPDATE w_cxc SET id_obra='$id_obra',desc_cxc='$descripcion',factura_cxc='$factura',fecha_cxc='$fecha',monto_cxc='$monto',saldo_cxc='$monto',subtotal_cxc='$subtotal',iva_cxc='$iva' WHERE folio_cxc='$folio' ";		
        $resultado = $conexion->prepare($consulta);
        if($resultado->execute()){
            $data=1;
        }
        
        
        break;        
    case 3://baja
        $consulta = "UPDATE w_cxc SET estado_cxc=0 WHERE folio_cxc='$folio'";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()){
            $data=1;                          
        }
        
        break;   
  
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
