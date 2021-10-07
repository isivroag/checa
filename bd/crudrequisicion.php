

<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   
$folioreq = (isset($_POST['folioreq'])) ? $_POST['folioreq'] : '';
$subcontrato = (isset($_POST['subcontrato'])) ? $_POST['subcontrato'] : '';

$descripcionreq = (isset($_POST['descripcionreq'])) ? $_POST['descripcionreq'] : '';
$clavereq = (isset($_POST['clavereq'])) ? $_POST['clavereq'] : '';
$fechareq = (isset($_POST['fechareq'])) ? $_POST['fechareq'] : '';
$montoreq = (isset($_POST['montoreq'])) ? $_POST['montoreq'] : '';



$opcionreq = (isset($_POST['opcionreq'])) ? $_POST['opcionreq'] : '';



$data=0;
switch($opcionreq){
    case 1: //alta
        $consulta = "INSERT INTO w_reqsub (id_sub,fecha_req,factura_req,concepto_req,monto_req,saldo_req) VALUES('$subcontrato','$fechareq','$clavereq','$descripcionreq','$montoreq','$montoreq') ";
        $resultado = $conexion->prepare($consulta);
        if($resultado->execute()){
            $data=1;
        } 

        
        break;
    case 2: //modificación
        $consulta = "UPDATE w_reqsub SET  id_sub='$id_sub',fecha_reg='$fechareq',concepto_req='$descripcionreq',factura_req='$clavereq',monto_req='$montoreq',saldo_req='$montoreq' WHERE folio_req='$folioreq' ";		
        $resultado = $conexion->prepare($consulta);
        if($resultado->execute()){
            $data=1;
        }
        
        
        break;        
    case 3://baja
        $consulta = "UPDATE w_reqsub SET estado_req=0 WHERE folio_req='$folioreq'";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()){
            $data=1;                          
        }
        
        break;   
  
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
