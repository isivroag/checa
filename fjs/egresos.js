$(document).ready(function () {
  var id_concepto, opcion
  opcion = 4

  //FUNCION FORMATO MONEDA
  document.getElementById('monto').onblur = function () {
    Intl.NumberFormat('es-MX',{ minimumFractionDigits: 2 }).format(parseFloat(data[i].monto_renglon).toFixed(2)),
    //number-format the user input
    this.value =  Intl.NumberFormat('es-MX',{ minimumFractionDigits: 2 }).format(parseFloat(this.value.replace(/,/g, ''))
      .toFixed(2)
      .toString()
      .replace(/\B(?=(\d{3})+(?!\d))/g, ','));

    //set the numeric value to a number input
    //        document.getElementById("monto").value = this.value.replace(/,/g, "")
  }
  // TERMINA FUNCION FORMATO MONEDA
  tablaobra = $('#tablaObra').DataTable({
    columnDefs: [
      {
        targets: -1,
        data: null,
        defaultContent:
          "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-success btnSelObra'><i class='fas fa-hand-pointer'></i></button></div></div>",
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

  tablaprov = $('#tablaProveedor').DataTable({
    columnDefs: [
      {
        targets: -1,
        data: null,
        defaultContent:
          "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-success btnSelProveedor'><i class='fas fa-hand-pointer'></i></button></div></div>",
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

  function commaSeparateNumber(val) {
    while (/(\d+)(\d{3})/.test(val.toString())) {
      val = val.toString().replace(/(\d+)(\d{3})/, '$1' + ',' + '$2')
    }

    return val
  }

  var fila //capturar la fila para editar o borrar el registro

  //botón EDITAR
  $(document).on('click', '#btnGuardar', function () {
    folio = $('#folio').val()
    fecha = $('#fecha').val()
    clave = $('#clave').val()
    id_obra = $('#id_obra').val()
    id_prov = $('#id_prov').val()
    tipo = $('#tipo_cxp').val()
    descripcion = $('#descripcion').val()
    monto = $('#monto').val().replace(/,/g, '')

    if (
      fecha.length == 0 ||
      clave.length == 0 ||
      id_obra.length == 0 ||
      id_prov.length == 0 ||
      descripcion.length == 0 ||
      monto.length == 0
    ) {
      Swal.fire({
        title: 'Datos Faltantes',
        text: 'Debe ingresar todos los datos Requeridos',
        icon: 'warning',
      })
      return false
    } else {
      if (folio == 0) {
        $.ajax({
          url: 'bd/buscarfacturacxp.php',
          type: 'POST',
          dataType: 'json',
          async:false,
          data: {
            clave: clave,
            id_prov: id_prov,
          },
          success: function (data) {
            console.log(data);
            console.log(clave);
            console.log(id_prov);
            if (data == 0) {
              opcion = 1
              $.ajax({
                url: 'bd/crudegresos.php',
                type: 'POST',
                dataType: 'json',
                data: {
                  folio: folio,
                  fecha: fecha,
                  clave: clave,
                  id_obra: id_obra,
                  id_prov: id_prov,
                  descripcion: descripcion,
                  tipo: tipo,
                  monto: monto,
                  opcion: opcion,
                },
                success: function (data) {
                  if (data == 1) {
                    mensaje()
                   // window.location.href = 'cntacxp.php'
                  } else {
                    Swal.fire({
                      title: 'Operacion No Exitosa',
                      icon: 'warning',
                    })
                  }
                },
              })
            } else {
              Swal.fire({
                title:
                  'El Folio de la factura ya fue registrada para este proveedor',
                icon: 'error',
              })
            }
          },
        })
      } else {
        opcion = 2
        $.ajax({
          url: 'bd/crudegresos.php',
          type: 'POST',
          dataType: 'json',
          data: {
            folio: folio,
            fecha: fecha,
            clave: clave,
            id_obra: id_obra,
            id_prov: id_prov,
            descripcion: descripcion,
            tipo: tipo,
            monto: monto,
            opcion: opcion,
          },
          success: function (data) {
            if (data == 1) {
              mensaje()
              window.location.href = 'cntacxp.php'
            } else {
              Swal.fire({
                title: 'Operacion No Exitosa',
                icon: 'warning',
              })
            }
          },
        })
      }
    }
  })

  $(document).on('click', '#bobra', function () {
    $('#modalObra').modal('show')
  })

  $(document).on('click', '.btnSelObra', function () {
    fila = $(this)
    id_obra = parseInt($(this).closest('tr').find('td:eq(0)').text())
    obra = $(this).closest('tr').find('td:eq(2)').text()

    $('#id_obra').val(id_obra)
    $('#obra').val(obra)
    $('#modalObra').modal('hide')
  })

  //botón BORRAR
  $(document).on('click', '.btnSelProveedor', function () {
    fila = $(this)
    id_prov = parseInt($(this).closest('tr').find('td:eq(0)').text())
    proveedor = $(this).closest('tr').find('td:eq(2)').text()

    $('#id_prov').val(id_prov)
    $('#proveedor').val(proveedor)
    $('#modalProveedor').modal('hide')
  })

  $(document).on('click', '#bproveedor', function () {
    $('#modalProveedor').modal('show')
  })

  //botón BORRAR

  function mensaje() {
    swal.fire({
      title: 'Operación Exitosa',
      icon: 'success',
      focusConfirm: true,
      confirmButtonText: 'Aceptar',
      timer: 2000,
    })
  }

  function mensajeerror() {
    swal.fire({
      title: 'Error al Cancelar el Registro',
      icon: 'error',
      focusConfirm: true,
      confirmButtonText: 'Aceptar',
    })
  }

  function round(value, decimals) {
    return Number(Math.round(value + 'e' + decimals) + 'e-' + decimals)
  }
})
