$(document).ready(function() {
    var id, opcion;
    opcion = 4;

    // TOOLTIP DATATABLE
    $('[data-toggle="tooltip"]').tooltip()
    grafica();
   
 
    // TABLA PRINCIPAL

    tablaVis = $("#tablaV").DataTable({
        //fixedHeader: true,
        paging: false,
        searching: false, 
         info: false,
   
    rowCallback: function (row, data) {
        
        $($(row).find('td')['5']).addClass('text-right')
        $($(row).find('td')['6']).addClass('text-right')
        $($(row).find('td')['5']).addClass('currency')
        $($(row).find('td')['6']).addClass('currency')
      
      
  
       
      },
      columnDefs: [
       
        
        { "width": "40%", "targets": 3 },
        { "width": "12%", "targets": 4 },
        { "width": "12%", "targets": 5 }
    ],
      
        language: {
            lengthMenu: "Mostrar _MENU_ registros",
            zeroRecords: "No se encontraron resultados",
            info: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            infoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
            infoFiltered: "(filtrado de un total de _MAX_ registros)",
            sSearch: "Buscar:",
            oPaginate: {
                sFirst: "Primero",
                sLast: "Último",
                sNext: "Siguiente",
                sPrevious: "Anterior",
            },
            sProcessing: "Procesando...",
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

    //TABLA SUBCONTRATOS
    tablaEg = $("#tablaEg").DataTable({
        //fixedHeader: true,
        paging: false,
        searching: false, 
         info: false,
   
    rowCallback: function (row, data) {
        
        $($(row).find('td')['6']).addClass('text-right')
        $($(row).find('td')['6']).addClass('text-right')
        $($(row).find('td')['7']).addClass('currency')
        $($(row).find('td')['7']).addClass('currency')
      
      
  
       
      },
      columnDefs: [
        { "width": "12%", "targets": 1 },
        { "width": "18%", "targets": 2 },
        { "width": "10%", "targets": 3 },
        { "width": "30%", "targets": 4 } ,
        { "width": "12%", "targets": 6 },
        { "width": "12%", "targets": 5 }
 
       
    ],
      
        language: {
            lengthMenu: "Mostrar _MENU_ registros",
            zeroRecords: "No se encontraron resultados",
            info: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            infoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
            infoFiltered: "(filtrado de un total de _MAX_ registros)",
            sSearch: "Buscar:",
            oPaginate: {
                sFirst: "Primero",
                sLast: "Último",
                sNext: "Siguiente",
                sPrevious: "Anterior",
            },
            sProcessing: "Procesando...",
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
                .column( 6, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
    
            // Total over this page
            montototal = api
                .column( 5, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
    
            // Update footer
            $(api.column(5).footer()).html(
              Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
                parseFloat(montototal).toFixed(2),
              ),
            )
            $(api.column(6).footer()).html(
              Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
                parseFloat(saldototal).toFixed(2),
              ),
            )
            }
 
    });


       //TABLA CXP
       tablacxp = $("#tablacxp").DataTable({
        //fixedHeader: true,
        paging: false,
        searching: false, 
         info: false,
   
    rowCallback: function (row, data) {
        
        $($(row).find('td')['6']).addClass('text-right')
        $($(row).find('td')['6']).addClass('text-right')
        $($(row).find('td')['7']).addClass('currency')
        $($(row).find('td')['7']).addClass('currency')
      
      
  
       
      },
      columnDefs: [
        { "width": "12%", "targets": 1 },
        { "width": "18%", "targets": 2 },
        { "width": "10%", "targets": 3 },
        { "width": "30%", "targets": 4 } ,
        { "width": "12%", "targets": 6 },
        { "width": "12%", "targets": 5 }
 
       
    ],
      
        language: {
            lengthMenu: "Mostrar _MENU_ registros",
            zeroRecords: "No se encontraron resultados",
            info: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            infoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
            infoFiltered: "(filtrado de un total de _MAX_ registros)",
            sSearch: "Buscar:",
            oPaginate: {
                sFirst: "Primero",
                sLast: "Último",
                sNext: "Siguiente",
                sPrevious: "Anterior",
            },
            sProcessing: "Procesando...",
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
                .column( 6, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
    
            // Total over this page
            montototal = api
                .column( 5, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
    
            // Update footer
            $(api.column(5).footer()).html(
              Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
                parseFloat(montototal).toFixed(2),
              ),
            )
            $(api.column(6).footer()).html(
              Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
                parseFloat(saldototal).toFixed(2),
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




 
    
//BOTON BUSCAR OBRA
$(document).on('click', '#bobra', function () {
    $('#modalObra').modal('show')
})
//BOTON SELECCIONAR OBRA
$(document).on('click', '.btnSelObra', function () {
    fila = $(this)
    id_obra = parseInt($(this).closest('tr').find('td:eq(0)').text())
    obra = $(this).closest('tr').find('td:eq(2)').text()
    window.location.href = "rptobra.php?id_obra="+id_obra;
    
    //$('#id_obra').val(id_obra)
    $//('#obra').val(obra)
    //$('#modalObra').modal('hide')
})





  
    function startTime() {
        var today = new Date();
        var hr = today.getHours();
        var min = today.getMinutes();
        var sec = today.getSeconds();
        //Add a zero in front of numbers<10
        min = checkTime(min);
        sec = checkTime(sec);
        document.getElementById("clock").innerHTML = hr + " : " + min + " : " + sec;
        var time = setTimeout(function() {
            startTime();
        }, 500);
    }

    function checkTime(i) {
        if (i < 10) {
            i = "0" + i;
        }
        return i;
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


$(".modal-header").on("mousedown", function (mousedownEvt) {
    var $draggable = $(this);
    var x = mousedownEvt.pageX - $draggable.offset().left,
        y = mousedownEvt.pageY - $draggable.offset().top;
    $("body").on("mousemove.draggable", function (mousemoveEvt) {
        $draggable.closest(".modal-dialog").offset({
            "left": mousemoveEvt.pageX - x,
            "top": mousemoveEvt.pageY - y
        });
    });
    $("body").one("mouseup", function () {
        $("body").off("mousemove.draggable");
    });
    $draggable.closest(".modal").one("bs.modal.hide", function () {
        $("body").off("mousemove.draggable");
    });

//GRAFICA






});