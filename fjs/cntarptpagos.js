$(document).ready(function () {
  var id, opcion
  var forigen
  opcion = 4

  tablaVis = $('#tablaV').DataTable({
    /*<button class='btn btn-sm btn-danger btnBorrar'><i class='fas fa-trash-alt'></i></button>\ */
    columnDefs: [
      {
        targets: -1,
        data: null,
        defaultContent:
          "<div class='text-center'><div class='btn-group'>\
            <button class='btn btn-sm btn-primary  btnEditar'><i class='fas fa-edit'></i></button>\
            <button class='btn btn-sm bg-orange  btnaplicar'><i class='fa-solid fa-list-check'></i></button>\
            </div></div>",
      },
    ],

    //Para cambiar el lenguaje a español
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
    rowCallback: function (row, data) {
      $($(row).find('td')[5]).addClass('text-center')
      if (data[5] == '1') {
        //$($(row).find("td")[6]).css("background-color", "warning");
        $($(row).find('td')[5]).addClass('bg-gradient-info')
        //$($(row).find('td')[4]).css('background-color','#EEA447');
        $($(row).find('td')[5]).text('ABIERTO')
      } else if (data[5] == '2') {
        $($(row).find('td')[5]).addClass('bg-gradient-primary')
        //$($(row).find('td')[4]).css('background-color','#EEA447');
        $($(row).find('td')[5]).text('CERRADO')
      } else if (data[5] == '3') {
        $($(row).find('td')[5]).addClass('bg-gradient-success')
        //$($(row).find('td')[4]).css('background-color','#EEA447');
        $($(row).find('td')[5]).text('APLICADO')
      }
    },
  })

  tablac = $('#tablac').DataTable({
    paging: false,
    ordering: false,
    info: false,
    searching: false,

    columnDefs: [
      {
        targets: -1,
        data: null,
        defaultContent:
          "<div class='text-center'><div class='btn-group'>\
                <button class='btn btn-sm btn-success btnejecutar'><i class='fa-solid fa-check-circle'></i></button>\
                </div></div>",
      },
      { className: 'hide_column', targets: [0] },
      { className: 'hide_column', targets: [1] },
    ],
    //Para cambiar el lenguaje a español
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
    rowCallback: function (row, data) {
      if (data[9] == '0') {
        //$($(row).find("td")[6]).css("background-color", "warning");
        $($(row).find('td')[9]).addClass('bg-gradient-warning')
        $($(row).find('td')[9]).addClass('text-white')
        //$($(row).find('td')[4]).css('background-color','#EEA447');
        $($(row).find('td')[9]).text('PENDIENTE')
      } else {
        $($(row).find('td')[9]).addClass('bg-gradient-success')
        //$($(row).find('td')[4]).css('background-color','#EEA447');
        $($(row).find('td')[9]).text('APLICADO')
      }
    },
  })

  $('#btnNuevo').click(function () {
    window.location.href = 'rptpagos.php'
  })

  var fila //capturar la fila para editar o borrar el registro

  $(document).on('click', '.btnEditar', function () {
    fila = $(this).closest('tr')
    folio = parseInt(fila.find('td:eq(0)').text())
    window.location = 'rptpagos.php?folio=' + folio
  })

  $(document).on('click', '.btnejecutar', function () {
    fila = $(this).closest('tr')
    id_reg = parseInt(fila.find('td:eq(0)').text())
    forigen = id_reg
    tipodoc = fila.find('td:eq(2)').text()
    id = parseInt(fila.find('td:eq(3)').text())
    total = fila.find('td:eq(8)').text()

    switch (tipodoc) {
      case 'PROVISION SUB':
        trasladarprovsub(id, tipodoc, total)
        break
      case 'REQUISICION':
        //checar para pagar la requisicion
        pagarreqsub(id, total)

        break
      case 'CXP':
        break
      case 'PROVISION':
        trasladarprov(id, tipodoc, total)
        break
      case 'CXP GRAL':
        break
      case 'PROVISION GRAL':
        break
    }
  })

  $(document).on('click', '.btnaplicar', function () {
    fila = $(this).closest('tr')
    folio = parseInt(fila.find('td:eq(0)').text())

    estado = fila.find('td:eq(5)').text()

    if (estado == 'CERRADO') {
      buscarcuentas(folio)

      $('#modalcuentas').modal('show')
    } else {
      swal.fire({
        title: 'Es necesario cerrar el reporte',
        icon: 'warning',
        focusConfirm: true,
        confirmButtonText: 'Aceptar',
      })
    }
  })

  function buscarcuentas(foliosemanal) {
    tablac.clear()
    tablac.draw()

    $.ajax({
      type: 'POST',
      url: 'bd/semanaldetalle.php',
      dataType: 'json',

      data: { foliosemanal: foliosemanal },

      success: function (res) {
        for (var i = 0; i < res.length; i++) {
          tablac.row
            .add([
              res[i].id_reg,
              res[i].folio_rpt,
              res[i].tipo,
              res[i].folio,
              res[i].corto_obra,
              res[i].razon_prov,
              res[i].concepto,
              res[i].observaciones,
              Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
                parseFloat(res[i].montoautorizado).toFixed(2),
              ),
              res[i].aplicado,
            ])
            .draw()
        }
      },
    })
  }

  function trasladarprovsub(id, opcdoc, totaldoc) {
    //buscar subcontrato en el documento

    $.ajax({
      type: 'POST',
      url: 'bd/buscardocumento.php',
      dataType: 'json',
      async: false,
      data: { id: id, opcdoc: opcdoc },

      success: function (res) {
        subcontrato = res[0].id_sub
        concepto = res[0].concepto_prov
        idprovglobal = res[0].id_prov
      },
    })

    $('#formReq').trigger('reset')
    $('#modalReq').modal('show')
    $('#idprovision').val(id)
    $('#foliosubcontrato').val(subcontrato)
    $('#idprovreq').val(idprovglobal)

    $('#descripcionreq').val(concepto)
    //$('#subtotalreq').val(subtotal)
    //$('#ivareq').val(iva)
    $('#importe').val(
      totaldoc,
    ) /*
        $('#devolucion').val(devolucion)
        $('#descuento').val(descuento)
        $('#ret1').val(ret1)
        $('#ret2').val(ret2)
        $('#ret3').val(ret3)*/
    calculototalreq1($('#importe').val().replace(/,/g, ''))
  }

  function calculototalreq1(valor) {
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
    caluloconret()
  }

  function caluloconret() {
    total = $('#montoreqa').val().replace(/,/g, '')
    ret1 = $('#ret1').val().replace(/,/g, '')
    ret2 = $('#ret2').val().replace(/,/g, '')
    ret3 = $('#ret3').val().replace(/,/g, '')
    //  ret4=$('#ret4').val().replace(/,/g, '')

    if (ret1.length == 0) {
      ret1 = 0
      $('#ret1').val(
        Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
          parseFloat(ret1).toFixed(2),
        ),
      )
    }

    if (ret2.length == 0) {
      ret2 = 0
      $('#ret2').val(
        Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
          parseFloat(ret2).toFixed(2),
        ),
      )
    }

    if (ret3.length == 0) {
      ret3 = 0
      $('#ret3').val(
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
    $('#montoreq').val(
      Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
        parseFloat(calculo).toFixed(2),
      ),
    )
  }

  $(document).on('click', '#btnGuardarreq', function () {
    folioreq = $('#folioreq').val()
    subcontrato = $('#foliosubcontrato').val()
    id_prov = $('#idprovreq').val()
    fechareq = $('#fechareq').val()
    clavereq = $('#clavereq').val()
    factura = $('#clavereq').val()
    idprovision = $('#idprovision').val()

    opcionreq = 4
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

    var fechavp = $('#fechavp').val()

    var referenciavp = $('#referenciavp').val()
    var observacionesvp = $('#observacionesvp').val()
    var montovp = $('#montoreq').val()
    montovp = montovp.replace(/,/g, '')
    var metodovp = $('#metodovp').val()
    var usuario = $('#nameuser').val()
    var opcionpago = 3

    if (
      fechareq.length == 0 ||
      clavereq.length == 0 ||
      descripcionreq.length == 0 ||
      montoreq.length == 0 ||
      referenciavp.length == 0 ||
      metodovp.length == 0
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
                
                forigen: forigen,
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
                fechavp: fechavp,
                observacionesvp: observacionesvp,
                referenciavp: referenciavp,
                montovp: montovp,
                metodovp: metodovp,
                usuario: usuario,
                opcionpago: opcionpago,
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

  function pagarreqsub(folio_req, saldo) {
    $('formPago').trigger('reset')

    $('#foliovp1').val(folio_req)
    $('#conceptovp1').val('')
    $('#obsvp1').val('')
    $('#saldovp1').val(saldo)
    $('#montpagovp1').val('')
    $('#metodovp1').val('')
    $('#id_prov1').val('')
    $('#modalPago').modal('show')

  }

  //BOTON GUARDAR PAGO
  $(document).on('click', '#btnGuardarp', function () {
    var folioreq = $('#foliovp1').val()
    var fechavp = $('#fechavp1').val()

    var referenciavp = $('#referenciavp1').val()
    var observacionesvp = $('#observacionesvp1').val()
    var saldovp = $('#saldovp1').val()
    saldovp = saldovp.replace(/,/g, '')
    var montovp = $('#montopagovp1').val()
    montovp = montovp.replace(/,/g, '')
    var metodovp = $('#metodovp1').val()
    var usuario = $('#nameuser').val()
    var opcion = 4

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
      saldofin = 0

      opcion = 2
      $.ajax({
        url: 'bd/pagoreq.php',
        type: 'POST',
        dataType: 'json',
        async: false,
        data: {
          forigen: forigen,
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
  })

  function trasladarprov(id, opcdoc, totaldoc) {
    folio_provi = id
    $.ajax({
      type: 'POST',
      url: 'bd/buscardocumento.php',
      dataType: 'json',
      async: false,
      data: { id: id, opcdoc: opcdoc },

      success: function (res) {
        id_obra = res[0].id_obra
        obra = res[0].corto_obra
        id_prov = res[0].id_prov
        proveedor = res[0].razon_prov
        concepto = res[0].concepto_provi
      },
    })

    saldo = totaldoc
    /*
    total = fila.find('td:eq(7)').text()

    ret1 = fila.find('td:eq(9)').text()
    ret2 = fila.find('td:eq(10)').text()
    ret3 = fila.find('td:eq(11)').text()
    importe = fila.find('td:eq(12)').text()
    descuento = fila.find('td:eq(13)').text()
    devolucion = fila.find('td:eq(14)').text()
    montob=fila.find('td:eq(15)').text()*/

    $('formtprov').trigger('reset')

    $('#folioprovi').val(folio_provi)
    $('#id_obra2').val(id_obra)
    $('#obra2').val(obra)
    $('#id_prov2').val(id_prov)
    $('#proveedor2').val(proveedor)
    $('#descripcionreq2').val(concepto)

    $('#montoreqa2').val(saldo)
    /*
    $('#montoreqa2').val(montob)
    $('#importe2').val(importe)
   $('#devolucion2').val(devolucion)
   $('#descuento2').val(descuento)

    $('#ret12').val(ret1)
    $('#ret22').val(ret2)
    $('#ret32').val(ret3)
   */

    calculosubtotalreq2($('#montoreqa2').val().replace(/,/g, ''))

    $('#modaltprov').modal('show')
  }

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


   //BOTON GUARDAR TRASLADO A CXP
   $(document).on('click', '#btnGuardarvp2', function () {
    folio = $('#folioreq2').val()
    fecha = $('#fechareq2').val()
    factura = $('#facturareq2').val()
    id_obra = $('#id_obra2').val()
    id_prov = $('#id_prov2').val()
    folioprovi = $('#folioprovi').val()
    tipo = 'FACTURA'
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
    var fechavp = $('#fechavp2').val()

    var referenciavp = $('#referenciavp2').val()
    var observacionesvp = $('#observacionesvp2').val()
    var montovp = $('#montoreqa2').val()
    montovp = montovp.replace(/,/g, '')
    var metodovp = $('#metodovp2').val()
    var usuario = $('#nameuser').val()
    var opcionpago = 3


    if (
      fecha.length == 0 ||
      factura.length == 0 ||
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
            opcion = 5
            $.ajax({
              url: 'bd/crudegresos.php',
              type: 'POST',
              dataType: 'json',
              data: {
                forigen: forigen,
                folio: folio,
                folioprovi: folioprovi,
                fecha: fecha,
                factura: factura,
                id_obra: id_obra,
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
                fechavp: fechavp,
                observacionesvp: observacionesvp,
                referenciavp: referenciavp,
                montovp: montovp,
                metodovp: metodovp,
                usuario: usuario,
                opcion: opcion,
                

              },
              success: function (data) {
                if (data == 1) {
                  operacionexitosa()

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
  function operacionexitosa() {
    swal.fire({
      title: 'Pago Registrado',
      icon: 'success',
      focusConfirm: true,
      confirmButtonText: 'Aceptar',
    })
  }

  function round(value, decimals) {
    return Number(Math.round(value + 'e' + decimals) + 'e-' + decimals)
  }
})
