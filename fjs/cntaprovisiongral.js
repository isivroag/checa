$(document).ready(function () {
  var id, opcion
  opcion = 4
  // TOOLTIP DATATABLE
  $('[data-toggle="tooltip"]').tooltip()

  // FUNCION PERMISOS EDITAR POR USUARIO

  var textcolumnas = permisos()
  var textcolumnas2 = permisos2()

  // SOLO NUMEROS MONTO FACTURA
  /*
  document.getElementById('importe').onblur = function () {
    // calculosubtotalreq(this.value.replace(/,/g, ''))
    this.value = parseFloat(this.value.replace(/,/g, ''))
      .toFixed(2)
      .toString()
      .replace(/\B(?=(\d{3})+(?!\d))/g, ',')
  }*/

  
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

  document.getElementById('montoreqa').onblur = function () {
    calculosubtotalreq(this.value.replace(/,/g, ''))
    this.value = parseFloat(this.value.replace(/,/g, ''))
      .toFixed(2)
      .toString()
      .replace(/\B(?=(\d{3})+(?!\d))/g, ',')
  }


  function calculototalreq(valor) {
    subtotal = valor

    //descuento = $('#descuento').val().replace(/,/g, '')
    //devolucion = $('#devolucion').val().replace(/,/g, '')
/*
    if (descuento.length == 0) {
      descuento = 0
      $('#descuento').val('0.00')
    }

    if (devolucion.length == 0) {
      devolucion = 0
      $('#devolucion').val('0.00')
    }*/
    devolucion=0
    descuento=0

    //subtotal = (parseFloat(valor)+parseFloat(devolucion))-parseFloat(descuento)
    importe =
      parseFloat(subtotal) - parseFloat(devolucion) + parseFloat(descuento)

    total = round(subtotal * 1.16, 2)
    iva = total - subtotal

    $('#importe').val(
      Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
        parseFloat(importe).toFixed(2),
      ),
    )
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
    $('#montoreqa').val(
      Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
        parseFloat(total).toFixed(2),
      ),
    )

    //caluloconret()
  }

  function calculosubtotalreq(valor) {

    /*
    descuento = $('#descuento').val().replace(/,/g, '')
    devolucion = $('#devolucion').val().replace(/,/g, '')

    if (descuento.length == 0) {
      descuento = 0
      $('#descuento').val('0.00')
    }

    if (devolucion.length == 0) {
      devolucion = 0
      $('#devolucion').val('0.00')
    }
*/
devolucion=0
descuento=0
total = valor

    subtotal = round(total / 1.16, 2)
    importe =
      parseFloat(subtotal) - parseFloat(devolucion) + parseFloat(descuento)
    iva = round(total - subtotal, 2)
    $('#importe').val(
      Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
        parseFloat(importe).toFixed(2),
      ),
    )
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
    $('#montoreq').val(
      Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
        parseFloat(total).toFixed(2),
      ),
    )
    $('#montoreqa').val(
      Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
        parseFloat(total).toFixed(2),
      ),
    )
    //caluloconret()
  }
  
  
  //TERMINA NUEVOS CALCULOS

  // FUNCION PERMISOS EDITAR POR USUARIO

  

  var textcolumnas = permisos()
  var textcolumnas2 = permisos2()

  // PERMISOS TABLA PRINCIPAL
  function permisos() {
    var tipousuario = $('#tipousuario').val()
    var columnas = ''

    if (tipousuario == 1) {
      columnas =
        "<div class='text-center'><div class='btn-group'>\
        <button class='btn btn-sm bg-success btntrasladar'><i class='fas fa-share'  data-toggle='tooltip' data-placement='top' title='Trasladar a Cxp'></i></button>\
        <button class='btn btn-sm bg-info btnResumen'><i class='fas fa-bars'  data-toggle='tooltip' data-placement='top' title='Ver Cxp relacionadas'></i></button>\
        </div></div>"
    } else {
      columnas =
        "<div class='text-center'><div class='btn-group'>\
        <button class='btn btn-sm bg-success btntrasladar'><i class='fas fa-share'  data-toggle='tooltip' data-placement='top' title='Trasladar a Cxp'></i></button>\
        <button class='btn btn-sm bg-info btnResumen'><i class='fas fa-bars'  data-toggle='tooltip' data-placement='top' title='Ver Cxp relacionadas'></i></button>\
        <button class='btn btn-sm bg-warning btnSaldarprov' data-toggle='tooltip' data-placement='top' title='Saldar'><i class=' text-white fa-solid fa-circle-dollar-to-slot'></i></button>\
        <button class='btn btn-sm bg-danger btnCancelar'  data-toggle='tooltip' data-placement='top' title='Cancelar'><i class='fas fa-ban'></i></button>\
        </div></div>"
    }
    return columnas
  }

  //PERMISOS SECUNDARIOS

  function permisos2() {
    var tipousuario = $('#tipousuario').val()
    var columnas = ''

    if (tipousuario == 1) {
      columnas =
        "<div class='text-center'><div class='btn-group'><button class='btn btn-sm bg-primary btnVerpagos' data-toggle='tooltip' data-placement='top' title='Ver Pagos'><i class='fas fa-search-dollar'></i></button>\
        </div></div>"
    } else {
      columnas =
        "<div class='text-center'><div class='btn-group'><button class='btn btn-sm bg-primary btnVerpagos' data-toggle='tooltip' data-placement='top' title='Ver Pagos'><i class='fas fa-search-dollar'></i></button>\
        </div></div>"
    }
    return columnas
  }

  //FUNCION REDONDEAR
  function round(value, decimals) {
    return Number(Math.round(value + 'e' + decimals) + 'e-' + decimals)
  }

 

   // SOLO NUMEROS NUEVOS CAMPOS
   document.getElementById('importe2').onblur = function () {
    calculosubtotal2(this.value.replace(/,/g, ''))
    this.value = parseFloat(this.value.replace(/,/g, ''))
      .toFixed(2)
      .toString()
      .replace(/\B(?=(\d{3})+(?!\d))/g, ',')
  }

  document.getElementById('descuento2').onblur = function () {
    calculoantes2()
    this.value = parseFloat(this.value.replace(/,/g, ''))
      .toFixed(2)
      .toString()
      .replace(/\B(?=(\d{3})+(?!\d))/g, ',')
  }

  document.getElementById('devolucion2').onblur = function () {
    calculoantes2()
    this.value = parseFloat(this.value.replace(/,/g, ''))
      .toFixed(2)
      .toString()
      .replace(/\B(?=(\d{3})+(?!\d))/g, ',')
  }

  // TERMINA SOLO NUMEROS NUEVOS CAMPOS

  //NUEVOS CALCULOS
  function calculosubtotal2(valor) {
    descuento = $('#descuento2').val().replace(/,/g, '')
    devolucion = $('#devolucion2').val().replace(/,/g, '')

    if (descuento.length == 0) {
      descuento = 0
      $('#descuento2').val('0.00')
    }

    if (devolucion.length == 0) {
      devolucion = 0
      $('#devolucion2').val('0.00')
    }
    subtotal =
      parseFloat(valor) + parseFloat(devolucion) - parseFloat(descuento)

    total = round(subtotal * 1.16, 2)
    iva = total - subtotal

    $('#subtotalreq2').val(
      Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
        parseFloat(subtotal).toFixed(2),
      ),
    )
    $('#ivareq2').val(
      Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
        parseFloat(iva).toFixed(2),
      ),
    )
    $('#montoreq2').val(
      Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
        parseFloat(total).toFixed(2),
      ),
    )
    $('#montoreqa2').val(
      Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
        parseFloat(total).toFixed(2),
      ),
    )
    caluloconret2()
  }

  function calculototal2(valor) {
    descuento = $('#descuento2').val().replace(/,/g, '')
    devolucion = $('#devolucion2').val().replace(/,/g, '')

    if (descuento.length == 0) {
      descuento = 0
      $('#descuento2').val('0.00')
    }

    if (devolucion.length == 0) {
      devolucion = 0
      $('#devolucion2').val('0.00')
    }

    total = valor

    subtotal = round(total / 1.16, 2)
    importe =
      parseFloat(subtotal) - parseFloat(devolucion) + parseFloat(descuento)
    iva = round(total - subtotal, 2)
    $('#importe2').val(
      Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
        parseFloat(importe).toFixed(2),
      ),
    )
    $('#ivareq2').val(
      Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
        parseFloat(iva).toFixed(2),
      ),
    )
    $('#subtotalreq2').val(
      Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
        parseFloat(subtotal).toFixed(2),
      ),
    )
    $('#montoreq2').val(
      Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
        parseFloat(total).toFixed(2),
      ),
    )
    $('#montoreqa2').val(
      Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
        parseFloat(total).toFixed(2),
      ),
    )
    caluloconret2()
  }

  function calculoantes2() {
    valor = $('#importe2').val().replace(/,/g, '')
    descuento = $('#descuento2').val().replace(/,/g, '')
    devolucion = $('#devolucion2').val().replace(/,/g, '')
    if (descuento.length == 0) {
      descuento = 0
      $('#descuento2').val('0.00')
    }

    if (devolucion.length == 0) {
      devolucion = 0
      $('#devolucion2').val('0.00')
    }

    subtotal =
      parseFloat(valor) + parseFloat(devolucion) - parseFloat(descuento)

    total = round(subtotal * 1.16, 2)
    iva = total - subtotal

    $('#subtotalreq2').val(
      Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
        parseFloat(subtotal).toFixed(2),
      ),
    )
    $('#ivareq2').val(
      Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
        parseFloat(iva).toFixed(2),
      ),
    )
    $('#montoreq2').val(
      Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
        parseFloat(total).toFixed(2),
      ),
    )
    $('#montoreqa2').val(
      Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
        parseFloat(total).toFixed(2),
      ),
    )
    caluloconret2()
  }

  //CALCULO TOTAL REQ
  //CALCULO TOTAL REQ
  function calculototalreq2(valor) {
    subtotal = valor

    descuento = $('#descuento2').val().replace(/,/g, '')
    devolucion = $('#devolucion2').val().replace(/,/g, '')

    if (descuento.length == 0) {
      descuento = 0
      $('#descuento2').val('0.00')
    }

    if (devolucion.length == 0) {
      devolucion = 0
      $('#devolucion2').val('0.00')
    }

    //subtotal = (parseFloat(valor)+parseFloat(devolucion))-parseFloat(descuento)
    importe =
      parseFloat(subtotal) - parseFloat(devolucion) + parseFloat(descuento)

    total = round(subtotal * 1.16, 2)
    iva = total - subtotal

    $('#importe2').val(
      Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
        parseFloat(importe).toFixed(2),
      ),
    )
    $('#ivareq2').val(
      Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
        parseFloat(iva).toFixed(2),
      ),
    )
    $('#montoreq2').val(
      Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
        parseFloat(total).toFixed(2),
      ),
    )
    $('#montoreqa2').val(
      Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
        parseFloat(total).toFixed(2),
      ),
    )

    caluloconret2()
  }
  //CALCULO SUBTOTAL REQ
  function calculosubtotalreq2(valor) {
    descuento = $('#descuento2').val().replace(/,/g, '')
    devolucion = $('#devolucion2').val().replace(/,/g, '')

    if (descuento.length == 0) {
      descuento = 0
      $('#descuento2').val('0.00')
    }

    if (devolucion.length == 0) {
      devolucion = 0
      $('#devolucion2').val('0.00')
    }

    total = valor

    subtotal = round(total / 1.16, 2)
    importe =
      parseFloat(subtotal) - parseFloat(devolucion) + parseFloat(descuento)
    iva = round(total - subtotal, 2)
    $('#importe2').val(
      Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
        parseFloat(importe).toFixed(2),
      ),
    )
    $('#ivareq2').val(
      Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
        parseFloat(iva).toFixed(2),
      ),
    )
    $('#subtotalreq2').val(
      Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
        parseFloat(subtotal).toFixed(2),
      ),
    )
    $('#montoreq2').val(
      Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
        parseFloat(total).toFixed(2),
      ),
    )
    $('#montoreqa2').val(
      Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
        parseFloat(total).toFixed(2),
      ),
    )
    caluloconret2()
  }

  function caluloconret2() {
    total = $('#montoreqa2').val().replace(/,/g, '')
    ret1 = $('#ret12').val().replace(/,/g, '')
    ret2 = $('#ret22').val().replace(/,/g, '')
    ret3 = $('#ret32').val().replace(/,/g, '')
    //  ret4=$('#ret4').val().replace(/,/g, '')

    if (ret1.length == 0) {
      ret1 = 0
      $('#ret12').val(
        Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
          parseFloat(ret1).toFixed(2),
        ),
      )
    }

    if (ret2.length == 0) {
      ret2 = 0
      $('#ret22').val(
        Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
          parseFloat(ret2).toFixed(2),
        ),
      )
    }

    if (ret3.length == 0) {
      ret3 = 0
      $('#ret32').val(
        Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
          parseFloat(ret3).toFixed(2),
        ),
      )
    }
    /*
        if(ret4.length==0){
            ret4=0;
            $("#ret4").val( Intl.NumberFormat('es-MX',{minimumFractionDigits: 2,}).format(parseFloat(ret4).toFixed(2)));
          
        }*/

    retenciones = parseFloat(ret1) + parseFloat(ret2) + parseFloat(ret3)
    calculo = parseFloat(total) - parseFloat(retenciones)
    $('#montoreq2').val(
      Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
        parseFloat(calculo).toFixed(2),
      ),
    )
  }

  // SOLO NUMEROS SUBTOTAL FACTURA
  document.getElementById('subtotalreq2').onblur = function () {
    calculototalreq2(this.value.replace(/,/g, ''))
    this.value = parseFloat(this.value.replace(/,/g, ''))
      .toFixed(2)
      .toString()
      .replace(/\B(?=(\d{3})+(?!\d))/g, ',')
  }
  // SOLO NUMEROS IVA FACTURA
  document.getElementById('ivareq2').onblur = function () {
    this.value = parseFloat(this.value.replace(/,/g, ''))
      .toFixed(2)
      .toString()
      .replace(/\B(?=(\d{3})+(?!\d))/g, ',')
  }
  // SOLO NUMEROS MONTO FACTURA
  document.getElementById('montoreq2').onblur = function () {
    // calculosubtotalreq(this.value.replace(/,/g, ''))
    this.value = parseFloat(this.value.replace(/,/g, ''))
      .toFixed(2)
      .toString()
      .replace(/\B(?=(\d{3})+(?!\d))/g, ',')
  }

  document.getElementById('montoreqa2').onblur = function () {
    calculosubtotalreq2(this.value.replace(/,/g, ''))
    this.value = parseFloat(this.value.replace(/,/g, ''))
      .toFixed(2)
      .toString()
      .replace(/\B(?=(\d{3})+(?!\d))/g, ',')
  }

  //retenciones

  document.getElementById('ret12').onblur = function () {
    caluloconret2()
    this.value = parseFloat(this.value.replace(/,/g, ''))
      .toFixed(2)
      .toString()
      .replace(/\B(?=(\d{3})+(?!\d))/g, ',')
  }

  document.getElementById('ret22').onblur = function () {
    caluloconret2()
    this.value = parseFloat(this.value.replace(/,/g, ''))
      .toFixed(2)
      .toString()
      .replace(/\B(?=(\d{3})+(?!\d))/g, ',')
  }

  document.getElementById('ret32').onblur = function () {
    caluloconret2()
    this.value = parseFloat(this.value.replace(/,/g, ''))
      .toFixed(2)
      .toString()
      .replace(/\B(?=(\d{3})+(?!\d))/g, ',')
  }

  //TERMINA NUEVOS CALCULOS
  // TABLA PRINCIPAL

  tablaVis = $('#tablaV').DataTable({
    rowCallback: function (row, data) {
      $($(row).find('td')['3']).addClass('text-right')
      $($(row).find('td')['4']).addClass('text-right')
      $($(row).find('td')['3']).addClass('currency')
      $($(row).find('td')['4']).addClass('currency')
    },
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
        exportOptions: { columns: [0, 1, 2, 3, 4] },
      },
      {
        extend: 'pdfHtml5',
        text: "<i class='far fa-file-pdf'> PDF</i>",
        titleAttr: 'Exportar a PDF',
        title: 'Listado de Egresos',
        className: 'btn bg-danger',
        exportOptions: { columns: [0, 1, 2, 3, 4] },
      },
    ],
    stateSave: true,

    columnDefs: [
      {
        targets: -1,
        data: null,
        defaultContent: textcolumnas,
        /* */
      },
     // { className: 'hide_column', targets: [4] },
     { className: 'hide_column', targets: [1] },
    /* 
      { width: '30%', targets: 6 },
      { width: '20%', targets: 2 },
      { width: '20%', targets: 4 },
      { width: '8%', targets: 5 },
      { width: '8%', targets: 7 },
      { width: '8%', targets: 8 },*/
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

  // TABLA RESUMEN DE PAGOS
  tablaResumen = $('#tablaResumen').DataTable({
    rowCallback: function (row, data) {
      $($(row).find('td')['3']).addClass('text-right')
      $($(row).find('td')['3']).addClass('currency')
      $($(row).find('td')['4']).addClass('text-right')
      $($(row).find('td')['4']).addClass('currency')
    },
    columnDefs: [
      {
        targets: -1,
        data: null,
        defaultContent: textcolumnas2,
      },
      {
        targets: 3,
        render: function (data, type, full, meta) {
          return Intl.NumberFormat('es-MX', {
            minimumFractionDigits: 2,
          }).format(parseFloat(data).toFixed(2))
        },
      },
      {
        targets: 4,
        render: function (data, type, full, meta) {
          return Intl.NumberFormat('es-MX', {
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

      total = api
        .column(3)
        .data()
        .reduce(function (a, b) {
          return intVal(a) + intVal(b)
        }, 0)

      saldo = api
        .column(4)
        .data()
        .reduce(function (a, b) {
          return intVal(a) + intVal(b)
        }, 0)

      pageTotal = api
        .column(3, { page: 'current' })
        .data()
        .reduce(function (a, b) {
          return intVal(a) + intVal(b)
        }, 0)

      $(api.column(3).footer()).html(
        Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
          parseFloat(total).toFixed(2),
        ),
      )

      $(api.column(4).footer()).html(
        Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
          parseFloat(saldo).toFixed(2),
        ),
      )
    },
  })

  // TABLA RESUMEN DE PAGOS
  tablaResumenp = $('#tablaResumenp').DataTable({
    rowCallback: function (row, data) {
      $($(row).find('td')['3']).addClass('text-right')
      $($(row).find('td')['3']).addClass('currency')
    },
    columnDefs: [
      {
        targets: 3,
        render: function (data, type, full, meta) {
          return Intl.NumberFormat('es-MX', {
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

      total = api
        .column(3)
        .data()
        .reduce(function (a, b) {
          return intVal(a) + intVal(b)
        }, 0)

      pageTotal = api
        .column(3, { page: 'current' })
        .data()
        .reduce(function (a, b) {
          return intVal(a) + intVal(b)
        }, 0)

      $(api.column(3).footer()).html(
        Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
          parseFloat(total).toFixed(2),
        ),
      )
    },
  })
  // TABLA BUSCAR OBRA

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
    $('#formReq').trigger('reset')
    $('#modalReq').modal('show')
    id = null
    opcion = 1
  })

  //BOTON GUARDAR FACTURA
  $(document).on('click', '#btnGuardarreq', function () {
    folio = $('#folioreq').val()
    fecha = $('#fechareq').val()

  
    id_prov = $('#id_prov').val()
    tipo = 'PROVISION GRAL'
    descripcion = $('#descripcionreq').val()

    subtotal = $('#subtotalreq').val().replace(/,/g, '')
    iva = $('#ivareq').val().replace(/,/g, '')
    
    montoreq = $('#montoreqa').val().replace(/,/g, '')
  

    if (
      fecha.length == 0 ||
      id_prov.length == 0 ||
      descripcion.length == 0 ||
        montoreq.length == 0
    ) {
      Swal.fire({
        title: 'Datos Faltantes',
        text: 'Debe ingresar todos los datos Requeridos',
        icon: 'warning',
      })
      return false
    } else {
      opcion = 1
      $.ajax({
        url: 'bd/crudprovisiongral.php',
        type: 'POST',
        dataType: 'json',
        data: {
          folio: folio,
          fecha: fecha,
          id_prov: id_prov,
          descripcion: descripcion,
          subtotal: subtotal,
          iva: iva,
          tipo: tipo,
          montoreq: montoreq,
          opcion: opcion,
        },
        success: function (data) {
          if (data == 1) {
            facturaexitosa()
            window.location.reload()
          } else {
            facturaerror()
          }
        },
      })
    }
  })

  //BOTON EDITAR
  $(document).on('click', '.btnEditar', function () {
    fila = $(this).closest('tr')
    id = parseInt(fila.find('td:eq(0)').text())

    saldo = fila.find('td:eq(9)').text().replace(/,/g, '')
    monto = fila.find('td:eq(8)').text().replace(/,/g, '')

    if (parseFloat(monto) == parseFloat(saldo)) {
      opcion = 2
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

  //BOTON RESUMEN DE CXP
  $(document).on('click', '.btnResumen', function () {
    fila = $(this).closest('tr')
    id = parseInt(fila.find('td:eq(0)').text())

    buscarcxp(id)
    $('#modalResumen').modal('show')
  })

  // FUNCION BUSCAR CXP
  function buscarcxp(folio) {
    tablaResumen.clear()
    tablaResumen.draw()
    opcion = 2 // 2 para cuentas pagar
    $.ajax({
      type: 'POST',
      url: 'bd/buscarcxp-provigral.php',
      dataType: 'json',

      data: { folio: folio },

      success: function (res) {
        for (var i = 0; i < res.length; i++) {
          tablaResumen.row
            .add([
              res[i].folio_cxp,
              res[i].fecha_cxp,
              res[i].factura_cxp,
              res[i].monto_cxp,
              res[i].saldo_cxp,
            ])
            .draw()
        }
      },
    })
  }
  // BOTON TRASLADAR
  $(document).on('click', '.btntrasladar', function () {
    fila = $(this).closest('tr')
    folio_provi = parseInt(fila.find('td:eq(0)').text())


    id_prov = fila.find('td:eq(1)').text()
    proveedor = fila.find('td:eq(2)').text()
    saldo = fila.find('td:eq(6)').text()
    concepto = fila.find('td:eq(4)').text()
    

   

    $('formPago').trigger('reset')

    $('#folioprovi').val(folio_provi)
  
    $('#id_prov2').val(id_prov)
    $('#proveedor2').val(proveedor)
    $('#descripcionreq2').val(concepto)
    $('#montoreqa2').val(saldo)
    
   
    calculototal2($('#montoreqa2').val().replace(/,/g, ''))

    

    $('#modalPago').modal('show')
  })

  //BOTON GUARDAR TRASLADO A CXP
  $(document).on('click', '#btnGuardarvp', function () {
    folio = $('#folioreq2').val()
    fecha = $('#fechareq2').val()
    factura = $('#facturareq2').val()
  
    id_prov = $('#id_prov2').val()
    folioprovi = $('#folioprovi').val()
    tipo = 'FACTURA GRAL'
    descripcion = $('#descripcionreq2').val()
    subtotal = $('#subtotalreq2').val().replace(/,/g, '')
    iva = $('#ivareq2').val().replace(/,/g, '')
    monto = $('#montoreq2').val().replace(/,/g, '')

    montob = $('#montoreqa2').val().replace(/,/g, '')
    ret1 = $('#ret12').val().replace(/,/g, '')
    ret2 = $('#ret22').val().replace(/,/g, '')
    ret3 = $('#ret32').val().replace(/,/g, '')
    importe = $('#importe2').val().replace(/,/g, '')
    descuento = $('#descuento2').val().replace(/,/g, '')
    devolucion = $('#devolucion2').val().replace(/,/g, '')
    uuid = $('#uuid').val()


    if (
      fecha.length == 0 ||
      factura.length == 0 ||
  
      id_prov.length == 0 ||
      descripcion.length == 0 ||
      monto.length == 0 ||
      uuid.length == 0 ||
      uuid.length != 36
    ) {
      Swal.fire({
        title: 'Datos Faltantes',
        text: 'Debe ingresar todos los datos Requeridos',
        icon: 'warning',
      })
      return false
    } else {


       $.ajax({
        url: 'bd/buscaruuid.php',
        type: 'POST',
        dataType: 'json',
        async: false,
        data: {
          uuid: uuid,
        },
        success: function (data) {
          if (data == 0) {
            opcion = 4
            $.ajax({
              url: 'bd/crudcxpgral.php',
              type: 'POST',
              dataType: 'json',
              data: {
                folio: folio,
                folioprovi: folioprovi,
                fecha: fecha,
                factura: factura,
                id_prov: id_prov,
                descripcion: descripcion,
                tipo: tipo,
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
                uuid: uuid
              },
              success: function (data) {
                if (data == 1) {
                  facturaexitosa()

                  window.location.reload()
                } else {
                  facturaerror()
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

  //BOTON CANCELAR
  $(document).on('click', '.btnCancelar', function () {
    fila = $(this).closest('tr')

    folio = parseInt(fila.find('td:eq(0)').text())

    saldo = fila.find('td:eq(5)').text().replace(/,/g, '')
    monto = fila.find('td:eq(6)').text().replace(/,/g, '')

    if (parseFloat(monto) == parseFloat(saldo)) {
      $('#formcan').trigger('reset')
      $('#modalcan').modal('show')
      $('#foliocan').val(folio)
      $('#tipodoc').val(7) // 6 PROVISIONES DE CXP
    } else {
      tipodoc
      swal.fire({
        title: 'No es posible Cancelar el Registro',
        text: 'El documento ya tiene operaciones posteriores',
        icon: 'warning',
        focusConfirm: true,
        confirmButtonText: 'Aceptar',
      })
    }
  })

  //BOTON VER PAGOS DE CXP
  $(document).on('click', '.btnVerpagos', function () {
    fila = $(this).closest('tr')
    folio = parseInt(fila.find('td:eq(0)').text())
    buscarpagos(folio)
    $('#modalResumenp').modal('show')
  })

  function buscarpagos(folio) {
    tablaResumenp.clear()
    tablaResumenp.draw()
    opcion = 2 // 2 para cuentas pagar
    $.ajax({
      type: 'POST',
      url: 'bd/buscarpagocxpgral.php',
      dataType: 'json',

      data: { folio: folio, opcion: opcion },

      success: function (res) {
        for (var i = 0; i < res.length; i++) {
          tablaResumenp.row
            .add([
              res[i].folio_pagocxp,
              res[i].fecha_pagocxp,
              res[i].referencia_pagocxp,
              res[i].monto_pagocxp,
              res[i].metodo_pagocxp,
            ])
            .draw()
        }
      },
    })
  }

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
        url: 'bd/cancelaregresosgral.php',
        async: false,
        dataType: 'json',
        data: {
          foliocan: foliocan,
          motivo: motivo,
          fecha: fecha,
          usuario: usuario,
          tipodoc: tipodoc,
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
      title: 'Provisión Registrada',
      icon: 'success',
      focusConfirm: true,
      confirmButtonText: 'Aceptar',
    })
  }

  function facturaerror() {
    swal.fire({
      title: 'Provisión No Registrada',
      icon: 'error',
      focusConfirm: true,
      confirmButtonText: 'Aceptar',
    })
  }
  function operacionexitosa() {
    swal.fire({
      title: 'Traslado Exitoso',
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
        url: 'bd/buscarprovisiongral.php',
        dataType: 'json',
        data: { inicio: inicio, final: final, opcion: opcion },
        success: function (data) {
          for (var i = 0; i < data.length; i++) {
            tablaVis.row
              .add([
                data[i].folio_provi,
                data[i].id_prov,
                data[i].razon_prov,
                data[i].fecha_provi,
                data[i].concepto_provi,
                Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
                  parseFloat(data[i].monto_provi).toFixed(2),
                ),
                Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
                  parseFloat(data[i].saldo_provi).toFixed(2),
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

  var fila //capturar la fila para editar o borrar el registro

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

  $(document).on('click', '.btnSaldarprov', function () {
    fila = $(this).closest('tr')
    folio = parseInt(fila.find('td:eq(0)').text())
    saldo = fila.find('td:eq(6)').text()

    $('#formsaldar').trigger('reset')
    $('#modalsaldar').modal('show')
    $('#folioprovs').val(folio)
    $('#saldopendiente').val(saldo)
  })


    // GUARDAR MONTO COBRADO
    $(document).on('click', '#btnGuadarsaldar', function () {
      folioprov = $('#folioprovs').val()
  
      saldopendiente = $('#saldopendiente').val().replace(/,/g, '')
  
      if (saldopendiente === '') {
        swal.fire({
          title: 'Datos Incompletos',
          text: 'Verifique sus datos',
          icon: 'warning',
          focusConfirm: true,
          confirmButtonText: 'Aceptar',
        })
      } else {
        Swal.fire({
          title: '¿Está seguro de Saldar el registro:?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#0B9E09',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Aceptar',
        }).then(function (isConfirm) {
          if (isConfirm.value) {
            $.ajax({
              type: 'POST',
              url: 'bd/saldarprovgral.php',
              async: false,
              dataType: 'json',
              data: {
                folioprov: folioprov,
                saldopendiente: saldopendiente,
              },
              success: function (res) {
                if (res == 1) {
                  swal.fire({
                    title: 'Registrado Guardado',
                    icon: 'success',
                    focusConfirm: true,
                    confirmButtonText: 'Aceptar',
                  })
                  $('#modalsaldar').modal('hide')
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
      }
    })

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
