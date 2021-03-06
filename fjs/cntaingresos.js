$(document).ready(function () {
    var id, opcion
    opcion = 4

    $('#tablaV thead tr').clone(true).appendTo( '#tablaV thead' );
    $('#tablaV thead tr:eq(1) th').each( function (i) {

      
      
        var title = $(this).text();
        $(this).html( '<input class="form-control form-control-sm" type="text" placeholder="'+title+'" />' );
 
        $( 'input', this ).on( 'keyup change', function () {
          
          if (i==4){

           valbuscar=this.value;
          }else{
            valbuscar=this.value;

          }
          
            if ( tablaVis.column(i).search() !== valbuscar ) {
                tablaVis
                    .column(i)
                    .search( valbuscar,true,true )
                    .draw();
            }
        } );


    } );

  
    tablaVis = $('#tablaV').DataTable({
      dom:
        "<'row justify-content-center'<'col-sm-12 col-md-4 form-group'l><'col-sm-12 col-md-4 form-group'B><'col-sm-12 col-md-4 form-group'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        
        columnDefs: [
          
         
         { className: "text-right", "targets": [4] },
      { className: "text-right", "targets": [5] },
          
         { "width": "200px", "targets": 1 },
         { "width": "80px", "targets": 0},
         { "width": "80px", "targets": 2},{ "width": "200px", "targets": 3}
        ],
    
      buttons: [
        {
          extend: 'excelHtml5',
          text: "<i class='fas fa-file-excel'> Excel</i>",
          titleAttr: 'Exportar a Excel',
          title: 'CONSULTA DE INGRESOS',
          className: 'btn bg-success ',
          footer: true,
          exportOptions: {
            columns: [0, 1, 2, 3, 4, 5],
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
          title: 'CONSULTA DE INGRESOS',
          footer: true,
          className: 'btn bg-danger',
          exportOptions: { columns: [0, 1, 2, 3, 4,5] },
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
    ordering:false,
      
  
      
  
      //Para cambiar el lenguaje a espa??ol
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
  
     


      "footerCallback": function ( row, data, start, end, display ) {
        var api = this.api(), data;

       
        var intVal = function ( i ) {
            return typeof i === 'string' ?
                i.replace(/[\$,]/g, '')*1 :
                typeof i === 'number' ?
                    i : 0;
        };

        saldototal = api
            .column( 5, { page: 'current'} )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );

        // Total over this page
        montototal = api
            .column( 4, { page: 'current'} )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );

        // Update footer
        $(api.column(4).footer()).html(
          Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
            parseFloat(montototal).toFixed(2),
          ),
        )
        $(api.column(5).footer()).html(
          Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
            parseFloat(saldototal).toFixed(2),
          ),
        )
        }
    });
  
    function commaSeparateNumber(val) {
        while (/(\d+)(\d{3})/.test(val.toString())) {
            val = val.toString().replace(/(\d+)(\d{3})/, '$1' + ',' + '$2');
        }
        val = '$ ' + val
        return val;
    }
    $('#btnBuscar').click(function () {
      var inicio = $('#inicio').val()
      var final = $('#final').val()
    
  
      tablaVis.clear()
      tablaVis.draw()
  
   
  
      if (inicio != '' && final != '') {
        $.ajax({
          type: 'POST',
          url: 'bd/buscarcxc.php',
          dataType: 'json',
          data: { inicio: inicio, final: final },
          success: function (data) {
            for (var i = 0; i < data.length; i++) {
              
              tablaVis.row
                .add([
                  data[i].folio_cxc,
                  data[i].corto_obra,
                  data[i].fecha_cxc,
                  data[i].desc_cxc,
                  data[i].monto_cxc,
                  data[i].saldo_cxc,
                  
                  
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
    })
  })
  

