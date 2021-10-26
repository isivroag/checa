
$(document).ready(function() {
    var id, opcion;
    opcion = 4;


     //FUNCION FORMATO MONEDA 
     $('#tablaV thead tr')
     .clone(true)
     .addClass('filters')
     .appendTo( '#tablaV thead' );


    tablaVis = $("#tablaV").DataTable({

        fixedHeader: true,
        initComplete: function () {
            var api = this.api();
 
            // For each column
            api
                .columns()
                .eq(0)
                .each(function (colIdx) {
                    // Set the header cell to contain the input element
                    var cell = $('.filters th').eq(
                        $(api.column(colIdx).header()).index()
                    );
                    var title = $(cell).text();
                    $(cell).html('<input type="text" class="form-control form-control-sm" placeholder="' + title + '" />');
 
                    // On every keypress in this input
                    $(
                        'input',
                        $('.filters th').eq($(api.column(colIdx).header()).index())
                    )
                        .off('keyup change')
                        .on('keyup change', function (e) {
                            e.stopPropagation();
 
                            // Get the search value
                            $(this).attr('title', $(this).val());
                            var regexr = '({search})'; //$(this).parents('th').find('select').val();
 
                            var cursorPosition = this.selectionStart;
                            // Search the column for that value
                            api
                                .column(colIdx)
                                .search(
                                    this.value != ''
                                        ? regexr.replace('{search}', '(((' + this.value + ')))')
                                        : '',
                                    this.value != '',
                                    this.value == ''
                                )
                                .draw();
 
                            $(this)
                                .focus()[0]
                                .setSelectionRange(cursorPosition, cursorPosition);
                        });
                });
        },


        dom: "<'row justify-content-center'<'col-sm-12 col-md-4 form-group'l><'col-sm-12 col-md-4 form-group'B><'col-sm-12 col-md-4 form-group'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",

        buttons: [{
                extend: "excelHtml5",
                text: "<i class='fas fa-file-excel'> Excel</i>",
                titleAttr: "Exportar a Excel",
                title: "Reporte de Pagos",
                footer: true,
                className: "btn bg-success ",
                exportOptions: { columns: [0, 1,2,3, 4,6,7,8] },
            },
            {
                extend: "pdfHtml5",
                text: "<i class='far fa-file-pdf'> PDF</i>",
                titleAttr: "Reporte de Cuentas x Pagar",
                title: "Reporte de Pagos",
                footer: true,
                className: "btn bg-danger",
                exportOptions: { columns: [0, 1,2,3, 4, 6,7,8] },
            },
        ],
        stateSave: true,
      orderCellsTop: true,
    fixedHeader: true,
    paging:false,
    //ordering:false,

        columnDefs: [
            /*
            {
            targets: -1,
            data: null,
            defaultContent: "<div class='text-center'>\
            </div></div>",
            //<button class='btn btn-sm bg-danger btnCancelar'><i class='fas fa-ban'></i></button>
        },*/
       // {className: "hide_column", targets: [1]},
        { "width": "8%", "targets": 2 },
        { "width": "17%", "targets": 4 },
        { "width": "30%", "targets": 6 },
        { "width": "20%", "targets": 5 }
    
    ],
    rowCallback: function (row, data) {

        $($(row).find('td')['8']).addClass('text-right')

        $($(row).find('td')['8']).addClass('currency')
 
      },
        //Para cambiar el lenguaje a español
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
    
           
            montototal = api
                .column( 8, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
    
          

            $(api.column(8).footer()).html(
              Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
                parseFloat(montototal).toFixed(2),
              ),
            )
            }
    });

  
    /*
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
*/
 

    function operacionexitosa() {
        swal.fire({
            title: "Pago Registrado",
            icon: "success",
            focusConfirm: true,
            confirmButtonText: "Aceptar",
        });
    }
    function mensaje() {
        swal.fire({
            title: "Registro Cancelado",
            icon: "warning",
            focusConfirm: true,
            confirmButtonText: "Aceptar",
        });
    }

    function mensajeerror() {
        swal.fire({
            title: "Error al Cancelar el Registro",
            icon: "error",
            focusConfirm: true,
            confirmButtonText: "Aceptar",
        });
    }

 
 

 
    var fila; //capturar la fila para editar o borrar el registro

    //botón EDITAR




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