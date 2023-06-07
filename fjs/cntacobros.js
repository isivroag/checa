$(document).ready(function() {
    var id, opcion;
    opcion = 4;
    var fila; 
    var cxc,pago;

    var textcolumnas = permisos()
    //buscarsubpartida()

    function permisos() {
      var tipousuario = $('#tipousuario').val()
      var columnas = ''
     
      if (tipousuario == 1) {
        columnas =
        "<div class='text-center'><div class='btn-group'>\
        <button class='btn btn-sm bg-primary btnVer'><i class='fas fa-search-dollar'  data-toggle='tooltip' data-placement='top' title='Ver Detalle'></i></button>\
        </div></div>"
      } else {
        columnas =
          "<div class='text-center'><div class='btn-group'>\
          <button class='btn btn-sm bg-primary btnVer'><i class='fas fa-search-dollar'  data-toggle='tooltip' data-placement='top' title='Ver Detalle'></i></button>\
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
            "defaultContent": textcolumnas
        },
       
        
    
       
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
              .column( 4, { page: 'current'} )
              .data()
              .reduce( function (a, b) {
                  return intVal(a) + intVal(b);
              }, 0 );
              
          
  
          // Total over this page
         
        
          $(api.column(4).footer()).html(
              Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
                parseFloat(pagos).toFixed(2),
              ),
            )

        
          }
    });



    tablaInfo = $("#tablaInfo").DataTable({
      paging: false,
      seraching: false,
      info: false,
      order: false,
  
      columnDefs: [
        {
          targets: -1,
          data: null,
          defaultContent:
            "<div class='text-center'><div class='btn-group'>\
          <button class='btn btn-sm bg-success  btnImporte'><i class='fa-solid fa-dollar-sign'></i></button>\
          </div></div>",
        },
        { className: "hide_column", targets: [0] },
       { className: "hide_column", targets: [1] },
       { className: "hide_column", targets: [2] },
       { className: "hide_column", targets: [3] },
        
        {
          targets: 7,
          render: function (data, type, full, meta) {
            return new Intl.NumberFormat('es-MX', {
              minimumFractionDigits: 2,
            }).format(parseFloat(data).toFixed(2))
          },
        },
      ],
  
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
      rowCallback: function (row, data) {
        // FORMATO DE CELDAS
        $($(row).find('td')['6']).addClass('text-right')
        $($(row).find('td')['7']).addClass('currency')
        $($(row).find('td')['7']).addClass('text-right')
        
  
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
  
   
        importetabla = api
          .column(7, { page: 'current' })
          .data()
          .reduce(function (a, b) {
            return intVal(a) + intVal(b)
          }, 0)
  
        $(api.column(7).footer()).html(
          Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
            parseFloat(importetabla).toFixed(2),
          ),
        )
      },
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
    

      tablaVer = $('#tablaVer').DataTable({
        searching:false,
        paging:false,
        info:false,
        columnDefs: [
          {
            targets: -1,
            data: null,
            defaultContent:
              "<div class='text-center'><div class='btn-group'>\
              <button class='btn btn-sm btn-danger btnDeldetalle' data-toggle='tooltip' data-placement='top' title='Eliminar Detalle'><i class='fas fa-trash'></i></button>\
              </div></div>",
          },
          { className: 'hide_column', targets: [0] },
          {
            targets: 3,
            render: function (data, type, full, meta) {
              return new Intl.NumberFormat('es-MX', {
                minimumFractionDigits: 2,
              }).format(parseFloat(data).toFixed(2))
            },
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


        rowCallback: function (row, data) {
          // FORMATO DE CELDAS
          $($(row).find('td')['3']).addClass('text-right')
          $($(row).find('td')['3']).addClass('currency')

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
              .column( 3, { page: 'current'} )
              .data()
              .reduce( function (a, b) {
                  return intVal(a) + intVal(b);
              }, 0 );
              
          
  
          // Total over this page
         
        
          $(api.column(3).footer()).html(
              Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
                parseFloat(pagos).toFixed(2),
              ),
            )

        
          }
      })

      tablaVer2 = $('#tablaVer2').DataTable({
        searching:false,
        paging:false,
        info:false,
        columnDefs: [
         
          { className: 'hide_column', targets: [0] },
          {
            targets: 3,
            render: function (data, type, full, meta) {
              return new Intl.NumberFormat('es-MX', {
                minimumFractionDigits: 2,
              }).format(parseFloat(data).toFixed(2))
            },
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


        rowCallback: function (row, data) {
          // FORMATO DE CELDAS
          $($(row).find('td')['3']).addClass('text-right')
          $($(row).find('td')['3']).addClass('currency')

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
              .column( 3, { page: 'current'} )
              .data()
              .reduce( function (a, b) {
                  return intVal(a) + intVal(b);
              }, 0 );
              
          
  
          // Total over this page
         
        
          $(api.column(3).footer()).html(
              Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
                parseFloat(pagos).toFixed(2),
              ),
            )

        
          }
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
   
         
          window.location.href = 'cntacobros.php?id_obra=' + id_obra
 
  })

      
    $(document).on('click', '.btnVer', function () {
      fila = $(this).closest("tr");
  
      cxc =  fila.find('td:eq(0)').text();
      pago =  fila.find('td:eq(1)').text();
      obra=$('#id_obra').val();
      buscarinfo(obra,cxc,pago);

      $("#modalInfo").modal("show");


/*
      tablaVer.clear()
      tablaVer.draw()
      $.ajax({
        type: 'POST',
        url: 'bd/buscargeneraling.php',
        dataType: 'json',
        async: false,
        data: {
          obra: obra, cxc: cxc, pago:pago
         
        },
        success: function (res) {
          for (var i = 0; i < res.length; i++) {
            tablaVer.row
              .add([
                res[i].id_reg,
                res[i].nom_partidacto,
                res[i].nom_subpartidacto,
                res[i].monto,
                
              ])
              .draw()
          }

          $('#modalVer').modal('show')
        },
        error: function () {
          Swal.fire({
            title: 'Error al cargar el detalle',
            icon: 'error',
          })
        },
      })

    */ 

    })

    $(document).on('click', '.btnDeldetalle', function () {
      fila = $(this).closest("tr");
      id =  fila.find('td:eq(0)').text();
      opcion=2

      $.ajax({
        url: "bd/crudgeneraling.php",
        type: "POST",
        dataType: "json",
        data: { id: id ,opcion: opcion },
        success: function (data) {
            if (data==1 )
            {
             
             
        
        
              tablaVer.clear()
              tablaVer.draw()
              $.ajax({
                type: 'POST',
                url: 'bd/buscargeneraling.php',
                dataType: 'json',
                async: false,
                data: {
                  obra: obra, cxc: cxc, pago:pago
                 
                },
                success: function (res) {
                  for (var i = 0; i < res.length; i++) {
                    tablaVer.row
                      .add([
                        res[i].id_reg,
                        res[i].nom_partidacto,
                        res[i].nom_subpartidacto,
                        res[i].monto,
                        
                      ])
                      .draw()
                  }
        
                
                },
                error: function () {
                  Swal.fire({
                    title: 'Error al cargar el detalle',
                    icon: 'error',
                  })
                },
              })


            }
            
           
        }
    });
    $("#modalCRUD").modal("hide");
    })

  $(document).on('click', '.btnDetalle', function () {
    fila = $(this).closest("tr");
    


  
    cxc =  fila.find('td:eq(0)').text();
    pago =  fila.find('td:eq(1)').text();
    obra=$('#id_obra').val();


    tablaVer2.clear()
    tablaVer2.draw()
    $.ajax({
      type: 'POST',
      url: 'bd/buscargeneraling.php',
      dataType: 'json',
      async: false,
      data: {
        obra: obra, cxc: cxc, pago:pago
       
      },
      success: function (res) {
        for (var i = 0; i < res.length; i++) {
          tablaVer2.row
            .add([
              res[i].id_reg,
              res[i].nom_partidacto,
              res[i].nom_subpartidacto,
              res[i].monto,
              
            ])
            .draw()
        }

      },
      error: function () {
        Swal.fire({
          title: 'Error al cargar el detalle',
          icon: 'error',
        })
      },
    })






    cxc =  fila.find('td:eq(0)').text();
    pago =  fila.find('td:eq(1)').text();
    $('#cxc').val(cxc)
    $('#pago').val(pago)
    $('#modalDetalle').modal('show')
  })

  $('#partidacto').on('change', function () {
    buscarsubpartida()
  })

  $(document).on('click', '#btnGuardarsub', function () {
    obra=$('#id_obra').val()
    cxc=$('#cxc').val()
    pago=$('#pago').val()
    subpartida=$('#subpartidacto').val()
    importe=$('#montosubpartida').val()
    opcion=1
    if (obra.length == 0 || cxc==0 || pago==0 || subpartida==0) {
      Swal.fire({
          title: 'Datos Faltantes',
          text: "Debe ingresar todos los datos Requeridos",
          icon: 'warning',
      })
      return false;
  } else {
      $.ajax({
          url: "bd/crudgeneraling.php",
          type: "POST",
          dataType: "json",
          data: { obra: obra,  cxc: cxc, pago: pago,subpartida: subpartida, importe: importe,opcion: opcion },
          success: function (data) {
              if (data==1 )
              {
                registroguardado()
                $('#modalDetalle').modal('hide')
              }
              else{
                registronoguardado()
              }
             
          }
      });
      $("#modalCRUD").modal("hide");
  }

  })
  
  function buscarsubpartida() {
    partida = $('#partidacto').val()
    
   

    $('#subpartidacto').empty()
    $.ajax({
      type: 'POST',
      url: 'bd/buscarsubpartidacto.php',
      dataType: 'json',
      async: false,
      data: {
        partida: partida,
       
      },
      success: function (res) {
        for (var i = 0; i < res.length; i++) {
          $('#subpartidacto').append(
            $('<option>', {
              value: res[i].id_subpartidacto,
              text: res[i].nom_subpartidacto,
            }),
          )
        }
      },
      error: function () {
        Swal.fire({
          title: 'Error al cargar Subpartidas disponibles',
          icon: 'error',
        })
      },
    })
  }


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



  $(document).on("click", ".btnInfo", function () {
    fila = $(this).closest("tr");
    id = parseInt(fila.find("td:eq(0)").text());
    cxc = parseInt(fila.find("td:eq(2)").text());
    pago = parseInt(fila.find("td:eq(3)").text());
    $("#id_obra").val(id);
    
    buscarinfo(id,obra,cxc,pago);

    $("#modalInfo").modal("show");
  });

  function buscarinfo(obra,cxc,pago) {
    
    opcion = 1;

    tablaInfo.clear();
    tablaInfo.draw();
    $.ajax({
      type: "POST",
      url: "bd/buscactopagocxc.php",
      dataType: "json",

      data: { obra: obra,cxc : cxc, pago: pago , opcion: opcion },

      success: function (data) {
       
        for (var i = 0; i < data.length; i++) {
          tablaInfo.row
            .add([
              data[i].id_reg,
              data[i].id_obra,
              data[i].folio_cxc,
              data[i].folio_pagocxc,
              data[i].id_partida,
              data[i].nom_partidacto,
              data[i].porcentaje,
              data[i].importe
            
            ])
            .draw();

          //tabla += '<tr><td>' + res[i].id_objetivo + '</td><td>' + res[i].desc_objetivo + '</td><td class="text-center">' + icono + '</td><td class="text-center"></td></tr>';
        }
      },
      error: function () {},
    });
  }
  $(document).on("click", ".btnImporte", function () {
    fila = $(this).closest("tr");

    registro = fila.find("td:eq(0)").text();
    obra = fila.find("td:eq(1)").text();
    cxc = fila.find("td:eq(2)").text();
    pago = fila.find("td:eq(3)").text();
    partida = fila.find("td:eq(4)").text();
    concepto = fila.find("td:eq(5)").text();
    porcentaje = fila.find("td:eq(6)").text();
    importe = fila.find("td:eq(7)").text();
    $("#id_obra2").val(obra);
    $("#cxc2").val(cxc);
    $("#pago2").val(pago);
    $("#id_partida").val(partida);
    $("#id_reg").val(registro);
    if (registro == 0) {
      tipo = 0;
    } else {
      tipo = 1;
    }
    $("#tipo").val(tipo);
    $("#concepto").val(concepto);
    $("#porcentaje").val(porcentaje);
    $("#importe").val(importe);

    $("#modalImporte").modal("show");
  });

  $(document).on("click", "#btncalcular", function (e) {
    e.preventDefault();
    obra = $("#id_obra2").val();
    cxc = $("#cxc2").val();
    pago = $("#pago2").val();
    partida = $("#id_partida").val();
    porcentaje = $("#porcentaje").val().replace(/,/g, '');
    monto= $("#importe").val().replace(/,/g, '');
    opcion=1;
    calcularpor(obra,partida,porcentaje,monto,opcion,cxc,pago)


  });

  $(document).on("click", "#btncalcular2", function (e) {
    e.preventDefault();
    obra = $("#id_obra2").val();
    cxc = $("#cxc2").val();
    pago = $("#pago2").val();
    partida = $("#id_partida").val();
    porcentaje = $("#porcentaje").val().replace(/,/g, '');
    monto= $("#importe").val().replace(/,/g, '');
    opcion=2;
    calcularpor(obra,partida,porcentaje,monto,opcion,cxc,pago)



  });
  function calcularpor(obra, partida,porcentaje,monto,opcion,cxc,pago){
    
    $.ajax({
      type: "POST",
      url: "bd/calcularcostopagocxc.php",
      dataType: "json",

      data: { obra: obra, partida: partida, porcentaje: porcentaje, opcion: opcion,monto: monto, cxc: cxc, pago: pago },

      success: function (data) {
        console.log(data)
        if (opcion==1){
          $("#importe").val(data);
        }else{
          $("#porcentaje").val(data);
        }

        
      },
      error: function () {},
    });
  }

  $(document).on("click", "#btnGuardarimporte", function (e) {
    e.preventDefault();
    obra = $("#id_obra2").val();
    cxc = $("#cxc2").val();
    pago = $("#pago2").val();
    partida = $("#id_partida").val();
    porcentaje = $("#porcentaje").val().replace(/,/g, '');
    registro = $("#id_reg").val();
    importe = $("#importe").val().replace(/,/g, '');
    tipo = $("#tipo").val();
    $.ajax({
      type: "POST",
      url: "bd/guardarcostopagocxc.php",
      dataType: "json",

      data: { obra: obra, partida: partida, porcentaje: porcentaje, 
        importe: importe, tipo: tipo, registro: registro,cxc: cxc, pago: pago },

      success: function (data) {
        if (data==1){
          $("#modalImporte").modal("hide");
          exito()
        buscarinfo(obra,cxc,pago)
        }
        else{
          fracaso()
        }
        
      },
      error: function () {
        error()
      },
    });
  });


  function exito() {
    swal.fire({
      title: 'Registro Guardado',
      icon: 'success',
      focusConfirm: true,
      confirmButtonText: 'Aceptar',
    })
  }

  function fracaso() {
    swal.fire({
      title: 'Registro NO Guardado',
      icon: 'warning',
      focusConfirm: true,
      confirmButtonText: 'Aceptar',
    })
  }

  function error() {
    swal.fire({
      title: 'Error en funcion',
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