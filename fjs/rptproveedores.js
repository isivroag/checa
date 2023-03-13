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
            "<div class='text-center'>\
              <button class='btn btn-sm btn-secondary btnVercuentas'><i class='fas fa-search-dollar' data-toggle='tooltip' data-placement='top' title='Ver cuentas bancarias'></i></button>\
                                  </div>",
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
  


  
   
    //TABLA CUENTAS
  
    tablacuenta = $('#tablaCuentas').DataTable({
      columnDefs: [
        
        { className: 'hide_column', targets: [1] },
        { className: 'hide_column', targets: [6] },
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
      rowCallback: function (row, data) {
    
      
        if (data[6] == '1') {
          //$($(row).find("td")[6]).css("background-color", "warning");
          $($(row).find('td')).addClass('bg-gradient-info')
          //$($(row).find('td')[4]).css('background-color','#EEA447');
          //$($(row).find('td')['4']).text('PENDIENTE')
        
        }
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
                res[i].cuentadefault,
              ])
              .draw()
          }
        },
      })
    }
  

 
  })
  