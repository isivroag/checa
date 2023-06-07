<?php
//filter.php  

include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   


$obra = (isset($_POST['obra'])) ? $_POST['obra'] : '';
$cxc = (isset($_POST['cxc'])) ? $_POST['cxc'] : '';
$pago = (isset($_POST['pago'])) ? $_POST['pago'] : '';
$partida = (isset($_POST['partida'])) ? $_POST['partida'] : '';
$porcentaje = (isset($_POST['porcentaje'])) ? $_POST['porcentaje'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$monto = (isset($_POST['monto'])) ? $_POST['monto'] : '';


$a=0;
$b=0;
$c=0;
$d=0;
$e=0;

$consulta = "SELECT * FROM vconsultacostopagocxc WHERE id_obra='$obra' and folio_cxc='$cxc' and folio_pagocxc='$pago' and id_partida<'$partida' order by id_partida";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
if ($resultado->rowCount() >= 1) {
    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    foreach ($data as $row) {
        switch ($row['id_partida']) {
            case 1:
                $a = $row['importe'];
                break;
            case 2:
                $b = $row['importe'];
                if($partida == 3){
                    $b=0;
                }
                
                break;
            case 3:
                $c = $row['importe'];
                break;
            case 4:
                $d = $row['importe'];
                break;
            case 5:
                $e = $row['importe'];

                break;
       
            default:
                $importe=0;
            break;
        }
    }
    if ($opcion==1){
        $importe=($a+$b+$c+$d+$e)*($porcentaje/100);
    }else{
        $importe=($monto/($a+$b+$c+$d+$e))*100;
    }
    
} else {
    $importe = 0;
}



print json_encode($importe, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
