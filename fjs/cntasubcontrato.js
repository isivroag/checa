$(document).ready(function () {
  var id, opcion, idprovglobal
  var usuario=$('#nameuser').val();
  var rol=$('#rolusuario').val();
  opcion = 4

  var textcolumnas = permisos()

  function permisos() {
    var tipousuario = $('#tipousuario').val()
    var columnas = ''
   
    if (tipousuario == 1) {
      columnas =
        "<div class='text-center'><div class='btn-group'>\
      <button class='btn btn-sm bg-secondary btnProvision'><i class='fas fa-funnel-dollar'  data-toggle='tooltip' data-placement='top' title='Provisiones'></i></button>\
      <button class='btn btn-sm bg-orange btnVerprovision'><i class='fas fa-bars'  data-toggle='tooltip' data-placement='top' title='Ver Provisiones'></i></button>\
        <button class='btn btn-sm bg-purple btnRequisicion' data-toggle='tooltip' data-placement='top' title='Registrar Requisición'><i class='fas fa-hand-holding-usd'></i></button>\
        <button class='btn btn-sm bg-info btnResumen'><i class='fas fa-bars' data-toggle='tooltip' data-placement='top' title='Resumen Requisiciones'></i></button>\
        </div></div>"
    } else {
      columnas =
        "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-primary btnEditar'  data-toggle='tooltip' data-placement='top' title='Editar'><i class='fas fa-edit'></i></button>\
        <button class='btn btn-sm bg-success btnCobrado'><i class='fas fa-money-bill-wave'  data-toggle='tooltip' data-placement='top' title='Definir Importe Cobrado'></i></button>\
        <button class='btn btn-sm bg-secondary btnProvision'><i class='fas fa-funnel-dollar'  data-toggle='tooltip' data-placement='top' title='Provisiones'></i></button>\
        <button class='btn btn-sm bg-orange btnVerprovision'><i class='fas fa-bars'  data-toggle='tooltip' data-placement='top' title='Ver Provisiones'></i></button>\
        <button class='btn btn-sm bg-purple btnRequisicion' data-toggle='tooltip' data-placement='top' title='Registrar Requisición'><i class='fas fa-hand-holding-usd'></i></button>\
        <button class='btn btn-sm bg-info btnResumen'><i class='fas fa-bars' data-toggle='tooltip' data-placement='top' title='Resumen Requisiciones'></i></button>\
        <button class='btn btn-sm bg-danger btnCancelar' data-toggle='tooltip' data-placement='top' title='Cancelar'><i class='fas fa-ban'></i></button>\
        </div></div>"
    }
    return columnas
  }

  var textcolumnas2 = permisos2()

  function permisos2() {
    var tipousuario = $('#tipousuario').val()
    var columnas = ''
   
    if (tipousuario == 1) {
      columnas =
        "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-primary btnVerpagos' data-toggle='tooltip' data-placement='top' title='Ver Pagos' ><i class='fas fa-search-dollar'></i></button>\
      <button class='btn btn-sm btn-success btnPagar' data-toggle='tooltip' data-placement='top' title='Pagar Requisicion' ><i class='fas fa-dollar-sign'></i></button>\
      </div></div>"
    } else {
      columnas =
        "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-primary btnVerpagos' data-toggle='tooltip' data-placement='top' title='Ver Pagos' ><i class='fas fa-search-dollar'></i></button>\
      <button class='btn btn-sm btn-success btnPagar' data-toggle='tooltip' data-placement='top' title='Pagar Requisicion' ><i class='fas fa-dollar-sign'></i></button>\
      <button class='btn btn-sm bg-danger btnCancelarreq' data-toggle='tooltip' data-placement='top' title='Cancelar'><i class='fas fa-ban'></i></button>\
      </div></div>"
    }
    return columnas
  }

  var textcolumnas3 = permisos3()

  function permisos3() {
    var tipousuario = $('#tipousuario').val()
    var columnas = ''

    if (tipousuario == 1) {
      columnas =""
        /*"<div class='text-center'><div class='btn-group'><button class='btn btn-sm bg-danger btnCancelarpago' data-toggle='tooltip' data-placement='top' title='Cancelar'><i class='fas fa-ban'></i></button>\
      </div></div>"*/
    } else {
      columnas =
        "<div class='text-center'><div class='btn-group'><button class='btn btn-sm bg-danger btnCancelarpago' data-toggle='tooltip' data-placement='top' title='Cancelar'><i class='fas fa-ban'></i></button>\
      </div></div>"
    }
    return columnas
  }

  var textcolumnas4 = permisos4()

  function permisos4() {
    var tipousuario = $('#tipousuario').val()
    var columnas = ''
    console.log(tipousuario)
    if (tipousuario == 1) {
      columnas =
        "<div class='text-center'><div class='btn-group'><button class='btn btn-sm bg-success btntrasladarprov' data-toggle='tooltip' data-placement='top' title='Trasladar a Requisición'><i class='fas fa-share'></i></button>\
      <button class='btn btn-sm btn-primary btnVerreq' data-toggle='tooltip' data-placement='top' title='Ver Requisiciones' ><i class='fas fa-search-dollar'></i></button>\
      </div></div>"
    } else {
      columnas =
        "<div class='text-center'><div class='btn-group'><button class='btn btn-sm bg-success btntrasladarprov' data-toggle='tooltip' data-placement='top' title='Trasladar a Requisición'><i class='fas fa-share'></i></button>\
      <button class='btn btn-sm btn-primary btnVerreq' data-toggle='tooltip' data-placement='top' title='Ver Requisiciones' ><i class='fas fa-search-dollar'></i></button>\
      <button class='btn btn-sm bg-danger btnCancelarprov' data-toggle='tooltip' data-placement='top' title='Cancelar'><i class='fas fa-ban'></i></button>\
      </div></div>"
    }
    return columnas
  }

  //FUNCION REDONDEAR
  function round(value, decimals) {
    return Number(Math.round(value + 'e' + decimals) + 'e-' + decimals)
  }






  //CALCULO TOTAL
  function calculototal(valor) {
    subtotal = valor

    total = round(subtotal * 1.16, 2)
    iva = total - subtotal

    $('#iva').val(
      Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
        parseFloat(iva).toFixed(2),
      ),
    )
    $('#monto').val(
      Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
        parseFloat(total).toFixed(2),
      ),
    )
  }
  //CALCULO SUBTOTAL
  function calculosubtotal(valor) {
    total = valor

    subtotal = round(total / 1.16, 2)

    iva = round(total - subtotal, 2)

    $('#iva').val(
      Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
        parseFloat(iva).toFixed(2),
      ),
    )
    $('#subtotal').val(
      Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
        parseFloat(subtotal).toFixed(2),
      ),
    )
  }

  /*FUCIONES VIEJAS DE REQUISICION

  //CALCULO TOTAL REQ
  function calculototalreq(valor) {
    subtotal = valor

    total = round(subtotal * 1.16, 2)
    iva = total - subtotal

    $('#ivareq').val(
      Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
        parseFloat(iva).toFixed(2),
      ),
    )
    $('#montoreq').val(
      Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
        parseFloat(total).toFixed(2),
      ),
    )
  }
  //CALCULO SUBTOTAL REQ
  function calculosubtotalreq(valor) {
    total = valor

    subtotal = round(total / 1.16, 2)

    iva = round(total - subtotal, 2)

    $('#ivareq').val(
      Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
        parseFloat(iva).toFixed(2),
      ),
    )
    $('#subtotalreq').val(
      Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
        parseFloat(subtotal).toFixed(2),
      ),
    )


  // SOLO NUMEROS SUBTOTAL REQ
  document.getElementById('subtotalreq').onblur = function () {
    calculototalreq(this.value.replace(/,/g, ''))
    this.value = parseFloat(this.value.replace(/,/g, ''))
      .toFixed(2)
      .toString()
      .replace(/\B(?=(\d{3})+(?!\d))/g, ',')
  }

  // SOLO NUMEROS IVA REQ
  document.getElementById('ivareq').onblur = function () {
    this.value = parseFloat(this.value.replace(/,/g, ''))
      .toFixed(2)
      .toString()
      .replace(/\B(?=(\d{3})+(?!\d))/g, ',')
  }

  // SOLO NUMEROS MONTO REQ
  document.getElementById('montoreq').onblur = function () {
    calculosubtotalreq(this.value.replace(/,/g, ''))
    this.value = parseFloat(this.value.replace(/,/g, ''))
      .toFixed(2)
      .toString()
      .replace(/\B(?=(\d{3})+(?!\d))/g, ',')
  }

  }*/


        // --------------------SOLO NUMEROS NUEVOS CAMPOS
      document.getElementById('importe').onblur = function () {
        calculosubtotalreq1(this.value.replace(/,/g, ''))
        this.value = parseFloat(this.value.replace(/,/g, ''))
          .toFixed(2)
          .toString()
          .replace(/\B(?=(\d{3})+(?!\d))/g, ',')
      }
    
      document.getElementById('descuento').onblur = function () {
        calculoantes()
        this.value = parseFloat(this.value.replace(/,/g, ''))
          .toFixed(2)
          .toString()
          .replace(/\B(?=(\d{3})+(?!\d))/g, ',')
      }
    
      document.getElementById('devolucion').onblur = function () {
        calculoantes()
        this.value = parseFloat(this.value.replace(/,/g, ''))
          .toFixed(2)
          .toString()
          .replace(/\B(?=(\d{3})+(?!\d))/g, ',')
      }
    
     
    
    // NUEVOS CAMPOS REQUISICION

