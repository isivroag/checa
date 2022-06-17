$(document).ready(function () {
    var id, opcion
    opcion = 4

  

  
    tablaVis = $('#tablaV').DataTable({
        "paging": false,
        info:false,
      dom:
        "<'row justify-content-center'<'col-sm-12 col-md-4 form-group'l><'col-sm-12 col-md-4 form-group'B><'col-sm-12 col-md-4 form-group'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        
        columnDefs: [
          
          {
            targets: 4,
            render: function (data, type, full, meta) {
              return "<div class='text-wrap width-200'>" + data + '</div>'
              //return "<div class='text-wrap width-200'>" + data + '</div>'
            },
          },
          {
            targets: 5,
            render: function (data, type, full, meta) {
              return "<div class='text-wrap width-200'>" + data + '</div>'
              //return "<div class='text-wrap width-200'>" + data + '</div>'
            },

            
          }, { className: "text-right", "targets": [6] },
          { className: "text-center", "targets": [7] },
          {
            "render": function (data, type, row) {
                return commaSeparateNumber(data);
            },
            "targets": [6]
        },
          
         { "width": "50px", "targets": 1 },
         { "width": "50px", "targets": 0}
        ],
    
      buttons: [
        {
          extend: 'excelHtml5',
          text: "<i class='fas fa-file-excel'> Excel</i>",
          titleAttr: 'Exportar a Excel',
          title: 'Reporte de Presupuestos',
          className: 'btn bg-success ',
          footer: true,
          exportOptions: {
            columns: [0, 1, 2, 3, 4, 5,6,7],
            /*format: {
              body: function (data, row, column, node) {
                if (column === 5) {
                  return data.replace(/[$,]/g, '')
                } else if (column === 6) {
                  return data
                } else {
                  return data
                }
              },
            },*/
          },
        },
        {
          extend: 'pdfHtml5',
          text: "<i class='far fa-file-pdf'> PDF</i>",
          titleAttr: 'Exportar a PDF',
          title: 'Reporte de Presupuestos',
          footer: true,
          className: 'btn bg-danger',
          exportOptions: { columns: [0, 1, 2, 3, 4, 5,6,7] },
          format: {
              body: function (data, row, column, node) {
                if (column === 6) {
                  /*switch (data) {
                    case '0':
                      return data.replace(0, 'RECHAZADO')
  
                      break
                    case '1':
                      return data.replace('1', 'PENDIENTE')
                      break
                    case '2':
                      return data.replace('2', 'ENVIADO')
                      break
                    case '3':
                      return data.replace('3', 'ACEPTADO')
                      break
                    case '4':
                      return data.replace('4', 'EN ESPERA')
                      break
                    case '5':
                      return data.replace('5', 'EDITADO')
                      break
                  }*/
                  return data
                } else {
                  return data
                }
              },
            },
        },
      ],
      stateSave: true,
      orderCellsTop: true,
    fixedHeader: true,
    paging:false,
      
  
      
  
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
  
     


      "footerCallback": function ( row, data, start, end, display ) {
        var api = this.api(), data;

        // Remove the formatting to get integer data for summation
        var intVal = function ( i ) {
            return typeof i === 'string' ?
                i.replace(/[\$,]/g, '')*1 :
                typeof i === 'number' ?
                    i : 0;
        };

        // Total over all pages
        total = api
            .column( 6 )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );

        // Total over this page
        pageTotal = api
            .column( 6, { page: 'current'} )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );

        // Update footer
        $( api.column( 6 ).footer() ).html(
            '$ '+ new Intl.NumberFormat('es-MX').format(Math.round((pageTotal + Number.EPSILON) * 100) / 100) 
        );
        }
    });
  
    function commaSeparateNumber(val) {
        while (/(\d+)(\d{3})/.test(val.toString())) {
            val = val.toString().replace(/(\d+)(\d{3})/, '$1' + ',' + '$2');
        }
        val = '$ ' + val
        return val;
    }

    
   function buscardiaio() {
      var inicio = $('#inicio').val()
      var final = $('#final').val()
    
  
      tablaVis.clear()
      tablaVis.draw()
     
  
      if (inicio != '' && final != '') {
        $.ajax({
          type: 'POST',
          url: 'bd/buscarregistrospago.php',
          dataType: 'json',
          data: { inicio: inicio, final: final },
          success: function (data) {
            for (var i = 0; i < data.length; i++) {
              
              tablaVis.row
                .add([
                  data[i].folio_pago,
                  data[i].folio_reg,
                  data[i].fecha,
                  data[i].nom,
                  data[i].nom_concepto,
                  data[i].concepto,
                  data[i].monto,
                  data[i].metodo,
                  
                ])
                .draw()
  
              //tabla += '<tr><td>' + res[i].id_objetivo + '</td><td>' + res[i].desc_objetivo + '</td><td class="text-center">' + icono + '</td><td class="text-center"></td></tr>';
            }
          },
        })
      } else {
        swal.fire({
            title: 'Debe Seleccionar Ambas Fechas',
            icon: 'warning',
            focusConfirm: true,
            confirmButtonText: 'Aceptar',
        })
      }
    }

  })
  

