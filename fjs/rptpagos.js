$(document).ready(function() {
    var id, opcion;
    opcion = 4;

    tablaVis = $("#tablav").DataTable({

        paging: false,
        ordering: false,
        info: false,
        searching: false,
    

        columnDefs: [{
            targets: -1,
            data: null,
            defaultContent: "<div class='text-center'><div class='btn-group'>\
            <button class='btn btn-sm btn-primary  btnEditar'><i class='fas fa-edit'></i></button>\
            <button class='btn btn-sm bg-purple  btnAddenda'><i class='fas fa-expand-alt'></i></button>\
            <button class='btn btn-sm btn-danger btnBorrar'><i class='fas fa-trash-alt'></i></button>\
            </div></div>"
        },
    ],

        //Para cambiar el lenguaje a español
        language: {
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


    tablaC = $('#tablaC').DataTable({
      
          
        columnDefs: [
          {
            targets: -1,
            data: null,
            defaultContent:
              "<div class='text-center'><button class='btn btn-sm btn-success btnAutorizar' data-toggle='tooltip' data-placement='top' title='Autorizar'><i class='fa-solid fa-dollar-sign'></i></button>\
                    <button class='btn btn-sm btn-warning text-light btnCancelar'><i class='fa-solid fa-rectangle-xmark' data-toggle='tooltip' data-placement='top' title='Cancelar'></i></button>\
                    </div>",
          },
          { className: 'hide_column', targets: [7] },
          { className: 'hide_column', targets: [2] },
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
        "ordering": false,
        paging:false,
    
      
      })

    $("#btnAgregar").click(function() {
        buscarcuentas()

        $("#modalcuentas").modal("show");
       
    });

    var fila; //capturar la fila para editar o borrar el registro

    function buscarcuentas() {
        tablaC.clear()
        tablaC.draw()
        opcion = 2
        $.ajax({
          type: 'POST',
          url: 'bd/buscarcuentas.php',
          dataType: 'json',
    
          data: {  },
    
          success: function (res) {
            for (var i = 0; i < res.length; i++) {
              tablaC.row
                .add([
                  res[i].tipo,
                  res[i].folio,
                  res[i].id_obra,
                  res[i].corto_obra,
                  res[i].razon_prov,
                  res[i].fecha,
                  res[i].concepto,
                  res[i].monto,
                  res[i].saldo,
                ])
                .draw()
            }
          },
        })
      }


   

})


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