<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   
$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';

$id_emp = (isset($_POST['id_emp'])) ? $_POST['id_emp'] : '';
$id_clie = (isset($_POST['id_clie'])) ? $_POST['id_clie'] : '';

$corto = (isset($_POST['corto'])) ? $_POST['corto'] : '';
$largo = (isset($_POST['largo'])) ? $_POST['largo'] : '';
$clave = (isset($_POST['clave'])) ? $_POST['clave'] : '';
$fecha = (isset($_POST['fecha'])) ? $_POST['fecha'] : '';
$monto = (isset($_POST['monto'])) ? $_POST['monto'] : '';
$duracion = (isset($_POST['duracion'])) ? $_POST['duracion'] : '';


$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';



$data=0;
switch($opcion){
    case 1: //alta
        $consulta = "INSERT INTO w_obra (clave_obra,corto_obra,largo_obra,inicio_obra,id_emp,id_clie,monto_obra,importe_origen,duracion) VALUES('$clave','$corto','$largo','$fecha','$id_emp','$id_clie','$monto','$monto','$duracion') ";
        $resultado = $conexion->prepare($consulta);
        if($resultado->execute()){
            $data=1;
        } 

        
        break;
    case 2: //modificación
        $consulta = "UPDATE w_obra SET  clave_obra='$clave',corto_obra='$corto',largo_obra='$largo',inicio_obra='$fecha',id_emp='$id_emp',id_clie='$id_clie',monto_obra='$monto',importe_origen='$monto',duracion='$duracion' WHERE id_obra='$folio' ";		
        $resultado = $conexion->prepare($consulta);
        if($resultado->execute()){
            $data=1;
        }
        
        
        break;        
    case 3://baja
        $consulta = "UPDATE w_obra SET estado_obra=0 WHERE id_obra='$folio' ";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()){
            $data=1;                          
        }
        
        break;   
  
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
