$(document).ready(function () {
  var id, opcion
  opcion = 4

  tablaVis = $('#tablav').DataTable({
    paging: false,
    ordering: false,
    info: false,
    searching: false,

    columnDefs: [
      {
        targets: -1,
        data: null,
        defaultContent:
          "<div class='text-center'><div class='btn-group'>\
            <button class='btn btn-sm btn-primary  btnEditar'><i class='fas fa-edit'></i></button>\
            <button class='btn btn-sm bg-purple  btnAddenda'><i class='fas fa-expand-alt'></i></button>\
            <button class='btn btn-sm btn-danger btnBorrar'><i class='fas fa-trash-alt'></i></button>\
            </div></div>",
      },
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
  })

  tablaC = $('#tablaC').DataTable({
    columnDefs: [
      {
        targets: -1,
        data: null,
        defaultContent:
          "<div class='text-center'><button class='btn btn-sm btn-success btnAutorizar' data-toggle='tooltip' data-placement='top' title='Autorizar y Confirmar'><i class='fas fa-hand-pointer'></i></button>\
                  </div>",
      },
      { className: 'hide_column', targets: [7] },
      { className: 'hide_column', targets: [2] },
      { className: 'text-right', targets: [8] },
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
    ordering: false,
    paging: false,
  })

  $('#btnAgregar').click(function () {
    buscarcuentas()

    $('#modalcuentas').modal('show')
  })

  var fila //capturar la fila para editar o borrar el registro

  $(document).on('click', '.btnAutorizar', function () {
    fila = $(this).closest('tr')
    id = parseInt(fila.find('td:eq(1)').text())
    tipodoc = fila.find('td:eq(0)').text()
    saldo = fila.find('td:eq(8)').text()
    $('#formPago').trigger('reset')

    $('#tipocuenta').val(tipodoc)
    $('#foliocuenta').val(id)
    $('#saldo').val(saldo)

    $('#modalPago').modal('show')
    $('#modalcuentas').modal('hide')
  })

  $(document).on('click', '#btnguardarpago', function () {
    foliosemanal = $('#folio').val()

    tipodoc = $('#tipocuenta').val()
    id = $('#foliocuenta').val()
    montopago = $('#montopago').val()
    obs= $('#obspago').val()
    usuario=$('nameuser').val()

    if (id.length == 0 || tipodoc.length == 0 || montopago.length == 0) {
      swal.fire({
        title: 'Datos Incompletos',
        text: 'Verifique sus datos',
        icon: 'warning',
        focusConfirm: true,
        confirmButtonText: 'Aceptar',
      })
    } else {
      $.ajax({
        url: 'bd/buscarsaldosem.php',
        type: 'POST',
        dataType: 'json',
        async: false,
        data: {
          tipodoc: tipodoc,
          id: id,
          montopago: montopago,
        },
        success: function (res) {
          saldo = res
        },
      })
    }

    if (parseFloat(saldo) < parseFloat(montopago)) {
      swal.fire({
        title: 'Pago Excede el Saldo',
        text:
          'El pago no puede exceder el sado de la cuenta, Verifique el monto del Pago',
        icon: 'warning',
        focusConfirm: true,
        confirmButtonText: 'Aceptar',
      })
      $('#saldo').val(saldo)
    } else {
      saldofin = saldo - montopago

      opcion = 1
      $.ajax({
        url: 'bd/registrarpagosem.php',
        type: 'POST',
        dataType: 'json',
        async: false,
        data: {
          foliosemanal: foliosemanal,
          tipodoc: tipodoc,
          obs: obs,
          id: id,
          montopago: montopago,
          usuario: usuario,
          opcion: opcion,
        },
        success: function (res) {
          if (res==1){
          operacionexitosa()
          $('#modalPago').modal('hide')
          window.location.reload()
        }
          else{
            swal.fire({
              title: 'Pago No aplicado',
              text:
                'Error al registrarl el pago',
              icon: 'error',
              focusConfirm: true,
              confirmButtonText: 'Aceptar',
            })
          }
        } ,error: function(){
          swal.fire({
            title: 'Pago No aplicado',
            text:
              'Error al registrarl el pago',
            icon: 'error',
            focusConfirm: true,
            confirmButtonText: 'Aceptar',
          })
        }
        
        
      })
    }
  })

  function buscarcuentas() {
    tablaC.clear()
    tablaC.draw()
    opcion = 2
    $.ajax({
      type: 'POST',
      url: 'bd/buscarcuentas.php',
      dataType: 'json',

      data: {},

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
              Intl.NumberFormat('es-MX', { minimumFractionDigits: 2 }).format(
                parseFloat(res[i].saldo).toFixed(2),
              ),
            ])
            .draw()
        }
      },
    })
  }


  function operacionexitosa() {
    swal.fire({
        title: "Pago Registrado",
        icon: "success",
        focusConfirm: true,
        confirmButtonText: "Aceptar",
    });
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
