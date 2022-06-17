<?php  
 //filter.php  

 include_once 'conexion.php';
 $objeto = new conn();
 $conexion = $objeto->connect();
 
 // Recepción de los datos enviados mediante POST desde el JS   
 
 
 $id_prov = (isset($_POST['id_prov'])) ? $_POST['id_prov'] : '';
 $factura = (isset($_POST['factura'])) ? $_POST['factura'] : '';
 $uuid = (isset($_POST['uuid'])) ? $_POST['uuid'] : '';
 
 $res=0;
 //$consulta = "SELECT * FROM vcxp where estado_cxp = 1 and id_prov='$id_prov' and factura_cxp='$factura'";
 $consulta = "SELECT * FROM vcxp where estado_cxp = 1 and uuid='$uuid'";
 $resultado = $conexion->prepare($consulta);
 $resultado->execute();
 if($resultado->rowCount() >= 1){
   $res=1;
 }
 else{
    //$consulta = "SELECT * FROM vrequisicion where estado_req = 1 and id_prov='$id_prov' and factura_req='$factura'";
    $consulta = "SELECT * FROM vrequisicion where estado_req = 1 and uuid='$uuid'";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();
    if($resultado->rowCount() >= 1){
       $res=1;
    }
   
 }
 
 
 
 
 print json_encode($res, JSON_UNESCAPED_UNICODE);
 $conexion = NULL;
