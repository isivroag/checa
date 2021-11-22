<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   
$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';
$fecha = (isset($_POST['fecha'])) ? $_POST['fecha'] : '';
$id_obra = (isset($_POST['id_obra'])) ? $_POST['id_obra'] : '';
$id_prov = (isset($_POST['id_prov'])) ? $_POST['id_prov'] : '';
$descripcion = (isset($_POST['descripcion'])) ? $_POST['descripcion'] : '';
$tipo = (isset($_POST['tipo'])) ? $_POST['tipo'] : '';
$subtotal = (isset($_POST['subtotal'])) ? $_POST['subtotal'] : '';
$iva = (isset($_POST['iva'])) ? $_POST['iva'] : '';
$monto = (isset($_POST['monto'])) ? $_POST['monto'] : '';
$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';



$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';



$data=0;
switch($opcion){
    case 1: //alta
        $consulta = "INSERT INTO w_gasto (id_obra,id_prov,fecha_gto,concepto_gto,monto_gto,saldo_gto,subtotal_gto,iva_gto,tipo_gto,usuarioalt) VALUES('$id_obra','$id_prov','$fecha','$descripcion','$monto','$monto','$subtotal','$iva','$tipo','$usuario') ";
        $resultado = $conexion->prepare($consulta);
        if($resultado->execute()){
            $data=1;
        } 

        
        break;
    case 2: //modificación
        $consulta = "UPDATE w_gasto SET id_obra='$id_obra',id_prov='$id_prov',concepto_gto='$descripcion' WHERE folio_gto='$folio' ";		
        $resultado = $conexion->prepare($consulta);
        if($resultado->execute()){
            $data=1;
        }
        
        
        break;        
    case 3://baja
        $consulta = "UPDATE w_gasto SET estado_gto=0 WHERE folio_gto='$folio'";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()){
            $data=1;                          
        }
        
        break;   
  
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
