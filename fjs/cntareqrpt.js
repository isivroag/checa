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
            <button class='btn btn-sm btn-primary btnVer' data-toggle='tooltip' data-placement='top' title='Detalle de Requisición' ><i class='fa-solid fa-magnifying-glass'></i></button>\
            <button class='btn btn-sm btn-warning btnQuitar text-white' data-toggle='tooltip' data-placement='top' title='Quitar a Reporte' ><i class='fa-solid fa-circle-minus'></i></button>\
            </div></div>";
      } else {
        columnas =
          "<div class='text-center'><div class='btn-group'>\
            <button class='btn btn-sm btn-primary btnVer' data-toggle='tooltip' data-placement='top' title='Detalle de Requisición' ><i class='fa-solid fa-magnifying-glass'></i></button>\
            <button class='btn btn-sm btn-warning btnQuitar text-white' data-toggle='tooltip' data-placement='top' title='Quitar a Reporte' ><i class='fa-solid fa-circle-minus'></i></button>\
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
  
 
   
  
    // TABLA PRINCIPAL
  
    tablaVis = $("#tablaV").DataTable({
      fixedHeader: false,
      paging: false,
      sorting:false,
      searching:false,
  
      dom:
        "<'row justify-content-center'<'col-sm-12 col-md-4 form-group'l><'col-sm-12 col-md-4 form-group'B><'col-sm-12 col-md-4 form-group'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
  
      buttons: [
        {
          extend: "excelHtml5",
          text: "<i class='fas fa-file-excel'> Excel</i>",
          titleAttr: "Exportar a Excel",
          title: "Reporte Requisiciones",
          className: "btn bg-success ",
          exportOptions: { columns: [0, 2,4, 5, 6, 7] },
        },
        {
          extend: "pdfHtml5",
          text: "<i class='far fa-file-pdf'> PDF</i>",
          titleAttr: "Exportar a PDF",
          title: "Reporte Requisiciones",
          className: "btn bg-danger",
          exportOptions: { columns: [0, 2,4, 5, 6, 7] },
        },
      ],
  
      columnDefs: [
        {
          targets: -1,
          data: null,
          defaultContent: textcolumnas,
        },
        
        { className: "hide_column", targets: [1] },
        { className: "hide_column", targets: [3] },
      ],
      rowCallback: function (row, data) {
        $($(row).find("td")["7"]).addClass("text-right");
  
        valor=data[2]
   
      },
  
      // SUMA DE TOTAL
      footerCallback: function (row, data, start, end, display) {
        var api = this.api(),
          data;
  
        var intVal = function (i) {
          return typeof i === "string"
            ? i.replace(/[\$,]/g, "") * 1
            : typeof i === "number"
            ? i
            : 0;
        };
        /*
              total = api
                .column(6)
                .data()
                .reduce(function (a, b) {
                  return intVal(a) + intVal(b)
                }, 0)*/
  
       
  
        saldo = api
          .column(7, { page: "current" })
          .data()
          .reduce(function (a, b) {
            return intVal(a) + intVal(b);
          }, 0);
  
          $('#importerpt').val(Intl.NumberFormat("es-MX", { minimumFractionDigits: 2 }).format(
            parseFloat(saldo).toFixed(2)
          ))
        $(api.column(7).footer()).html(
          Intl.NumberFormat("es-MX", { minimumFractionDigits: 2 }).format(
            parseFloat(saldo).toFixed(2)
          )
        );
      },
  
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
  
    tablaDet = $('#tablaDet').DataTable({
      paging: false,
      ordering: false,
      info: false,
      searching: false,
  
     
     
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
        $($(row).find('td')[2]).addClass('text-center')
        $($(row).find('td')[3]).addClass('text-right')
        
        
  
      
        
        
  
        $($(row).find('td')[4]).addClass('text-right')
        
  
        
  
        $($(row).find('td')[5]).addClass('text-right')
        
      },
    })
  
    // TABLA BUSCAR OBRA
  
    tablaobra = $("#tablaObra").DataTable({
      columnDefs: [
        {
          targets: -1,
          data: null,
          defaultContent:
            "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-success btnSelObra' data-toggle='tooltip' data-placement='top' title='Seleccionar Obra'><i class='fas fa-hand-pointer'></i></button></div></div>",
        },
      ],
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

 
  
 

    $(document).on("click", ".btnQuitar", function () {
      
      fila = $(this).closest("tr");
      folio = parseInt(fila.find("td:eq(0)").text());
     
      
      opcion = 3;
  
      $.ajax({
        type: "POST",
        url: "bd/movreq.php",
        dataType: "json",
  
        data: { folio: folio, opcion: opcion },
  
        success: function (res) { 
         window.location.reload()
        
        },
      });
     
    });


  

  
    //BOTON BUSCAR OBRA
    $(document).on("click", "#bobra", function () {
      $("#modalObra").modal("show");
    });
  
    //BOTON SELECCIONAR OBRA
    $(document).on("click", ".btnSelObra", function () {
      fila = $(this);
      id_obra = parseInt($(this).closest("tr").find("td:eq(0)").text());
      obra = $(this).closest("tr").find("td:eq(2)").text();
      $("#id_obra").val(id_obra);
      $("#obra").val(obra);
      $("#modalObra").modal("hide");
    });
  
   
    $(document).on("click", "#btnGuardar", function () {
      
      fecha = $('#fecharpt').val()
      importe = $('#importerpt').val().replace(/,/g, '')
      opcion=1
      usuario=$('#nameuser').val()

      $.ajax({
        type: 'POST',
        url: 'bd/crudreporte.php',
        dataType: 'json',
        data: { fecha: fecha, importe: importe,opcion: opcion, usuario: usuario },
  
        success: function (res) {
         if (res!=0){
            $('#foliorpt').val(res)
            $('#btnGuardar').css('display', 'none');
            $('#btnImprimir').css('display', 'block');
            facturaexitosa()
         }
        },
      })
    });
  
    $(document).on("click", "#btnImprimir", function () {
      
     folio=$('#foliorpt').val()
     var ancho = 1000;
     var alto = 800;
     var x = parseInt((window.screen.width / 2) - (ancho / 2));
     var y = parseInt((window.screen.height / 2) - (alto / 2));

     url = "formatos/pdfreporte.php?folio=" + folio;

     window.open(url, "REPORTE DE PAGOS", "left=" + x + ",top=" + y + ",height=" + alto + ",width=" + ancho + "scrollbar=si,location=no,resizable=si,menubar=no");
     
    });
  

  

  
    //BUSCAR DETALLE DE REQUISICION
    $(document).on("click", ".btnVer", function () {
      
      tablaDet.clear();
      tablaDet.draw();
      fila = $(this).closest("tr");
      folio = parseInt(fila.find("td:eq(0)").text());
      $.ajax({
        type: 'POST',
        url: 'bd/buscardetallereq.php',
        dataType: 'json',
        data: { folio: folio },
  
        success: function (res) {
          console.log(res)
          folio=res[0].folio_req
          $('#folio').val(folio)
          fecha=res[0].fecha
          $('#fecha').val(fecha)
          id_obra=res[0].id_obra
          $('#id_obra').val(id_obra)
          obra=res[0].corto_obra
          $('#obra').val(obra)
          id_prov=res[0].id_prov
          $('#id_prov').val(id_prov)
          proveedor=res[0].razon_prov
          $('#nombre').val(proveedor)
          id_sol=res[0].id_sol
          $('#id_sol').val(id_sol)
          solicitante=res[0].nombre
          $('#solicitante').val(solicitante)
          concepto=res[0].desc_req
          $('#concepto').val(concepto)
          monto_req=res[0].monto_req
          $('#total').val( Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
                parseFloat(monto_req).toFixed(2)),)

          for (var i = 0; i < res.length; i++) {
            tablaDet.row
              .add([
                res[i].id_reg,
                res[i].concepto,
                res[i].unidad,
                 Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
                parseFloat(res[i].cantidad).toFixed(2)),
                 Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
                parseFloat(res[i].precio).toFixed(2)),
                 Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
                parseFloat(res[i].importe).toFixed(2)),
              ])
              .draw()
  
            //tabla += '<tr><td>' + res[i].id_objetivo + '</td><td>' + res[i].desc_objetivo + '</td><td class="text-center">' + icono + '</td><td class="text-center"></td></tr>';
          }
        },
      })
  
      $("#modalVer").modal("show");
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
  