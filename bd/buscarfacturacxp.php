<?php  
 //filter.php  

 include_once 'conexion.php';
 $objeto = new conn();
 $conexion = $objeto->connect();
 
 // Recepción de los datos enviados mediante POST desde el JS   
 
 
 $id_prov = (isset($_POST['id_prov'])) ? $_POST['id_prov'] : '';
 $clave = (isset($_POST['clave'])) ? $_POST['clave'] : '';
 
 
 $consulta = "SELECT * FROM vcxp where estado_cxp = 1 and id_prov='$id_prov' and clave_cxp='$clave'";
 $resultado = $conexion->prepare($consulta);
 $resultado->execute();
 if($resultado->rowCount() >= 1){
    $data=1;
 }
 else{
     $data=0;
 }
 
 
 
 print json_encode($data, JSON_UNESCAPED_UNICODE);
 $conexion = NULL;  
 ?>