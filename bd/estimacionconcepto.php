<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   
$obra = (isset($_POST['obra'])) ? $_POST['obra'] : '';
$estimacion = (isset($_POST['estimacion'])) ? $_POST['estimacion'] : '';

$id = (isset($_POST['id'])) ? $_POST['id'] : '';
$precio = (isset($_POST['precio'])) ? $_POST['precio'] : '';
$cantidad = (isset($_POST['cantidad'])) ? $_POST['cantidad'] : '';
$importe = (isset($_POST['importe'])) ? $_POST['importe'] : '';
$opc = (isset($_POST['opc'])) ? $_POST['opc'] : '';




$data = 0;
switch ($opc) {
    case 1:
        $consulta = "INSERT INTO w_tmpdetalle_est (folio_tmp,id_renglon,cantidad,precio,importe) 
        VALUES('$estimacion','$id','$cantidad','$precio','$importe') ";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()) {
            $data = 1;
        }

        break;
    case 2:
        $consulta = "DELETE FROM w_tmpdetalle_est WHERE id_det='$id'";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()) {
            $data = 1;
        }

        break;
}

$consulta="SELECT sum(importe) AS suma FROM w_tmpdetalle_est WHERE folio_tmp='$estimacion' group by folio_tmp";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$datos = $resultado->fetchAll(PDO::FETCH_ASSOC);
$suma=0;
foreach($datos as $row){
    $suma=$row['suma'];
}


$consulta="UPDATE w_tmp_est SET importe_est='$suma' WHERE folio_tmp='$estimacion'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();



print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
