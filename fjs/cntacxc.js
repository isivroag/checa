$(document).ready(function() {
    var id, opcion;
    opcion = 4;

    // TOOLTIP DATATABLE
    $('[data-toggle="tooltip"]').tooltip()

        //FUNCION REDONDEAR
        function round(value, decimals) {
            return Number(Math.round(value + "e" + decimals) + "e-" + decimals);
        }  

    //FUNCION FORMATO MONEDA 
    document.getElementById("montopagovp").onblur = function () {

        //number-format the user input
        this.value = parseFloat(this.value.replace(/,/g, ""))
            .toFixed(2)
            .toString()
            .replace(/\B(?=(\d{3})+(?!\d))/g, ",");


    }

    // SOLO NUMEROS NUEVOS CAMPOS
  document.getElementById('importe').onblur = function () {
    calculosubtotal(this.value.replace(/,/g, ''))
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

 

// TERMINA SOLO NUMEROS NUEVOS CAMPOS

//NUEVOS CALCULOS
function calculosubtotal(valor) {

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

function calculototal(valor) {

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

//TERMINA NUEVOS CALCULOS

       //CALCULO TOTAL REQ
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
//CALCULO SUBTOTAL REQ
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

    // SOLO NUMEROS SUBTOTAL FACTURA
    document.getElementById('subtotalreq').onblur = function () {
        calculototalreq(this.value.replace(/,/g, ''))
        this.value = parseFloat(this.value.replace(/,/g, ''))
            .toFixed(2)
            .toString()
            .replace(/\B(?=(\d{3})+(?!\d))/g, ',')
    }
    // SOLO NUMEROS IVA FACTURA
    document.getElementById('ivareq').onblur = function () {
        this.value = parseFloat(this.value.replace(/,/g, ''))
            .toFixed(2)
            .toString()
            .replace(/\B(?=(\d{3})+(?!\d))/g, ',')
    }
    // SOLO NUMEROS MONTO FACTURA
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
    // SOLO NUMEROS MONTO
    document.getElementById('montopagovp').onblur = function () {
        this.value = parseFloat(this.value.replace(/,/g, ''))
            .toFixed(2)
            .toString()
            .replace(/\B(?=(\d{3})+(?!\d))/g, ',')
    }

    //retenciones

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
/*
    document.getElementById('ret4').onblur = function () {
      caluloconret()
    }*/
    // TABLA PRINCIPAL

    tablaVis = $("#tablaV").DataTable({
        dom: "<'row justify-content-center'<'col-sm-12 col-md-4 form-group'l><'col-sm-12 col-md-4 form-group'B><'col-sm-12 col-md-4 form-group'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",

        buttons: [{
                extend: "excelHtml5",
                text: "<i class='fas fa-file-excel'> Excel</i>",
                titleAttr: "Exportar a Excel",
                title: "Reporte de Venta",
                className: "btn bg-success ",
                exportOptions: { columns: [0, 1, 2, 3, 4, 5] },
            },
            {
                extend: "pdfHtml5",
                text: "<i class='far fa-file-pdf'> PDF</i>",
                titleAttr: "Exportar a PDF",
                title: "Reporte de Venta",
                className: "btn bg-danger",
                exportOptions: { columns: [0, 1, 2, 3, 4, 5] },
            },
        ],
        stateSave: true,

        columnDefs: [{
            targets: -1,
            data: null,
            defaultContent:  "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-primary btnEditar'  data-toggle='tooltip' data-placement='top' title='Editar'><i class='fas fa-edit'></i></button>\
            <button class='btn btn-sm bg-success btnPagar'><i class='fas fa-dollar-sign'  data-toggle='tooltip' data-placement='top' title='Pagar'></i></button>\
            <button class='btn btn-sm bg-info btnResumen'><i class='fas fa-bars'  data-toggle='tooltip' data-placement='top' title='Resumen de Pagos'></i></button>\
            <button class='btn btn-sm bg-danger btnCancelar'  data-toggle='tooltip' data-placement='top' title='Cancelar'><i class='fas fa-ban'></i></button>\
            </div></div>",
        },
        { className: "hide_column", targets: [7] },
        { className: "hide_column", targets: [8] },
        { className: "hide_column", targets: [9] },
        { className: "hide_column", targets: [10] },
        { className: "hide_column", targets: [11] },
        { className: "hide_column", targets: [12] },
        { className: "hide_column", targets: [13] },
        { className: "hide_column", targets: [14] },
        { className: "hide_column", targets: [15] },
       
    
    ],
    rowCallback: function (row, data) {
        
        $($(row).find('td')['5']).addClass('text-right')
        $($(row).find('td')['6']).addClass('text-right')
        $($(row).find('td')['5']).addClass('currency')
        $($(row).find('td')['6']).addClass('currency')
      
      
  
       
      },
      
        language: {
            lengthMenu: "Mostrar _MENU_ registros",
            zeroRecords: "No se encontraron resultados",
            info: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            infoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
            infoFiltered: "(filtrado de un total de _MAX_ registros)",
            sSearch: "Buscar:",
            oPaginate: {
                sFirst: "Primero",
                sLast: "Último",
                sNext: "Siguiente",
                sPrevious: "Anterior",
            },
            sProcessing: "Procesando...",
        },
    });

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

            // TABLA RESUMEN DE PAGOS
    tablaResumen = $("#tablaResumen").DataTable({

        rowCallback: function (row, data) {

            $($(row).find('td')['3']).addClass('text-right')
            $($(row).find('td')['3']).addClass('currency')

        }, columnDefs: [
            {
                targets: -1,
                data: null,
                defaultContent:
                  "<div class='text-center'><button class='btn btn-sm bg-danger btnCancelarpago' data-toggle='tooltip' data-placement='top' title='Cancelar'><i class='fas fa-ban'></i></button>\
                            </div></div>",
              },

            {
                targets: 3,
                render: function (data, type, full, meta) {
                    return Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
                        parseFloat(data).toFixed(2),
                    )
                  
                },
            },
        ],

        language: {
            lengthMenu: "Mostrar _MENU_ registros",
            zeroRecords: "No se encontraron resultados",
            info: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            infoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
            infoFiltered: "(filtrado de un total de _MAX_ registros)",
            sSearch: "Buscar:",
            oPaginate: {
                sFirst: "Primero",
                sLast: "Último",
                sNext: "Siguiente",
                sPrevious: "Anterior",
            },
            sProcessing: "Procesando...",
        },
        "footerCallback": function (row, data, start, end, display) {
            var api = this.api(), data;


            var intVal = function (i) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '') * 1 :
                    typeof i === 'number' ?
                        i : 0;
            };


            total = api
                .column(3)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            pageTotal = api
                .column(3, { page: 'current' })
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);


            $(api.column(3).footer()).html(
                Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
                    parseFloat(total ).toFixed(2),
                )
               
            );
        }
    });


            //BOTON NUEVO
    $('#btnNuevo').click(function () {
        $('#formReq').trigger('reset')
        $('#modalReq').modal('show')
        id = null
        opcion = 1
    })

      //BOTON EDITAR
  $(document).on('click', '.btnEditar', function () {
    fila = $(this).closest('tr')
    folio = parseInt(fila.find('td:eq(0)').text())

    saldo = fila.find('td:eq(5)').text()
    monto = fila.find('td:eq(6)').text()
    
    montob = fila.find('td:eq(7)').text()
    ret1 = fila.find('td:eq(8)').text()
    ret2 = fila.find('td:eq(9)').text()
    ret3 = fila.find('td:eq(10)').text()
    importe = fila.find('td:eq(11)').text()
    descuento = fila.find('td:eq(12)').text()
    devolucion = fila.find('td:eq(13)').text()
    subtotal = fila.find('td:eq(14)').text()
    iva = fila.find('td:eq(15)').text()

    if (monto == saldo) {
      opcion = 2

      $.ajax({
        url: 'bd/buscarfactura.php',
        type: 'POST',
        dataType: 'json',
        data: {
          folio: folio,
          opcion: opcion,
        },
        success: function (data) {
          if (data != null) {
            factura=data[0].factura_cxc;
            fecha=data[0].fecha_cxc;
            id_obra=data[0].id_obra;
            obra=data[0].corto_obra;
            
            descripcion=data[0].desc_cxc;
           /* subtotal= Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
              parseFloat(data[0].subtotal_cxc).toFixed(2),
            );
            iva= Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
              parseFloat(data[0].iva_cxc).toFixed(2),
            );
            monto= Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
              parseFloat(data[0].monto_cxc).toFixed(2),
            );
*/
           $('#folioreq').val(folio);
            $('#fechareq').val(fecha);
            $('#facturareq').val(factura);
             $('#id_obra').val(id_obra);
             $('#obra').val(obra);
          
             $('#descripcionreq').val(descripcion);
             $('#montoreq').val(monto)
             $('#ivareq').val(iva);
             $('#subtotalreq').val(subtotal);

             $('#importe').val(importe);
             $('#ret1').val(ret1);
             $('#ret2').val(ret2);
             $('#ret3').val(ret3);
             $('#descuento').val(descuento);
             $('#devolucion').val(devolucion);
             $('#montoreqa').val(montob);
             






            } else {
            Swal.fire({
              title: 'Subcontrato no encontrado',
              icon: 'warning',
            })
          }
        },
      })
      $('#modalReq').modal('show')
    } else {
      swal.fire({
        title: 'No es posible editar la Factura',
        text: 'El documento ya tiene operaciones posteriores',
        icon: 'warning',
        focusConfirm: true,
        confirmButtonText: 'Aceptar',
      })
    }
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



      //BOTON GUARDAR FACTURA
      $(document).on('click', '#btnGuardarreq', function () {
        folio = $('#folioreq').val()
        fecha = $('#fechareq').val()
        factura = $('#facturareq').val()
        id_obra = $('#id_obra').val()
       
  
        descripcion = $('#descripcionreq').val()
        subtotal = $('#subtotalreq').val().replace(/,/g, '')
        iva = $('#ivareq').val().replace(/,/g, '')
        montob = $('#montoreqa').val().replace(/,/g, '')
        monto = $('#montoreq').val().replace(/,/g, '')
        ret1 = $('#ret1').val().replace(/,/g, '')
        ret2 = $('#ret2').val().replace(/,/g, '')
        ret3 = $('#ret3').val().replace(/,/g, '')
        importe = $('#importe').val().replace(/,/g, '')
        descuento = $('#descuento').val().replace(/,/g, '')
        devolucion = $('#devolucion').val().replace(/,/g, '')
     //   ret4 = $('#ret4').val().replace(/,/g, '')

        if (
            fecha.length == 0 ||
            factura.length == 0 ||
            id_obra.length == 0 ||
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
                url: 'bd/crudingreso.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    folio: folio,
                    fecha: fecha,
                    factura: factura,
                    id_obra: id_obra,
                    descripcion: descripcion,
                    subtotal: subtotal,
                    iva: iva,
                    monto: monto,
                    ret1: ret1,
                    ret2: ret2,
                    ret3: ret3,
                    importe: importe,
                    devolucion: devolucion,
                    descuento: descuento,
                    montob: montob,
                    opcion: opcion,
                },
                success: function (data) {
                    if (data == 1) {
                        facturaexitosa()
                         window.location.href = 'cntacxc.php'
                    } else {
                        facturaerror()
                    }
                },
                error: function()  {
                    console.log("ERROR EN FUNCION")
                }
            })
        }
    })

    //BOTON RESUMEN DE PAGOS

    $(document).on("click", ".btnResumen", function() {
        fila = $(this).closest("tr");
        id = parseInt(fila.find("td:eq(0)").text());
        buscarpagos(id);
        $("#modalResumen").modal("show");
    });

    //FUNCION BUSCARPAGOS
    function buscarpagos(folio) {
        tablaResumen.clear();
        tablaResumen.draw();
        opcion=1; // 1 para cuentas por cobrar
        $.ajax({
            type: "POST",
            url: "bd/buscarpagocxp.php",
            dataType: "json",

            data: { folio: folio, opcion: opcion },

            success: function(res) {
                for (var i = 0; i < res.length; i++) {
                    tablaResumen.row
                        .add([
                            res[i].folio_pagocxc,
                            res[i].fecha_pagocxc,
                            res[i].referencia_pagocxc,
                            res[i].monto_pagocxc,
                            res[i].metodo_pagocxc,
                        ])
                        .draw();

                    //tabla += '<tr><td>' + res[i].id_objetivo + '</td><td>' + res[i].desc_objetivo + '</td><td class="text-center">' + icono + '</td><td class="text-center"></td></tr>';
                }
            },
        });
    }
 
 
