$(document).ready(function () {
    var id, opcion
    opcion = 4
  
    //FUNCION FORMATO MONEDA
  
    tablaPs = $('#tablaPs').DataTable({
      dom:
        "<'row justify-content-center'<'col-sm-12 col-md-4 form-group'l><'col-sm-12 col-md-4 form-group'B><'col-sm-12 col-md-4 form-group'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
  
      buttons: [
        {
          extend: 'excelHtml5',
          text: "<i class='fas fa-file-excel'> Excel</i>",
          titleAttr: 'Exportar a Excel',
          title: 'Saldo de Provisiones',
          className: 'btn bg-success ',
          exportOptions: { columns: [0, 1, 2, 3, 4, 5] },
        },
        {
          extend: 'pdfHtml5',
          text: "<i class='far fa-file-pdf'> PDF</i>",
          titleAttr: 'Exportar a PDF',
          title: 'Saldo de Provisiones',
          className: 'btn bg-danger',
          exportOptions: { columns: [0, 1, 2, 3, 4,5] },
        },
      ],
      stateSave: true,
      paging: false,
  
      columnDefs: [
        {
          targets: -1,
          data: null,
          defaultContent:
            "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-success btnSelps' data-toggle='tooltip' data-placement='top' title='Seleccionar'><i class='fa-solid fa-check'></i></button></div></div>",
        },
  
        { width: '30%', targets: 2 },
        { width: '30%', targets: 3 },
        { width: '10%', targets: 4 },
        { width: '10%', targets: 5 },
        { width: '10%', targets: 1 },
      
      ],
      rowCallback: function (row, data) {
        $($(row).find('td')['4']).addClass('text-right')
  
        $($(row).find('td')['4']).addClass('currency')
        $($(row).find('td')['5']).addClass('text-right')
  
        $($(row).find('td')['5']).addClass('currency')
      },
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
  
        pagos = api
          .column(4, { page: 'current' })
          .data()
          .reduce(function (a, b) {
            return intVal(a) + intVal(b)
          }, 0)
  
        // Total over this page
        montototal = api
          .column(5, { page: 'current' })
          .data()
          .reduce(function (a, b) {
            return intVal(a) + intVal(b)
          }, 0)
  
        // Update footer
        $(api.column(5).footer()).html(
          Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
            parseFloat(montototal).toFixed(2),
          ),
        )
        $(api.column(4).footer()).html(
          Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
            parseFloat(pagos).toFixed(2),
          ),
        )
      },
    })
  
    $('#tablaPs thead tr').clone(true).appendTo('#tablaPs thead')
    $('#tablaPs thead tr:eq(1) th').each(function (i) {
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
  
        if (tablaPs.column(i).search() !== valbuscar) {
          tablaPs.column(i).search(valbuscar, true, true).draw()
        }
      })
    })
  
    tablaRq = $('#tablaRq').DataTable({
      dom:
        "<'row justify-content-center'<'col-sm-12 col-md-4 form-group'l><'col-sm-12 col-md-4 form-group'B><'col-sm-12 col-md-4 form-group'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
  
      buttons: [
        {
          extend: 'excelHtml5',
          text: "<i class='fas fa-file-excel'> Excel</i>",
          titleAttr: 'Exportar a Excel',
          title: 'Saldo de Cuentas x Pagar',
          className: 'btn bg-success ',
          exportOptions: { columns: [0, 1, 2, 3, 4,5,6] },
        },
        {
          extend: 'pdfHtml5',
          text: "<i class='far fa-file-pdf'> PDF</i>",
          titleAttr: 'Exportar a PDF',
          title: 'Saldo de Cuentas x Pagar',
          className: 'btn bg-danger',
          exportOptions: { columns: [0, 1, 2, 3, 4,5,6] },
        },
      ],
      stateSave: true,
      paging: false,
  
      columnDefs: [
        {
          targets: -1,
          data: null,
          defaultContent:
            "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-success btnSelrq' data-toggle='tooltip' data-placement='top' title='Seleccionar'><i class='fa-solid fa-check'></i></button></div></div>",
        },
  
        { width: '10%', targets: 0 },
        { width: '8%', targets: 1 },
        { width: '8%', targets: 2 },
        { width: '25%', targets: 3 },
        { width: '20%', targets: 4 },
        { width: '10%', targets: 5 },
        { width: '10%', targets: 6 },
        
      ],
      rowCallback: function (row, data) {
        $($(row).find('td')['5']).addClass('text-right')
  
        $($(row).find('td')['5']).addClass('currency')
        $($(row).find('td')['6']).addClass('text-right')
  
        $($(row).find('td')['6']).addClass('currency')
      },
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
  
        pagos = api
          .column(5, { page: 'current' })
          .data()
          .reduce(function (a, b) {
            return intVal(a) + intVal(b)
          }, 0)
  
        // Total over this page
        montototal = api
          .column(6, { page: 'current' })
          .data()
          .reduce(function (a, b) {
            return intVal(a) + intVal(b)
          }, 0)
  
        // Update footer
        $(api.column(6).footer()).html(
          Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
            parseFloat(montototal).toFixed(2),
          ),
        )
        $(api.column(5).footer()).html(
          Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
            parseFloat(pagos).toFixed(2),
          ),
        )
      },
    })
  
    $('#tablaRq thead tr').clone(true).appendTo('#tablaRq thead')
    $('#tablaRq thead tr:eq(1) th').each(function (i) {
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
  
        if (tablaRq.column(i).search() !== valbuscar) {
          tablaRq.column(i).search(valbuscar, true, true).draw()
        }
      })
    })
  /*
    tablaCxp = $('#tablaCxp').DataTable({
      dom:
        "<'row justify-content-center'<'col-sm-12 col-md-4 form-group'l><'col-sm-12 col-md-4 form-group'B><'col-sm-12 col-md-4 form-group'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
  
      buttons: [
        {
          extend: 'excelHtml5',
          text: "<i class='fas fa-file-excel'> Excel</i>",
          titleAttr: 'Exportar a Excel',
          title: 'Saldo de CxP',
          className: 'btn bg-success ',
          exportOptions: { columns: [0, 1, 2, 3, 4, 6, 7] },
        },
        {
          extend: 'pdfHtml5',
          text: "<i class='far fa-file-pdf'> PDF</i>",
          titleAttr: 'Reporte de Cuentas x Pagar',
          title: 'Listado de Egresos',
          className: 'btn bg-danger',
          exportOptions: { columns: [0, 1, 2, 3, 4, 6, 7] },
        },
      ],
      stateSave: true,
      paging: false,
  
      columnDefs: [
        {
          targets: -1,
          data: null,
          defaultContent:
            "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-success btnSelcxp' data-toggle='tooltip' data-placement='top' title='Seleccionar'><i class='fa-solid fa-check'></i></button></div></div>",
        },
  
        { width: '8%', targets: 2 },
        { width: '10%', targets: 1 },
        { width: '15%', targets: 3 },
        { width: '20%', targets: 4 },
        { width: '20%', targets: 5 },
        { width: '10%', targets: 6 },
        { width: '10%', targets: 7 },
      ],
      rowCallback: function (row, data) {
        $($(row).find('td')['6']).addClass('text-right')
  
        $($(row).find('td')['6']).addClass('currency')
        $($(row).find('td')['7']).addClass('text-right')
  
        $($(row).find('td')['7']).addClass('currency')
      },
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
  
        pagos = api
          .column(7, { page: 'current' })
          .data()
          .reduce(function (a, b) {
            return intVal(a) + intVal(b)
          }, 0)
  
        // Total over this page
        montototal = api
          .column(6, { page: 'current' })
          .data()
          .reduce(function (a, b) {
            return intVal(a) + intVal(b)
          }, 0)
  
        // Update footer
        $(api.column(6).footer()).html(
          Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
            parseFloat(montototal).toFixed(2),
          ),
        )
        $(api.column(7).footer()).html(
          Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
            parseFloat(pagos).toFixed(2),
          ),
        )
      },
    })
  
    $('#tablaCxp thead tr').clone(true).appendTo('#tablaCxp thead')
    $('#tablaCxp thead tr:eq(1) th').each(function (i) {
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
  
        if (tablaCxp.column(i).search() !== valbuscar) {
          tablaCxp.column(i).search(valbuscar, true, true).draw()
        }
      })
    })
  
    tablaProv = $('#tablaProv').DataTable({
      dom:
        "<'row justify-content-center'<'col-sm-12 col-md-4 form-group'l><'col-sm-12 col-md-4 form-group'B><'col-sm-12 col-md-4 form-group'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
  
      buttons: [
        {
          extend: 'excelHtml5',
          text: "<i class='fas fa-file-excel'> Excel</i>",
          titleAttr: 'Exportar a Excel',
          title: 'Saldo de Provisiones',
          className: 'btn bg-success ',
          exportOptions: { columns: [0, 1, 2, 3, 4, 6] },
        },
        {
          extend: 'pdfHtml5',
          text: "<i class='far fa-file-pdf'> PDF</i>",
          titleAttr: 'Saldo de Provisiones',
          title: 'Listado de Egresos',
          className: 'btn bg-danger',
          exportOptions: { columns: [0, 1, 2, 3, 4, 6] },
        },
      ],
      stateSave: true,
      paging: false,
  
      columnDefs: [
        {
          targets: -1,
          data: null,
          defaultContent:
            "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-success btnSelprovi' data-toggle='tooltip' data-placement='top' title='Seleccionar'><i class='fa-solid fa-check'></i></button></div></div>",
        },
  
        { width: '10%', targets: 0 },
        { width: '10%', targets: 1 },
        { width: '15%', targets: 2 },
        { width: '20%', targets: 3 },
        { width: '20%', targets: 4 },
        { width: '10%', targets: 5 },
        { width: '10%', targets: 6 },
      ],
      rowCallback: function (row, data) {
        $($(row).find('td')['6']).addClass('text-right')
  
        $($(row).find('td')['6']).addClass('currency')
        $($(row).find('td')['7']).addClass('text-right')
  
        $($(row).find('td')['7']).addClass('currency')
      },
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
  
        pagos = api
          .column(6, { page: 'current' })
          .data()
          .reduce(function (a, b) {
            return intVal(a) + intVal(b)
          }, 0)
  
        // Total over this page
        montototal = api
          .column(5, { page: 'current' })
          .data()
          .reduce(function (a, b) {
            return intVal(a) + intVal(b)
          }, 0)
  
        // Update footer
        $(api.column(5).footer()).html(
          Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
            parseFloat(montototal).toFixed(2),
          ),
        )
        $(api.column(6).footer()).html(
          Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
            parseFloat(pagos).toFixed(2),
          ),
        )
      },
    })
  
    $('#tablaProv thead tr').clone(true).appendTo('#tablaProv thead')
    $('#tablaProv thead tr:eq(1) th').each(function (i) {
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
  
        if (tablaProv.column(i).search() !== valbuscar) {
          tablaProv.column(i).search(valbuscar, true, true).draw()
        }
      })
    })
    var fila //capturar la fila para editar o borrar el registro
  */
    //botón SELECCIONAR
  
    $(document).on('click', '.btnSelps', function () {
      fila = $(this).closest('tr')
      id = parseInt(fila.find('td:eq(0)').text())
      tipo = 5
      swal
        .fire({
          title: 'SELECCIONAR',
          text:
            '¿Desea Marcar el Registro para incluirlo en el Rerporte de Pagos?',
          showCancelButton: true,
          icon: 'question',
          focusConfirm: true,
          confirmButtonText: 'Aceptar',
          cancelButtonText: 'Cancelar',
          confirmButtonColor: '#28B463',
          cancelButtonColor: '#d33',
        })
        .then(function (isConfirm) {
          if (isConfirm.value) {
            $.ajax({
              url: 'bd/seleccionrpt.php',
              type: 'POST',
              dataType: 'json',
              data: { id: id, tipo: tipo },
              success: function (data) {
                if (data == 1) {
                  window.location.reload()
                } else {
                }
              },
            })
          } else if (isConfirm.dismiss === swal.DismissReason.cancel) {
          }
        })
    })
  
    $(document).on('click', '.btnSelrq', function () {
      fila = $(this).closest('tr')
      id = parseInt(fila.find('td:eq(0)').text())
      tipo = 6
  
      swal
        .fire({
          title: 'SELECCIONAR',
          text:
            '¿Desea Marcar el Registro para incluirlo en el Rerporte de Pagos?',
          showCancelButton: true,
          icon: 'question',
          focusConfirm: true,
          confirmButtonText: 'Aceptar',
          cancelButtonText: 'Cancelar',
          confirmButtonColor: '#28B463',
          cancelButtonColor: '#d33',
        })
        .then(function (isConfirm) {
          if (isConfirm.value) {
            $.ajax({
              url: 'bd/seleccionrpt.php',
              type: 'POST',
              dataType: 'json',
              data: { id: id, tipo: tipo },
              success: function (data) {
                if (data == 1) {
                  window.location.reload()
                } else {
                }
              },
            })
          } else if (isConfirm.dismiss === swal.DismissReason.cancel) {
          }
        })
    })
  
 
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
  