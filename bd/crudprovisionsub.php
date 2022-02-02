

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

$ret1 = (isset($_POST['ret1'])) ? $_POST['ret1'] : '';
$ret2 = (isset($_POST['ret2'])) ? $_POST['ret2'] : '';
$ret3 = (isset($_POST['ret3'])) ? $_POST['ret3'] : '';

$importe = (isset($_POST['importe'])) ? $_POST['importe'] : '';
$descuento = (isset($_POST['descuento'])) ? $_POST['descuento'] : '';
$devolucion = (isset($_POST['devolucion'])) ? $_POST['devolucion'] : '';
//$ret4 = (isset($_POST['ret4'])) ? $_POST['ret4'] : '';
$montob = (isset($_POST['montob'])) ? $_POST['montob'] : '';


$data=0;
switch($opcionreq){
    case 1: //alta
        $consulta = "INSERT INTO w_provsub (id_sub,fecha_prov,concepto_prov,monto_prov,saldo_prov,subtotal_prov,iva_prov,ret1,ret2,ret3,montob,importe,descuento,devolucion) 
        VALUES('$subcontrato','$fechareq','$descripcionreq','$montoreq','$montoreq','$subtotalreq','$ivareq','$ret1','$ret2','$ret3','$montob','$importe','$descuento','$devolucion') ";
        $resultado = $conexion->prepare($consulta);
        if($resultado->execute()){
            $data=1;
        } 

        
        break;
    case 2: //modificación
        $consulta = "UPDATE w_provsub SET id_sub='$subcontrato',fecha_prov='$fechareq',concepto_prov='$descripcionreq',monto_prov='$montoreq',
        saldo_prov='$montoreq',subtotal_prov='$subtotalreq',iva_prov='$ivareq' 
        WHERE id_provs='$folioreq' ";		
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
