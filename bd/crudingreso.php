<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   
$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';

$id_obra = (isset($_POST['id_obra'])) ? $_POST['id_obra'] : '';
$descripcion = (isset($_POST['descripcion'])) ? $_POST['descripcion'] : '';
$clave = (isset($_POST['clave'])) ? $_POST['clave'] : '';
$fecha = (isset($_POST['fecha'])) ? $_POST['fecha'] : '';
$monto = (isset($_POST['monto'])) ? $_POST['monto'] : '';


$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';



$data=0;
switch($opcion){
    case 1: //alta
        $consulta = "INSERT INTO w_cxc (id_obra,fecha_cxc,clave_cxc,desc_cxc,monto_cxc,saldo_cxc) VALUES('$id_obra','$fecha','$clave','$descripcion','$monto','$monto') ";
        $resultado = $conexion->prepare($consulta);
        if($resultado->execute()){
            $data=1;
        } 

        
        break;
    case 2: //modificación
        $consulta = "UPDATE w_cxc SET  id_obra='$id_obra',desc_cxc='$descripcion',clave_cxc='$clave' WHERE folio_cxc='$folio' ";		
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
