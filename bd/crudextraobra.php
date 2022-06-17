<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   
$folioadd = (isset($_POST['folioadd'])) ? $_POST['folioadd'] : '';

$fechaadd = (isset($_POST['fechaadd'])) ? $_POST['fechaadd'] : '';

$id_obra = (isset($_POST['id_obra'])) ? $_POST['id_obra'] : '';
$claveadd = (isset($_POST['claveadd'])) ? $_POST['claveadd'] : '';
$importeadd = (isset($_POST['importeadd'])) ? $_POST['importeadd'] : '';
$tipoadd = (isset($_POST['tipoadd'])) ? $_POST['tipoadd'] : '';
$descripcionadd = (isset($_POST['descripcionadd'])) ? $_POST['descripcionadd'] : '';
$importeobra = (isset($_POST['importeobra'])) ? $_POST['importeobra'] : '';


$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';


$id = (isset($_POST['id'])) ? $_POST['id'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$importefinal = 0;

switch ($opcion) {
    case 1: //alta

        if ($tipoadd == "INCREMENTO") {
            $importefinal = $importeobra + $importeadd;
        } else {
            $importefinal = $importeobra - $importeadd;
        }
        $consulta = "INSERT INTO w_extraobra (id_obra,fecha_extra,tipo_extra,clave_extra,concepto_extra,monto_extra,monto_ini,monto_fin,usuarioalt) 
        VALUES('$id_obra','$fechaadd','$tipoadd','$claveadd','$descripcionadd','$importeadd','$importeobra','$importefinal','$usuario') ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        //INCREMENTAR LAS ADDENDAS DE OBRA

        if ($tipoadd == "INCREMENTO") {
            $consulta = "UPDATE w_obra SET  add_obra=add_obra+'$importeadd', monto_obra=monto_obra+'$importeadd' WHERE id_obra='$id_obra'";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
        } else {
            $consulta = "UPDATE w_obra SET  dec_obra=dec_obra+'$importeadd',monto_obra=monto_obra-'$importeadd' WHERE id_obra='$id_obra'";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
        }

        $consulta = "SELECT * FROM w_extraobra ORDER BY id_extra DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 2: //modificación

        break;
    case 3: //baja
        $consulta = "UPDATE w_extraobra SET estado_extra=0 WHERE id_extra='$id' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        //BUSCAR EL MONTO DEL EXTRA Y EL TIPO, Y LA OBRA




        $data = 1;


        break;
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
