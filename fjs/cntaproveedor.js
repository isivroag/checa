$(document).ready(function () {
  var id, opcion
  opcion = 4

  // TOOLTIP DATATABLE
  $('[data-toggle="tooltip"]').tooltip()

  tablaVis = $('#tablaV').DataTable({

    dom:
    "<'row justify-content-center'<'col-sm-12 col-md-4 form-group'l><'col-sm-12 col-md-4 form-group'B><'col-sm-12 col-md-4 form-group'f>>" +
    "<'row'<'col-sm-12'tr>>" +
    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",

  buttons: [
    {
      extend: 'excelHtml5',
      text: "<i class='fas fa-file-excel'> Excel</i>",
      titleAttr: 'Exportar a Excel',
      title: 'Listado de Proveedores',
      className: 'btn bg-success ',
      exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7] },
    },
    {
      extend: 'pdfHtml5',
      text: "<i class='far fa-file-pdf'> PDF</i>",
      titleAttr: 'Exportar a PDF',
      title: 'Listado de Proveedores',
      className: 'btn bg-danger',
      exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7] },
    },
  ],

    columnDefs: [
      {
        targets: -1,
        data: null,
        defaultContent:
          "<div class='text-center'><button class='btn btn-sm btn-primary btnEditar' data-toggle='tooltip' data-placement='top' title='Editar'><i class='fas fa-edit'></i></button>\
            <button class='btn btn-sm btn-info btnCuenta'><i class='fas fa-money-check-alt' data-toggle='tooltip' data-placement='top' title='Alta de Cuenta'></i></button>\
            <button class='btn btn-sm btn-secondary btnVercuentas'><i class='fas fa-search-dollar' data-toggle='tooltip' data-placement='top' title='Ver cuentas bancarias'></i></button>\
                                <button class='btn btn-sm btn-danger btnBorrar' data-toggle='tooltip' data-placement='top' title='Eliminar'><i class='fas fa-trash-alt'></i></button></div>",
      },
      { className: 'hide_column', targets: [3] },
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

    //FILTROS
    $('#tablaV thead tr').clone(true).appendTo('#tablaV thead')
    $('#tablaV thead tr:eq(1) th').each(function (i) {
      var title = $(this).text()
      $(this).html(
        '<input class="form-control form-control-sm" type="text" placeholder="' +
          title +
          '" />',
      )
  
      $('input', this).on('keyup change', function () {
        if (i == 4) {
          valbuscar = this.value
        } else {
          valbuscar = this.value
        }
  
        if (tablaVis.column(i).search() !== valbuscar) {
          tablaVis.column(i).search(valbuscar, true, true).draw()
        }
      })
    })

  //BONTON NUEVO
  $('#btnNuevo').click(function () {
    //window.location.href = "prospecto.php";
    $('#formDatos').trigger('reset')
    $('.modal-header').css('background-color', '#28a745')
    $('.modal-header').css('color', 'white')
    $('.modal-title').text('NUEVO PROVEEDOR')
    $('#modalCRUD').modal('show')
    id = null
    opcion = 1
  })

  var fila

  //BOTON EDITAR
  $(document).on('click', '.btnEditar', function () {
    fila = $(this).closest('tr')
    id = parseInt(fila.find('td:eq(0)').text())

    rfc = fila.find('td:eq(1)').text()
    razon = fila.find('td:eq(2)').text()
    dir = fila.find('td:eq(3)').text()
    tel = fila.find('td:eq(4)').text()
    contacto = fila.find('td:eq(5)').text()
    tel_contacto = fila.find('td:eq(6)').text()
    especialidad = fila.find('td:eq(7)').text()

    $('#rfc').val(rfc)
    $('#razon').val(razon)
    $('#dir').val(dir)
    $('#tel').val(tel)
    $('#contacto').val(contacto)
    $('#tel_contacto').val(tel_contacto)
    $('#especialidad').val(especialidad)
    opcion = 2 //editar

    $('.modal-header').css('background-color', '#007bff')
    $('.modal-header').css('color', 'white')
    $('.modal-title').text('EDITAR PROVEEDOR')
    $('#modalCRUD').modal('show')
  })

  //BOTON BORRAR
  $(document).on('click', '.btnBorrar', function () {
    fila = $(this)

    id = parseInt($(this).closest('tr').find('td:eq(0)').text())
    opcion = 3
    swal
      .fire({
        title: 'ELIMINAR',
        text: '¿Desea eliminar el registro seleccionado?',
        showCancelButton: true,
        icon: 'question',
        focusConfirm: true,
        confirmButtonText: 'Aceptar',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#28B463',
        cancelButtonColor: '#d33',
      })
      .then(function (isConfirm) {
        if (isConfirm.value) {
          $.ajax({
            url: 'bd/crudproveedor.php',
            type: 'POST',
            dataType: 'json',
            data: { id: id, opcion: opcion },
            success: function (data) {
              tablaVis.row(fila.parents('tr')).remove().draw()
            },
          })
        } else if (isConfirm.dismiss === swal.DismissReason.cancel) {
        }
      })
  })

  //GUARDAR PROVEEDOR

  $('#formDatos').submit(function (e) {
    e.preventDefault()

    var razon = $('#razon').val()
    var dir = $('#dir').val()
    var tel = $('#tel').val()
    var rfc = $('#rfc').val()
    var contacto = $('#contacto').val()
    var tel_contacto = $('#tel_contacto').val()
    var especialidad = $('#especialidad').val()

    if (razon.length == 0 || rfc.length == 0) {
      Swal.fire({
        title: 'Datos Faltantes',
        text: 'Debe ingresar todos los datos del Prospecto',
        icon: 'warning',
      })
      return false
    } else {
      $.ajax({
        url: 'bd/buscarrfc.php',
        type: 'POST',
        dataType: 'json',
        async: false,
        data: {
          rfc: rfc,
          opcion: opcion
        },
        success: function (data) {
            
          if (data == 0) {
            // funcion crud
            $.ajax({
              url: 'bd/crudproveedor.php',
              type: 'POST',
              dataType: 'json',
              data: {
                razon: razon,
                tel: tel,
                rfc: rfc,
                dir: dir,
                id: id,
                contacto: contacto,
                especialidad: especialidad,
                tel_contacto: tel_contacto,
                opcion: opcion,
              },
              success: function (data) {
                id = data[0].id_prov
                rfc = data[0].rfc_prov
                razon = data[0].razon_prov
                tel = data[0].tel_prov
                dir = data[0].dir_prov
                contacto = data[0].contacto_prov
                tel_contacto = data[0].telcon_prov
                if (opcion == 1) {
                  tablaVis.row
                    .add([
                      id,
                      rfc,
                      razon,
                      dir,
                      tel,
                      contacto,
                      tel_contacto,
                      especialidad,
                    ])
                    .draw()
                } else {
                  tablaVis
                    .row(fila)
                    .data([
                      id,
                      rfc,
                      razon,
                      dir,
                      tel,
                      contacto,
                      tel_contacto,
                      especialidad,
                    ])
                    .draw()
                }
              },
            })
            $('#modalCRUD').modal('hide')
            // funcion crud
          } else {
            Swal.fire({
              title: 'El RFC ya se encuentra registrado',
              icon: 'error',
            })
          }
        },
      })
    }
  })

  //BOTON ALTA DE CUENTA
  $(document).on('click', '.btnCuenta', function () {
 
    //window.location.href = "prospecto.php";
    $('#formcuentaprov').trigger('reset')
    fila = $(this)
   

    idprovcuenta = parseInt($(this).closest('tr').find('td:eq(0)').text())
    $('#idprovcuenta').val(idprovcuenta)
    $('#modalcuentaprov').modal('show')

    opcion = 1 //alta
  })

  // GUARDAR CUENTA

  $('#formcuentaprov').submit(function (e) {
    e.preventDefault()
    var id = $('#idcuentaprov').val()

    var banco = $('#bancoprov').val()
    var cuenta = $('#cuenta').val()
    var clabe = $('#clabe').val()
    var tarjeta = $('#tarjeta').val()
    var idprovcuenta = $('#idprovcuenta').val()

    if (banco.length == 0 || cuenta.length == 0) {
      Swal.fire({
        title: 'Datos Faltantes',
        text: 'Debe ingresar todos los datos requeridos',
        icon: 'warning',
      })
      return false
    } else {
      $.ajax({
        url: 'bd/crudcuentaprov.php',
        type: 'POST',
        dataType: 'json',
        data: {
          banco: banco,
          cuenta: cuenta,
          clabe: clabe,
          id: id,
          tarjeta: tarjeta,
          idprovcuenta: idprovcuenta,
          opcion: opcion,
        },
        success: function (data) {
          window.location.reload()
        },
      })
      $('#modalcuentaprov').modal('hide')
    }
  })
  //TABLA CUENTAS

  tablacuenta = $('#tablaCuentas').DataTable({
    columnDefs: [
      {
        targets: -1,
        data: null,
        defaultContent:
          "<div class='text-center'><button class='btn btn-sm bg-primary btnEditarcuenta' data-toggle='tooltip' data-placement='top' title='Editar Cuenta'><i class='fas fa-edit'></i></button>\
                     <button class='btn btn-sm bg-danger btnEliminarcuenta' data-toggle='tooltip' data-placement='top' title='Eliminar Cuenta'><i class='fas fa-trash-alt'></i></button>\
                    </div></div>",
      },
      { className: 'hide_column', targets: [1] },
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

  //BOTON RESUMEN DE CUENTAS
  $(document).on('click', '.btnVercuentas', function () {
    fila = $(this).closest('tr')
    id = parseInt(fila.find('td:eq(0)').text())
    buscarcuentas(id)
    $('#modalCuentas').modal('show')
  })

  // FUNCION BUSCAR CUENTAS
  function buscarcuentas(id) {
    tablacuenta.clear()
    tablacuenta.draw()
    opcion = 2 // 2 para cuentas pagar
    $.ajax({
      type: 'POST',
      url: 'bd/buscarcuentasprov.php',
      dataType: 'json',

      data: { id: id },

      success: function (res) {
        for (var i = 0; i < res.length; i++) {
          tablacuenta.row
            .add([
              res[i].id_cuentaprov,
              res[i].id_prov,
              res[i].banco,
              res[i].cuenta,
              res[i].clabe,
              res[i].tarjeta,
            ])
            .draw()
        }
      },
    })
  }

  // BOTON EDITAR CUENTA
  $(document).on('click', '.btnEditarcuenta', function () {
    fila = $(this).closest('tr')
    id = parseInt(fila.find('td:eq(0)').text())
    idprovcuenta = parseInt(fila.find('td:eq(1)').text())
    banco = fila.find('td:eq(2)').text()
    cuenta = fila.find('td:eq(3)').text()
    clabe = fila.find('td:eq(4)').text()
    tarjeta = fila.find('td:eq(5)').text()
    $('#formcuentaprov').trigger('reset')

    $('#idcuentaprov').val(id)
    $('#idprovcuenta').val(idprovcuenta)
    $('#bancoprov').val(banco)
    $('#cuenta').val(cuenta)
    $('#clabe').val(clabe)
    $('#tarjeta').val(tarjeta)
    $('#modalCuentas').modal('hide')
    $('#modalcuentaprov').modal('show')

    opcion = 2 //alta
  })

  //BOTON ELIMINAR CUENTA
  $(document).on('click', '.btnEliminarcuenta', function () {
    fila = $(this).closest('tr')
    id = parseInt(fila.find('td:eq(0)').text())
    opcion = 3 //borrar

    swal
      .fire({
        title: 'ELIMINAR',
        text: '¿Desea eliminar el registro seleccionado?',
        showCancelButton: true,
        icon: 'question',
        focusConfirm: true,
        confirmButtonText: 'Aceptar',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#28B463',
        cancelButtonColor: '#d33',
      })
      .then(function (isConfirm) {
        if (isConfirm.value) {
          $.ajax({
            url: 'bd/crudcuentaprov.php',
            type: 'POST',
            dataType: 'json',
            data: { id: id, opcion: opcion },
            success: function (data) {
              window.location.reload()
            },
          })
        } else if (isConfirm.dismiss === swal.DismissReason.cancel) {
        }
      })
  })
})
