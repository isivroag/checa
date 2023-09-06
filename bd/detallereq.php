<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();


$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';



$cantidad = (isset($_POST['cantidad'])) ? $_POST['cantidad'] : '';
$costo = (isset($_POST['costo'])) ? $_POST['costo'] : '';
$concepto = (isset($_POST['concepto'])) ? $_POST['concepto'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$importe = (isset($_POST['importe'])) ? $_POST['importe'] : '';
$id= (isset($_POST['id'])) ? $_POST['id'] : '';

$unidad = (isset($_POST['unidad'])) ? $_POST['unidad'] : '';


switch ($opcion) {
    case 1: //alta
        $consulta = "INSERT INTO requisicion_det (folio_req,concepto,cantidad,precio,importe,unidad) 
                    values ('$folio','$concepto','$cantidad','$costo','$importe','$unidad')";
        
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();


        $consulta = "SELECT * from requisicion_det where folio_req='$folio'";
        
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        $total=0;
        foreach ($data as $row) {
            $total+=$row['importe'];
        }

        $consulta = "UPDATE requisicion set monto_req='$total' where folio_req='$folio'";
        
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();


        $consulta = "SELECT * from requisicion_det where folio_req='$folio' order by id_reg DESC limit 1";
        
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);


        break;
        case 2:
            $consulta = "DELETE FROM requisicion_det where id_reg='$id'";
        
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
    
            $consulta = "SELECT * from requisicion_det where folio_req='$folio'";
        
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
            $total=0;
            foreach ($data as $row) {
                $total+=$row['importe'];
            }
    
            $consulta = "UPDATE requisicion set monto_req='$total' where folio_req='$folio'";
            
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();

            $data=1;
        break;

}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;

?>