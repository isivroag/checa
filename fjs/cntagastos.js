$(document).ready(function () {
  var id, opcion
  opcion = 4
  // TOOLTIP DATATABLE
  $('[data-toggle="tooltip"]').tooltip()

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
        <button class='btn btn-sm btn-success btnPagar' data-toggle='tooltip' data-placement='top' title='Pagar' ><i class='fas fa-dollar-sign'></i></button>\
        <button class='btn btn-sm bg-primary btnVerpagos' data-toggle='tooltip' data-placement='top' title='Ver Pagos'><i class='fas fa-search-dollar'></i></button>\
        </div></div>"
    } else {
      columnas =
        "<div class='text-center'><div class='btn-group'>\
        <button class='btn btn-sm btn-success btnPagar' data-toggle='tooltip' data-placement='top' title='Pagar' ><i class='fas fa-dollar-sign'></i></button>\
        <button class='btn btn-sm bg-primary btnVerpagos' data-toggle='tooltip' data-placement='top' title='Ver Pagos'><i class='fas fa-search-dollar'></i></button>\
        <button class='btn btn-sm bg-danger btnCancelar'  data-toggle='tooltip' data-placement='top' title='Cancelar'><i class='fas fa-ban'></i></button>\
        </div></div>"
    }
    return columnas
  }

  function permisos2() {
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

  //FUNCION REDONDEAR
  function round(value, decimals) {
    return Number(Math.round(value + 'e' + decimals) + 'e-' + decimals)
  }

  //FUNCION FORMATO MONEDA
  document.getElementById('montoreq').onblur = function () {
    //number-format the user input
    this.value = parseFloat(this.value.replace(/,/g, ''))
      .toFixed(2)
      .toString()
      .replace(/\B(?=(\d{3})+(?!\d))/g, ',')
  }

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
  }

 

  // SOLO NUMEROS SUBTOTAL FACTURA
  /*
  document.getElementById('subtotalreq').onblur = function () {
    calculototalreq(this.value.replace(/,/g, ''))
    this.value = parseFloat(this.value.replace(/,/g, ''))
      .toFixed(2)
      .toString()
      .replace(/\B(?=(\d{3})+(?!\d))/g, ',')
  }*/
  // SOLO NUMEROS IVA FACTURA
  /*
  document.getElementById('ivareq').onblur = function () {
    this.value = parseFloat(this.value.replace(/,/g, ''))
      .toFixed(2)
      .toString()
      .replace(/\B(?=(\d{3})+(?!\d))/g, ',')
  }*/
  // SOLO NUMEROS MONTO FACTURA
  document.getElementById('montoreq').onblur = function () {
    //calculosubtotalreq(this.value.replace(/,/g, ''))
    this.value = parseFloat(this.value.replace(/,/g, ''))
      .toFixed(2)
      .toString()
      .replace(/\B(?=(\d{3})+(?!\d))/g, ',')
  }


  // TABLA PRINCIPAL

  tablaVis = $('#tablaV').DataTable({
    rowCallback: function (row, data) {
      $($(row).find('td')['7']).addClass('text-right')
      $($(row).find('td')['8']).addClass('text-right')
      $($(row).find('td')['7']).addClass('currency')
      $($(row).find('td')['8']).addClass('currency')
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
        title: 'Listado de Gastos',
        className: 'btn bg-success ',
        exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7, 8] },
      },
      {
        extend: 'pdfHtml5',
        text: "<i class='far fa-file-pdf'> PDF</i>",
        titleAttr: 'Exportar a PDF',
        title: 'Listado de Gastos',
        className: 'btn bg-danger',
        exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7, 8] },
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
      { className: 'hide_column', targets: [3] },
      { className: 'hide_column', targets: [1] },
      { width: '30%', targets: 6 },
      { width: '20%', targets: 2 },
      { width: '20%', targets: 4 },
      { width: '8%', targets: 5 },
      { width: '8%', targets: 7 },
      { width: '8%', targets: 8 },
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
        sLast: '??ltimo',
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
  tablaResumenp = $('#tablaResumenp').DataTable({
    rowCallback: function (row, data) {
      $($(row).find('td')['3']).addClass('text-right')
      $($(row).find('td')['3']).addClass('currency')
    },
    columnDefs: [
        {
            targets: -1,
            data: null,
            defaultContent:textcolumnas2,
          },
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
        sLast: '??ltimo',
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
        sLast: '??ltimo',
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
        sLast: '??ltimo',
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

    id_obra = $('#id_obra').val()
    id_prov = $('#id_prov').val()
    tipo = 'GASTO'
    descripcion = $('#descripcionreq').val()
    //subtotal = $('#subtotalreq').val().replace(/,/g, '')
    //iva = $('#ivareq').val().replace(/,/g, '')
    monto = $('#montoreq').val().replace(/,/g, '')
    usuario=$('#nameuser').val()

    if (
      fecha.length == 0 ||
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
      opcion = 1
      $.ajax({
        url: 'bd/crudgasto.php',
        type: 'POST',
        dataType: 'json',
        data: {
          folio: folio,
          fecha: fecha,
          id_obra: id_obra,
          id_prov: id_prov,
          descripcion: descripcion,
          tipo: tipo,
          //subtotal: subtotal,
          //iva: iva,
          monto: monto,
          usuario: usuario,
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

    //BOTON PAGAR
    $(document).on('click', '.btnPagar', function () {
        fila = $(this).closest('tr')
        folio_req = parseInt(fila.find('td:eq(0)').text())
        saldo = fila.find('td:eq(8)').text()
    
        $('formPago').trigger('reset')
    
        $('#foliovp').val(folio_req)
        $('#conceptovp').val('')
        $('#obsvp').val('')
        $('#saldovp').val(saldo)
        $('#montpagovp').val('')
        $('#metodovp').val('')

    
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
        var opcion = 5
    
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
              url: 'bd/pagogasto.php',
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
                console.log(res)
                if (res == 1) {
                  operacionexitosa()
                  $('#modalPago').modal('hide')
                  window.location.reload()
                } else {
                  Swal.fire({
                    title: 'La operaci??n no pudo ser registrada',
                    icon: 'error',
                  })
                }
              },
            })
          }
        }
      })


  
  //BOTON CANCELAR
  $(document).on('click', '.btnCancelar', function () {
    fila = $(this).closest('tr')

    folio = parseInt(fila.find('td:eq(0)').text())

    saldo = fila.find('td:eq(7)').text().replace(/,/g, '')
    monto = fila.find('td:eq(8)').text().replace(/,/g, '')

    if (parseFloat(monto) == parseFloat(saldo)) {
      $('#formcan').trigger('reset')
      $('#modalcan').modal('show')
      $('#foliocan').val(folio)
      $('#tipodoc').val(11) // 11 gastos
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

        //BOTON CANCELAR PAGO
        $(document).on('click', '.btnCancelarpago', function () {
            fila = $(this).closest('tr')
            folio = parseInt(fila.find('td:eq(0)').text())
        
            saldo = fila.find('td:eq(4)').text().replace(/,/g, '')
            monto = fila.find('td:eq(5)').text().replace(/,/g, '')
        
            $('#formcan').trigger('reset')
            $('#modalcan').modal('show')
            $('#foliocan').val(folio)
            $('#tipodoc').val(12) // 12 cancelar pago de  gastos
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
    opcion = 5 // 5 gastos
    $.ajax({
      type: 'POST',
      url: 'bd/buscarpagocxp.php',
      dataType: 'json',

      data: { folio: folio, opcion: opcion },

      success: function (res) {
        for (var i = 0; i < res.length; i++) {
          tablaResumenp.row
            .add([
              res[i].folio_pagogto,
              res[i].fecha_pagogto,
              res[i].referencia_pagogto,
              res[i].monto_pagogto,
              res[i].metodo_pagogto,
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
        url: 'bd/cancelaregresos.php',
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
      title: 'Operaci??n Registrada',
      icon: 'success',
      focusConfirm: true,
      confirmButtonText: 'Aceptar',
    })
  }

  function facturaerror() {
    swal.fire({
      title: 'Operaci??n No Registrada',
      icon: 'error',
      focusConfirm: true,
      confirmButtonText: 'Aceptar',
    })
  }
  function operacionexitosa() {
    swal.fire({
      title: 'Operaci??n Exitoso',
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

    console.log(opcion)

    if (inicio != '' && final != '') {
      $.ajax({
        type: 'POST',
        url: 'bd/buscargasto.php',
        dataType: 'json',
        data: { inicio: inicio, final: final, opcion: opcion },
        success: function (data) {
          for (var i = 0; i < data.length; i++) {
            tablaVis.row
              .add([
                data[i].folio_gto,
                data[i].id_obra,
                data[i].corto_obra,
                data[i].id_prov,
                data[i].razon_prov,
                data[i].fecha_gtp,
                data[i].desc_gto,
                Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
                  parseFloat(data[i].monto_gto).toFixed(2),
                ),
                Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
                  parseFloat(data[i].saldo_gto).toFixed(2),
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
})

function filterFloat(evt, input) {
  // Backspace = 8, Enter = 13, ???0??? = 48, ???9??? = 57, ???.??? = 46, ???-??? = 43
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
