

<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   
$folioreq = (isset($_POST['folioreq'])) ? $_POST['folioreq'] : '';
$subcontrato = (isset($_POST['subcontrato'])) ? $_POST['subcontrato'] : '';

$descripcionreq = (isset($_POST['descripcionreq'])) ? $_POST['descripcionreq'] : '';

$fechareq = (isset($_POST['fechareq'])) ? $_POST['fechareq'] : '';
$montoreq = (isset($_POST['montoreq'])) ? $_POST['montoreq'] : '';
$subtotalreq = (isset($_POST['subtotalreq'])) ? $_POST['subtotalreq'] : '';
$ivareq = (isset($_POST['ivareq'])) ? $_POST['ivareq'] : '';



$opcionreq = (isset($_POST['opcionreq'])) ? $_POST['opcionreq'] : '';



$data=0;
switch($opcionreq){
    case 1: //alta
        $consulta = "INSERT INTO w_provsub (id_sub,fecha_prov,concepto_prov,monto_prov,saldo_prov,subtotal_prov,iva_prov) VALUES('$subcontrato','$fechareq','$descripcionreq','$montoreq','$montoreq','$subtotalreq','$ivareq') ";
        $resultado = $conexion->prepare($consulta);
        if($resultado->execute()){
            $data=1;
        } 

        
        break;
    case 2: //modificación
        $consulta = "UPDATE w_provsub SET id_sub='$subcontrato',fecha_prov='$fechareq',concepto_prov='$descripcionreq',monto_prov='$montoreq',saldo_prov='$montoreq',subtotal_prov='$subtotalreq',iva_prov='$ivareq' WHERE id_provs='$folioreq' ";		
        $resultado = $conexion->prepare($consulta);
        if($resultado->execute()){
            $data=1;
        }
        
        
        break;        
    case 3://baja
        $consulta = "UPDATE w_provsub SET estado_prov=0 WHERE id_provs='$folioreq'";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()){
            $data=1;                          
        }
        
        break;   
  
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
