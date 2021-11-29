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
  
   



      //FUNCION FORMATO MONEDA
  document.getElementById("montonom").onblur = function () {

    //number-format the user input
    this.value = parseFloat(this.value.replace(/,/g, ""))
        .toFixed(2)
        .toString()
        .replace(/\B(?=(\d{3})+(?!\d))/g, ",");


}


    tablaVis = $("#tablaV").DataTable({
        fixedHeader: true,
        paging: false,
    
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
        },{ className: "hide_column", targets: [1] },
        { className: "hide_column", targets: [5] },
        { width: '30%', targets: 2 },
     
       
    ],
    rowCallback: function (row, data) {
      // FORMATO DE CELDAS
      $($(row).find('td')['3']).addClass('text-right')
      $($(row).find('td')['4']).addClass('text-right')
      
      $($(row).find('td')['3']).addClass('currency')
      $($(row).find('td')['3']).addClass('currency')
      saldo=parseFloat(data[3])
      minimo=parseFloat(data[5])
      console.log(saldo)
      if(saldo==0){
        $($(row).find('td')[3]).addClass('text-danger text-bold')
      }
      else if (saldo<=minimo) {
      
        $($(row).find('td')[3]).addClass('text-warning text-bold')
        
      } else{
        
        $($(row).find('td')[3]).addClass('text-success text-bold')
        
      } 

      
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
    opcioncaja=2
    $.ajax({
      url: 'bd/revisarsaldocaja.php',
      type: 'POST',
      dataType: 'json',
      async:false,
      data: { folio: id_obra, opcioncaja: opcioncaja },
      success: function (data) {
        if (data != null) {
         
          window.location.href = 'cntacajaobra.php?id_obra=' + id_obra
         

        } else {
          swal.fire({
            title: 'NO EXISTE REGISTRO DE CAJA',
            text:'No es posible realizar operaciones',
            icon: 'error',
            focusConfirm: true,
            confirmButtonText: 'Aceptar',
          })
          window.setTimeout(function() {
            window.location.href = 'cntacajaobra.php'
        }, 1500);
          
         
        }
      },
    })
   

  })

    

    //botón GUARDAR CAJA    
    $(document).on("click", "#btnGuardarnom", function() {
      folio=$('#folionom').val()
      fecha=$('#fechaini').val()
      id_obra=$('#id_obra').val()
      obs=$('#descripcion').val()
      monto=$('#montonom').val().replace(/,/g, '')
      usuario=$('#nameuser').val()
      
      if (fecha.length == 0 || id_obra.length == 0 || monto.length == 0  ) {
        Swal.fire({
            title: 'Datos Faltantes',
            text: "Debe ingresar todos los datos del Requeridos",
            icon: 'warning',
        })
        return false;
    } else {
        $.ajax({
            url: "bd/crudcaja.php",
            type: "POST",
            dataType: "json",
            data: { folio: folio, 
                 fecha: fecha, id_obra: id_obra, obs: obs,
                 monto: monto,usuario: usuario,
                  id: id, opcion: opcion },
            success: function (data) {
               
                id = data[0].id_caja;
                id_obra = data[0].id_obra;
                obra = data[0].corto_obra;
              
                saldo = data[0].saldo_caja;
                monto= data[0].monto_caja;
                
                if (opcion == 1) {
                    tablaVis.row.add([id, id_obra, obra, saldo, monto,]).draw();
                } else {
                    tablaVis.row(fila).data([id, id_obra, obra, saldo, monto,]).draw();
                }

                registroguardado()
            }
        });
        $("#modalReq").modal("hide");
    }

    });

    //botón BORRAR
    $(document).on("click", ".btnVer", function() {
      fila = $(this)
      folio = parseInt($(this).closest('tr').find('td:eq(0)').text())
      window.location.href="movcajaobra.php?folio="+folio
    });

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