<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$idpx = (isset($_POST['idpx'])) ? $_POST['idpx'] : '';
$fecha = (isset($_POST['fecha'])) ? $_POST['fecha'] : '';
$idconcepto = (isset($_POST['idconcepto'])) ? $_POST['idconcepto'] : '';
$concepto = (isset($_POST['concepto'])) ? $_POST['concepto'] : '';
$obs = (isset($_POST['obs'])) ? $_POST['obs'] : '';
$subtotal = (isset($_POST['subtotal'])) ? $_POST['subtotal'] : '';
$descuento = (isset($_POST['descuento'])) ? $_POST['descuento'] : '';
$total = (isset($_POST['total'])) ? $_POST['total'] : '';
$precio = (isset($_POST['precio'])) ? $_POST['precio'] : '';
$registro = (isset($_POST['registro'])) ? $_POST['registro'] : '';
$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';

switch ($opcion) {
    case 1: //alta
        $consulta = "INSERT INTO registro (fecha_reg,id_px,id_concepto,nom_concepto,precio_concepto,descuento_reg,total_reg,saldo_reg,usuario,obs_reg) VALUES('$fecha','$idpx','$idconcepto','$concepto','$precio','$descuento','$total','$total','$usuario','$obs')";
        $resultado = $conexion->prepare($consulta);
       if( $resultado->execute()){
            $data=1;
       }else{
            $data=0;
       }

       
        break;
    case 2: //modificación
        $consulta = "UPDATE registro SET  WHERE folio_reg='$registro'";
  
        $resultado = $conexion->prepare($consulta);
        if( $resultado->execute()){
             $data=1;
        }else{
             $data=0;
        }
        break;
    case 3: //baja
        $consulta = "UPDATE registro SET estado_reg=0 WHERE folio_reg='$registro' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = 1;
        break;
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
