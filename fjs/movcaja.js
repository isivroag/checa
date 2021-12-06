

$(document).ready(function () {
    var id, opcion
    opcion = 4
    var fila //capturar la fila para editar o borrar el registro

    $('#tablaV thead tr').clone(true).appendTo('#tablaV thead');
    $('#tablaV thead tr:eq(1) th').each(function (i) {


        var title = $(this).text();


        $(this).html('<input class="form-control form-control-sm" type="text" placeholder="' + title + '" />');

        $('input', this).on('keyup change', function () {

            if (i == 3) {


                valbuscar = this.value;
            } else {
                valbuscar = this.value;

            }

            if (tablaVis.column(i).search() !== valbuscar) {
                tablaVis
                    .column(i)
                    .search(valbuscar, true, true)
                    .draw();
            }
        });
    });


    tablaVis = $('#tablaV').DataTable({

        columnDefs: [
            {
              targets: -1,
              data: null,
              defaultContent:
                "<div class='text-center'><button class='btn btn-sm bg-danger btnCancelar' data-toggle='tooltip' data-placement='top' title='Cancelar'><i class='fas fa-ban'></i></button>\
                                  </div></div>",
            },
        ],
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
                exportOptions: {
                    columns: [0, 1, 2, 3,4,5],
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
                title: 'MOVIMIENTOS DE CAJA',
                className: 'btn bg-danger',
                exportOptions: { columns: [0, 1, 2, 3,4,5] },
                format: {
                    body: function (data, row, column, node) {
                        if (column === 3) {

                            return data
                        } else {
                            return data
                        }
                    },
                },
            },
        ],
        stateSave: false,
        orderCellsTop: false,
        fixedHeader: true,
        paging: false,
        order: [[ 0, "desc" ]],



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
       
            $($(row).find('td')['4']).addClass('text-right')
            $($(row).find('td')['5']).addClass('text-right')
            $($(row).find('td')['6']).addClass('text-right')
            $($(row).find('td')['4']).addClass('currency')
            $($(row).find('td')['5']).addClass('currency')
            $($(row).find('td')['6']).addClass('currency')
            $($(row).find('td')[5]).addClass('text-bold')
           
            if (data[2] == 'Reposicion') {
                //$($(row).find("td")[6]).css("background-color", "warning");
                $($(row).find('td')[2]).addClass('bg-gradient-success')
                $($(row).find('td')[5]).addClass('text-success')
                //$($(row).find('td')['2']).text('PENDIENTE')
              } else if (data[2] == 'Egreso') {
                //$($(row).find("td")[2]).css("background-color", "blue");
                $($(row).find('td')[2]).addClass('bg-gradient-purple')
                $($(row).find('td')[5]).addClass('text-purple')
                //$($(row).find('td')['2']).text('ENVIADO')
              } else if (data[2] == 'Saldo Inicial') {
                //$($(row).find("td")[2]).css("background-color", "success");
                $($(row).find('td')[2]).addClass('bg-gradient-primary')
                $($(row).find('td')[5]).addClass('text-primary')
                //$($(row).find('td')['6']).text('ACEPTADO')
              }else if (data[2] == 'Ajuste Positivo'){
                $($(row).find('td')[2]).addClass('bg-gradient-success')
                $($(row).find('td')[5]).addClass('text-success')
              }else if (data[2] == 'Ajuste Negativo'){
                $($(row).find('td')[2]).addClass('bg-gradient-purple')
                $($(row).find('td')[5]).addClass('text-purple')
              }else if (data[2] == 'Cancelacion Pago'){
                $($(row).find('td')[2]).addClass('text-white bg-gradient-warning')
                $($(row).find('td')[5]).addClass('text-warning')
              }


            
        },


    });




  //BOTON CANCELAR PAGO
  $(document).on('click', '.btnCancelar', function () {
    fila = $(this).closest('tr')
    folio = parseInt(fila.find('td:eq(0)').text())
    tipo=fila.find('td:eq(2)').text()
   
    if (tipo=='Reposicion' || tipo=='Ajuste Negativo' || tipo=='Ajuste Negativo' || tipo=='Saldo Inicial' ){
        $('#formcan').trigger('reset')
        $('#modalcan').modal('show')
        $('#foliocan').val(folio)    
    }else{
        swal.fire({
            title: 'No es posible Cancelar el Registro',
            text:'Estas operaciones deben ser canceladas desde el modulo de Gastos.',
            icon: 'error',
            focusConfirm: true,
            confirmButtonText: 'Aceptar',
          })
    }
    
 
  })



  // GUARDAR CANCELAR
  $(document).on('click', '#btnGuardarCAN', function () {
    foliocan = $('#foliocan').val()
    motivo = $('#motivo').val()
    fecha = $('#fecha').val()
    usuario = $('#nameuser').val()
    idcaja=$('#idcaja').val()
    
    if (motivo === '') {
      swal.fire({
        title: 'Datos Incompletos',
        text: 'Verifique sus datos',
        icon: 'warning',
        focusConfirm: true,
        confirmButtonText: 'Aceptar',
      })
    } else {
      
        $.ajax({
        type: 'POST',
        url: 'bd/buscarregcaja.php',
        async: false,
        dataType: 'json',
        data: {
          foliocan: foliocan,
          idcaja: idcaja,
        },
        success: function (res) {
          if (res == 0) {
            $.ajax({
                type: 'POST',
                url: 'bd/cancelarmovcaja.php',
                async: false,
                dataType: 'json',
                data: {
                  foliocan: foliocan,
                  motivo: motivo,
                  fecha: fecha,
                  usuario: usuario,
                },
                success: function (res) {
                  if (res == 1) {
                    mensaje()
                    $('#modalcan').modal('hide')
                    location.reload()
                  } else {
                    mensajeerror()
                  }
                },
              })
            
          } else {
            mensajeerror()
          }
        },
      })

    }
  })



    function mensaje() {
        swal.fire({
          title: 'Registro Cancelado',
          icon: 'warning',
          focusConfirm: true,
          confirmButtonText: 'Aceptar',
        })
      }
    
      function mensajeerror() {
        swal.fire({
          title: 'No es posible Cancelar el Registro',
          text:'Esta caja tiene registros posteriores.',
          icon: 'error',
          focusConfirm: true,
          confirmButtonText: 'Aceptar',
        })
      }


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


