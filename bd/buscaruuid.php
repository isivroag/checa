<?php  
 //filter.php  

 include_once 'conexion.php';
 $objeto = new conn();
 $conexion = $objeto->connect();
 
 // Recepción de los datos enviados mediante POST desde el JS   
 
 
 
 $uuid = (isset($_POST['uuid'])) ? $_POST['uuid'] : '';
 
 $res=0;
 //$consulta = "SELECT * FROM vcxp where estado_cxp = 1 and id_prov='$id_prov' and factura_cxp='$factura'";
 $consulta = "SELECT * FROM vfoliosfact where uuid='$uuid'";
 $resultado = $conexion->prepare($consulta);
 $resultado->execute();
 if($resultado->rowCount() >= 1){
   $res=1;
 }

 
 
 
 
 print json_encode($res, JSON_UNESCAPED_UNICODE);
 $conexion = NULL;
