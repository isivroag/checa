$(document).ready(function () {
    var id, opcion, valor;
    opcion = 4;
    valor = 0;
    /*<button class='btn btn-sm btn-primary btnEditar'  data-toggle='tooltip' data-placement='top' title='Editar'><i class='fas fa-edit'></i></button>\
        <button class='btn btn-sm bg-info btnResumen'><i class='fas fa-bars'  data-toggle='tooltip' data-placement='top' title='Resumen de Pagos'></i></button>
      */
    var textcolumnas = permisos();
  
    function permisos() {
      var tipousuario = $("#tipousuario").val();
      var columnas = "";
  
      if (tipousuario == 1) {
        columnas =
          "<div class='text-center'><div class='btn-group'>\
          <button class='btn btn-sm btn-primary btnVer' data-toggle='tooltip' data-placement='top' title='Ver Reporte' ><i class='fa-solid fa-magnifying-glass'></i></button>\
            <button class='btn btn-sm btn-success btnImprimir' data-toggle='tooltip' data-placement='top' title='Generar Reporte' ><i class='fa-solid fa-file-pdf'></i></button>\
            </div></div>";
      } else {
        columnas =
          "<div class='text-center'><div class='btn-group'>\
          <button class='btn btn-sm btn-primary btnVer' data-toggle='tooltip' data-placement='top' title='Ver Reporte' ><i class='fa-solid fa-magnifying-glass'></i></button>\
            <button class='btn btn-sm btn-success btnImprimir' data-toggle='tooltip' data-placement='top' title='Generar Reporte' ><i class='fa-solid fa-file-pdf'></i></button>\
            </div></div>";
      }
      return columnas;
    }
  
    var textcolumnas3 = permisos3();
  
    function permisos3() {
      var tipousuario = $("#tipousuario").val();
      var columnas = "";
  
      if (tipousuario == 1) {
        columnas = "";
        /*"<div class='text-center'><div class='btn-group'><button class='btn btn-sm bg-danger btnCancelarpago' data-toggle='tooltip' data-placement='top' title='Cancelar'><i class='fas fa-ban'></i></button>\
            </div></div>"*/
      } else {
        columnas =
          "<div class='text-center'><div class='btn-group'><button class='btn btn-sm bg-danger btnCancelarpago' data-toggle='tooltip' data-placement='top' title='Cancelar'><i class='fas fa-ban'></i></button>\
            </div></div>";
      }
      return columnas;
    }
  
    // TOOLTIP DATATABLE
    $('[data-toggle="tooltip"]').tooltip();
  
    //FUNCION REDONDEAR
    function round(value, decimals) {
      return Number(Math.round(value + "e" + decimals) + "e-" + decimals);
    }
  
    //FUNCION FORMATO MONEDA
  
    //CALCULO TOTAL REQ
    function calculototalreq(valor) {
      subtotal = valor;
  
      total = round(subtotal * 1.16, 2);
      iva = total - subtotal;
  
      $("#ivareq").val(
        Intl.NumberFormat("es-MX", { minimumFractionDigits: 2 }).format(
          parseFloat(iva).toFixed(2)
        )
      );
      $("#montonom").val(
        Intl.NumberFormat("es-MX", { minimumFractionDigits: 2 }).format(
          parseFloat(total).toFixed(2)
        )
      );
    }
    //CALCULO SUBTOTAL REQ
    function calculosubtotalreq(valor) {
      total = valor;
  
      subtotal = round(total / 1.16, 2);
  
      iva = round(total - subtotal, 2);
  
      $("#ivareq").val(
        Intl.NumberFormat("es-MX", { minimumFractionDigits: 2 }).format(
          parseFloat(iva).toFixed(2)
        )
      );
      $("#subtotalreq").val(
        Intl.NumberFormat("es-MX", { minimumFractionDigits: 2 }).format(
          parseFloat(subtotal).toFixed(2)
        )
      );
    }
  
    // TABLA PRINCIPAL
  
    tablaVis = $("#tablaV").DataTable({
      fixedHeader: false,
      paging: false,
  
    
  
    columnDefs: [
        {
            targets: -1,
            data: null,
            defaultContent: textcolumnas,
        },
    ],
      rowCallback: function (row, data) {
        $($(row).find("td")["2"]).addClass("text-right");
    },
  
      // SUMA DE TOTAL
     
  
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
  
 
  
    //FILTROS
    $("#tablaV thead tr").clone(true).appendTo("#tablaV thead");
    $("#tablaV thead tr:eq(1) th").each(function (i) {
      var title = $(this).text();
      $(this).html(
        '<input class="form-control form-control-sm" type="text" placeholder="' +
          title +
          '" />'
      );
  
      $("input", this).on("keyup change", function () {
        if (i == 4) {
          valbuscar = this.value;
        } else {
          valbuscar = this.value;
        }
  
        if (tablaVis.column(i).search() !== valbuscar) {
          tablaVis.column(i).search(valbuscar, true, true).draw();
        }
      });
    });
  
    // TABLA BUSCAR OBRA
  
 
  
 

    //BOTON CANCELAR OTRO GASTO
  
    $(document).on("click", ".btnImprimir", function () {
      fila = $(this).closest("tr");
  
      folio = parseInt(fila.find("td:eq(0)").text());
     
      var ancho = 1000;
      var alto = 800;
      var x = parseInt((window.screen.width / 2) - (ancho / 2));
      var y = parseInt((window.screen.height / 2) - (alto / 2));
 
      url = "formatos/pdfreporte.php?folio=" + folio;
 
      window.open(url, "REPORTE DE PAGOS", "left=" + x + ",top=" + y + ",height=" + alto + ",width=" + ancho + "scrollbar=si,location=no,resizable=si,menubar=no");
   
    });
  
    $(document).on("click", ".btnVer", function () {
      fila = $(this).closest("tr");
  
      folio = parseInt(fila.find("td:eq(0)").text());
      window.location.href="cntareqrpt.php?folio="+folio
     
   
    });
  
  
    function facturaexitosa() {
      swal.fire({
        title: "Registro Guardado",
        icon: "success",
        focusConfirm: true,
        confirmButtonText: "Aceptar",
      });
    }
  
    function facturaerror() {
      swal.fire({
        title: "Registro No Guardado",
        icon: "error",
        focusConfirm: true,
        confirmButtonText: "Aceptar",
      });
    }
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
        icon: "success",
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
  
    //BUSQUEDA GENERAL
    $(document).on("click", "#btnBuscar", function () {
      var inicio = $("#inicio").val();
      var final = $("#final").val();
      var obra = $("#id_obra").val();
      var opcion = 1;
  
      tablaVis.clear();
      tablaVis.draw();
  
      if (inicio != "" && final != "" && obra != "") {
        $.ajax({
          type: "POST",
          url: "bd/buscarotro.php",
          dataType: "json",
          data: { inicio: inicio, final: final, obra: obra, opcion: opcion },
          success: function (data) {
            for (var i = 0; i < data.length; i++) {
              tablaVis.row
                .add([
                  data[i].id_otro,
                  data[i].id_obra,
                  data[i].corto_obra,
                  data[i].id_prov,
                  data[i].razon_prov,
                  data[i].fecha,
                  data[i].desc_otro,
                  Intl.NumberFormat("es-MX", { minimumFractionDigits: 2 }).format(
                    parseFloat(data[i].monto_otro).toFixed(2)
                  ),
                  Intl.NumberFormat("es-MX", { minimumFractionDigits: 2 }).format(
                    parseFloat(data[i].saldo_otro).toFixed(2)
                  ),
                ])
                .draw();
            }
          },
        });
      } else {
        alert("Selecciona ambas fechas");
      }
    });
  
    var fila; //capturar la fila para editar o borrar el registro
  
    function startTime() {
      var today = new Date();
      var hr = today.getHours();
      var min = today.getMinutes();
      var sec = today.getSeconds();
      //Add a zero in front of numbers<10
      min = checkTime(min);
      sec = checkTime(sec);
      document.getElementById("clock").innerHTML = hr + " : " + min + " : " + sec;
      var time = setTimeout(function () {
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
  