function calculosubtotalreq1(valor) {

  descuento=$('#descuento').val().replace(/,/g, '')
  devolucion=$('#devolucion').val().replace(/,/g, '')

  if (descuento.length==0){
    descuento=0
    $('#descuento').val('0.00')
  }

  if (devolucion.length==0){
    devolucion=0
    $('#devolucion').val('0.00')
  }
  subtotal = (parseFloat(valor)+parseFloat(devolucion))-parseFloat(descuento)

  
  total = round(subtotal * 1.16, 2)
  iva = total - subtotal


      
 
  $("#subtotalreq").val( Intl.NumberFormat('es-MX',{minimumFractionDigits: 2,}).format(parseFloat(subtotal).toFixed(2)));
  $("#ivareq").val( Intl.NumberFormat('es-MX',{minimumFractionDigits: 2,}).format(parseFloat(iva).toFixed(2)));
  $("#montoreq").val( Intl.NumberFormat('es-MX',{minimumFractionDigits: 2,}).format(parseFloat(total).toFixed(2)));
  $("#montoreqa").val( Intl.NumberFormat('es-MX',{minimumFractionDigits: 2,}).format(parseFloat(total).toFixed(2)));
  caluloconret()


}

function calculototalreq1(valor) {

  descuento=$('#descuento').val().replace(/,/g, '')
  devolucion=$('#devolucion').val().replace(/,/g, '')

  if (descuento.length==0){
    descuento=0
    $('#descuento').val('0.00')
  }

  if (devolucion.length==0){
    devolucion=0
    $('#devolucion').val('0.00')
  }



  total=valor;

  subtotal = round(total / 1.16, 2);
  importe=(parseFloat(subtotal)-parseFloat(devolucion))+parseFloat(descuento)
  iva = round(total - subtotal, 2);
  $("#importe").val(Intl.NumberFormat('es-MX',{minimumFractionDigits: 2,}).format(parseFloat(importe).toFixed(2)));
  $("#ivareq").val(Intl.NumberFormat('es-MX',{minimumFractionDigits: 2,}).format(parseFloat(iva).toFixed(2)));
  $("#subtotalreq").val(Intl.NumberFormat('es-MX',{minimumFractionDigits: 2,}).format(parseFloat(subtotal).toFixed(2)));
  $("#montoreq").val( Intl.NumberFormat('es-MX',{minimumFractionDigits: 2,}).format(parseFloat(total).toFixed(2)));
  $("#montoreqa").val( Intl.NumberFormat('es-MX',{minimumFractionDigits: 2,}).format(parseFloat(total).toFixed(2)));
  caluloconret()

  

}

function calculoantes()
{
  valor=$('#importe').val().replace(/,/g, '')
  descuento=$('#descuento').val().replace(/,/g, '')
  devolucion=$('#devolucion').val().replace(/,/g, '')
  if (descuento.length==0){
      descuento=0
      $('#descuento').val('0.00')
    }

    if (devolucion.length==0){
      devolucion=0
      $('#devolucion').val('0.00')
    }

    subtotal = (parseFloat(valor)+parseFloat(devolucion))-parseFloat(descuento)

    
    total = round(subtotal * 1.16, 2)
    iva = total - subtotal


        
   
    $("#subtotalreq").val( Intl.NumberFormat('es-MX',{minimumFractionDigits: 2,}).format(parseFloat(subtotal).toFixed(2)));
    $("#ivareq").val( Intl.NumberFormat('es-MX',{minimumFractionDigits: 2,}).format(parseFloat(iva).toFixed(2)));
    $("#montoreq").val( Intl.NumberFormat('es-MX',{minimumFractionDigits: 2,}).format(parseFloat(total).toFixed(2)));
    $("#montoreqa").val( Intl.NumberFormat('es-MX',{minimumFractionDigits: 2,}).format(parseFloat(total).toFixed(2)));
    caluloconret()
}

    function calculototalreq(valor) {

  

      subtotal=valor
      
        descuento=$('#descuento').val().replace(/,/g, '')
        devolucion=$('#devolucion').val().replace(/,/g, '')
    
        if (descuento.length==0){
            descuento=0
            $('#descuento').val('0.00')
          }
      
          if (devolucion.length==0){
            devolucion=0
            $('#devolucion').val('0.00')
          }
    
          //subtotal = (parseFloat(valor)+parseFloat(devolucion))-parseFloat(descuento)
          importe=(parseFloat(subtotal)-parseFloat(devolucion))+parseFloat(descuento)
        
        total = round(subtotal * 1.16, 2)
        iva = total - subtotal
    
    
            
       
        $("#importe").val(Intl.NumberFormat('es-MX',{minimumFractionDigits: 2,}).format(parseFloat(importe).toFixed(2)));
        $("#ivareq").val( Intl.NumberFormat('es-MX',{minimumFractionDigits: 2,}).format(parseFloat(iva).toFixed(2)));
        $("#montoreq").val( Intl.NumberFormat('es-MX',{minimumFractionDigits: 2,}).format(parseFloat(total).toFixed(2)));
        $("#montoreqa").val( Intl.NumberFormat('es-MX',{minimumFractionDigits: 2,}).format(parseFloat(total).toFixed(2)));
        
        caluloconret()
        
    
    
    }

    function calculosubtotalreq(valor) {
     
        descuento=$('#descuento').val().replace(/,/g, '')
        devolucion=$('#devolucion').val().replace(/,/g, '')
    
        if (descuento.length==0){
          descuento=0
          $('#descuento').val('0.00')
        }
    
        if (devolucion.length==0){
          devolucion=0
          $('#devolucion').val('0.00')
        }
    
    
     
        total=valor;
    
        subtotal = round(total / 1.16, 2);
        importe=(parseFloat(subtotal)-parseFloat(devolucion))+parseFloat(descuento)
        iva = round(total - subtotal, 2);
        $("#importe").val(Intl.NumberFormat('es-MX',{minimumFractionDigits: 2,}).format(parseFloat(importe).toFixed(2)));
        $("#ivareq").val(Intl.NumberFormat('es-MX',{minimumFractionDigits: 2,}).format(parseFloat(iva).toFixed(2)));
        $("#subtotalreq").val(Intl.NumberFormat('es-MX',{minimumFractionDigits: 2,}).format(parseFloat(subtotal).toFixed(2)));
        $("#montoreq").val( Intl.NumberFormat('es-MX',{minimumFractionDigits: 2,}).format(parseFloat(total).toFixed(2)));
        $("#montoreqa").val( Intl.NumberFormat('es-MX',{minimumFractionDigits: 2,}).format(parseFloat(total).toFixed(2)));
        caluloconret()
    
            
    
    }
    
    function caluloconret(){
        total=$('#montoreqa').val().replace(/,/g, '')
        ret1=$('#ret1').val().replace(/,/g, '')
        ret2=$('#ret2').val().replace(/,/g, '')
        ret3=$('#ret3').val().replace(/,/g, '')
      //  ret4=$('#ret4').val().replace(/,/g, '')
    
      
        if(ret1.length==0){
            ret1=0
            $("#ret1").val( Intl.NumberFormat('es-MX',{minimumFractionDigits: 2,}).format(parseFloat(ret1).toFixed(2)));
            
        }
    
        if(ret2.length==0){
            ret2=0;
            $("#ret2").val( Intl.NumberFormat('es-MX',{minimumFractionDigits: 2,}).format(parseFloat(ret2).toFixed(2)));
            
        }
    
        if(ret3.length==0){
            ret3=0;
            $("#ret3").val( Intl.NumberFormat('es-MX',{minimumFractionDigits: 2,}).format(parseFloat(ret3).toFixed(2)));
           
        }
    /*
        if(ret4.length==0){
            ret4=0;
            $("#ret4").val( Intl.NumberFormat('es-MX',{minimumFractionDigits: 2,}).format(parseFloat(ret4).toFixed(2)));
          
        }*/
        
    
        retenciones=parseFloat(ret1)+parseFloat(ret2)+parseFloat(ret3)
        calculo=parseFloat(total)-parseFloat(retenciones)
        $("#montoreq").val( Intl.NumberFormat('es-MX',{minimumFractionDigits: 2,}).format(parseFloat(calculo).toFixed(2)));
            
    }
 
         document.getElementById('subtotalreq').onblur = function () {
          calculototalreq(this.value.replace(/,/g, ''))
          this.value = parseFloat(this.value.replace(/,/g, ''))
              .toFixed(2)
              .toString()
              .replace(/\B(?=(\d{3})+(?!\d))/g, ',')
      }
 
      document.getElementById('ivareq').onblur = function () {
          this.value = parseFloat(this.value.replace(/,/g, ''))
              .toFixed(2)
              .toString()
              .replace(/\B(?=(\d{3})+(?!\d))/g, ',')
      }

      document.getElementById('montoreq').onblur = function () {
         // calculosubtotalreq(this.value.replace(/,/g, ''))
          this.value = parseFloat(this.value.replace(/,/g, ''))
              .toFixed(2)
              .toString()
              .replace(/\B(?=(\d{3})+(?!\d))/g, ',')
      }
    
      document.getElementById('montoreqa').onblur = function () {
          calculosubtotalreq(this.value.replace(/,/g, ''))
          this.value = parseFloat(this.value.replace(/,/g, ''))
            .toFixed(2)
            .toString()
            .replace(/\B(?=(\d{3})+(?!\d))/g, ',')
        }

        

     document.getElementById('ret1').onblur = function () {
      caluloconret()
      this.value = parseFloat(this.value.replace(/,/g, ''))
      .toFixed(2)
      .toString()
      .replace(/\B(?=(\d{3})+(?!\d))/g, ',')
    }

    document.getElementById('ret2').onblur = function () {
      caluloconret()
      this.value = parseFloat(this.value.replace(/,/g, ''))
      .toFixed(2)
      .toString()
      .replace(/\B(?=(\d{3})+(?!\d))/g, ',')
    }

    document.getElementById('ret3').onblur = function () {
      caluloconret()
      this.value = parseFloat(this.value.replace(/,/g, ''))
      .toFixed(2)
      .toString()
      .replace(/\B(?=(\d{3})+(?!\d))/g, ',')
    }

