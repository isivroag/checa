$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip()
  
    var id, opcion
    var operacion = $('#opcion').val()
  
    var textopermiso = permisos()
  
    function permisos() {
      if (operacion == 1) {
        columnas =
          "<div class='text-center'><button class='btn btn-sm btn-danger btnBorrar'><i class='fas fa-trash-alt'></i></button></div>"
      } else {
        columnas = ''
      }
      return columnas
    }
  
    tablaC = $('#tablaC').DataTable({
      columnDefs: [
        {
          targets: -1,
          data: null,
          defaultContent:
            "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-success btnSelCliente'><i class='fas fa-hand-pointer'></i></button></div></div>",
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
    })
  
    tablaCon = $('#tablaCon').DataTable({
      columnDefs: [
        {
          targets: -1,
          data: null,
          defaultContent:
            "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-success btnSelConcepto'><i class='fas fa-hand-pointer'></i></button></div></div>",
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
    })
  
    //TABLA DETALLE DE desechables
    tablaDetIndes = $('#tablaDetIndes').DataTable({
      paging: false,
      ordering: false,
      info: false,
      searching: false,
  
      columnDefs: [
        {
          targets: -1,
          data: null,
          defaultContent: textopermiso,
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
  
      rowCallback: function (row, data) {
        $($(row).find('td')[2]).addClass('text-center')
        $($(row).find('td')[3]).addClass('text-right')
        val = numeral(data[3]).format('0,0.00')
        
  
        $($(row).find('td')[3]).text(val)
        
        val2 = numeral(data[4]).format('0,0.00')
  
        $($(row).find('td')[4]).addClass('text-right')
        $($(row).find('td')[4]).text(val2)
  
        val3 = numeral(data[5]).format('0,0.00')
  
        $($(row).find('td')[5]).addClass('text-right')
        $($(row).find('td')[5]).text(val3)
      },
    })
  
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


      tablapersonal = $('#tablaPer').DataTable({
        columnDefs: [
          {
            targets: -1,
            data: null,
            defaultContent:
              "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-success btnSelPer' data-toggle='tooltip' data-placement='top' title='Seleccionar Obra'><i class='fas fa-hand-pointer'></i></button></div></div>",
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
  
    $(document).on('click', '#bproveedor', function () {
      $('.modal-header').css('background-color', '#007bff')
      $('.modal-header').css('color', 'white')
  
      $('#modalProspecto').modal('show')
    })
  
    
    $(document).on('click', '#bper', function () {
        $('.modal-header').css('background-color', '#007bff')
        $('.modal-header').css('color', 'white')
    
        $('#modalPersonal').modal('show')
      })
    
   
  
    $(document).on('click', '#bobra', function () {
      $('.modal-header').css('background-color', '#007bff')
      $('.modal-header').css('color', 'white')
  
      $('#modalObra').modal('show')
  
    })
  
    $(document).on('click', '.btnSelCliente', function () {
      fila = $(this).closest('tr')
  
      idprov = fila.find('td:eq(0)').text()
      nomprov = fila.find('td:eq(2)').text()
  
      opcion = 1
  
      $('#id_prov').val(idprov)
      $('#nombre').val(nomprov)
      $('#modalProspecto').modal('hide')
    })
  

    $(document).on('click', '#btnGuardar', function () {
      folio = $('#folio').val()
      fecha = $('#fecha').val()
  
      id_prov = $('#id_prov').val()
      proveedor = $('#nombre').val()
      id_obra = $('#id_obra').val()
      obra = $('#obra').val()
      id_sol = $('#id_sol').val()
      solicitante = $('#solicitante').val()
      concepto = $('#concepto').val()
  
      total = $('#total').val().replace(/,/g, '')
      tokenid = $('#tokenid').val()
      opcion = $('#opcion').val()
      usuario= $('#nameuser').val()
  
      if (
        total.length != 0 &&
        concepto.length != 0 &&
        id_prov.length != 0 &&
        id_obra.length != 0 &&
        id_sol.length != 0
      ) {
        $.ajax({
          type: 'POST',
          url: 'bd/crudreq.php',
          dataType: 'json',
          data: {
            fecha: fecha,
            folio: folio,
            id_prov: id_prov,
            id_obra: id_obra,
            id_sol: id_sol,
            concepto: concepto,
            total: total,
            tokenid: tokenid,
            opcion: opcion,
            usuario: usuario
          },
          success: function (res) {
            if (res == 0) {
              Swal.fire({
                title: 'Error al Guardar',
                icon: 'error',
              })
            } else {
              Swal.fire({
                title: 'Operación Exitosa',
                icon: 'success',
              })
  
              window.setTimeout(function () {
                window.location.href = 'cntareq.php'
              }, 1500)
            }
          },
        })
      } else {
        Swal.fire({
          title: 'Datos Faltantes',
          icon: 'warning',
        })
        return false
      }
    })
  

  

  
    // SELECCIONAR  DESECHABLE
    $(document).on('click', '.btnSelObra', function () {
      fila = $(this).closest('tr')
      id_obra = fila.find('td:eq(0)').text()
      obra = fila.find('td:eq(2)').text()
      
  
      /*
       */
      $('#id_obra').val(id_obra)
      $('#obra').val(obra)
      
  
      $('#modalObra').modal('hide')
    })
  

    $(document).on('click', '.btnSelPer', function () {
        fila = $(this).closest('tr')
        id_per = fila.find('td:eq(0)').text()
        personal = fila.find('td:eq(1)').text()
        
    
        /*
         */
        $('#id_sol').val(id_per)
        $('#solicitante').val(personal)
        
    
        $('#modalPersonal').modal('hide')
      })
    //BOTON LIMPIAR DESECHABLE
    $(document).on('click', '#btlimpiarides', function () {
      limpiardes()
    })
  
    //AGREGAR DESECHABLE
    $(document).on('click', '#btnagregarides', function () {
      folio = $('#folio').val()
     
      cantidad = $('#cantidadconcepto').val().replace(/,/g, '')
      concepto = $('#nomconcepto').val()
      unidad = $('#unidadm').val()
      costo = $('#costou').val().replace(/,/g, '')
     
      importe = parseFloat(costo) * parseFloat(cantidad)
      opcion = 1
  
      if (
        folio.length != 0 &&
        concepto.length != 0 &&
        cantidad.length != 0 &&
        unidad.length != 0 &&
        costo.length != 0
      ) {
        $.ajax({
          type: 'POST',
          url: 'bd/detallereq.php',
          dataType: 'json',
          //async: false,
          data: {
            folio: folio,
            cantidad: cantidad,
            concepto: concepto,
            opcion: opcion,
            importe: importe,
            unidad: unidad,
            costo: costo,
          },
          success: function (data) {
            id_reg = data[0].id_reg
          
            concepto = data[0].concepto
            cantidad = data[0].cantidad
            unidad = data[0].unidad
            precio = data[0].precio
            subtotal = data[0].importe
  
            tablaDetIndes.row
              .add([id_reg,  concepto, unidad, precio, cantidad, subtotal,])
              .draw()
            $.ajax({
              url: 'bd/sumareq.php',
              type: 'POST',
              dataType: 'json',
              async: false,
              data: { folio: folio },
              success: function (data) {
                total = data
  
                var myNumeral = numeral(total)
                var valor = myNumeral.format('0,0.00')
                
                $('#total').val(valor)
              },
            })
            limpiardes()
          },
        })
      } else {
        Swal.fire({
          title: 'Datos Faltantes',
          icon: 'warning',
        })
        return false
      }
    })
  
    function limpiar() {
      var today = new Date()
      var dd = today.getDate()
  
      var mm = today.getMonth() + 1
      var yyyy = today.getFullYear()
      if (dd < 10) {
        dd = '0' + dd
      }
  
      if (mm < 10) {
        mm = '0' + mm
      }
  
      today = yyyy + '-' + mm + '-' + dd
  
      $('#id_prov').val('')
      $('#nombre').val('')
      $('#fecha').val(today)
      $('#folio').val('')
      $('#folior').val('')
      $('#id_partida').val('')
      $('#partida').val('')
      $('#ccredito').val(false)
      $('#fechal').val(today)
      $('#cfactura').val(false)
      $('#referencia').val('')
      $('#proyecto').val('')
      $('#subtotal').val('')
      $('#iva').val('')
      $('#total').val('')
      $('#cinverso').val(false)
    }
  
    function limpiardes() {
     
      $('#nomconcepto').val('')
      $('#unidadm').val('')
      $('#cantidadconcepto').val('')
      $('#costou').val('')
      
     
    }
  
    function round(value, decimals) {
      return Number(Math.round(value + 'e' + decimals) + 'e-' + decimals)
    }
  
    // BORRAR MATERIAL
    $(document).on('click', '.btnBorrar', function (e) {
      e.preventDefault()
      fila = $(this)
      folio = $('#folio').val()
      id = parseInt($(this).closest('tr').find('td:eq(0)').text())
      usuario = $('#nameuser').val()
  
      tipooperacion = 2
  
      $.ajax({
        type: 'POST',
        url: 'bd/detallereq.php',
        dataType: 'json',
        data: { id: id, opcion: tipooperacion, folio: folio },
        success: function (data) {
          if (data == 1) {
            tablaDetIndes.row(fila.parents('tr')).remove().draw()
            tipo = 4
            $.ajax({
              url: 'bd/sumareq.php',
              type: 'POST',
              dataType: 'json',
              async: false,
              data: { folio: folio, tipo: tipo },
              success: function (data) {
                 total = data
  
                var myNumeral = numeral(total)
                var valor = myNumeral.format('0,0.00')
              
                $('#total').val(valor)
               
              },
            })
          } else {
            mensajeerror()
          }
        },
      })
    })
  
    function mensajeerror() {
      swal.fire({
        title: 'Operacion No exitosa',
        icon: 'error',
        focusConfirm: true,
        confirmButtonText: 'Aceptar',
      })
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
  
  function addCommas(nStr) {
    nStr += ''
    x = nStr.split('.')
    x1 = x[0]
    x2 = x.length > 1 ? '.' + x[1] : ''
    var rgx = /(\d+)(\d{3})/
    while (rgx.test(x1)) {
      x1 = x1.replace(rgx, '$1' + ',' + '$2')
    }
    return x1 + x2
  }
  