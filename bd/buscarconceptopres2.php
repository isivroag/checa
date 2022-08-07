<?php
//filter.php  

include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   





$obra = (isset($_POST['obra'])) ? $_POST['obra'] : '';
$texto = (isset($_POST['texto'])) ? $_POST['texto'] : '';
$informacion = array();

function buscarpadre($idpadre, $conn, $obra, &$informacion)
{



    $consultaf = "SELECT * FROM w_pres WHERE indice_renglon='$idpadre' and id_obra='$obra'";

    $resultadof = $conn->prepare($consultaf);
    $resultadof->execute();
    $dataf = $resultadof->fetchAll(PDO::FETCH_ASSOC);

    foreach ($dataf as $rowf) {

        $padre = $rowf['padre_renglon'];
        $id = $rowf['id_renglon'];
        $indice = $rowf['indice_renglon'];
        $clave = "";
        $concepto = $rowf['concepto_renglon'];
        $unidad = "";
        $cantidad = "";
        $precio = "";

        $tipo = $rowf['tipo_renglon'];
    }
    if ($padre == 0) {
        $is_gift = in_array($id, array_column($informacion, 'id_renglon'));
        if ($is_gift == false) {
            $reg = array(
                "id_renglon" => $id,
                "indice_renglon" => $indice,
                "clave_renglon" => $clave,
                "concepto_renglon" => $concepto,
                "unidad_renglon" => '',
                "cantidad_renglon" => '',
                "precio_renglon" => '',
                "monto_renglon" => '',
                "tipo_renglon" => $tipo,
                "padre_renglon" => $padre,
            );
            $registro = (object) $reg;
            array_push($informacion, $registro);
        }
    } else {
        buscarpadre($padre, $conn, $obra, $informacion);
        $is_gift = in_array($id, array_column($informacion, 'id_renglon'));
        if ($is_gift == false) {
            $reg = array(
                "id_renglon" => $id,
                "indice_renglon" => $indice,
                "clave_renglon" => $clave,
                "concepto_renglon" => $concepto,
                "unidad_renglon" => '',
                "cantidad_renglon" => '',
                "precio_renglon" => '',
                "monto_renglon" => '',
                "tipo_renglon" => $tipo,
                "padre_renglon" => $padre,
            );
            $registro = (object) $reg;
            array_push($informacion, $registro);
        }
    }
}



$consulta = "SELECT * FROM w_pres WHERE id_obra='$obra' and concepto_renglon like '%" . $texto . "%' and tipo_renglon='CO' order by id_renglon";

$resultado = $conexion->prepare($consulta);
$resultado->execute();
$datadet = $resultado->fetchAll(PDO::FETCH_ASSOC);

foreach ($datadet as $row) {


    $idpadre = $row['padre_renglon'];
    if ($idpadre != 0) {
        buscarpadre($idpadre, $conexion, $obra, $informacion);
    }

    $nuevoregistro = array(
        "id_renglon" => $row['id_renglon'],
        "indice_renglon" => $row['indice_renglon'],
        "clave_renglon" => $row['clave_renglon'],
        "concepto_renglon" => $row['concepto_renglon'],
        "unidad_renglon" => $row['unidad_renglon'],
        "cantidad_renglon" => $row['cantidad_renglon'],
        "precio_renglon" => $row['precio_renglon'],
        "monto_renglon" => $row['monto_renglon'],
        "tipo_renglon" => $row['tipo_renglon'],
        "padre_renglon" => $row['padre_renglon'],
    );

    $registro = (object) $nuevoregistro;
    array_push($informacion, $registro);
}

print json_encode($informacion, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
