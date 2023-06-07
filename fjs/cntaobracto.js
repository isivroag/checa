$(document).ready(function () {
  var id, opcion;
  opcion = 4;

  tablaVis = $("#tablaV").DataTable({
    columnDefs: [
      {
        targets: -1,
        data: null,
        defaultContent:
          "<div class='text-center'><div class='btn-group'>\
          <button class='btn btn-sm bg-info  btnInfo'><i class='fa-solid fa-circle-info'></i></button>\
          </div></div>",
      },
      { className: "hide_column", targets: [3] },
      { className: "hide_column", targets: [5] },
      { className: "hide_column", targets: [7] },
      
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
      
      {
        targets: 5,
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
      $($(row).find('td')['4']).addClass('text-right')
      $($(row).find('td')['5']).addClass('currency')
      $($(row).find('td')['5']).addClass('text-right')
      

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
        .column(5, { page: 'current' })
        .data()
        .reduce(function (a, b) {
          return intVal(a) + intVal(b)
        }, 0)

      $(api.column(5).footer()).html(
        Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
          parseFloat(importetabla).toFixed(2),
        ),
      )
    },
  });

  $(document).on("click", ".btnImporte", function () {
    fila = $(this).closest("tr");

    registro = fila.find("td:eq(0)").text();
    obra = fila.find("td:eq(1)").text();
    partida = fila.find("td:eq(2)").text();
    concepto = fila.find("td:eq(3)").text();
    porcentaje = fila.find("td:eq(4)").text();
    importe = fila.find("td:eq(5)").text();
    $("#id_obra2").val(obra);
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
    partida = $("#id_partida").val();
    porcentaje = $("#porcentaje").val().replace(/,/g, '');
    monto= $("#importe").val().replace(/,/g, '');
    opcion=1;
    calcularpor(obra,partida,porcentaje,monto,opcion)


  });

  $(document).on("click", "#btncalcular2", function (e) {
    e.preventDefault();
    obra = $("#id_obra2").val();
    partida = $("#id_partida").val();
    porcentaje = $("#porcentaje").val().replace(/,/g, '');
    monto= $("#importe").val().replace(/,/g, '');
    opcion=2;
    calcularpor(obra,partida,porcentaje,monto,opcion)



  });
  function calcularpor(obra, partida,porcentaje,monto,opcion){
    
    $.ajax({
      type: "POST",
      url: "bd/calcularcosto.php",
      dataType: "json",

      data: { obra: obra, partida: partida, porcentaje: porcentaje, opcion: opcion,monto: monto },

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
    partida = $("#id_partida").val();
    porcentaje = $("#porcentaje").val().replace(/,/g, '');
    registro = $("#id_reg").val();
    importe = $("#importe").val().replace(/,/g, '');
    console.log(porcentaje)
    console.log(importe)
    tipo = $("#tipo").val();
    $.ajax({
      type: "POST",
      url: "bd/guardarcosto.php",
      dataType: "json",

      data: { obra: obra, partida: partida, porcentaje: porcentaje, 
        importe: importe, tipo: tipo, registro: registro },

      success: function (data) {
        if (data==1){
          $("#modalImporte").modal("hide");
          exito()
        buscarinfo(obra)
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

  $(document).on("click", ".btnInfo", function () {
    fila = $(this).closest("tr");
    id = parseInt(fila.find("td:eq(0)").text());
    $("#id_obra").val(id);
    
    buscarinfo(id);

    $("#modalInfo").modal("show");
  });

  function buscarinfo(id) {
    obra = id;
    opcion = 1;

    tablaInfo.clear();
    tablaInfo.draw();
    $.ajax({
      type: "POST",
      url: "bd/buscactoobra.php",
      dataType: "json",

      data: { obra: obra, opcion: opcion },

      success: function (data) {
       
        for (var i = 0; i < data.length; i++) {
          tablaInfo.row
            .add([
              data[i].id_reg,
              data[i].id_obra,
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

  var fila; //capturar la fila para editar o borrar el registro

 
});

function filterFloat(evt, input) {
  // Backspace = 8, Enter = 13, ‘0′ = 48, ‘9′ = 57, ‘.’ = 46, ‘-’ = 43
  var key = window.Event ? evt.which : evt.keyCode;
  var chark = String.fromCharCode(key);
  var tempValue = input.value + chark;
  var isNumber = key >= 48 && key <= 57;
  var isSpecial = key == 8 || key == 13 || key == 0 || key == 46;
  if (isNumber || isSpecial) {
    return filter(tempValue);
  }

  return false;
}
function filter(__val__) {
  var preg = /^([0-9]+\.?[0-9]{0,2})$/;
  return preg.te;
  st(__val__) === true;
}

$(".modal-header").on("mousedown", function (mousedownEvt) {
  var $draggable = $(this);
  var x = mousedownEvt.pageX - $draggable.offset().left,
    y = mousedownEvt.pageY - $draggable.offset().top;
  $("body").on("mousemove.draggable", function (mousemoveEvt) {
    $draggable.closest(".modal-dialog").offset({
      left: mousemoveEvt.pageX - x,
      top: mousemoveEvt.pageY - y,
    });
  });
  $("body").one("mouseup", function () {
    $("body").off("mousemove.draggable");
  });
  $draggable.closest(".modal").one("bs.modal.hide", function () {
    $("body").off("mousemove.draggable");
  });
});
