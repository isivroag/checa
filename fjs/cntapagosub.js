$(document).ready(function() {
    var id, opcion;
    opcion = 4;
    var fila; 

    var textcolumnas = permisos()

    function permisos() {
      var tipousuario = $('#tipousuario').val()
      var columnas = ''
     
      if (tipousuario == 1) {
        columnas =
        "<div class='text-center'><div class='btn-group'>\
        <button class='btn btn-sm bg-primary btnVer'><i class='fas fa-search-dollar'  data-toggle='tooltip' data-placement='top' title='Ver Movimientos'></i></button>\
        </div></div>"
      } else {
        columnas =
          "<div class='text-center'><div class='btn-group'>\
          <button class='btn btn-sm bg-primary btnVer'><i class='fas fa-search-dollar'  data-toggle='tooltip' data-placement='top' title='Ver Movimientos'></i></button>\
          </div></div>"
      }
      return columnas
    }
  
   



    tablaVis = $(".tablaV").DataTable({
        fixedHeader: true,
        paging: false,
       // searching:false,
        info:false,
    
        dom:
          "<'row justify-content-center'<'col-sm-12 col-md-4 form-group'l><'col-sm-12 col-md-4 form-group'B><'col-sm-12 col-md-4 form-group'f>>" +
          "<'row'<'col-sm-12'tr>>" +
          "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
    
        buttons: [
          {
            extend: 'excelHtml5',
            text: "<i class='fas fa-file-excel'> Excel</i>",
            titleAttr: 'Exportar a Excel',
            title: 'MOVIMIENTOS DE CAJA',
            className: 'btn bg-success ',
            exportOptions: { columns: [0, 1, 2, 3, 4, 5] },
          },
          {
            extend: 'pdfHtml5',
            text: "<i class='far fa-file-pdf'> PDF</i>",
            titleAttr: 'Exportar a PDF',
            title: 'MOVIMIENTOS DE CAJA',
            className: 'btn bg-danger',
            exportOptions: { columns: [0, 1, 2, 3, 4, 5] },
          },
        ],


        columnDefs: [{
            "targets": -1,
            "data": null,
            "defaultContent": ""
        },{ className: "hide_column", targets: [0] },
       
        
    
       
    ],
  


    rowCallback: function (row, data) {
      // FORMATO DE CELDAS
      $($(row).find('td')['5']).addClass('text-right')
     
      $($(row).find('td')['5']).addClass('currency')
      
 

      
    },
 
        //Para cambiar el lenguaje a español
        "language": {
            "lengthMenu": "Mostrar _MENU_ registros",
            "zeroRecords": "No se encontraron resultados",
            "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sSearch": "Buscar:",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "sProcessing": "Procesando...",
        },


        "footerCallback": function ( row, data, start, end, display ) {
          var api = this.api(), data;
  
         
          var intVal = function ( i ) {
              return typeof i === 'string' ?
                  i.replace(/[\$,]/g, '')*1 :
                  typeof i === 'number' ?
                      i : 0;
          };
  
          pagos = api
              .column( 5, { page: 'current'} )
              .data()
              .reduce( function (a, b) {
                  return intVal(a) + intVal(b);
              }, 0 );
              
          
  
          // Total over this page
         
        
          $(api.column(5).footer()).html(
              Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
                parseFloat(pagos).toFixed(2),
              ),
            )

        
          }
    });

 
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
    

  //boton nuevo
    $("#btnNuevo").click(function() {
        $('#formReq').trigger('reset')
        $('#modalReq').modal('show')
        id = null
        opcion = 1

    });


     //BOTON BUSCAR OBRA
  $(document).on('click', '#bobra', function () {
    $('#modalObra').modal('show')
  })
  //BOTON SELECCIONAR OBRA
  //BOTON SELECCIONAR OBRA
  $(document).on('click', '.btnSelObra', function () {
    fila = $(this)
    id_obra = parseInt($(this).closest('tr').find('td:eq(0)').text())
    obra = $(this).closest('tr').find('td:eq(2)').text()
   
         
          window.location.href = 'cntapagosub.php?id_obra=' + id_obra
         


  })

    

  


  function registroguardado() {
    swal.fire({
      title: 'Registro Guardado',
      icon: 'success',
      focusConfirm: true,
      confirmButtonText: 'Aceptar',
    })
  }

  function registronoguardado() {
    swal.fire({
      title: 'Registro No Guardado',
      icon: 'error',
      focusConfirm: true,
      confirmButtonText: 'Aceptar',
    })
  }

   

});

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