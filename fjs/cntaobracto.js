$(document).ready(function() {
  var id, opcion;
  opcion = 4;

  tablaVis = $("#tablaV").DataTable({



      "columnDefs": [{
          "targets": -1,
          "data": null,
          "defaultContent": "<div class='text-center'><div class='btn-group'>\
          <button class='btn btn-sm bg-info  btnInfo'><i class='fa-solid fa-circle-info'></i></button>\
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

  tablaInfo = $("#tablaInfo").DataTable({
    paging:false,
    seraching:false,
    info:false,
    order:false,


    "columnDefs": [{
        "targets": -1,
        "data": null,
        "defaultContent": "<div class='text-center'><div class='btn-group'>\
        <button class='btn btn-sm bg-info  btnInfo'><i class='fa-solid fa-circle-info'></i></button>\
        </div></div>"
    },
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


  $(document).on("click", ".btnInfo", function() {
    fila = $(this).closest("tr");
    id = parseInt(fila.find('td:eq(0)').text());
    $('#id_obra').val(id);
    console.log(id)
    buscarinfo(id)

    $('#modalInfo').modal('show')
   

});
function buscarinfo(id){
    obra=id
    opcion = 1
    
    tablaInfo.clear()
    tablaInfo.draw()
    $.ajax({
      type: 'POST',
      url: 'bd/buscactoobra.php',
      dataType: 'json',

      data: { obra: obra, opcion: opcion },

      success: function (data) {
       console.log(data)
        for (var i = 0; i < data.length; i++) {
          tablaInfo.row
            .add([
              data[i].id_reg,
              data[i].id_obra,
              data[i].id_partida,
              data[i].nom_partidacto,
              data[i].porcentaje,
              new Intl.NumberFormat('es-MX').format(
                Math.round(data[i].importe * 100, 2) / 100,
              ),
              data[i].estado_reg,
              
            ])
            .draw()

          //tabla += '<tr><td>' + res[i].id_objetivo + '</td><td>' + res[i].desc_objetivo + '</td><td class="text-center">' + icono + '</td><td class="text-center"></td></tr>';
        }
              
       
      },
      error: function(){

      }
    })


}


  var fila; //capturar la fila para editar o borrar el registro

 
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