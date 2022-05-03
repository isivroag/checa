$(document).ready(function () {
  var id, opcion
  opcion = 4

  // TOOLTIP DATATABLE
  $('[data-toggle="tooltip"]').tooltip()

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
        title: 'Reporte de Pago a Proveedores',
        className: 'btn bg-success ',
        exportOptions: { columns: [0, 1, 2, 3, 4, 6] },
      },
      {
        extend: 'pdfHtml5',
        text: "<i class='far fa-file-pdf'> PDF</i>",
        titleAttr: 'Exportar a PDF',
        title: 'Reporte de Pago a Proveedores',
        className: 'btn bg-danger',
        exportOptions: { columns: [0, 1, 2, 3, 4, 6] },
      },
    ],

    columnDefs: [
      {
        targets: -1,
        data: null,
        defaultContent:
          "<div class='text-center'><button class='btn btn-sm btn-success btnAutorizar' data-toggle='tooltip' data-placement='top' title='Autorizar'><i class='fa-solid fa-dollar-sign'></i></button>\
              <button class='btn btn-sm btn-warning text-light btnCancelar'><i class='fa-solid fa-rectangle-xmark' data-toggle='tooltip' data-placement='top' title='Cancelar'></i></button>\
              </div>",
      },
      { className: 'hide_column', targets: [5] },
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
    },
  })

  //FILTROS
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

      if (tablaVis.column(i).search() !== valbuscar) {
        tablaVis.column(i).search(valbuscar, true, true).draw()
      }
    })
  })

  var fila

  //BOTON EDITAR
  $(document).on('click', '.btnAutorizar', function () {})

  //BOTON BORRAR
  $(document).on('click', '.btnCancelar', function () {
    fila = $(this).closest('tr')
    id = parseInt(fila.find('td:eq(1)').text())
    tipodoc = fila.find('td:eq(0)').text()

    switch (tipodoc) {
      case 'PROVISION SUB':
        tipo = 8
        break
      case 'REQUISICION':
        tipo = 9
        break
      case 'CXP':
        tipo = 10
        break
      case 'PROVISION':
        tipo = 11
        break
    }

    swal
      .fire({
        title: 'SELECCIONAR',
        text: '¿Desea Quitar el registro del Rerporte de Pagos?',
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
})
