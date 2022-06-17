<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   
$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';
$fechao = (isset($_POST['fechao'])) ? $_POST['fechao'] : '';


$id_obra = (isset($_POST['id_obra'])) ? $_POST['id_obra'] : '';
$id_prov = (isset($_POST['id_prov'])) ? $_POST['id_prov'] : '';
$descripcion = (isset($_POST['descripcion'])) ? $_POST['descripcion'] : '';
$monto = (isset($_POST['monto'])) ? $_POST['monto'] : '';

$subtotal = (isset($_POST['subtotal'])) ? $_POST['subtotal'] : '';
$iva = (isset($_POST['iva'])) ? $_POST['iva'] : '';
$facturado = (isset($_POST['facturado'])) ? $_POST['facturado'] : '';
$factura = (isset($_POST['factura'])) ? $_POST['factura'] : '';

$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';




$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';



$data=0;
switch($opcion){
    case 1: //alta
        $consulta = "INSERT INTO w_otro (id_obra,fecha,desc_otro,monto_otro,saldo_otro,usuarioalt,id_prov,subtotal_otro,iva_otro,facturado,factura) 
        VALUES('$id_obra','$fechao','$descripcion','$monto','$monto','$usuario','$id_prov','$subtotal','$iva','$facturado','$factura') ";
        $resultado = $conexion->prepare($consulta);
        if($resultado->execute()){
            $data=1;
        } 

        
        break;
    case 2: //modificación
       
        
        break;        
    case 3://baja
        $consulta = "UPDATE w_otro SET estado_otro=0 WHERE id_otro='$folio'";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()){
            $data=1;                          
        }
        
        break;   
  
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;

