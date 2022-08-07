<?php  
 //filter.php  

 include_once 'conexion.php';
 $objeto = new conn();
 $conexion = $objeto->connect();
 
 // Recepción de los datos enviados mediante POST desde el JS   
 
 
 $obra = (isset($_POST['obra'])) ? $_POST['obra'] : '';

 function buscarpadre($idpadre, $conn, $obra)
 {
 
 
 
     $consultaf = "SELECT * FROM w_pres WHERE indice_renglon='$idpadre' and id_obra='$obra'";
 
     $resultadof = $conn->prepare($consultaf);
     $resultadof->execute();
     $dataf = $resultadof->fetchAll(PDO::FETCH_ASSOC);
     foreach ($dataf as $rowf) {
         $padre = $rowf['padre_renglon'];
     }
     if ($padre == 0) {
         echo '<tr>
         <td></td>
         <td>' . $rowf['id_renglon'] . '</td>
         <td>' . $rowf['indice_renglon'] . '</td>
         <td>' . $rowf['clave_renglon'] . '</td>
         <td>' . $rowf['concepto_renglon'] . '</td>
         <td class="text-right"></td>
         <td class="text-center"></td>
         <td class="text-right"></td>
         <td class="text-right"></td>
         <td>' . $rowf['tipo_renglon'] . '</td>
         <td>' . $rowf['padre_renglon'] . '</td>
         <td></td>
     </tr>';
     } else {
         buscarpadre($padre, $conn, $obra);
         echo '<tr>
         <td></td>
         <td>' . $rowf['id_renglon'] . '</td>
         <td>' . $rowf['indice_renglon'] . '</td>
         <td>' . $rowf['clave_renglon'] . '</td>
         <td>' . $rowf['concepto_renglon'] . '</td>
         <td class="text-right"></td>
         <td class="text-center"></td>
         <td class="text-right"></td>
         <td class="text-right"></td>
         <td>' . $rowf['tipo_renglon'] . '</td>
         <td>' . $rowf['padre_renglon'] . '</td>
         <td></td>
     </tr>';
     }
 }



 $consulta = "SELECT * FROM v_tmp_detalleest WHERE folio_tmp='$folio_tmp' order by id_renglon";
 //$consulta = "SELECT * FROM v_tmp_detalleest WHERE folio_tmp='$folio_tmp' ";
 $resultado = $conexion->prepare($consulta);
 $resultado->execute();
 $datadet = $resultado->fetchAll(PDO::FETCH_ASSOC);
 
 foreach ($datadet as $datdet) {

     //empezar la busqueda de los padres
     $idpadre = $datdet['padre_renglon'];
     if ($idpadre != 0) {
         buscarpadre($idpadre, $conexion, $id_obra);
     }
 ?>
     <tr>
         <td><?php echo $datdet['id_det'] ?></td>
         <td><?php echo $datdet['id_renglon'] ?></td>
         <td><?php echo $datdet['indice_renglon'] ?></td>
         <td><?php echo $datdet['clave_renglon'] ?></td>
         <td><?php echo $datdet['concepto_renglon'] ?></td>
         <td class="text-right"><?php echo number_format($datdet['cantidad'], 2) ?></td>
         <td class="text-center"><?php echo $datdet['unidad_renglon'] ?></td>
         <td class="text-right"><?php echo number_format($datdet['precio'], 2) ?></td>
         <td class="text-right"><?php echo number_format($datdet['importe'], 2) ?></td>
         <td><?php echo $datdet['tipo_renglon'] ?></td>
         <td><?php echo $datdet['padre_renglon'] ?></td>
         <td></td>
     </tr>
 <?php

 }



 ?>