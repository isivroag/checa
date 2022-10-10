<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   
$obra = (isset($_POST['obra'])) ? $_POST['obra'] : '';

$presupuestado = (isset($_POST['presupuestado'])) ? $_POST['presupuestado'] : '';

$ejecutado = (isset($_POST['ejecutado'])) ? $_POST['ejecutado'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';

$data = 0;
switch ($opcion) {
    case 1:
        $consulta = "UPDATE w_datos SET nompres = '$presupuestado',nomeje='$ejecutado' WHERE id_obra='$obra'";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()) {
            $data = 1;
        }
        break;
    case 2:
        $consulta = "UPDATE w_datos SET cajapres = '$presupuestado',cajaeje='$ejecutado' WHERE id_obra='$obra'";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()) {
            $data = 1;
        }
        break;
        case 3:
            $consulta = "SELECT * FROM w_datos WHERE id_obra='$obra'";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            if ($resultado->rowCount()==0){
                $consulta = "INSERT INTO w_datos (id_obra) VALUES ('$obra')";
                $resultado = $conexion->prepare($consulta);
                $resultado->execute();

                $consulta = "SELECT * FROM w_datos WHERE id_obra='$obra'";
                $resultado = $conexion->prepare($consulta);
                $resultado->execute();
            }
            $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
            break;
        case 4:
            $consulta = "UPDATE w_datos SET cajapres = '$presupuestado',nompres='$ejecutado' WHERE id_obra='$obra'";
            $resultado = $conexion->prepare($consulta);
            if ($resultado->execute()) {
                $data = 1;
            }
            break;
}



print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
