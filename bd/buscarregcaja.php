<?php  
 //filter.php  

 include_once 'conexion.php';
 $objeto = new conn();
 $conexion = $objeto->connect();
 
 // Recepción de los datos enviados mediante POST desde el JS   
 
 
 $idcaja = (isset($_POST['idcaja'])) ? $_POST['idcaja'] : '';
 $foliocan = (isset($_POST['foliocan'])) ? $_POST['foliocan'] : '';
 $data=1;

    $consulta = "SELECT * FROM mov_caja WHERE id_caja='$idcaja' and id_mov > '$foliocan' and estado_mov= 1";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();
    if($resultado->rowCount() >=1){
       $data=1;
    }else{
        $data=0;
    }

 
 
 
 
 print json_encode($data, JSON_UNESCAPED_UNICODE);
 $conexion = NULL;