//---------------------------- NUEVOS CAMPOS REQUISICION



        // --------------------NUEVOS CAMPOS PROVISION
     /*   document.getElementById('importeprov').onblur = function () {
          calculosubtotalprov1(this.value.replace(/,/g, ''))
          this.value = parseFloat(this.value.replace(/,/g, ''))
            .toFixed(2)
            .toString()
            .replace(/\B(?=(\d{3})+(?!\d))/g, ',')
        }
      
        document.getElementById('descuentoprov').onblur = function () {
          calculoantesprov()
          this.value = parseFloat(this.value.replace(/,/g, ''))
            .toFixed(2)
            .toString()
            .replace(/\B(?=(\d{3})+(?!\d))/g, ',')
        }
      
        document.getElementById('devolucionprov').onblur = function () {
          calculoantesprov()
          this.value = parseFloat(this.value.replace(/,/g, ''))
            .toFixed(2)
            .toString()
            .replace(/\B(?=(\d{3})+(?!\d))/g, ',')
        }
      
       */
      
      // TERMINA SOLO NUMEROS NUEVOS CAMPOS
  
      //NUEVOS CALCULOS
      /*
  function calculosubtotalprov1(valor) {
  
    descuento=$('#descuentoprov').val().replace(/,/g, '')
    devolucion=$('#devolucionprov').val().replace(/,/g, '')
  
    if (descuento.length==0){
      descuento=0
      $('#descuentoprov').val('0.00')
    }
  
    if (devolucion.length==0){
      devolucion=0
      $('#devolucionprov').val('0.00')
    }
    subtotal = (parseFloat(valor)+parseFloat(devolucion))-parseFloat(descuento)
  
    
    total = round(subtotal * 1.16, 2)
    iva = total - subtotal
  
  
        
   
    $("#subtotalprov").val( Intl.NumberFormat('es-MX',{minimumFractionDigits: 2,}).format(parseFloat(subtotal).toFixed(2)));
    $("#ivaprov").val( Intl.NumberFormat('es-MX',{minimumFractionDigits: 2,}).format(parseFloat(iva).toFixed(2)));
    $("#montoprov").val( Intl.NumberFormat('es-MX',{minimumFractionDigits: 2,}).format(parseFloat(total).toFixed(2)));
    $("#montoaprov").val( Intl.NumberFormat('es-MX',{minimumFractionDigits: 2,}).format(parseFloat(total).toFixed(2)));
    caluloconretprov()
  
  
  }*/
  /*
  function calculototalreq1(valor) {
  
    descuento=$('#descuentoprov').val().replace(/,/g, '')
    devolucion=$('#devolucionprov').val().replace(/,/g, '')
  
    if (descuento.length==0){
      descuento=0
      $('#descuentoprov').val('0.00')
    }
  
    if (devolucion.length==0){
      devolucion=0
      $('#devolucionprov').val('0.00')
    }
  
  
  
    total=valor;
  
    subtotal = round(total / 1.16, 2);
    importe=(parseFloat(subtotal)-parseFloat(devolucion))+parseFloat(descuento)
    iva = round(total - subtotal, 2);
    $("#importeprov").val(Intl.NumberFormat('es-MX',{minimumFractionDigits: 2,}).format(parseFloat(importe).toFixed(2)));
    $("#ivaprov").val(Intl.NumberFormat('es-MX',{minimumFractionDigits: 2,}).format(parseFloat(iva).toFixed(2)));
    $("#subtotalprov").val(Intl.NumberFormat('es-MX',{minimumFractionDigits: 2,}).format(parseFloat(subtotal).toFixed(2)));
    $("#montoprov").val( Intl.NumberFormat('es-MX',{minimumFractionDigits: 2,}).format(parseFloat(total).toFixed(2)));
    $("#montoaprov").val( Intl.NumberFormat('es-MX',{minimumFractionDigits: 2,}).format(parseFloat(total).toFixed(2)));
    caluloconretprov()
  
    
  
  }
  
  function calculoantesprov()
  {
    valor=$('#importeprov').val().replace(/,/g, '')
    descuento=$('#descuentoprov').val().replace(/,/g, '')
    devolucion=$('#devolucionprov').val().replace(/,/g, '')
    if (descuento.length==0){
        descuento=0
        $('#descuentoprov').val('0.00')
      }
  
      if (devolucion.length==0){
        devolucion=0
        $('#devolucionprov').val('0.00')
      }
  
      subtotal = (parseFloat(valor)+parseFloat(devolucion))-parseFloat(descuento)
  
      
      total = round(subtotal * 1.16, 2)
      iva = total - subtotal
  
  
          
     
      $("#subtotalprov").val( Intl.NumberFormat('es-MX',{minimumFractionDigits: 2,}).format(parseFloat(subtotal).toFixed(2)));
      $("#ivaprov").val( Intl.NumberFormat('es-MX',{minimumFractionDigits: 2,}).format(parseFloat(iva).toFixed(2)));
      $("#montoprov").val( Intl.NumberFormat('es-MX',{minimumFractionDigits: 2,}).format(parseFloat(total).toFixed(2)));
      $("#montoaprov").val( Intl.NumberFormat('es-MX',{minimumFractionDigits: 2,}).format(parseFloat(total).toFixed(2)));
      caluloconretprov()
  }
  

      function calculototalprov(valor) {
  
    
  
        subtotal=valor
        
          descuento=$('#descuentoprov').val().replace(/,/g, '')
          devolucion=$('#devolucionprov').val().replace(/,/g, '')
      
          if (descuento.length==0){
              descuento=0
              $('#descuentoprov').val('0.00')
            }
        
            if (devolucion.length==0){
              devolucion=0
              $('#devolucionprov').val('0.00')
            }
      
            //subtotal = (parseFloat(valor)+parseFloat(devolucion))-parseFloat(descuento)
            importe=(parseFloat(subtotal)-parseFloat(devolucion))+parseFloat(descuento)
          
          total = round(subtotal * 1.16, 2)
          iva = total - subtotal
      
      
              
         
          $("#importeprov").val(Intl.NumberFormat('es-MX',{minimumFractionDigits: 2,}).format(parseFloat(importe).toFixed(2)));
          $("#ivaprov").val( Intl.NumberFormat('es-MX',{minimumFractionDigits: 2,}).format(parseFloat(iva).toFixed(2)));
          $("#montoprov").val( Intl.NumberFormat('es-MX',{minimumFractionDigits: 2,}).format(parseFloat(total).toFixed(2)));
          $("#montoaprov").val( Intl.NumberFormat('es-MX',{minimumFractionDigits: 2,}).format(parseFloat(total).toFixed(2)));
          
          caluloconretprov()
          
      
      
      }
 
      function calculosubtotalprov(valor) {
       
          descuento=$('#descuentoprov').val().replace(/,/g, '')
          devolucion=$('#devolucionprov').val().replace(/,/g, '')
      
          if (descuento.length==0){
            descuento=0
            $('#descuentoprov').val('0.00')
          }
      
          if (devolucion.length==0){
            devolucion=0
            $('#devolucionprov').val('0.00')
          }
      
      
       
          total=valor;
      
          subtotal = round(total / 1.16, 2);
          importe=(parseFloat(subtotal)-parseFloat(devolucion))+parseFloat(descuento)
          iva = round(total - subtotal, 2);
          $("#importeprov").val(Intl.NumberFormat('es-MX',{minimumFractionDigits: 2,}).format(parseFloat(importe).toFixed(2)));
          $("#ivaprov").val(Intl.NumberFormat('es-MX',{minimumFractionDigits: 2,}).format(parseFloat(iva).toFixed(2)));
          $("#subtotalprov").val(Intl.NumberFormat('es-MX',{minimumFractionDigits: 2,}).format(parseFloat(subtotal).toFixed(2)));
          $("#montoprov").val( Intl.NumberFormat('es-MX',{minimumFractionDigits: 2,}).format(parseFloat(total).toFixed(2)));
          $("#montoaprov").val( Intl.NumberFormat('es-MX',{minimumFractionDigits: 2,}).format(parseFloat(total).toFixed(2)));
          caluloconretprov()
      
              
      
      }
      */
     /*
      function caluloconretprov(){
          total=$('#montoaprov').val().replace(/,/g, '')
          ret1=$('#ret1prov').val().replace(/,/g, '')
          ret2=$('#ret2prov').val().replace(/,/g, '')
          ret3=$('#ret3prov').val().replace(/,/g, '')
        //  ret4=$('#ret4').val().replace(/,/g, '')
      
        
          if(ret1.length==0){
              ret1=0
              $("#ret1prov").val( Intl.NumberFormat('es-MX',{minimumFractionDigits: 2,}).format(parseFloat(ret1).toFixed(2)));
              
          }
      
          if(ret2.length==0){
              ret2=0;
              $("#ret2prov").val( Intl.NumberFormat('es-MX',{minimumFractionDigits: 2,}).format(parseFloat(ret2).toFixed(2)));
              
          }
      
          if(ret3.length==0){
              ret3=0;
              $("#ret3prov").val( Intl.NumberFormat('es-MX',{minimumFractionDigits: 2,}).format(parseFloat(ret3).toFixed(2)));
             
          }
      
      //    if(ret4.length==0){
      //        ret4=0;
      //        $("#ret4").val( Intl.NumberFormat('es-MX',{minimumFractionDigits: 2,}).format(parseFloat(ret4).toFixed(2)));
            
      //    }
          
      
          retenciones=parseFloat(ret1)+parseFloat(ret2)+parseFloat(ret3)
          calculo=parseFloat(total)-parseFloat(retenciones)
          $("#montoprov").val( Intl.NumberFormat('es-MX',{minimumFractionDigits: 2,}).format(parseFloat(calculo).toFixed(2)));
              
      }*/
      /*
           // SOLO NUMEROS SUBTOTAL FACTURA
           document.getElementById('subtotalprov').onblur = function () {
            calculototalprov(this.value.replace(/,/g, ''))
            this.value = parseFloat(this.value.replace(/,/g, ''))
                .toFixed(2)
                .toString()
                .replace(/\B(?=(\d{3})+(?!\d))/g, ',')
        }
        // SOLO NUMEROS IVA FACTURA
        document.getElementById('ivaprov').onblur = function () {
            this.value = parseFloat(this.value.replace(/,/g, ''))
                .toFixed(2)
                .toString()
                .replace(/\B(?=(\d{3})+(?!\d))/g, ',')
        }
        // SOLO NUMEROS MONTO FACTURA
     
      
        document.getElementById('montoaprov').onblur = function () {
            calculosubtotalprov(this.value.replace(/,/g, ''))
            this.value = parseFloat(this.value.replace(/,/g, ''))
              .toFixed(2)
              .toString()
              .replace(/\B(?=(\d{3})+(?!\d))/g, ',')
          }
  
              //retenciones
  
       document.getElementById('ret1prov').onblur = function () {
        caluloconretprov()
        this.value = parseFloat(this.value.replace(/,/g, ''))
        .toFixed(2)
        .toString()
        .replace(/\B(?=(\d{3})+(?!\d))/g, ',')
      }
  
      document.getElementById('ret2prov').onblur = function () {
        caluloconretprov()
        this.value = parseFloat(this.value.replace(/,/g, ''))
        .toFixed(2)
        .toString()
        .replace(/\B(?=(\d{3})+(?!\d))/g, ',')
      }
  
      document.getElementById('ret3prov').onblur = function () {
        caluloconretprov()
        this.value = parseFloat(this.value.replace(/,/g, ''))
        .toFixed(2)
        .toString()
        .replace(/\B(?=(\d{3})+(?!\d))/g, ',')
      }*/
  
  //----------------------------TERMINA NUEVOS CALCULOS



