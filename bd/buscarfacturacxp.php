<?php  
 //filter.php  

 include_once 'conexion.php';
 $objeto = new conn();
 $conexion = $objeto->connect();
 
 // Recepción de los datos enviados mediante POST desde el JS   
 
 
 $id_prov = (isset($_POST['id_prov'])) ? $_POST['id_prov'] : '';
 $factura = (isset($_POST['factura'])) ? $_POST['factura'] : '';
 
 
 $consulta = "SELECT * FROM vcxp where estado_cxp = 1 and id_prov='$id_prov' and factura_cxp='$factura'";
 $resultado = $conexion->prepare($consulta);
 $resultado->execute();
 if($resultado->rowCount() >= 1){
   $data=1;
 }
 else{
    $consulta = "SELECT * FROM vrequisicion where estado_req = 1 and id_prov='$id_prov' and factura_req='$factura'";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();
    if($resultado->rowCount() >= 1){
       $data=1;
    }
    else{
        $data=0;
    }
 }
 
 
 
 
 print json_encode($data, JSON_UNESCAPED_UNICODE);
 $conexion = NULL;
