$(document).ready(function () {
  var id, opcion
  opcion = 4

  /*<button class='btn btn-sm btn-primary btnEditar'  data-toggle='tooltip' data-placement='top' title='Editar'><i class='fas fa-edit'></i></button>\
    <button class='btn btn-sm bg-info btnResumen'><i class='fas fa-bars'  data-toggle='tooltip' data-placement='top' title='Resumen de Pagos'></i></button>
  */
  var textcolumnas = permisos()

  function permisos() {
    var tipousuario = $('#tipousuario').val()
    var columnas = ''
    console.log(tipousuario)
    if (tipousuario == 1) {
      columnas =
        "<div class='text-center'><div class='btn-group'>\
        <button class='btn btn-sm bg-danger btnCancelar'  data-toggle='tooltip' data-placement='top' title='Cancelar'><i class='fas fa-ban'></i></button>\
        </div></div>"
    } else {
      columnas =
        "<div class='text-center'><div class='btn-group'>\
        <button class='btn btn-sm bg-danger btnCancelar'  data-toggle='tooltip' data-placement='top' title='Cancelar'><i class='fas fa-ban'></i></button>\
        </div></div>"
    }
    return columnas
  }

  // TOOLTIP DATATABLE
  $('[data-toggle="tooltip"]').tooltip()

  //FUNCION REDONDEAR
  function round(value, decimals) {
    return Number(Math.round(value + 'e' + decimals) + 'e-' + decimals)
  }

  // TABLA PRINCIPAL

  tablaVis = $('#tablaV').DataTable({
    info: false,
    searching: false,
    fixedHeader: true,
    paging: false,

    dom:
      "<'row justify-content-center'<'col-sm-12 col-md-4 form-group'l><'col-sm-12 col-md-4 form-group'B><'col-sm-12 col-md-4 form-group'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",

    buttons: [
      {
        extend: 'excelHtml5',
        text: "<i class='fas fa-file-excel'> Excel</i>",
        titleAttr: 'Exportar a Excel',
        title: 'Reporte de Venta',
        className: 'btn bg-success ',
        exportOptions: { columns: [0, 1, 2, 3, 4, 5] },
      },
      {
        extend: 'pdfHtml5',
        text: "<i class='far fa-file-pdf'> PDF</i>",
        titleAttr: 'Exportar a PDF',
        title: 'Reporte de Venta',
        className: 'btn bg-danger',
        exportOptions: { columns: [0, 1, 2, 3, 4, 5] },
      },
    ],

    columnDefs: [],
    rowCallback: function (row, data) {
      $($(row).find('td')['7']).addClass('text-right')

      $($(row).find('td')['7']).addClass('currency')
    },

    // SUMA DE TOTAL
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
      /*
          total = api
            .column(7)
            .data()
            .reduce(function (a, b) {
              return intVal(a) + intVal(b)
            }, 0)*/

      total = api
        .column(7, { page: 'current' })
        .data()
        .reduce(function (a, b) {
          return intVal(a) + intVal(b)
        }, 0)

      $(api.column(7).footer()).html(
        Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
          parseFloat(total).toFixed(2),
        ),
      )
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

  tablaVis2 = $('#tablaV2').DataTable({
    info: false,
    searching: false,
    fixedHeader: true,
    paging: false,

    dom:
      "<'row justify-content-center'<'col-sm-12 col-md-4 form-group'l><'col-sm-12 col-md-4 form-group'B><'col-sm-12 col-md-4 form-group'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",

    buttons: [
      {
        extend: 'excelHtml5',
        text: "<i class='fas fa-file-excel'> Excel</i>",
        titleAttr: 'Exportar a Excel',
        title: 'Reporte de Venta',
        className: 'btn bg-success ',
        exportOptions: { columns: [0, 1, 2, 3, 4, 5] },
      },
      {
        extend: 'pdfHtml5',
        text: "<i class='far fa-file-pdf'> PDF</i>",
        titleAttr: 'Exportar a PDF',
        title: 'Reporte de Venta',
        className: 'btn bg-danger',
        exportOptions: { columns: [0, 1, 2, 3, 4, 5] },
      },
    ],

    rowCallback: function (row, data) {
      $($(row).find('td')['5']).addClass('text-right')

      $($(row).find('td')['5']).addClass('currency')
    },

    // SUMA DE TOTAL
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
      /*
            total = api
              .column(5)
              .data()
              .reduce(function (a, b) {
                return intVal(a) + intVal(b)
              }, 0)*/

      total = api
        .column(5, { page: 'current' })
        .data()
        .reduce(function (a, b) {
          return intVal(a) + intVal(b)
        }, 0)

      $(api.column(5).footer()).html(
        Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
          parseFloat(total).toFixed(2),
        ),
      )
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
  $('#tablaV2 thead tr').clone(true).appendTo('#tablaV2 thead')
  $('#tablaV2 thead tr:eq(1) th').each(function (i) {
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

      if (tablaVis2.column(i).search() !== valbuscar) {
        tablaVis2.column(i).search(valbuscar, true, true).draw()
      }
    })
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

  //BOTON BUSCAR OBRA
  $(document).on('click', '#bobra', function () {
    $('#modalObra').modal('show')
  })
  //BOTON SELECCIONAR OBRA
  //BOTON SELECCIONAR OBRA
  $(document).on('click', '.btnSelObra', function () {
    fila = $(this)
    id_obra = parseInt($(this).closest('tr').find('td:eq(0)').text())
    obra = $(this).closest('tr').find('td:eq(2)').text()
    window.location.href = 'verpagos.php?id_obra=' + id_obra
  })

  //FUNCION BUSCARPAGOS
  function buscarpagos(folio) {
    tablaResumen.clear()
    tablaResumen.draw()
    opcion = 1 // 1 para cuentas por cobrar
    $.ajax({
      type: 'POST',
      url: 'bd/buscarpagocxp.php',
      dataType: 'json',

      data: { folio: folio, opcion: opcion },

      success: function (res) {
        for (var i = 0; i < res.length; i++) {
          tablaResumen.row
            .add([
              res[i].folio_pagocxc,
              res[i].fecha_pagocxc,
              res[i].referencia_pagocxc,
              res[i].monto_pagocxc,
              res[i].metodo_pagocxc,
            ])
            .draw()

          //tabla += '<tr><td>' + res[i].id_objetivo + '</td><td>' + res[i].desc_objetivo + '</td><td class="text-center">' + icono + '</td><td class="text-center"></td></tr>';
        }
      },
    })
  }

  function facturaexitosa() {
    swal.fire({
      title: 'Registro Guardado',
      icon: 'success',
      focusConfirm: true,
      confirmButtonText: 'Aceptar',
    })
  }

  function facturaerror() {
    swal.fire({
      title: 'Registro No Guardado',
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
      icon: 'success',
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

  //BUSQUEDA GENERAL
  $(document).on('click', '#btnBuscar', function () {
    var inicio = $('#inicio').val()
    var final = $('#final').val()
    var obra = $('#id_obra').val()
 

    if (inicio != '' && final != '' && obra != '') {
     opcion = 1
      $.ajax({
        type: 'POST',
        url: 'bd/buscarverpagos.php',
        dataType: 'json',
        data: { inicio: inicio, final: final, obra: obra, opcion: opcion },
        success: function (data) {
          tablaVis.clear()
          tablaVis.draw()

          for (var i = 0; i < data.length; i++) {
            tablaVis.row
              .add([
                data[i].clave_sub,
                data[i].desc_sub,
                data[i].razon_prov,
                data[i].concepto_req,
                data[i].fecha_pagors,
                data[i].referencia_pagors,
                data[i].metodo_pagors,
                Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
                  parseFloat(data[i].monto_pagors).toFixed(2),
                ),
              ])
              .draw()
          }
        },
      })

      opcion=2
      $.ajax({
        type: 'POST',
        url: 'bd/buscarverpagos.php',
        dataType: 'json',
        data: { inicio: inicio, final: final, obra: obra, opcion: opcion },
        success: function (data) {
          tablaVis2.clear()
          tablaVis2.draw()

          for (var i = 0; i < data.length; i++) {
            tablaVis2.row
              .add([
                data[i].razon_prov,
                data[i].desc_cxp,
                data[i].fecha_pagocxp,
                data[i].referencia_pagocxp,
                data[i].metodo_pagocxp,
                Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
                  parseFloat(data[i].monto_pagocxp).toFixed(2),
                ),
              ])
              .draw()
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
