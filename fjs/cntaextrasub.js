$(document).ready(function () {
    var id, opcion
    opcion = 4
    var fila
  
    var textcolumnas = permisos()
  
    function permisos() {
      var tipousuario = $('#tipousuario').val()
      var columnas = ''
  
      if (tipousuario == 1) {
        columnas =
          "<div class='text-center'><div class='btn-group'>\
          <button class='btn btn-sm bg-danger btnCancelar'><i class='fas fa-ban'  data-toggle='tooltip' data-placement='top' title='Cancelar'></i></button>\
          </div></div>"
      } else {
        columnas =
          "<div class='text-center'><div class='btn-group'>\
              <button class='btn btn-sm bg-danger btnCancelar'><i class='fas fa-ban'  data-toggle='tooltip' data-placement='top' title='Cancelar'></i></button>\
              </div></div>"
      }
      return columnas
    }
  
    //FUNCION FORMATO MONEDA
    document.getElementById('importeadd').onblur = function () {
      //number-format the user input
      this.value = parseFloat(this.value.replace(/,/g, ''))
        .toFixed(2)
        .toString()
        .replace(/\B(?=(\d{3})+(?!\d))/g, ',')
    }
  
    tablaVis = $('#tablaV').DataTable({
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
          title: 'ADENDAS',
          className: 'btn bg-success ',
          exportOptions: { columns: [0, 1, 2, 3, 4, 5] },
        },
        {
          extend: 'pdfHtml5',
          text: "<i class='far fa-file-pdf'> PDF</i>",
          titleAttr: 'Exportar a PDF',
          title: 'ADENDAS',
          className: 'btn bg-danger',
          exportOptions: { columns: [0, 1, 2, 3, 4, 5] },
        },
      ],
  
      columnDefs: [
        {
          targets: -1,
          data: null,
          defaultContent: textcolumnas,
        },
        { width: '50%', targets: 4 },
      ],
      rowCallback: function (row, data) {
        // FORMATO DE CELDAS
  
        $($(row).find('td')['5']).addClass('text-right')
  
        $($(row).find('td')['5']).addClass('currency')
      },
  
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
    })
  
    //boton nuevo
    $('#btnNuevo').click(function () {
      $('#formA').trigger('reset')
      $('#modalA').modal('show')
      id = null
      opcion = 1
    })
  
    //botón GUARDAR CAJA
    $(document).on('click', '#btnGuardarnom', function () {
      var folioadd = $('#folioadd').val()
      var fechaadd = $('#fechaadd').val()
      var foliosub = $('#foliosub').val()
  
      var claveadd = $('#claveadd').val()
      var tipoadd = $('#tipoadd').val()
      var descripcionadd = $('#descripcionadd').val()
  
      var importeadd = $('#importeadd').val().replace(/,/g, '')
      var importeobra = $('#importeobra').val().replace(/,/g, '')
  
      var usuario = $('#nameuser').val()
  

  
  
      if (fechaadd.length == 0 || foliosub.length == 0 || importeadd.length == 0) {
        Swal.fire({
          title: 'Datos Faltantes',
          text: 'Debe ingresar todos los datos del Requeridos',
          icon: 'warning',
        })
        return false
      } else {
        if (tipoadd == 'DECREMENTO') {
          if (importeobra < importeadd) {
            Swal.fire({
              title: 'OPERACION NO VALIDA',
              text: 'El importe del Contrato es menor al Importe del Decremento',
              icon: 'warning',
            })
            return 0
          }
        }
        $.ajax({
          url: 'bd/crudextrasub.php',
          type: 'POST',
          dataType: 'json',
          data: {
            folioadd: folioadd,
            fechaadd: fechaadd,
            foliosub: foliosub,
            claveadd: claveadd,
            importeadd: importeadd,
            tipoadd: tipoadd,
            descripcionadd: descripcionadd,
            usuario: usuario,
            importeobra: importeobra,
            id: id,
            opcion: opcion,
          },
          success: function (data) {
            id = data[0].id_extra
            fecha = data[0].fecha_extra
            tipo = data[0].tipo_extra
  
            clave = data[0].clave_extra
            monto = data[0].monto_extra
            concepto = data[0].concepto_extra
  
           window.location.reload()
  
            registroguardado()
          },
        })
        $('#modalA').modal('hide')
      }
    })
  
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
  })
  
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
  