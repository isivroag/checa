<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   
$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';

$id_obra = (isset($_POST['id_obra'])) ? $_POST['id_obra'] : '';
$id_prov = (isset($_POST['id_prov'])) ? $_POST['id_prov'] : '';
$descripcion = (isset($_POST['descripcion'])) ? $_POST['descripcion'] : '';
$clave = (isset($_POST['clave'])) ? $_POST['clave'] : '';
$fecha = (isset($_POST['fecha'])) ? $_POST['fecha'] : '';
$monto = (isset($_POST['monto'])) ? $_POST['monto'] : '';
$tipo = (isset($_POST['tipo'])) ? $_POST['tipo'] : '';


$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';



$data=0;
switch($opcion){
    case 1: //alta
        $consulta = "INSERT INTO w_subcontrato (id_obra,id_prov,fecha_sub,clave_sub,desc_sub,monto_sub,saldo_sub,tipo_sub) VALUES('$id_obra','$id_prov','$fecha','$clave','$descripcion','$monto','$monto','$tipo') ";
        $resultado = $conexion->prepare($consulta);
        if($resultado->execute()){
            $data=1;
        } 

        
        break;
    case 2: //modificación
        $consulta = "UPDATE w_subcontrato SET  id_obra='$id_obra',id_prov='$id_prov',desc_sub='$descripcion',clave_sub='$clave',tipo_sub='$tipo' WHERE folio_sub='$folio' ";		
        $resultado = $conexion->prepare($consulta);
        if($resultado->execute()){
            $data=1;
        }
        
        
        break;        
    case 3://baja
        $consulta = "UPDATE w_subcontrato SET estado_sub=0 WHERE folio_sub='$folio'";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()){
            $data=1;                          
        }
        
        break;   
  
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
