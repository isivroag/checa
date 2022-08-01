$(document).ready(function () {
  var id_concepto, opcion
  opcion = 4
  var fila

  //TABLA DETALLE ESTIMACION
  tablaDet = $('#tablaDet').DataTable({
    fixedHeader: true,
    paging: false,
    searching: false,
    ordering:false,
    info: false,
    columnDefs: [
  
      {
        targets: -1,
        data: null,
        render: function (data, type, row) {
          'use strict'

          if (row[8] == 'CO') {
            return  "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-danger btnborrarProd'><i class='fas fa-trash'></i></button></div></div>"
          } else {
            return ''
          }
        },
      },
      /*{ className: 'hide_column', targets: [0] },
        { className: 'hide_column', targets: [1] },
        { className: 'hide_column', targets: [2] },*/
        { className: 'hide_column', targets: [8] },
        { className: 'hide_column', targets: [9] },
      { width: '50%', targets: 3 },
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
      $($(row).find('td')[5]).addClass('text-right')
      $($(row).find('td')[6]).addClass('text-right')
      $($(row).find('td')[7]).addClass('text-right')
      if (data[8] == 'A') {
        $('td', row).css('background-color', '#D1D1D1')
        $('td', row).css('font-weight', 'bold')
        //$($(row).find('td')).addClass('bg-gradient-secondary')
      } else if (data[8] == 'B') {
        $('td', row).css('background-color', '#A4C9E7')
      } else if (data[8] == 'C') {
        $('td', row).css('background-color', '#EE936E')
      } else if (data[8] == 'CO') {
        //$('td', row).css('background-color', '#FEFEFE');
        $($(row).find('td')).addClass('ConSel')
      }
    },
  })
  //TABLA BUSCAR CONCEPTO
  tablaCon2 = $('#tablaCon2').DataTable({
    fixedHeader: false,
    paging: false,
    ordening: false,
    order: [[1, 'asc']],
    columnDefs: [
      { className: 'hide_column', targets: [0] },
      { className: 'hide_column', targets: [8] },
      { className: 'hide_column', targets: [9] },
      { width: '50%', targets: 3 },
      

      {
        targets: -1,
        data: null,
        render: function (data, type, row) {
          'use strict'

          if (row[8] == 'CO') {
            return "<div class='text-center'><button class='btn btn-sm btn-success btnSel' data-toggle='tooltip' data-placement='top' title='Seleccionar'><i class='fa-solid fa-circle-check'></i></button>\
                </div>"
          } else {
            return ''
          }
        },
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
      $($(row).find('td')[5]).addClass('text-right')
      $($(row).find('td')[6]).addClass('text-right')
      $($(row).find('td')[7]).addClass('text-right')
      if (data[8] == 'A') {
        $('td', row).css('background-color', '#D1D1D1')
        $('td', row).css('font-weight', 'bold')
        //$($(row).find('td')).addClass('bg-gradient-secondary')
      } else if (data[8] == 'B') {
        $('td', row).css('background-color', '#A4C9E7')
      } else if (data[8] == 'C') {
        $('td', row).css('background-color', '#EE936E')
      } else if (data[8] == 'CO') {
        //$('td', row).css('background-color', '#FEFEFE');
        $($(row).find('td')).addClass('ConSel')
      }
    },
  })

  function commaSeparateNumber(val) {
    while (/(\d+)(\d{3})/.test(val.toString())) {
      val = val.toString().replace(/(\d+)(\d{3})/, '$1' + ',' + '$2')
    }

    return val
  }

  //CALCULO IMPORTE
  function calcularimporte(cant, pv) {
    cantidad = cant
    precio = pv
    importe = round(cantidad * precio, 2)
    return importe
  }

  //AGREGAR CONCEPTO
  $(document).on('click', '#btnAgregar', function () {
    obra = $('#id_obra').val()
   
   
    $('#modalCon2').modal('show')
    


  $('#modalCon2').on('shown.bs.modal', function () {
    
    tablaCon2.columns.adjust().draw();
  })
});

  function buscarpresupuesto(obra){
    tablaCon.clear();
    tablaCon.draw();
  
  
  
  
        $.ajax({
            type: "POST",
            url: "bd/buscarpres.php",
            dataType: "json",
            data: { obra: obra },
            success: function(data) {
  
                for (var i = 0; i < data.length; i++) {
                    tablaCon.row
                        .add([
                            data[i].id_renglon,
                            data[i].indice_renglon,
                            data[i].clave_renglon,
                            data[i].concepto_renglon,
                            data[i].unidad_renglon,
                            Intl.NumberFormat('es-MX',{ minimumFractionDigits: 2 }).format(parseFloat(data[i].cantidad_renglon).toFixed(2)),
                            Intl.NumberFormat('es-MX',{ minimumFractionDigits: 2 }).format(parseFloat(data[i].precio_renglon).toFixed(2)),
                            Intl.NumberFormat('es-MX',{ minimumFractionDigits: 2 }).format(parseFloat(data[i].monto_renglon).toFixed(2)),
                            //new Intl.NumberFormat('es-MX').format(Math.round((data[i].monto_renglon) * 100,2) / 100) ,
                            data[i].tipo_renglon,
                            data[i].padre_renglon,
                           
  
                        ])
                        .draw();
  
                    //tabla += '<tr><td>' + res[i].id_objetivo + '</td><td>' + res[i].desc_objetivo + '</td><td class="text-center">' + icono + '</td><td class="text-center"></td></tr>';
                }
            },
        });
  }

  //borrar item grid
  $(document).on('click', '.btnborrarProd', function (event) {
    event.preventDefault()

    folio = $('#folio').val()
    fila = $(this)

    id = parseInt($(this).closest('tr').find('td:eq(0)').text())

    console.log(id)

    if (id.length == 0) {
      Swal.fire({
        title: 'Datos Faltantes',
        text: 'Debe ingresar todos los datos',
        icon: 'warning',
      })
      return false
    } else {
      opcion = 3
      $.ajax({
        url: 'bd/crudtmpdetalle.php',
        type: 'POST',
        dataType: 'json',
        data: {
          id: id,
          folio: folio,
          opcion: opcion,
        },
        success: function (data) {
          if (data != 0) {
            tablaDet.row(fila.parents('tr')).remove().draw()

            buscarsubtotal(folio)
          } else {
            Swal.fire({
              title: 'Operacion No Exitosa',
              icon: 'warning',
            })
          }
        },
        error: function () {
          Swal.fire({
            title: 'Operacion No Exitosa',
            icon: 'warning',
          })
        },
      })
    }
  })

  //botón guardar
  $(document).on('click', '#btnGuardar', function () {})

  // boton buscar concepto
  $(document).on('click', '#bconcepto', function () {})

  function round(value, decimals) {
    return Number(Math.round(value + 'e' + decimals) + 'e-' + decimals)
  }

  function mensaje() {
    swal.fire({
      title: 'Registro Exitoso',
      icon: 'success',
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
