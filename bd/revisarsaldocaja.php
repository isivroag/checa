<?php  
 //filter.php  

 include_once 'conexion.php';
 $objeto = new conn();
 $conexion = $objeto->connect();
 
 // Recepción de los datos enviados mediante POST desde el JS   
 
 
 $folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';
 $opcioncaja = (isset($_POST['opcioncaja'])) ? $_POST['opcioncaja'] : '';
 $caja = (isset($_POST['caja'])) ? $_POST['caja'] : '';
 
 $res=0;
switch($opcioncaja)
{
    case 1:
        $consulta = "SELECT * FROM w_caja WHERE id_caja='$folio' AND estado_caja = 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        if($resultado->rowCount() >=1){
            $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
            foreach($data as $row){
                $saldo=$row['saldo_caja'];
            }
            $res=$saldo;
        }
        else{
            $res=null;
        }
        break;
    case 2:

        $consulta = "SELECT * FROM w_caja WHERE id_obra='$folio' AND estado_caja = 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        if($resultado->rowCount() >=1){
            $res=1;
        }
        else{
            $res=null;
        }
        break;
        case 3:

            $consulta = "SELECT * FROM w_caja WHERE id_obra='$folio' and id_caja='$caja' AND estado_caja = 1";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            if($resultado->rowCount() >=1){
                $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
                foreach($data as $row){
                    $saldo=$row['saldo_caja'];
                }
                $res=$saldo;
            }
            else{
                $res=null;
            }
            break;
}
    

 
 
 
 
 
 print json_encode($res, JSON_UNESCAPED_UNICODE);
 $conexion = NULL;  
 ?>