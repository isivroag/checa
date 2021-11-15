<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   
$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';
$fechaini = (isset($_POST['fechaini'])) ? $_POST['fechaini'] : '';
$fechafin = (isset($_POST['fechafin'])) ? $_POST['fechafin'] : '';

$id_obra = (isset($_POST['id_obra'])) ? $_POST['id_obra'] : '';
$descripcion = (isset($_POST['descripcion'])) ? $_POST['descripcion'] : '';

$monto = (isset($_POST['monto'])) ? $_POST['monto'] : '';
$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';




$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';



$data=0;
switch($opcion){
    case 1: //alta
        $consulta = "INSERT INTO w_nomina (id_obra,fecha_ini,fecha_fin,desc_nom,monto_nom,usuarioalt) VALUES('$id_obra','$fechaini','$fechafin','$descripcion','$monto','$usuario') ";
        $resultado = $conexion->prepare($consulta);
        if($resultado->execute()){
            $data=1;
        } 

        
        break;
    case 2: //modificación
       
        
        break;        
    case 3://baja
        $consulta = "UPDATE w_nomina SET estado_nom=0 WHERE folio_nom='$folio'";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()){
            $data=1;                          
        }
        
        break;   
  
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
