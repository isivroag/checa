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
$subtotal = (isset($_POST['subtotal'])) ? $_POST['subtotal'] : '';
$iva = (isset($_POST['iva'])) ? $_POST['iva'] : '';
$tipo = (isset($_POST['tipo'])) ? $_POST['tipo'] : '';
$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';
$id_partidacto = (isset($_POST['id_partidacto'])) ? $_POST['id_partidacto'] : '';


$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';



$data=0;
switch($opcion){
    case 1: //alta
        $consulta = "INSERT INTO w_subcontrato (id_obra,id_prov,fecha_sub,clave_sub,desc_sub,monto_sub,saldo_sub,tipo_sub,subtotal_sub,iva_sub,usuarioalt,id_partidacto) 
        VALUES('$id_obra','$id_prov','$fecha','$clave','$descripcion','$monto','$monto','$tipo','$subtotal','$iva','$usuario','$id_partidacto') ";
        $resultado = $conexion->prepare($consulta);
        if($resultado->execute()){
            $data=1;
        } 

        
        break;
    case 2: //modificación
        $consulta = "UPDATE w_subcontrato SET  id_obra='$id_obra',id_prov='$id_prov',fecha_sub='$fecha',desc_sub='$descripcion',clave_sub='$clave',tipo_sub='$tipo',
        monto_sub='$monto',saldo_sub='$monto',subtotal_sub='$subtotal',iva_sub='$iva',id_partidacto='$id_partidacto' WHERE folio_sub='$folio' ";		
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