/*

  //CALCULO TOTAL PROV
  function calculototalprov(valor) {
    subtotal = valor

    total = round(subtotal * 1.16, 2)
    iva = total - subtotal

    $('#ivaprov').val(
      Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
        parseFloat(iva).toFixed(2),
      ),
    )
    $('#montoprov').val(
      Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
        parseFloat(total).toFixed(2),
      ),
    )
  }
  //CALCULO SUBTOTAL PROV
  function calculosubtotalprov(valor) {
    total = valor

    subtotal = round(total / 1.16, 2)

    iva = round(total - subtotal, 2)

    $('#ivaprov').val(
      Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
        parseFloat(iva).toFixed(2),
      ),
    )
    $('#subtotalprov').val(
      Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
        parseFloat(subtotal).toFixed(2),
      ),
    )
  }

  */

  document.getElementById('montoprov').onblur = function () {
    // calculosubtotalreq(this.value.replace(/,/g, ''))
     this.value = parseFloat(this.value.replace(/,/g, ''))
         .toFixed(2)
         .toString()
         .replace(/\B(?=(\d{3})+(?!\d))/g, ',')
 }
  document.getElementById('montocobrado').onblur = function () {
  
    this.value = parseFloat(this.value.replace(/,/g, ''))
      .toFixed(2)
      .toString()
      .replace(/\B(?=(\d{3})+(?!\d))/g, ',')
  }





  // SOLO NUMEROS SUBTOTAL
  document.getElementById('subtotal').onblur = function () {
    calculototal(this.value.replace(/,/g, ''))
    this.value = parseFloat(this.value.replace(/,/g, ''))
      .toFixed(2)
      .toString()
      .replace(/\B(?=(\d{3})+(?!\d))/g, ',')
  }

  // SOLO NUMEROS IVA
  document.getElementById('iva').onblur = function () {
    this.value = parseFloat(this.value.replace(/,/g, ''))
      .toFixed(2)
      .toString()
      .replace(/\B(?=(\d{3})+(?!\d))/g, ',')
  }

  // SOLO NUMEROS MONTO
  document.getElementById('monto').onblur = function () {
    calculosubtotal(this.value.replace(/,/g, ''))

    this.value = parseFloat(this.value.replace(/,/g, ''))
      .toFixed(2)
      .toString()
      .replace(/\B(?=(\d{3})+(?!\d))/g, ',')
  }


  // SOLO NUMEROS MONTOPAGO
  document.getElementById('montopagovp').onblur = function () {
    this.value = parseFloat(this.value.replace(/,/g, ''))
      .toFixed(2)
      .toString()
      .replace(/\B(?=(\d{3})+(?!\d))/g, ',')
  }

  // TOOLTIP DATATABLE
  $('[data-toggle="tooltip"]').tooltip()

  // TABLA PRINCIPAL
  tablaVis = $('#tablaV').DataTable({
    // OPCIONES
    stateSave: true,
    orderCellsTop: true,
    fixedHeader: true,
    paging: false,
    //BUTONES EXPORTAR
    dom:
      "<'row justify-content-center'<'col-sm-12 col-md-4 form-group'l><'col-sm-12 col-md-4 form-group'B><'col-sm-12 col-md-4 form-group'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",

    buttons: [
      {
        extend: 'excelHtml5',
        text: "<i class='fas fa-file-excel'> Excel</i>",
        titleAttr: 'Exportar a Excel',
        title: 'Listado de Egresos',
        className: 'btn bg-success ',
        exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9] },
      },
      {
        extend: 'pdfHtml5',
        text: "<i class='far fa-file-pdf'> PDF</i>",
        titleAttr: 'Exportar a PDF',
        title: 'Listado de Egresos',
        className: 'btn bg-danger',
        exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9] },
      },
    ],

    /* */

    //COLUMNAS

    columnDefs: [
      {
        targets: -1,
        data: null,
        /*defaultContent:
          "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-primary btnEditar'  data-toggle='tooltip' data-placement='top' title='Editar'><i class='fas fa-edit'></i></button>\
          <button class='btn btn-sm bg-secondary btnProvision'><i class='fas fa-funnel-dollar'  data-toggle='tooltip' data-placement='top' title='Provisiones'></i></button>\
          <button class='btn btn-sm bg-orange btnVerprovision'><i class='fas fa-bars'  data-toggle='tooltip' data-placement='top' title='Ver Provisiones'></i></button>\
            <button class='btn btn-sm bg-purple btnRequisicion' data-toggle='tooltip' data-placement='top' title='Registrar Requisición'><i class='fas fa-hand-holding-usd'></i></button>\
            <button class='btn btn-sm bg-info btnResumen'><i class='fas fa-bars' data-toggle='tooltip' data-placement='top' title='Resumen Requisiciones'></i></button>\
            <button class='btn btn-sm bg-danger btnCancelar' data-toggle='tooltip' data-placement='top' title='Cancelar'><i class='fas fa-ban'></i></button>\
            </div></div>",*/
        defaultContent: textcolumnas,
        /**/
      },
      { className: 'hide_column', targets: [3] },
      { width: '30%', targets: 6 },
      { width: '10%', targets: 1 },
      { width: '10%', targets: 2 },
      { width: '8%', targets: 5 },
    ],
    rowCallback: function (row, data) {
      // FORMATO DE CELDAS
      $($(row).find('td')['7']).addClass('text-right')
      $($(row).find('td')['8']).addClass('text-right')
      $($(row).find('td')['9']).addClass('text-right')
      $($(row).find('td')['7']).addClass('currency')
      $($(row).find('td')['8']).addClass('currency')
      $($(row).find('td')['9']).addClass('currency')
    },

    // SUMA DE SALDO Y TOTAL PARA EL FOOTER
    footerCallback: function (row, data, start, end, display) {
      var api = this.api(),
        data

      var intVal = function (i) {
        return typeof i === 'string'
          ? i.replace(/[\$,]/g, '') * 1
          : typeof i === 'number'
          ? i
          : 0
      }

      total = api
        .column(7)
        .data()
        .reduce(function (a, b) {
          return intVal(a) + intVal(b)
        }, 0)
      saldo = api
        .column(8)
        .data()
        .reduce(function (a, b) {
          return intVal(a) + intVal(b)
        }, 0)

        cobrado = api
        .column(9)
        .data()
        .reduce(function (a, b) {
          return intVal(a) + intVal(b)
        }, 0)

      $(api.column(7).footer()).html(
        Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
          parseFloat(total).toFixed(2),
        ),
      )

      $(api.column(8).footer()).html(
        Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
          parseFloat(saldo).toFixed(2),
        ),
      )
      if(rol==2 || rol==3){
      $(api.column(9).footer()).html(
        Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
          parseFloat(cobrado).toFixed(2),
        ),
      )
      }
    },

    language: {
      lengthMenu: 'Mostrar _MENU_ registros',
      zeroRecords: 'No se encontraron resultados',
      info:
        'Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros',
      infoEmpty: 'Mostrando registros del 0 al 0 de un total de 0 registros',
      infoFiltered: '(filtrado de un total de _MAX_ registros)',
      sSearch: 'Buscar:',
      oPaginate: {
        sFirst: 'Primero',
        sLast: 'Último',
        sNext: 'Siguiente',
        sPrevious: 'Anterior',
      },
      sProcessing: 'Procesando...',
    },
  })

  //FILTROS
  $('#tablaV thead tr').clone(true).appendTo('#tablaV thead')
  $('#tablaV thead tr:eq(1) th').each(function (i) {
    var title = $(this).text()
    $(this).html(
      '<input class="form-control form-control-sm" type="text" placeholder="' +
        title +
        '" />',
    )

    $('input', this).on('keyup change', function () {
      if (i == 4) {
        valbuscar = this.value
      } else {
        valbuscar = this.value
      }

      if (tablaVis.column(i).search() !== valbuscar) {
        tablaVis.column(i).search(valbuscar, true, true).draw()
      }
    })
  })

  //TABLA RESUMEN DE REQUISICIONES
  tablaResumen = $('#tablaResumen').DataTable({
    rowCallback: function (row, data) {
      $($(row).find('td')['4']).addClass('text-right')
      $($(row).find('td')['4']).addClass('currency')
      $($(row).find('td')['5']).addClass('text-right')
      $($(row).find('td')['5']).addClass('currency')
    },
    columnDefs: [
      {
        targets: 4,
        render: function (data, type, full, meta) {
          return new Intl.NumberFormat('es-MX', {
            minimumFractionDigits: 2,
          }).format(parseFloat(data).toFixed(2))
        },
      },
      {
        targets: 5,
        render: function (data, type, full, meta) {
          return new Intl.NumberFormat('es-MX', {
            minimumFractionDigits: 2,
          }).format(parseFloat(data).toFixed(2))
        },
      },
      {
        targets: -1,
        data: null,
        defaultContent: textcolumnas2,
        /* "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-primary btnVerpagos' data-toggle='tooltip' data-placement='top' title='Ver Pagos' ><i class='fas fa-search-dollar'></i></button>\
                    <button class='btn btn-sm btn-success btnPagar' data-toggle='tooltip' data-placement='top' title='Pagar Requisicion' ><i class='fas fa-dollar-sign'></i></button>\
                    <button class='btn btn-sm bg-danger btnCancelarreq' data-toggle='tooltip' data-placement='top' title='Cancelar'><i class='fas fa-ban'></i></button>\
                    </div></div>"*/
      },
    ],

    language: {
      lengthMenu: 'Mostrar _MENU_ registros',
      zeroRecords: 'No se encontraron resultados',
      info:
        'Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros',
      infoEmpty: 'Mostrando registros del 0 al 0 de un total de 0 registros',
      infoFiltered: '(filtrado de un total de _MAX_ registros)',
      sSearch: 'Buscar:',
      oPaginate: {
        sFirst: 'Primero',
        sLast: 'Último',
        sNext: 'Siguiente',
        sPrevious: 'Anterior',
      },
      sProcessing: 'Procesando...',
    },
    footerCallback: function (row, data, start, end, display) {
      var api = this.api(),
        data

      var intVal = function (i) {
        return typeof i === 'string'
          ? i.replace(/[\$,]/g, '') * 1
          : typeof i === 'number'
          ? i
          : 0
      }

      totalr = api
        .column(4)
        .data()
        .reduce(function (a, b) {
          return intVal(a) + intVal(b)
        }, 0)

      saldor = api
        .column(5)
        .data()
        .reduce(function (a, b) {
          return intVal(a) + intVal(b)
        }, 0)

      $(api.column(4).footer()).html(
        Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
          parseFloat(totalr).toFixed(2),
        ),
      )

      $(api.column(5).footer()).html(
        Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
          parseFloat(saldor).toFixed(2),
        ),
      )
    },
  })

  //TABLA RESUMEN DE PROVISIONES
  tablaVerprov = $('#tablaVerprov').DataTable({
    rowCallback: function (row, data) {
      $($(row).find('td')['4']).addClass('text-right')
      $($(row).find('td')['4']).addClass('currency')
      $($(row).find('td')['5']).addClass('text-right')
      $($(row).find('td')['5']).addClass('currency')
    },
    columnDefs: [
     /* { className: 'hide_column', targets: [1] },
      { className: 'hide_column', targets: [4] },
      { className: 'hide_column', targets: [5] },*/
      {
        targets: 4,
        render: function (data, type, full, meta) {
          return new Intl.NumberFormat('es-MX', {
            minimumFractionDigits: 2,
          }).format(parseFloat(data).toFixed(2))
        },
      },
      {
        targets: 5,
        render: function (data, type, full, meta) {
          return new Intl.NumberFormat('es-MX', {
            minimumFractionDigits: 2,
          }).format(parseFloat(data).toFixed(2))
        },
      },
      {
        targets: -1,
        data: null,
        defaultContent: textcolumnas4,
        /* "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-primary btnVerpagos' data-toggle='tooltip' data-placement='top' title='Ver Pagos' ><i class='fas fa-search-dollar'></i></button>\
                      <button class='btn btn-sm btn-success btnPagar' data-toggle='tooltip' data-placement='top' title='Pagar Requisicion' ><i class='fas fa-dollar-sign'></i></button>\
                      <button class='btn btn-sm bg-danger btnCancelarreq' data-toggle='tooltip' data-placement='top' title='Cancelar'><i class='fas fa-ban'></i></button>\
                      </div></div>"*/
      },
    ],

    language: {
      lengthMenu: 'Mostrar _MENU_ registros',
      zeroRecords: 'No se encontraron resultados',
      info:
        'Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros',
      infoEmpty: 'Mostrando registros del 0 al 0 de un total de 0 registros',
      infoFiltered: '(filtrado de un total de _MAX_ registros)',
      sSearch: 'Buscar:',
      oPaginate: {
        sFirst: 'Primero',
        sLast: 'Último',
        sNext: 'Siguiente',
        sPrevious: 'Anterior',
      },
      sProcessing: 'Procesando...',
    },
    footerCallback: function (row, data, start, end, display) {
      var api = this.api(),
        data

      var intVal = function (i) {
        return typeof i === 'string'
          ? i.replace(/[\$,]/g, '') * 1
          : typeof i === 'number'
          ? i
          : 0
      }

      totalr = api
        .column(4)
        .data()
        .reduce(function (a, b) {
          return intVal(a) + intVal(b)
        }, 0)

      saldor = api
        .column(5)
        .data()
        .reduce(function (a, b) {
          return intVal(a) + intVal(b)
        }, 0)

      $(api.column(4).footer()).html(
        Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
          parseFloat(totalr).toFixed(2),
        ),
      )

      $(api.column(5).footer()).html(
        Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
          parseFloat(saldor).toFixed(2),
        ),
      )
    },
  })
  //TABLA RESUMEN DE RESUMEN PAGOS
  tablaResumenp = $('#tablaResumenp').DataTable({
    rowCallback: function (row, data) {
      $($(row).find('td')['3']).addClass('text-right')
      $($(row).find('td')['3']).addClass('currency')
    },
    columnDefs: [
      {
        targets: -1,
        data: null,
        defaultContent: textcolumnas3,
        /*   "<div class='text-center'><button class='btn btn-sm bg-danger btnCancelarpago' data-toggle='tooltip' data-placement='top' title='Cancelar'><i class='fas fa-ban'></i></button>\
                    </div></div>"*/
      },
      {
        targets: 3,
        render: function (data, type, full, meta) {
          return new Intl.NumberFormat('es-MX', {
            minimumFractionDigits: 2,
          }).format(parseFloat(data).toFixed(2))
        },
      },
    ],

    language: {
      lengthMenu: 'Mostrar _MENU_ registros',
      zeroRecords: 'No se encontraron resultados',
      info:
        'Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros',
      infoEmpty: 'Mostrando registros del 0 al 0 de un total de 0 registros',
      infoFiltered: '(filtrado de un total de _MAX_ registros)',
      sSearch: 'Buscar:',
      oPaginate: {
        sFirst: 'Primero',
        sLast: 'Último',
        sNext: 'Siguiente',
        sPrevious: 'Anterior',
      },
      sProcessing: 'Procesando...',
    },
    footerCallback: function (row, data, start, end, display) {
      var api = this.api(),
        data

      var intVal = function (i) {
        return typeof i === 'string'
          ? i.replace(/[\$,]/g, '') * 1
          : typeof i === 'number'
          ? i
          : 0
      }

      totalr = api
        .column(3)
        .data()
        .reduce(function (a, b) {
          return intVal(a) + intVal(b)
        }, 0)

      $(api.column(3).footer()).html(
        Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
          parseFloat(totalr).toFixed(2),
        ),
      )
    },
  })
  // TABLA BUSCAR OBRA

  tablaobra = $('#tablaObra').DataTable({
    columnDefs: [
      {
        targets: -1,
        data: null,
        defaultContent:
          "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-success btnSelObra' data-toggle='tooltip' data-placement='top' title='Seleccionar Obra'><i class='fas fa-hand-pointer'></i></button></div></div>",
      },
    ],
    language: {
      lengthMenu: 'Mostrar _MENU_ registros',
      zeroRecords: 'No se encontraron resultados',
      info:
        'Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros',
      infoEmpty: 'Mostrando registros del 0 al 0 de un total de 0 registros',
      infoFiltered: '(filtrado de un total de _MAX_ registros)',
      sSearch: 'Buscar:',
      oPaginate: {
        sFirst: 'Primero',
        sLast: 'Último',
        sNext: 'Siguiente',
        sPrevious: 'Anterior',
      },
      sProcessing: 'Procesando...',
    },
  })

  // TABLA BUSCAR PROVEEDOR
  tablaprov = $('#tablaProveedor').DataTable({
    columnDefs: [
      {
        targets: -1,
        data: null,
        defaultContent:
          "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-success btnSelProveedor' data-toggle='tooltip' data-placement='top' title='Seleccionar Proveedor'><i class='fas fa-hand-pointer'></i></button></div></div>",
      },
    ],

    language: {
      lengthMenu: 'Mostrar _MENU_ registros',
      zeroRecords: 'No se encontraron resultados',
      info:
        'Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros',
      infoEmpty: 'Mostrando registros del 0 al 0 de un total de 0 registros',
      infoFiltered: '(filtrado de un total de _MAX_ registros)',
      sSearch: 'Buscar:',
      oPaginate: {
        sFirst: 'Primero',
        sLast: 'Último',
        sNext: 'Siguiente',
        sPrevious: 'Anterior',
      },
      sProcessing: 'Procesando...',
    },
  })

  //BOTON BUSCAR OBRA
  $(document).on('click', '#bobra', function () {
    $('#modalObra').modal('show')
  })
  //BOTON SELECCIONAR OBRA
  $(document).on('click', '.btnSelObra', function () {
    fila = $(this)
    id_obra = parseInt($(this).closest('tr').find('td:eq(0)').text())
    obra = $(this).closest('tr').find('td:eq(2)').text()

    $('#id_obra').val(id_obra)
    $('#obra').val(obra)
    $('#modalObra').modal('hide')
  })

  //BOTON SELECCIONAR PROVEEDOR
  $(document).on('click', '.btnSelProveedor', function () {
    fila = $(this)
    id_prov = parseInt($(this).closest('tr').find('td:eq(0)').text())
    proveedor = $(this).closest('tr').find('td:eq(2)').text()

    $('#id_prov').val(id_prov)
    $('#proveedor').val(proveedor)
    $('#modalProveedor').modal('hide')
  })
  //BOTON BUSCAR PROVEEDOR
  $(document).on('click', '#bproveedor', function () {
    $('#modalProveedor').modal('show')
  })
  //BOTON NUEVO
  $('#btnNuevo').click(function () {
    $('#formAlta').trigger('reset')
    $('#modalAlta').modal('show')
    id = null
    opcion = 1
  })

  //BOTON EDITAR
  $(document).on('click', '.btnEditar', function () {
    fila = $(this).closest('tr')
    folio = parseInt(fila.find('td:eq(0)').text())

    saldo = fila.find('td:eq(8)').text().replace(/,/g, '')
    monto = fila.find('td:eq(7)').text().replace(/,/g, '')

    if (parseFloat(monto) == parseFloat(saldo)) {
      opcion = 2
      $.ajax({
        url: 'bd/buscarsubcontrato.php',
        type: 'POST',
        dataType: 'json',
        data: {
          folio: folio,
          opcion: opcion,
        },
        success: function (data) {
          if (data != null) {
            clave = data[0].clave_sub
            fecha = data[0].fecha_sub
            id_obra = data[0].id_obra
            obra = data[0].corto_obra
            id_prov = data[0].id_prov
            proveedor = data[0].razon_prov
            descripcion = data[0].desc_sub
            subtotal = Intl.NumberFormat('es-MX', {
              minimumFractionDigits: 2,
            }).format(parseFloat(data[0].subtotal_sub).toFixed(2))
            iva = Intl.NumberFormat('es-MX', {
              minimumFractionDigits: 2,
            }).format(parseFloat(data[0].iva_sub).toFixed(2))
            monto = Intl.NumberFormat('es-MX', {
              minimumFractionDigits: 2,
            }).format(parseFloat(data[0].monto_sub).toFixed(2))

            $('#folio').val(folio)
            $('#fecha').val(fecha)
            $('#clave').val(clave)
            $('#id_obra').val(id_obra)
            $('#obra').val(obra)
            $('#id_prov').val(id_prov)
            $('#proveedor').val(proveedor)
            $('#descripcion').val(descripcion)
            $('#monto').val(monto)
            $('#iva').val(iva)
            $('#subtotal').val(subtotal)
          } else {
            Swal.fire({
              title: 'Subcontrato no encontrado',
              icon: 'warning',
            })
          }
        },
      })

      $('#modalAlta').modal('show')
    } else {
      swal.fire({
        title: 'No es posible editar el Subcontrato',
        text: 'El documento ya tiene operaciones posteriores',
        icon: 'warning',
        focusConfirm: true,
        confirmButtonText: 'Aceptar',
      })
    }
  })

  //BOTON GUARDAR SUBCONTRATO
  $(document).on('click', '#btnGuardar', function () {
    folio = $('#folio').val()

    fecha = $('#fecha').val()
    clave = $('#clave').val()
    id_obra = $('#id_obra').val()
    id_prov = $('#id_prov').val()
    tipo = 'SUBCONTRATO'
    descripcion = $('#descripcion').val()
    monto = $('#monto').val().replace(/,/g, '')
    iva = $('#iva').val().replace(/,/g, '')
    subtotal = $('#subtotal').val().replace(/,/g, '')
    

    if (
      fecha.length == 0 ||
      clave.length == 0 ||
      id_obra.length == 0 ||
      id_prov.length == 0 ||
      descripcion.length == 0 ||
      monto.length == 0
    ) {
      Swal.fire({
        title: 'Datos Faltantes',
        text: 'Debe ingresar todos los datos Requeridos',
        icon: 'warning',
      })
      return false
    } else {
      $.ajax({
        url: 'bd/buscarclave.php',
        type: 'POST',
        dataType: 'json',
        async: false,
        data: {
          clave: clave,
          opcion: opcion
        
        },
        success: function (data) {
            
          if (data == 0) {
            $.ajax({
              url: 'bd/crudsubcontrato.php',
              type: 'POST',
              dataType: 'json',
              data: {
                folio: folio,
                fecha: fecha,
                clave: clave,
                id_obra: id_obra,
                id_prov: id_prov,
                descripcion: descripcion,
                tipo: tipo,
                monto: monto,
                subtotal: subtotal,
                iva: iva,
                opcion: opcion,
                usuario: usuario
              },
              success: function (data) {
                if (data == 1) {
                  subcontratoguardado()
                  window.location.reload()
                } else {
                  Swal.fire({
                    title: 'Operacion No Exitosa',
                    icon: 'warning',
                  })
                }
              },
            })
          
          } else {
            Swal.fire({
              title: 'El Clave de subcontato ya se encuentra registrada',
              icon: 'error',
            })
          }
        },
      })

     
    }
  })

  // BOTON NUEVA REQUISICION
  $(document).on('click', '.btnRequisicion', function () {
    fila = $(this).closest('tr')
    id = parseInt(fila.find('td:eq(0)').text())
    proveedor = parseInt(fila.find('td:eq(3)').text())
    $('#formReq').trigger('reset')
    $('#modalReq').modal('show')
    $('#foliosubcontrato').val(id)
    $('#idprovreq').val(proveedor)
  })

  //BOTON TRASLADAR

  $(document).on('click', '.btntrasladarprov', function () {
    fila = $(this).closest('tr')
    id = parseInt(fila.find('td:eq(0)').text())
    subcontrato = parseInt(fila.find('td:eq(1)').text())
    concepto = fila.find('td:eq(3)').text()
    subtotal = fila.find('td:eq(4)').text()
    iva = fila.find('td:eq(5)').text()
    total = fila.find('td:eq(7)').text()

    ret1=fila.find('td:eq(8)').text()
    ret2=fila.find('td:eq(9)').text()
    ret3=fila.find('td:eq(10)').text()
    importe=fila.find('td:eq(11)').text()
    descuento=fila.find('td:eq(12)').text()
    devolucion=fila.find('td:eq(13)').text()
    

    $('#modalVerprov').modal('hide')
    $('#formReq').trigger('reset')
    $('#modalReq').modal('show')
    $('#idprovision').val(id)
    $('#foliosubcontrato').val(subcontrato)
    $('#idprovreq').val(idprovglobal)

    $('#descripcionreq').val(concepto)
    //$('#subtotalreq').val(subtotal)
    //$('#ivareq').val(iva)
    $('#importe').val(importe)
    $('#devolucion').val(devolucion)
    $('#descuento').val(descuento)
    $('#ret1').val(ret1)
    $('#ret2').val(ret2)
    $('#ret3').val(ret3)
    calculosubtotalreq1($('#importe').val().replace(/,/g, ''))
  })

  // BOTON NUEVA PROVISION
  $(document).on('click', '.btnProvision', function () {
    fila = $(this).closest('tr')
    id = parseInt(fila.find('td:eq(0)').text())
    proveedor = parseInt(fila.find('td:eq(3)').text())
    $('#formProv').trigger('reset')
    $('#modalProv').modal('show')
    $('#foliosubcontratop').val(id)
    $('#idprovp').val(proveedor)
  })

  //BOTON GUARDAR REQUISICION
  $(document).on('click', '#btnGuardarreq', function () {
    folioreq = $('#folioreq').val()
    subcontrato = $('#foliosubcontrato').val()
    id_prov = $('#idprovreq').val()
    fechareq = $('#fechareq').val()
    clavereq = $('#clavereq').val()
    factura = $('#clavereq').val()
    idprovision = $('#idprovision').val()

    opcionreq = 1
    descripcionreq = $('#descripcionreq').val()
    montoreq = $('#montoreq').val().replace(/,/g, '')
    ivareq = $('#ivareq').val().replace(/,/g, '')
    subtotalreq = $('#subtotalreq').val().replace(/,/g, '')


    montob = $('#montoreqa').val().replace(/,/g, '')
    ret1 = $('#ret1').val().replace(/,/g, '')
    ret2 = $('#ret2').val().replace(/,/g, '')
    ret3 = $('#ret3').val().replace(/,/g, '')
    importe = $('#importe').val().replace(/,/g, '')
    descuento = $('#descuento').val().replace(/,/g, '')
    devolucion = $('#devolucion').val().replace(/,/g, '')



    if (
      fechareq.length == 0 ||
      clavereq.length == 0 ||
      descripcionreq.length == 0 ||
      montoreq.length == 0
    ) {
      Swal.fire({
        title: 'Datos Faltantes',
        text: 'Debe ingresar todos los datos Requeridos',
        icon: 'warning',
      })
      return false
    } else {
      $.ajax({
        url: 'bd/buscarfacturacxp.php',
        type: 'POST',
        dataType: 'json',
        async: false,
        data: {
          factura: factura,
          id_prov: id_prov,
        },
        success: function (data) {
          if (data == 0) {
            $.ajax({
              url: 'bd/crudrequisicion.php',
              type: 'POST',
              dataType: 'json',
              async: false,
              data: {
                folioreq: folioreq,
                fechareq: fechareq,
                clavereq: clavereq,
                subcontrato: subcontrato,
                descripcionreq: descripcionreq,
                montoreq: montoreq,
                subtotalreq: subtotalreq,
                ivareq: ivareq,
                idprovision: idprovision,
                opcionreq: opcionreq,
                ret1: ret1,
                ret2: ret2,
                ret3: ret3,
                importe: importe,
                devolucion: devolucion,
                descuento: descuento,
                montob: montob,
              },
              success: function (data) {
                if (data == 1) {
                  Swal.fire({
                    title: 'Requisicion Guardada',
                    icon: 'success',
                  })
                  window.location.reload()
                } else {
                  Swal.fire({
                    title: 'Operacion No Exitosa',
                    icon: 'warning',
                  })
                }
              },
            })
          } else {
            Swal.fire({
              title:
                'El Folio de la factura ya fue registrada para este proveedor',
              icon: 'error',
            })
          }
        },
      })
    }
  })

  //BOTON GUARDAR PROVISION
  $(document).on('click', '#btnGuardarprov', function () {
    folioreq = $('#folioprov').val()
    subcontrato = $('#foliosubcontratop').val()
    id_prov = $('#idprovp').val()
    fechareq = $('#fechaprov').val()

    opcionreq = 1
    descripcionreq = $('#descripcionprov').val()
    montoreq = $('#montoprov').val().replace(/,/g, '')
  /*  ivareq = $('#ivaprov').val().replace(/,/g, '')
    subtotalreq = $('#subtotalprov').val().replace(/,/g, '')
    

    montob = $('#montoaprov').val().replace(/,/g, '')
    ret1 = $('#ret1prov').val().replace(/,/g, '')
    ret2 = $('#ret2prov').val().replace(/,/g, '')
    ret3 = $('#ret3prov').val().replace(/,/g, '')
    importe = $('#importeprov').val().replace(/,/g, '')
    descuento = $('#descuentoprov').val().replace(/,/g, '')
    devolucion = $('#devolucionprov').val().replace(/,/g, '')
*/

    if (
      fechareq.length == 0 ||
      descripcionreq.length == 0 ||
      montoreq.length == 0
    ) {
      Swal.fire({
        title: 'Datos Faltantes',
        text: 'Debe ingresar todos los datos Requeridos',
        icon: 'warning',
      })
      return false
    } else {
      $.ajax({
        url: 'bd/crudprovisionsub.php',
        type: 'POST',
        dataType: 'json',
        data: {
          folioreq: folioreq,
          fechareq: fechareq,
          subcontrato: subcontrato,
          descripcionreq: descripcionreq,
          montoreq: montoreq
          /*subtotalreq: subtotalreq,
          ivareq: ivareq,
          opcionreq: opcionreq,
          ret1: ret1,
          ret2: ret2,
          ret3: ret3,
          importe: importe,
          devolucion: devolucion,
          descuento: descuento,
          montob: montob,*/
        },
        success: function (data) {
          if (data == 1) {
            Swal.fire({
              title: 'Provisión Guardada',
              icon: 'success',
            })
            window.location.reload()
          } else {
            Swal.fire({
              title: 'Operacion No Exitosa',
              icon: 'warning',
            })
          }
        },
      })
    }
  })

  // BOTON RESUMEN REQUISICIONES
  $(document).on('click', '.btnResumen', function () {
    fila = $(this).closest('tr')
    id = parseInt(fila.find('td:eq(0)').text())
    buscarrequisicion(id)
    $('#modalResumen').modal('show')
  })

  // BOTON RESUMEN REQUISICIONES POR PROVISION
  $(document).on('click', '.btnVerreq', function () {
    fila = $(this).closest('tr')
    id = parseInt(fila.find('td:eq(0)').text())
    buscarrequisicionprov(id)
    $('#modalVerprov').modal('hide')
    $('#modalResumen').modal('show')
  })

  // BOTON RESUMEN PROVISIONES
  $(document).on('click', '.btnVerprovision', function () {
    fila = $(this).closest('tr')
    idprovglobal = parseInt(fila.find('td:eq(3)').text())
    id = parseInt(fila.find('td:eq(0)').text())
    buscarprovision(id)
    $('#modalVerprov').modal('show')
  })

  //BOTON VER PAGOS
  $(document).on('click', '.btnVerpagos', function () {
    fila = $(this).closest('tr')
    id = parseInt(fila.find('td:eq(0)').text())
    buscarpagos(id)

    $('#modalResumenp').modal('show')
  })

  //FUNCION BUSCAR REQUISICIONES

  function buscarrequisicion(folio) {
    tablaResumen.clear()
    tablaResumen.draw()
    opcion = 2
    $.ajax({
      type: 'POST',
      url: 'bd/buscarrequisicion.php',
      dataType: 'json',

      data: { folio: folio, opcion: opcion },

      success: function (res) {
        for (var i = 0; i < res.length; i++) {
          tablaResumen.row
            .add([
              res[i].id_req,
              res[i].factura_req,
              res[i].fecha_req,
              res[i].concepto_req,
              res[i].monto_req,
              res[i].saldo_req,
            ])
            .draw()
        }
      },
    })
  }

  //FUNCION BUSCAR REQUISICIONES POR PROVISION

  function buscarrequisicionprov(folio) {
    tablaResumen.clear()
    tablaResumen.draw()
    opcion = 3
    $.ajax({
      type: 'POST',
      url: 'bd/buscarrequisicion.php',
      dataType: 'json',

      data: { folio: folio, opcion: opcion },

      success: function (res) {
        for (var i = 0; i < res.length; i++) {
          tablaResumen.row
            .add([
              res[i].id_req,
              res[i].factura_req,
              res[i].fecha_req,
              res[i].concepto_req,
              res[i].monto_req,
              res[i].saldo_req,
            ])
            .draw()
        }
      },
    })
  }

  //FUNCION BUSCAR PROVISIONES

  function buscarprovision(folio) {
    tablaVerprov.clear()
    tablaVerprov.draw()
    opcion = 2
    $.ajax({
      type: 'POST',
      url: 'bd/buscarprovision.php',
      dataType: 'json',

      data: { folio: folio, opcion: opcion },

      success: function (res) {
        for (var i = 0; i < res.length; i++) {
          tablaVerprov.row
            .add([
              res[i].id_provs,
              res[i].id_sub,
              res[i].fecha_prov,
              res[i].concepto_prov,
              res[i].subtotal_prov,
              res[i].iva_prov,
              res[i].monto_prov,
              res[i].saldo_prov,
              res[i].ret1,
              res[i].ret2,
              res[i].ret3,
              res[i].importe,
              res[i].descuento,
              res[i].devolucion,
            ])
            .draw()
        }
      },
    })
  }

  // FUNCION BUSCAR PAGOS
  function buscarpagos(folio) {
    tablaResumenp.clear()
    tablaResumenp.draw()
    opcion = 3 // 3 para pagos de requisiciones
    $.ajax({
      type: 'POST',
      url: 'bd/buscarpagocxp.php',
      dataType: 'json',

      data: { folio: folio, opcion: opcion },

      success: function (res) {
        for (var i = 0; i < res.length; i++) {
          tablaResumenp.row
            .add([
              res[i].folio_pagors,
              res[i].fecha_pagors,
              res[i].referencia_pagors,
              res[i].monto_pagors,
              res[i].metodo_pagors,
            ])
            .draw()
        }
      },
    })
  }

  //BOTON PAGAR
  $(document).on('click', '.btnPagar', function () {
    fila = $(this).closest('tr')
    folio_req = parseInt(fila.find('td:eq(0)').text())
    saldo = fila.find('td:eq(5)').text()

    $('formPago').trigger('reset')

    $('#foliovp').val(folio_req)
    $('#conceptovp').val('')
    $('#obsvp').val('')
    $('#saldovp').val(saldo)
    $('#montpagovp').val('')
    $('#metodovp').val('')
    $('#id_prov').val(id_prov)

    $('#modalPago').modal('show')
  })

  //BOTON GUARDAR PAGO
  $(document).on('click', '#btnGuardarvp', function () {
    var folioreq = $('#foliovp').val()
    var fechavp = $('#fechavp').val()

    var referenciavp = $('#referenciavp').val()
    var observacionesvp = $('#observacionesvp').val()
    var saldovp = $('#saldovp').val()
    saldovp = saldovp.replace(/,/g, '')
    var montovp = $('#montopagovp').val()
    montovp = montovp.replace(/,/g, '')
    var metodovp = $('#metodovp').val()
    var usuario = $('#nameuser').val()
    var opcion = 3

    if (
      folioreq.length == 0 ||
      fechavp.length == 0 ||
      referenciavp.length == 0 ||
      montovp.length == 0 ||
      metodovp.length == 0 ||
      usuario.length == 0
    ) {
      swal.fire({
        title: 'Datos Incompletos',
        text: 'Verifique sus datos',
        icon: 'warning',
        focusConfirm: true,
        confirmButtonText: 'Aceptar',
      })
    } else {
      $.ajax({
        url: 'bd/buscarsaldo.php',
        type: 'POST',
        dataType: 'json',
        async: false,
        data: {
          folioreq: folioreq,
          opcion: opcion,
        },
        success: function (res) {
          saldovp = res
        },
      })

      if (parseFloat(saldovp) < parseFloat(montovp)) {
        swal.fire({
          title: 'Pago Excede el Saldo',
          text:
            'El pago no puede exceder el sado de la cuenta, Verifique el monto del Pago',
          icon: 'warning',
          focusConfirm: true,
          confirmButtonText: 'Aceptar',
        })
        $('#saldovp').val(saldovp)
      } else {
        saldofin = saldovp - montovp

        opcion = 1
        $.ajax({
          url: 'bd/pagoreq.php',
          type: 'POST',
          dataType: 'json',
          async: false,
          data: {
            folioreq: folioreq,
            fechavp: fechavp,
            observacionesvp: observacionesvp,
            referenciavp: referenciavp,
            saldovp: saldovp,
            montovp: montovp,
            saldofin: saldofin,
            metodovp: metodovp,
            usuario: usuario,
            opcion: opcion,
          },
          success: function (res) {
          
            if (res == 1) {
              operacionexitosa()
              $('#modalPago').modal('hide')
              window.location.reload()
            } else {
              Swal.fire({
                title: 'La operación no pudo ser registrada',
                icon: 'error',
              })
            }
          },
        })
      }
    }
  })

  //BOTON CANCELAR SUBCONTRATO
  $(document).on('click', '.btnCancelar', function () {
    fila = $(this).closest('tr')
    folio = parseInt(fila.find('td:eq(0)').text())

    saldo = fila.find('td:eq(8)').text().replace(/,/g, '')
    monto = fila.find('td:eq(7)').text().replace(/,/g, '')

    if (parseFloat(monto) == parseFloat(saldo)) {
      $('#formcan').trigger('reset')
      $('#modalcan').modal('show')
      $('#foliocan').val(folio)
      $('#tipodoc').val(1) // 1 PARA SUBCONTRATOS
    } else {
      swal.fire({
        title: 'No es posible Cancelar el Subcontrato',
        text: 'El documento ya tiene operaciones posteriores',
        icon: 'warning',
        focusConfirm: true,
        confirmButtonText: 'Aceptar',
      })
    }
  })

  // BOTON CANCELAR PROVISION

  $(document).on('click', '.btnCancelarprov', function () {
    fila = $(this).closest('tr')
    folio = parseInt(fila.find('td:eq(0)').text())

    saldo = fila.find('td:eq(7)').text().replace(/,/g, '')
    monto = fila.find('td:eq(6)').text().replace(/,/g, '')

    if (parseFloat(monto) == parseFloat(saldo)) {
      $('#formcan').trigger('reset')
      $('#modalcan').modal('show')
      $('#foliocan').val(folio)
      $('#tipodoc').val(6) // 6 PROVISIONES
    } else {
      swal.fire({
        title: 'No es posible Cancelar el Subcontrato',
        text: 'El documento ya tiene operaciones posteriores',
        icon: 'warning',
        focusConfirm: true,
        confirmButtonText: 'Aceptar',
      })
    }
  })

  //BOTON CANCELAR REQUISICION
  $(document).on('click', '.btnCancelarreq', function () {
    fila = $(this).closest('tr')
    folio = parseInt(fila.find('td:eq(0)').text())

    saldo = fila.find('td:eq(4)').text().replace(/,/g, '')
    monto = fila.find('td:eq(5)').text().replace(/,/g, '')

    if (parseFloat(monto) == parseFloat(saldo)) {
      $('#formcan').trigger('reset')
      $('#modalcan').modal('show')
      $('#foliocan').val(folio)
      $('#tipodoc').val(2) // 1 PARA REQUISICIONES
    } else {
      swal.fire({
        title: 'No es posible Cancelar la Requisición',
        text: 'El documento ya tiene operaciones posteriores',
        icon: 'warning',
        focusConfirm: true,
        confirmButtonText: 'Aceptar',
      })
    }
  })

  //BOTON CANCELAR PAGO
  $(document).on('click', '.btnCancelarpago', function () {
    fila = $(this).closest('tr')
    folio = parseInt(fila.find('td:eq(0)').text())

    saldo = fila.find('td:eq(4)').text().replace(/,/g, '')
    monto = fila.find('td:eq(5)').text().replace(/,/g, '')

    $('#formcan').trigger('reset')
    $('#modalcan').modal('show')
    $('#foliocan').val(folio)
    $('#tipodoc').val(3) // 3 PARA PAGOS DE REQUISICIONES
  })



  // GUARDAR CANCELAR
  $(document).on('click', '#btnGuardarCAN', function () {
    foliocan = $('#foliocan').val()
    motivo = $('#motivo').val()
    fecha = $('#fecha').val()
    usuario = $('#nameuser').val()
    tipodoc = $('#tipodoc').val()

    if (motivo === '') {
      swal.fire({
        title: 'Datos Incompletos',
        text: 'Verifique sus datos',
        icon: 'warning',
        focusConfirm: true,
        confirmButtonText: 'Aceptar',
      })
    } else {
      $.ajax({
        type: 'POST',
        url: 'bd/cancelaregresos.php',
        async: false,
        dataType: 'json',
        data: {
          foliocan: foliocan,
          motivo: motivo,
          fecha: fecha,
          tipodoc: tipodoc,
          usuario: usuario,
        },
        success: function (res) {
          if (res == 1) {
            mensaje()
            $('#modalcan').modal('hide')
            location.reload()
          } else {
            mensajeerror()
          }
        },
      })
    }
  })


  //boton definir monto cobrado

