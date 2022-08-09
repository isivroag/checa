$(document).ready(function () {
  var id_concepto, opcion
  opcion = 4
  var fila

  jQuery.ajaxSetup({
    beforeSend: function() {
        $("#div_carga").show();
    },
    complete: function() {
        $("#div_carga").hide();
    },
    success: function() {},
});


jQuery.ajaxSetup({
  beforeSend: function() {
      $("#div_carga2").show();
  },
  complete: function() {
      $("#div_carga2").hide();
  },
  success: function() {},
});
document.getElementById('cantidad').onblur = function () {
  calculosubtotalreq1(this.value.replace(/,/g, ''))
  this.value = parseFloat(this.value.replace(/,/g, ''))
    .toFixed(2)
    .toString()
    .replace(/\B(?=(\d{3})+(?!\d))/g, ',')
}


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

          if (row[9] == 'CO') {
            return  "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-danger btnborrarc'><i class='fas fa-trash'></i></button></div></div>"
          } else {
            return ''
          }
        },
      },
      { className: 'hide_column', targets: [0] },
        { className: 'hide_column', targets: [1] },
       /* { className: 'hide_column', targets: [2] },*/
        { className: 'hide_column', targets: [9] },
        { className: 'hide_column', targets: [10] },
      { width: '50%', targets: 4 },
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
      $($(row).find('td')[6]).addClass('text-right')
      $($(row).find('td')[7]).addClass('text-right')
      $($(row).find('td')[8]).addClass('text-right')
      if (data[9] == 'A') {
        $('td', row).css('background-color', '#D1D1D1')
        $('td', row).css('font-weight', 'bold')
        //$($(row).find('td')).addClass('bg-gradient-secondary')
      } else if (data[9] == 'B') {
        $('td', row).css('background-color', '#A4C9E7')
      } else if (data[9] == 'C') {
        $('td', row).css('background-color', '#EE936E')
      } else if (data[9] == 'CO') {
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

  tablaCon = $('#tablaCon').DataTable({
    fixedHeader: false,
    searching:false,
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

  document.getElementById('cantidad').onblur = function () {
    calcularimporte(this.value.replace(/,/g, ''))
    this.value = parseFloat(this.value.replace(/,/g, ''))
      .toFixed(2)
      .toString()
      .replace(/\B(?=(\d{3})+(?!\d))/g, ',')
  }

  //CALCULO IMPORTE
  function calcularimporte(cant) {
    cantidad = cant
    precio = $('#precio_renglon').val().replace(/,/g, '')
    importe = round(cantidad * precio, 2)
    $('#importe').val(importe) 
  }

  //AGREGAR CONCEPTO
  $(document).on('click', '#btnAgregar', function () {
    obra = $('#id_obra').val()
    $('#modalCon').modal('show')
});


$(document).on('click', '#btnAgregarc', function () {
  obra = $('#id_obra').val()
  estimacion=$('#idtmp').val()
  id=$('#id_renglon').val()
  precio=$('#precio_renglon').val().replace(/,/g, '')
  cantidad=$('#cantidad').val().replace(/,/g, '')
  importe=$('#importe').val().replace(/,/g, '')
  opc=1

  if (
    obra.length == 0 ||
    estimacion.length == 0 ||
    indice.length == 0 ||
    cantidad.length == 0
   
  ) {
    Swal.fire({
      title: 'Datos Faltantes',
      text: 'Debe ingresar todos los datos Requeridos',
      icon: 'warning',
    })
    return false
  } else {
    $.ajax({
      url: 'bd/estimacionconcepto.php',
      type: 'POST',
      dataType: 'json',
      data: {
        obra: obra,
        estimacion: estimacion,
        id: id,
        precio: precio,
        cantidad: cantidad,
        importe: importe,
        opc: opc

      },
      success: function (data) {
        if (data == 1) {
          window.location.reload()
        } else {
          Swal.fire({
            title: 'Error ',
            text: 'No fue posible agregar el concepto',
            icon: 'error',
          })
        }
      },
    })
  }
});



$(document).on('click', '.btnborrarc', function (event) {
  event.preventDefault()
  obra = $('#id_obra').val()
  estimacion=$('#idtmp').val()
  fila = $(this)
  id = parseInt($(this).closest('tr').find('td:eq(0)').text())
  opc=2
 

  if (
    obra.length == 0 ||
    estimacion.length == 0 ||
    id.length == 0
    
   
  ) {
    Swal.fire({
      title: 'Datos Faltantes',
      text: 'Debe ingresar todos los datos Requeridos',
      icon: 'warning',
    })
    return false
  } else {
    $.ajax({
      url: 'bd/estimacionconcepto.php',
      type: 'POST',
      dataType: 'json',
      data: {
        obra: obra,
        estimacion: estimacion,
        id: id,
        opc: opc

      },
      success: function (data) {
        if (data == 1) {
          window.location.reload()
        } else {
          Swal.fire({
            title: 'Error ',
            text: 'No fue posible agregar el concepto',
            icon: 'error',
          })
        }
      },
    })
  }
})

$('#modalCon').on('shown.bs.modal', function () {
    
  tablaCon.columns.adjust().draw();
})


$(document).on('click', '#btnbuscar', function () {
  texto = $('#txtbuscar').val()
  obra = $('#id_obra').val()



  tablaCon.clear()
  tablaCon.draw()

if (texto.length>0){
  $.ajax({
    type: "POST",
    url: "bd/buscarconceptopres2.php",
    dataType: "json",
    data: { obra: obra, texto: texto },
    success: function(data) {

        for (var i = 0; i < data.length; i++) {
            tablaCon.row
                .add([
                    data[i].id_renglon,
                    data[i].indice_renglon,
                    data[i].clave_renglon,
                    data[i].concepto_renglon,
                    data[i].unidad_renglon,
                    data[i].cantidad_renglon != '' ? Intl.NumberFormat('es-MX',{ minimumFractionDigits: 2 }).format(parseFloat(data[i].cantidad_renglon).toFixed(2)) : "",
                    data[i].precio_renglon != '' ? Intl.NumberFormat('es-MX',{ minimumFractionDigits: 2 }).format(parseFloat(data[i].precio_renglon).toFixed(2)) : "",
                    data[i].monto_renglon != '' ? Intl.NumberFormat('es-MX',{ minimumFractionDigits: 2 }).format(parseFloat(data[i].monto_renglon).toFixed(2)) : "",
                    data[i].tipo_renglon,
                    data[i].padre_renglon,
                   

                ])
                .draw();

            //tabla += '<tr><td>' + res[i].id_objetivo + '</td><td>' + res[i].desc_objetivo + '</td><td class="text-center">' + icono + '</td><td class="text-center"></td></tr>';
        }
    },
    error: function(){
      Swal.fire({
        title: 'Error de funcion',
              icon: 'error',
      })
    }
});
}

  
})


buscarpresupuesto()

  function buscarpresupuesto(){
    tablaDet.clear();
    tablaDet.draw();
  
    
    obra = $('#id_obra').val()
    estimacion=$('#idtmp').val()
    console.log(obra)
    console.log(estimacion)
  
        $.ajax({
            type: "POST",
            url: "bd/buscarconceptopres.php",
            dataType: "json",
            data: { obra: obra, estimacion: estimacion },
            success: function(data) {
  
                for (var i = 0; i < data.length; i++) {
                    tablaDet.row
                        .add([
                            data[i].id_det,
                            data[i].id_renglon,
                            data[i].indice_renglon,
                            data[i].clave_renglon,
                            data[i].concepto_renglon,
                            data[i].cantidad_renglon != '' ? Intl.NumberFormat('es-MX',{ minimumFractionDigits: 2 }).format(parseFloat(data[i].cantidad_renglon).toFixed(2)) : "",
                            data[i].unidad_renglon,
                            data[i].precio_renglon != '' ? Intl.NumberFormat('es-MX',{ minimumFractionDigits: 2 }).format(parseFloat(data[i].precio_renglon).toFixed(2)) : "",
                            data[i].monto_renglon != '' ? Intl.NumberFormat('es-MX',{ minimumFractionDigits: 2 }).format(parseFloat(data[i].monto_renglon).toFixed(2)) : "",
                            data[i].tipo_renglon,
                            data[i].padre_renglon,
                           
  
                        ])
                        .draw();
  
                    //tabla += '<tr><td>' + res[i].id_objetivo + '</td><td>' + res[i].desc_objetivo + '</td><td class="text-center">' + icono + '</td><td class="text-center"></td></tr>';
                }
            },
            error: function(){
              swal.fire({
                title: 'Error ',
                icon: 'error',
                focusConfirm: true,
                confirmButtonText: 'Aceptar',
              })
            }
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
  $(document).on('click', '#btnGuardar', function () {
    obra=$('#id_obra').val()
    estimacion=$('#idtmp').val()
    folio=$('#folio').val()
    descripcion=$('#descripcion').val()
    folioest=$('#folioest').val()
    opcion=$('#opcion').val()
    fecha=$('#fecha').val()
    idusuario=$('#iduser').val()
  
    if (
      estimacion.length == 0 ||
      folio.length == 0 
    
     
    ) {
      Swal.fire({
        title: 'Datos Faltantes',
        text: 'Debe ingresar todos los datos Requeridos',
        icon: 'warning',
      })
      return false
    } else {
      $.ajax({
        url: 'bd/crudestimacion.php',
        type: 'POST',
        dataType: 'json',
        data: {
          obra: obra,
          estimacion: estimacion,
          folio: folio,
          descripcion: descripcion,
          folioest: folioest,
          fecha: fecha,
          idusuario: idusuario,
          opcion: opcion,
  
        },
        success: function (data) {
          if (data == 1) {
            window.location.href='cntaestimacion.php?id_obra='+obra
          } else {
            Swal.fire({
              title: 'Error ',
              text: 'No fue posible agregar el concepto',
              icon: 'error',
            })
          }
        },
        error: function(){
          Swal.fire({
            title: 'Error',
            icon: 'error',
          })
        }
      })
    }

  })

 
  $(document).on('click', '.btnSel', function () {

    fila = $(this).closest('tr')
    id = fila.find('td:eq(0)').text()
    indice = fila.find('td:eq(1)').text()
    clave = fila.find('td:eq(2)').text()
    concepto = fila.find('td:eq(3)').text()
    unidad = fila.find('td:eq(4)').text()
    cantidadpres = fila.find('td:eq(5)').text()
    precio = fila.find('td:eq(6)').text()

   
    $('#id_renglon').val(id)
    $('#indice_renglon').val(indice)
    $('#clave_renglon').val(clave)
    $('#cantidad_renglon').val(cantidadpres)
    $('#concepto_renglon').val(concepto)
    $('#unidad_renglon').val(unidad)
    $('#precio_renglon').val(precio)
   
    $('#modalAlta').modal('show')
  })

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