//BOTON PAGAR
    $(document).on('click', '.btnPagar', function () {
        fila = $(this).closest("tr");
        folio_cxc = parseInt(fila.find("td:eq(0)").text());
        saldo = fila.find("td:eq(6)").text();
        $('formPago').trigger("reset");

        $('#foliovp').val(folio_cxc);
        $('#conceptovp').val('');
        $('#obsvp').val('');
        $('#saldovp').val(saldo);
        $('#montpagovp').val('');
        $('#metodovp').val('');
    
       
        $('#modalPago').modal('show');
      })

      // GUARDAR PAGO
      $(document).on('click', '#btnGuardarvp', function () {
        var foliocxc = $('#foliovp').val()
        var fechavp = $('#fechavp').val()
        var referenciavp = $('#referenciavp').val()
        var observacionesvp = $('#observacionesvp').val()
        var saldovp = $('#saldovp').val()
        saldovp = saldovp.replace(/,/g, '')
        var montovp = $('#montopagovp').val()
        montovp = montovp.replace(/,/g, '')
        montovp=montovp.replace(",", "");
        var metodovp = $('#metodovp').val()
        var usuario = $('#nameuser').val()
        var opcion=1
      
    
        if (
            foliocxc.length == 0 ||
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
                        foliocxc: foliocxc,opcion: opcion
                    },
                    success: function (res) {
                    saldovp = res;
               
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
            saldofin = saldovp - montovp;
           
            opcion = 1;
            $.ajax({
              url: 'bd/pagocxc.php',
              type: 'POST',
              dataType: 'json',
              async: false,
              data: {
                foliocxc: foliocxc,
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

             
                operacionexitosa();
                $('#modalPago').modal('hide')
                window.location.reload();
            
              },
            })
          }
        }
      })
      //BOTON CANCELAR CXC

    $(document).on("click", ".btnCancelar", function() {
        fila = $(this).closest("tr");

        folio = parseInt(fila.find('td:eq(0)').text())

            saldo = fila.find('td:eq(6)').text().replace(/,/g, '')
            monto = fila.find('td:eq(5)').text().replace(/,/g, '')
        console.log(saldo)
        console.log(monto)
            if (monto == saldo) {
            $("#formcan").trigger("reset");
          
            $("#modalcan").modal("show");
            $('#foliocan').val(folio)
            $('#tipodoc').val(1)// 1 CUENTA POR COBRAR
        } else {
            swal.fire({
                title: "¡No es posible cancelar la Factura!",
                text: "El documento ya tiene operaciones posteriores",
                icon: "error",
                focusConfirm: true,
                confirmButtonText: "Aceptar",
            });
        }


    });

    $(document).on('click', '.btnCancelarpago', function () {
        fila = $(this).closest('tr')
        folio = parseInt(fila.find('td:eq(0)').text())
    
    
      
          $('#formcan').trigger('reset')
          $('#modalcan').modal('show')
          $('#foliocan').val(folio)
          $('#tipodoc').val(2) // 2 PARA PAGOS DE CXC
       
      })

  //GUARDAR CANCELAR
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
        url: 'bd/cancelaringresos.php',
        async: false,
        dataType: 'json',
        data: {
          foliocan: foliocan,
          motivo: motivo,
          fecha: fecha,
          usuario: usuario,
          tipodoc: tipodoc
        },
        success: function (res) {
          if (res == 1) {
            $('#modalcan').modal('hide')
            mensaje()

            location.reload()
          } else {
            mensajeerror()
          }
        },
      })
    }
  })

    function facturaexitosa() {
        swal.fire({
            title: "Factura Registrada",
            icon: "success",
            focusConfirm: true,
            confirmButtonText: "Aceptar",
        });
    }


    function facturaerror() {
        swal.fire({
            title: "Factura No Registrada",
            icon: "error",
            focusConfirm: true,
            confirmButtonText: "Aceptar",
        });
    }
    function operacionexitosa() {
        swal.fire({
            title: "Pago Registrado",
            icon: "success",
            focusConfirm: true,
            confirmButtonText: "Aceptar",
        });
    }
    function mensaje() {
        swal.fire({
            title: "Registro Cancelado",
            icon: "success",
            focusConfirm: true,
            confirmButtonText: "Aceptar",
        });
    }

    function mensajeerror() {
        swal.fire({
            title: "Error al Cancelar el Registro",
            icon: "error",
            focusConfirm: true,
            confirmButtonText: "Aceptar",
        });
    }


    $(document).on('click', '#btnBuscar', function () {
        var inicio = $("#inicio").val();
        var final = $("#final").val();
        var opcion = 1;

        tablaVis.clear();
        tablaVis.draw();

  

        if (inicio != "" && final != "") {
            $.ajax({
                type: "POST",
                url: "bd/buscarcxc.php",                
                dataType: "json",
                data: { inicio: inicio, final: final, opcion: opcion },
                success: function(data) {
                    
                    for (var i = 0; i < data.length; i++) {
                        tablaVis.row
                            .add([
                                
                                data[i].folio_cxc,
                                data[i].factura_cxc,
                                data[i].corto_obra,
                                data[i].fecha_cxc,
                                data[i].desc_cxc,
                                Intl.NumberFormat('es-MX',{minimumFractionDigits: 2,}).format(parseFloat( data[i].monto_cxc).toFixed(2)),
                                Intl.NumberFormat('es-MX',{minimumFractionDigits: 2,}).format(parseFloat( data[i].saldo_cxc).toFixed(2)),

                            ])
                            .draw();

                    
                    }
                },
            });
        } else {
            alert("Selecciona ambas fechas");
        }
    });

 

   
    var fila; //capturar la fila para editar o borrar el registro

   

  


  
    function startTime() {
        var today = new Date();
        var hr = today.getHours();
        var min = today.getMinutes();
        var sec = today.getSeconds();
        //Add a zero in front of numbers<10
        min = checkTime(min);
        sec = checkTime(sec);
        document.getElementById("clock").innerHTML = hr + " : " + min + " : " + sec;
        var time = setTimeout(function() {
            startTime();
        }, 500);
    }

    function checkTime(i) {
        if (i < 10) {
            i = "0" + i;
        }
        return i;
    }
});

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


$(".modal-header").on("mousedown", function (mousedownEvt) {
    var $draggable = $(this);
    var x = mousedownEvt.pageX - $draggable.offset().left,
        y = mousedownEvt.pageY - $draggable.offset().top;
    $("body").on("mousemove.draggable", function (mousemoveEvt) {
        $draggable.closest(".modal-dialog").offset({
            "left": mousemoveEvt.pageX - x,
            "top": mousemoveEvt.pageY - y
        });
    });
    $("body").one("mouseup", function () {
        $("body").off("mousemove.draggable");
    });
    $draggable.closest(".modal").one("bs.modal.hide", function () {
        $("body").off("mousemove.draggable");
    });
});