$(document).on('click', '.btnCobrado', function () {
  fila = $(this).closest('tr')
  folio = parseInt(fila.find('td:eq(0)').text())

 

  $('#formcobrar').trigger('reset')
  $('#modalcobrar').modal('show')
  $('#foliosubcob').val(folio)
  
})

  // GUARDAR MONTO COBRADO
  $(document).on('click', '#btnGuardarcobro', function () {
    foliosubcob = $('#foliosubcob').val()
  
    montocobrado =$('#montocobrado').val().replace(/,/g, '') 

    if (montocobrado === '') {
      swal.fire({
        title: 'Datos Incompletos',
        text: 'Verifique sus datos',
        icon: 'warning',
        focusConfirm: true,
        confirmButtonText: 'Aceptar',
      })
    } else {
      $.ajax({
        type: 'POST',
        url: 'bd/guardarimportecobrado.php',
        async: false,
        dataType: 'json',
        data: {
          foliosubcob: foliosubcob,
          montocobrado: montocobrado,
        },
        success: function (res) {
          if (res == 1) {
            swal.fire({
              title: 'Registrado Guardado',
              icon: 'success',
              focusConfirm: true,
              confirmButtonText: 'Aceptar',
            })
            $('#modalcobrar').modal('hide')
            location.reload()
          } else {
            swal.fire({
              title: 'Error al Guardar el Registro',
              icon: 'error',
              focusConfirm: true,
              confirmButtonText: 'Aceptar',
            })
          }
        },
      })
    }
  })
  function subcontratoguardado() {
    swal.fire({
      title: 'Subcontrato Guardado',
      icon: 'success',
      focusConfirm: true,
      confirmButtonText: 'Aceptar',
    })
  }

  function subcontratoerror() {
    swal.fire({
      title: 'Error al Guardar el Registro',
      icon: 'error',
      focusConfirm: true,
      confirmButtonText: 'Aceptar',
    })
  }
  function operacionexitosa() {
    swal.fire({
      title: 'Pago Registrado',
      icon: 'success',
      focusConfirm: true,
      confirmButtonText: 'Aceptar',
    })
  }
  function mensaje() {
    swal.fire({
      title: 'Registro Cancelado',
      icon: 'warning',
      focusConfirm: true,
      confirmButtonText: 'Aceptar',
    })
  }

  function mensajeerror() {
    swal.fire({
      title: 'Error al Cancelar el Registro',
      icon: 'error',
      focusConfirm: true,
      confirmButtonText: 'Aceptar',
    })
  }

  $('#btnBuscar').click(function () {
    var inicio = $('#inicio').val()
    var final = $('#final').val()

    tablaVis.clear()
    tablaVis.draw()



    if (inicio != '' && final != '') {
      $.ajax({
        type: 'POST',
        url: 'bd/buscarcxp.php',
        dataType: 'json',
        data: { inicio: inicio, final: final, opcion: opcion },
        success: function (data) {
          for (var i = 0; i < data.length; i++) {
            tablaVis.row
              .add([
                data[i].folio_cxp,
                data[i].tipo_cxp,
                data[i].clave_cxp,
                data[i].corto_obra,
                data[i].id_prov,
                data[i].razon_prov,
                data[i].fecha_cxp,
                data[i].desc_cxp,
                new Intl.NumberFormat('es-MX').format(
                  Math.round(data[i].monto_cxp * 100, 2) / 100,
                ),
                new Intl.NumberFormat('es-MX').format(
                  Math.round(data[i].saldo_cxp * 100, 2) / 100,
                ),
              ])
              .draw()

            //tabla += '<tr><td>' + res[i].id_objetivo + '</td><td>' + res[i].desc_objetivo + '</td><td class="text-center">' + icono + '</td><td class="text-center"></td></tr>';
          }
        },
      })
    } else {
      alert('Selecciona ambas fechas')
    }
  })

  var fila

  function startTime() {
    var today = new Date()
    var hr = today.getHours()
    var min = today.getMinutes()
    var sec = today.getSeconds()
    //Add a zero in front of numbers<10
    min = checkTime(min)
    sec = checkTime(sec)
    document.getElementById('clock').innerHTML = hr + ' : ' + min + ' : ' + sec
    var time = setTimeout(function () {
      startTime()
    }, 500)
  }

  function checkTime(i) {
    if (i < 10) {
      i = '0' + i
    }
    return i
  }
})

