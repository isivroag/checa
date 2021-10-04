<?php

$id_obra = $_POST['id_obra'];
$fecha = date("YmdHis");
$nombre = $_FILES['file']['name'];
$extencion = explode(".", $nombre);
$extencion = end($extencion);
$path="../archivos/";


if (move_uploaded_file($_FILES["file"]["tmp_name"], "../archivos/" . $id_obra . $fecha . "." . $extencion)) {
    $excel = $id_obra . $fecha . "." . $extencion;


    $destino = $path.$excel;//Le agregamos un prefijo para identificarlo el archivo cargado


    if (file_exists ($path.$excel)){ 
        /** Llamamos las clases necesarias PHPEcel */
        require_once('../vendor/PHPExcel/PHPExcel.php');
        require_once('../vendor/PHPExcel/PHPExcel/Reader/Excel2007.php');

        // Cargando la hoja de excel
        $objReader = new PHPExcel_Reader_Excel2007();
        $objPHPExcel = $objReader->load($path.$excel);
        $objFecha = new PHPExcel_Shared_Date();       
        // Asignamon la hoja de excel activa
        $objPHPExcel->setActiveSheetIndex(0);
        $hoja=$objPHPExcel->getSheet(0);
        $filas= $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
        echo "<table id='presupuesto' class='table table-responsive-sm table-bordered table-hover' style='width:100%; table-layoyt:fixed'>
        <thead class='bg-gradient-green'>
            <tr>
                <td>CLAVE</td>
                <td>CONCEPTO</td>
                <td>MONTO</td>
                <td>TIPO</td>
                <td>PADRE</td>
            </tr>
        </thead>
        <tbody id='tbody_tabla_detalle'>
       ";
       for ($row=2; $row <=$filas; $row++){
           $clave=$hoja->getCell('A'.$row)-> getValue();
           $concepto=$hoja->getCell('B'.$row)-> getValue();
           $monto=$hoja->getCell('C'.$row)-> getValue();
           $tipo=$hoja->getCell('D'.$row)-> getValue();
           $padre=$hoja->getCell('E'.$row)-> getValue();

           echo "<tr>";
           echo "<td>".$clave."</td>";
           echo "<td>".$concepto."</td>";
           echo "<td>".$monto."</td>";
           echo "<td>".$tipo."</td>";
           echo "<td>".$padre."</td>";
           echo "</tr>";
       }
       echo "</tbody></table>";
}}
else {echo "Error Al Cargar el Archivo";}
        



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
