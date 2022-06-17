$(document).ready(function () {
    var id, opcion
    var forigen
    opcion = 4
    var fila //capturar la fila para editar o borrar el registro
  
    function round(value, decimals) {
      return Number(Math.round(value + 'e' + decimals) + 'e-' + decimals)
    }
  
    tablaVis = $('#tablaV').DataTable({
      /*<button class='btn btn-sm btn-danger btnBorrar'><i class='fas fa-trash-alt'></i></button>\ */
      columnDefs: [
  
        {
            targets:0,
            class: "details-control",
            orderable: false,
            data: null,
            defaultContent: ""
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
        $($(row).find('td')[6]).addClass('text-center')
        if (data[6] == '1') {
          //$($(row).find("td")[6]).css("background-color", "warning");
          $($(row).find('td')[6]).addClass('bg-gradient-info')
          //$($(row).find('td')[4]).css('background-color','#EEA447');
          $($(row).find('td')[6]).text('ABIERTO')
        } else if (data[6] == '2') {
          $($(row).find('td')[6]).addClass('bg-gradient-primary')
          //$($(row).find('td')[4]).css('background-color','#EEA447');
          $($(row).find('td')[6]).text('CERRADO')
        } else if (data[6] == '3') {
          $($(row).find('td')[6]).addClass('bg-gradient-success')
          //$($(row).find('td')[4]).css('background-color','#EEA447');
          $($(row).find('td')[6]).text('APLICADO')
        }
      },
    })


  
    

    var detailRows = [];
  
    $('#tablaV tbody').on('click', 'tr td.details-control', function() {
        var tr = $(this).closest('tr');
        var row = tablaVis.row(tr);
        var idx = $.inArray(tr.attr('id'), detailRows);
        folio = parseInt($(this).closest("tr").find('td:eq(1)').text());


        if (row.child.isShown()) {
            tr.removeClass('details');
            row.child.hide();

            // Remove from the 'open' array
            detailRows.splice(idx, 1);
        } else {
            tr.addClass('details');
            row.child(format(row.data(), folio)).show();

            // Add to the 'open' array
            if (idx === -1) {
                detailRows.push(tr.attr('id'));
            }
        }
    });

    tablaVis.on('draw', function() {
        $.each(detailRows, function(i, id) {
            $('#' + id + ' td.details-control').trigger('click');
        })
    });

    function format(d, foliosemanal) {

        tabla = "";

        tabla = " <div class='container '><div class='row'>" +
            "<div class='col-lg-12'>" +
            "<div class='table-responsive'>" +
            "<table class=' table table-sm table-striped table-hover table-bordered table-condensed mx-auto' style='width:100%'>" +
            "<thead class='text-center bg-gradient-green '>" +
            "<tr>" +
            "<th>Tipo Op</th>"+
            "<th>Folio Op</th>"+
            "<th>Obra</th>"+
            "<th>Proveedor</th>"+
            "<th>Concepto</th>"+
            "<th>Observaciones</th>"+
            "<th>Importe</th>"+
            "<th>Estado</th>"+
            "</tr>" +
            "</thead>" +
            "<tbody>";

        $.ajax({

            url: "bd/semanaldetalle.php",
            type: "POST",
            dataType: "json",
            data: { foliosemanal: foliosemanal },
            async: false,
            success: function(res) {
                suma=0
               
                for (var i = 0; i < res.length; i++) {

                    switch(parseInt(res[i].aplicado)){
                        case 0:
                          clase='bg-gradient-warning text-white';
                          textoclase='PENDIENTE'
                          break;
                        case 1:
                            clase='bg-gradient-success text-white';
                          textoclase='APLICADO'
                          break;
                       
                      }
                      suma+=parseFloat(res[i].montoautorizado)
                    tabla += '<tr>'+
                                '</td><td>' + res[i].tipo + 
                                '</td><td>' + res[i].folio + 
                                '</td><td>' + res[i].corto_obra + 
                                '</td><td>' + res[i].razon_prov + 
                                '</td><td>' + res[i].concepto + 
                                '</td><td>'+ res[i].observaciones +
                                '</td ><td class="text-right">' + Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
                                    parseFloat(res[i].montoautorizado).toFixed(2),
                                  )+
                                  '</td><td class="text-center '+clase+'">' + textoclase+
                                  '</td></tr>';
                }

            }
        });

        tabla += "</tbody>" +
        "<tfoot><tr><th></th><th></th><th></th><th></th><th></th><th>TOTAL</th>"+
        "<td class='text-right text-bold'>"+ Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
            parseFloat(suma).toFixed(2),
          ) + 
        "</th><td></td></tr></tfoot>"+
            "</table>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>";

         



        return tabla;
    };

  
})
  