function filterFloat(evt, input) {
  // Backspace = 8, Enter = 13, ‘0′ = 48, ‘9′ = 57, ‘.’ = 46, ‘-’ = 43
  var key = window.Event ? evt.which : evt.keyCode
  var chark = String.fromCharCode(key)
  var tempValue = input.value + chark
  var isNumber = key >= 48 && key <= 57
  var isSpecial = key == 8 || key == 13 || key == 0 || key == 46
  if (isNumber || isSpecial) {
    return filter(tempValue)
  }

  return false
}
function filter(__val__) {
  var preg = /^([0-9]+\.?[0-9]{0,2})$/
  return preg.te
  st(__val__) === true
}

$('.modal-header').on('mousedown', function (mousedownEvt) {
  var $draggable = $(this)
  var x = mousedownEvt.pageX - $draggable.offset().left,
    y = mousedownEvt.pageY - $draggable.offset().top
  $('body').on('mousemove.draggable', function (mousemoveEvt) {
    $draggable.closest('.modal-dialog').offset({
      left: mousemoveEvt.pageX - x,
      top: mousemoveEvt.pageY - y,
    })
  })
  $('body').one('mouseup', function () {
    $('body').off('mousemove.draggable')
  })
  $draggable.closest('.modal').one('bs.modal.hide', function () {
    $('body').off('mousemove.draggable')
  })
})
