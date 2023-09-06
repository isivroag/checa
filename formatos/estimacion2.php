<?php
/*if (isset($_GET['folio'])) {
   echo getPlantilla($_GET['folio']);
}*/

require '../vendor/autoload.php';
    use Luecano\NumeroALetras\NumeroALetras;


function getPlantilla($folio)
{
    include_once '../bd/conexion.php';
$plantilla="";
    if ($folio != "" ) {
        $objeto = new conn();
        $conexion = $objeto->connect();
      
        $fecha=date('Y-m-d');
        $consulta = "SELECT id_obra,corto_obra FROM vreq WHERE folio_rpt='$folio' group by id_obra order by id_obra ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        
      

       
      
    } else {
        echo '<script type="text/javascript">';
        echo 'window.location.href="../cntareq.php';
        echo '</script>';
    }

    $plantilla .= '
  <body>
    <header class="clearfix">
      <div id="logo">
        <img src="img/logo.jpg">
      </div>
      <div id="company">
        <h2 class="name">CHECA S.A. DE C.V.</h2>
       
      </div>

      <div id="folio">
        <h1>REPORTE DE PAGOS</h1>
        <div class="">Folio de Reporte: <strong>' . $folio . '</strong></div>
        <div class="date">Fecha:' .$fecha . '</div>
      </div>

      </div>
    </header>
    <main>
    ';

    foreach($data as $row){
        $id_obra=$row['id_obra'];
        $plantilla.='
   
        <div id="details" class="clearfix">
            <div id="client">
            
            <h2 class="name">OBRA: <strong>' . $row['corto_obra'] . '</strong></h2>
            
            </div>
        </div>';

        $plantilla.='
        <table class="sborde" border="0" cellspacing="0" cellpadding="0">
            <thead>
                <tr>
                    
                    <th class="total">FOLIO</th>
                    <th class="total">PROVEEDOR</th>
                    <th class="total">CONCEPTO</th>
                    <th class="total">MONTO</th>
                </tr>
            </thead>
            <tbody>';

        $consultadet="SELECT * FROM vreq where id_obra='$id_obra' and folio_rpt='$folio'";
        $resultadodet = $conexion->prepare($consultadet);
        $resultadodet->execute();

        $datadet = $resultadodet->fetchAll(PDO::FETCH_ASSOC);
        $importeobra=0;
        foreach($datadet as $rowdet){
            $importeobra+=$rowdet['monto_req'];

            $plantilla.='
            <tr>
                    <td class="desc">' . $rowdet['folio_req'] . '</td>
                    <td class="desc" style="text">' . $rowdet['razon_prov'] . '</td>
                    <td class="desc" style="text">' . $rowdet['desc_req'] . '</td>
                    <td class="qty">$' . number_format($rowdet['monto_req'], 2) . '</td>
            </tr>
            ';

        }

        $plantilla .=
        '</tbody>
            <tfoot class="sborde">
                <tr>
                    
                    <td colspan="3" class="text-right" >TOTAL A PAGAR '. $row['corto_obra'].'</td>
                    <td class=><strong>$ ' . number_format($importeobra, 2) . '</strong></td>
                </tr>
            </tfoot>
        </table>';
    }

   
    
  
  
        $plantilla.='
        
        
      
     
    </main>
    <footer>
     
    </footer>
  </body>';

    return $plantilla;
}
