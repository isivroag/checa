$(document).ready(function() {
    var id, opcion;
    opcion = 4;

    tablaVis = $("#tablaV").DataTable({



        "columnDefs": [{
            "targets": -1,
            "data": null,
            "defaultContent": "<div class='text-center'><div class='btn-group'>\
            <button class='btn btn-sm btn-primary  btnEditar'><i class='fas fa-edit'></i></button>\
            <button class='btn btn-sm bg-info  btnInfo'><i class='fa-solid fa-circle-info'></i></button>\
            <button class='btn btn-sm bg-purple  btnAddenda'><i class='fas fa-expand-alt'></i></button>\
            <button class='btn btn-sm btn-danger btnBorrar'><i class='fas fa-trash-alt'></i></button>\
            </div></div>"
        },{ className: "hide_column", targets: [3] },
        { className: "hide_column", targets: [5] },
        { className: "hide_column", targets: [7] }
    ],

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

    document.getElementById('prescaja').onblur = function () {
      
        this.value = parseFloat(this.value.replace(/,/g, ''))
          .toFixed(2)
          .toString()
          .replace(/\B(?=(\d{3})+(?!\d))/g, ',')
      }

      document.getElementById('presnom').onblur = function () {
      
        this.value = parseFloat(this.value.replace(/,/g, ''))
          .toFixed(2)
          .toString()
          .replace(/\B(?=(\d{3})+(?!\d))/g, ',')
      }

    $("#btnNuevo").click(function() {

        window.location.href = "obra.php";
       
    });

    var fila; //capturar la fila para editar o borrar el registro

    //botón EDITAR    
    $(document).on("click", ".btnEditar", function() {
        fila = $(this).closest("tr");
        id = parseInt(fila.find('td:eq(0)').text());
        window.location.href = "obra.php?id="+id;
       

    });

    $(document).on("click", "#btnGuardarpres", function() {
        obra=$('#id_obra').val();
   
        nompres = $('#presnom').val().replace(/,/g, '')
        cajapres = $('#prescaja').val().replace(/,/g, '')
       
      
        opcion=4;
    
        $.ajax({
          url: 'bd/actualizadatos.php',
          type: 'POST',
          dataType: 'json',
          data: {
            obra: obra,
            presupuestado: cajapres,
            ejecutado: nompres,
            opcion: opcion
           
          },
          success: function (data) {
            if (data == 1) {
             
              window.location.reload()
            } else {
              facturaerror()
            }
          },
        })
       

    });

    $(document).on("click", ".btnInfo", function() {
        fila = $(this).closest("tr");
        id = parseInt(fila.find('td:eq(0)').text());
        $('#id_obra').val(id);
        buscarinfo(id)

        $('#modalInfo').modal('show')
       

    });

    function buscarinfo(id){
      obra=id
        opcion = 3
        $.ajax({
          type: 'POST',
          url: 'bd/actualizadatos.php',
          dataType: 'json',
    
          data: { obra: obra, opcion: opcion },
    
          success: function (res) {
           
           
                 $('#presnom').val(  Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
                    parseFloat(res[0].nompres).toFixed(2),))
                 $('#prescaja').val( Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
                    parseFloat(res[0].cajapres).toFixed(2),))
                  
           
          },
        })


    }

    $(document).on("click", ".btnAddenda", function() {
        fila = $(this).closest("tr");
        id = parseInt(fila.find('td:eq(0)').text());
        window.location.href = "cntaextraobra.php?id="+id;
       

    });

    //botón BORRAR
    $(document).on("click", ".btnBorrar", function() {
        fila = $(this);

        id = parseInt($(this).closest("tr").find('td:eq(0)').text());
        opcion = 3 //borrar

        //agregar codigo de sweatalert2
        var respuesta = confirm("¿Está seguro de eliminar el registro: " + id + "?");



        if (respuesta) {
            $.ajax({

                url: "bd/crudproveedor.php",
                type: "POST",
                dataType: "json",
                data: { id: id, opcion: opcion },

                success: function(data) {
                    console.log(fila);

                    tablaVis.row(fila.parents('tr')).remove().draw();
                }
            });
        }
    });



   

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