<?php  
 //filter.php  

 include_once 'conexion.php';
 $objeto = new conn();
 $conexion = $objeto->connect();
 
 // Recepción de los datos enviados mediante POST desde el JS   
 
 
 $id_obra = (isset($_POST['id_obra'])) ? $_POST['id_obra'] : '';

 
 $res=0;
 $consulta = "SELECT * FROM w_obra WHERE id_obra='$id_obra' and estado_obra = 1 ";
 $resultado = $conexion->prepare($consulta);
 if($resultado->execute()){
     $res=1;
    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    session_start();
 foreach($data as $row){

    $_SESSION["id_obra"]=$row['id_obra'];
    $_SESSION["nom_obra"]=$row['corto_obra'];

 }
 }
 
 
 
 print json_encode($res, JSON_UNESCAPED_UNICODE);
 $conexion = NULL;  
 ?>