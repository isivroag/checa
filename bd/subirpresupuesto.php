<?php

$id_obra = $_POST['id_obra'];
$fecha = date("YmdHis");
$nombre = $_FILES['file']['name'];
$extencion = explode(".", $nombre);
$extencion = end($extencion);
$path = "../archivos/";




if (move_uploaded_file($_FILES["file"]["tmp_name"], "../archivos/" . $id_obra . $fecha . "." . $extencion)) {
    $excel = $id_obra . $fecha . "." . $extencion;


    $destino = $path . $excel; //Le agregamos un prefijo para identificarlo el archivo cargado


    if (file_exists($path . $excel)) {
        include_once 'conexion.php';
        $objeto = new conn();
        $conexion = $objeto->connect();

        /** Llamamos las clases necesarias PHPEcel */
        require_once('../vendor/PHPExcel/PHPExcel.php');
        require_once('../vendor/PHPExcel/PHPExcel/Reader/Excel2007.php');

        // Cargando la hoja de excel
        $objReader = new PHPExcel_Reader_Excel2007();
        $objPHPExcel = $objReader->load($path . $excel);
        $objFecha = new PHPExcel_Shared_Date();
        // Asignamon la hoja de excel activa
        $objPHPExcel->setActiveSheetIndex(0);
        $hoja = $objPHPExcel->getSheet(0);
        $filas = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

        for ($row = 2; $row <= $filas; $row++) {
            $clave = $hoja->getCell('A' . $row)->getValue();
            $concepto = $hoja->getCell('B' . $row)->getValue();
            $monto = $hoja->getCell('C' . $row)->getValue();
            $tipo = $hoja->getCell('D' . $row)->getValue();
            $padre = $hoja->getCell('E' . $row)->getValue();

            $consulta = "INSERT INTO w_presupuesto (id_obra,clave_renglon,concepto_renglon,monto_renglon,tipo_renglon,padre_renglon) VALUES('$id_obra','$clave','$concepto','$monto','$tipo','$padre') ";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
        }
        echo 1;
    }
} else {
    echo 0;
}
        



  // include_once 'conexion.php';
    
   
    /*$objeto = new conn();
    $conexion = $objeto->connect();
    $consulta = "UPDATE frente set mapaurl='$archivo' WHERE id_frente='$frente'";
    $resultado = $conexion->prepare($consulta); 
    if ($resultado->execute()) {
        echo 1;
    } else {
        echo 0;
    }*/
