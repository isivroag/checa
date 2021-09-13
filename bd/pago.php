<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   


$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';
$fechap = (isset($_POST['fechap'])) ? $_POST['fechap'] : '';
$obsp = (isset($_POST['obsp'])) ? $_POST['obsp'] : '';
$conceptop = (isset($_POST['conceptop'])) ? $_POST['conceptop'] : '';
$montop = (isset($_POST['montop'])) ? $_POST['montop'] : '';
$saldop = (isset($_POST['saldop'])) ? $_POST['saldop'] : '';
$metodo = (isset($_POST['metodo'])) ? $_POST['metodo'] : '';
$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';
$saldofin = $saldop - $montop;

$res = 0;

$consulta = "INSERT INTO pago (folio_reg,fecha,concepto,obs,monto,metodo,usuario) VALUES ('$folio','$fechap','$conceptop','$obsp','$montop','$metodo','$usuario')";
$resultado = $conexion->prepare($consulta);

if ($resultado->execute()) {
    $res += 1;

    $consulta = "UPDATE registro SET saldo_reg='$saldofin' where folio_reg='$folio'";
    $resultado = $conexion->prepare($consulta);
    if ($resultado->execute()) {
        $res += 1;
    }else{
        $res=0;
    }
} else {
    $res = 0;
}
print json_encode($res, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
