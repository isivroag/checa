<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   
$foliosemanal = (isset($_POST['foliosemanal'])) ? $_POST['foliosemanal'] : '';

$tipodoc = (isset($_POST['tipodoc'])) ? $_POST['tipodoc'] : '';

$obs = (isset($_POST['obs'])) ? $_POST['obs'] : '';
$montopago = (isset($_POST['montopago'])) ? $_POST['montopago'] : '';

$id = (isset($_POST['id'])) ? $_POST['id'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$data=0;

switch($opcion){
    case 1: //alta
        $consulta = "INSERT INTO semanal_detalle (folio_rpt,tipo,folio,observaciones,monto,aplicado) VALUES('$foliosemanal','$tipodoc','$id','$obs','$montopago','0') ";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()){
            $data=1;
            $consulta = "SELECT SUM(monto) as total from semanal_detalle where folio_rpt='$foliosemanal' group by folio_rpt";
            $resultado = $conexion->prepare($consulta);
            if ($resultado->execute()){
                $res = $resultado->fetchAll(PDO::FETCH_ASSOC);

                foreach ($res as $reg) {
                    $total = $reg['total'];
                }
                $consulta = "UPDATE semanal set total='$total' where folio='$foliosemanal'";
                $resultado = $conexion->prepare($consulta);
                $resultado->execute();



            }

        }


      
        break;
    case 2: //modificación
       
        break;        
    case 3://baja
        $consulta = " ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 
        $data=1;                          
        break;   
   

}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
