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
      
      if (tipousuario == 1) {
        columnas =
          "<div class='text-center'><div class='btn-group'>\
          <button class='btn btn-sm btn-primary btnVerpagos' data-toggle='tooltip' data-placement='top' title='Ver Pagos' ><i class='fas fa-search-dollar'></i></button>\
        <button class='btn btn-sm btn-success btnPagar' data-toggle='tooltip' data-placement='top' title='Pagar' ><i class='fas fa-dollar-sign'></i></button>\
          <button class='btn btn-sm bg-danger btnCancelar'  data-toggle='tooltip' data-placement='top' title='Cancelar'><i class='fas fa-ban'></i></button>\
          </div></div>"
      } else {
        columnas =
          "<div class='text-center'><div class='btn-group'>\
          <button class='btn btn-sm btn-primary btnVerpagos' data-toggle='tooltip' data-placement='top' title='Ver Pagos' ><i class='fas fa-search-dollar'></i></button>\
        <button class='btn btn-sm btn-success btnPagar' data-toggle='tooltip' data-placement='top' title='Pagar' ><i class='fas fa-dollar-sign'></i></button>\
          <button class='btn btn-sm bg-danger btnCancelar'  data-toggle='tooltip' data-placement='top' title='Cancelar'><i class='fas fa-ban'></i></button>\
          </div></div>"
      }
      return columnas
    }
  
    var textcolumnas3 = permisos3()
  
    function permisos3() {
      var tipousuario = $('#tipousuario').val()
      var columnas = ''
     
      if (tipousuario == 1) {
        columnas = ''
        /*"<div class='text-center'><div class='btn-group'><button class='btn btn-sm bg-danger btnCancelarpago' data-toggle='tooltip' data-placement='top' title='Cancelar'><i class='fas fa-ban'></i></button>\
          </div></div>"*/
      } else {
        columnas =
          "<div class='text-center'><div class='btn-group'><button class='btn btn-sm bg-danger btnCancelarpago' data-toggle='tooltip' data-placement='top' title='Cancelar'><i class='fas fa-ban'></i></button>\
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
  
    //FUNCION FORMATO MONEDA
  

  
    // TABLA PRINCIPAL
  
    tablaVis = $('#tablaV').DataTable({
      fixedHeader: false,
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
          title: 'Reporte Gastos de Obra',
          className: 'btn bg-success ',
          exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7, 8] },
        },
        {
          extend: 'pdfHtml5',
          text: "<i class='far fa-file-pdf'> PDF</i>",
          titleAttr: 'Exportar a PDF',
          title: 'Reporte Gastos de Obra',
          className: 'btn bg-danger',
          exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7, 8] },
        },
      ],
  
      columnDefs: [
        {
          targets: -1,
          data: null,
          defaultContent: textcolumnas,
        },
        { className: 'hide_column', targets: [1] },
        { className: 'hide_column', targets: [3] },
      ],
      rowCallback: function (row, data) {
        $($(row).find('td')['7']).addClass('text-right')
  
        $($(row).find('td')['7']).addClass('currency')
        $($(row).find('td')['8']).addClass('text-right')
  
        $($(row).find('td')['8']).addClass('currency')
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
              .column(6)
              .data()
              .reduce(function (a, b) {
                return intVal(a) + intVal(b)
              }, 0)*/
  
        total = api
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
  
    //BOTON SELECCIONAR PROVEEDOR

  

  
    //BOTON NUEVO
    $('#btnNuevo').click(function () {
     id=$('#id_obra').val();
     window.location.href = 'tmpestimacion.php?id_obra='+id
    })
  
    //BOTON EDITAR
    $(document).on('click', '.btnEditar', function () {})
  
    //BOTON BUSCAR OBRA
    $(document).on('click', '#bobra', function () {
      $('#modalObra').modal('show')
    })
    //BOTON SELECCIONAR OBRA
    //BOTON SELECCIONAR OBRA
    $(document).on('click', '.btnSelObra', function () {
      fila = $(this)
      id_obra = parseInt($(this).closest('tr').find('td:eq(0)').text())
      
      window.location.href = 'cntaestimacion.php?id_obra='+id_obra
    })
  

  





  

    //BUSQUEDA GENERAL
    $(document).on('click', '#btnBuscar', function () {
      var inicio = $('#inicio').val()
      var final = $('#final').val()
      var obra = $('#id_obra').val()
      var opcion = 1
  
      tablaVis.clear()
      tablaVis.draw()
  
      if (inicio != '' && final != '' && obra != '') {
        $.ajax({
          type: 'POST',
          url: 'bd/buscarotro.php',
          dataType: 'json',
          data: { inicio: inicio, final: final, obra: obra, opcion: opcion },
          success: function (data) {
            for (var i = 0; i < data.length; i++) {
              tablaVis.row
                .add([
                  data[i].id_otro,
                  data[i].id_obra,
                  data[i].corto_obra,
                  data[i].id_prov,
                  data[i].razon_prov,
                  data[i].fecha,
                  data[i].desc_otro,
                  Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
                    parseFloat(data[i].monto_otro).toFixed(2),
                  ),
                  Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
                    parseFloat(data[i].saldo_otro).toFixed(2),
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
  