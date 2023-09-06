<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();
date_default_timezone_set('America/Mexico_City');

// Recepción de los datos enviados mediante POST desde el JS   
$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';
$fecha = (isset($_POST['fecha'])) ? $_POST['fecha'] : '';


$id_obra = (isset($_POST['id_obra'])) ? $_POST['id_obra'] : '';
$id_prov = (isset($_POST['id_prov'])) ? $_POST['id_prov'] : '';
$concepto = (isset($_POST['concepto'])) ? $_POST['concepto'] : '';
$total = (isset($_POST['total'])) ? $_POST['total'] : '';

$id_sol = (isset($_POST['id_sol'])) ? $_POST['id_sol'] : '';


$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';


$fechaalta = date('Y-m-d H:i:s');

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';



$data=0;
switch($opcion){
    case 1: //alta
        $consulta = "UPDATE requisicion SET id_obra='$id_obra',id_prov='$id_prov',id_sol='$id_sol',fecha='$fecha',desc_req='$concepto',
        monto_req='$total',saldo_req='$total',terminado='1', fecha_alta='$fechaalta', usuarioalt='$usuario'
        WHERE folio_req='$folio' ";
        $resultado = $conexion->prepare($consulta);
        if($resultado->execute()){
            $data=1;
        } 

        
        break;
    case 2: //modificación
       
        
        break;        
    case 3://baja
        $consulta = "UPDATE requisicion SET estado_req=0 WHERE folio_req='$folio'";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()){
            $data=1;                          
        }
        
        break;   
  
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;

