<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   
$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';

$fecha = (isset($_POST['fecha'])) ? $_POST['fecha'] : '';

$id_obra = (isset($_POST['id_obra'])) ? $_POST['id_obra'] : '';
$obs = (isset($_POST['obs'])) ? $_POST['obs'] : '';
$monto = (isset($_POST['monto'])) ? $_POST['monto'] : '';
$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';
$fecha = (isset($_POST['fecha'])) ? $_POST['fecha'] : '';
$mincaja = (isset($_POST['mincaja'])) ? $_POST['mincaja'] : '';

$claveca = (isset($_POST['claveca'])) ? $_POST['claveca'] : '';
$fechaalta = date('Y-m-d');

$id = (isset($_POST['id'])) ? $_POST['id'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';


switch($opcion){
    case 1: //alta
        $consulta = "INSERT INTO w_caja (id_obra,monto_caja,saldo_caja,obs_caja,fecha_ini,usuarioalt,min_caja,clave_caja) VALUES('$id_obra','$monto','0','$obs','$fecha','$usuario','$mincaja','$claveca') ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 

        $consulta = "SELECT * FROM vcaja ORDER BY id_caja DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 2: //modificación
       
        break;        
    case 3://baja
        $consulta = "UPDATE w_caja SET estado_caja=0 WHERE id_caja='$id' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 
        $data=1;                          
        break;   
   

}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
