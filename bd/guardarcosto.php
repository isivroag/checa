<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();
ini_set('precision', 6);
// Recepción de los datos enviados mediante POST desde el JS   

$registro = (isset($_POST['registro'])) ? $_POST['registro'] : '';

$tipo = (isset($_POST['tipo'])) ? $_POST['tipo'] : '';

$obra = (isset($_POST['obra'])) ? $_POST['obra'] : '';

$partida = (isset($_POST['partida'])) ? $_POST['partida'] : '';
$porcentaje = (isset($_POST['porcentaje'])) ? $_POST['porcentaje'] : '';
$importe = (isset($_POST['importe'])) ? $_POST['importe'] : '';


$res = 0;
switch($tipo){
    case 0:
        $consulta = "INSERT INTO obracto (id_obra,id_partida,porcentaje,importe) 
        VALUES ('$obra','$partida','$porcentaje','$importe')";
        break;

    case 1:
        $consulta = "UPDATE obracto 
        SET porcentaje='$porcentaje', importe='$importe' WHERE id_reg='$registro'";
        break;


}
        //guardar el pago
        
        $resultado = $conexion->prepare($consulta);

        if ($resultado->execute()) {
            $res = 1;
              
        } else {
            $res = 0;
        }
        print json_encode($res, JSON_UNESCAPED_UNICODE);
        $conexion = NULL;
     