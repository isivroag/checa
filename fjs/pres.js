$(document).ready(function () {
    const MAXIMO_TAMANIO_BYTES = 12000000;

    jQuery.ajaxSetup({
      beforeSend: function() {
          $("#div_carga").show();
      },
      complete: function() {
          $("#div_carga").hide();
      },
      success: function() {},
  });



  tablaObra = $('#tablaObra').DataTable({
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

  tabla = $('#tabla').DataTable({

    "paging": false,
    "ordening":false,
    "order": [[ 1, "asc" ]],
    columnDefs: [
      
      //{ className: "hide_column", "targets": [4] },
      //{ className: "hide_column", "targets": [5] },
      { "sWidth": "70%", "aTargets": [ 3 ] }
      
      

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
    rowCallback: function (row, data) {

           

      $($(row).find('td')[5]).addClass("text-right")
      $($(row).find('td')[6]).addClass("text-right")
      $($(row).find('td')[7]).addClass("text-right")
      if (data[8] == "A") {
        $('td', row).css('background-color', '#D1D1D1');
        $('td', row).css('font-weight', 'bold');
        //$($(row).find('td')).addClass('bg-gradient-secondary')  
      }else if(data[8]=="B"){
          $('td', row).css('background-color', '#A4C9E7');
      
      }else if (data[8]=="C"){
        $('td', row).css('background-color', '#EE936E');
      }else if (data[8]=="CO"){
        $('td', row).css('background-color', '#FEFEFE');
      }
      

      

  },

  })



  $('#archivo').on('change', function () {
    var ext = $(this).val().split('.').pop()
    var fileName = $(this).val().split('\\').pop()
    if ($(this).val() != '') {
      if (ext == 'xls' || ext == 'xlsx' || ext == 'csv') {
        $(this)
          .siblings('.custom-file-label')
          .addClass('selected')
          .html(fileName)
      } else {
        $(this).val('')
        Swal.fire(
          'Mensaje De Error',
          'Extensión no permitida: ' + ext + '',
          'error',
        )
      }
    }
  })

  $(document).on('click', '#upload', function () {
    id_obra = $('#id_obra').val()
    var formData = new FormData()
    var files = $('#archivo')[0].files[0]

    if (files.size > MAXIMO_TAMANIO_BYTES) {
      const tamanioEnMb = MAXIMO_TAMANIO_BYTES / 1000000

      Swal.fire({
        title: 'El tamaño del archivo es muy grande',
        text: 'El archivo no puede exceder los ' + tamanioEnMb + 'MB',
        icon: 'warning',
      })
      // Limpiar
      $('#archivo').val()
    } else {
      formData.append('file', files)
      formData.append('id_obra', id_obra)
      $.ajax({
        url: 'bd/subirpresupuesto.php',
        type: 'post',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
           if (response==1){
           
              buscarpresupuesto(id_obra);
            
          }       
          else{
           mensajeerror();
          }

                },
      })
    }

    return false
  })

  function mensajeerror() {
    swal.fire({
        title: "Error al Subir Presupuesto",
        icon: "error",
        focusConfirm: true,
        confirmButtonText: "Aceptar",
    });
}

  
  $(document).on('click', '#bobra', function () {
    $('#modalObra').modal('show')
  })


  $('#id_obra').on('change', function (){
  
   id_obra=$('#id_obra').val();
   alert(id_obra);
    buscarpresupuesto(id_obra);
  })

  //botón BORRAR
  $(document).on('click', '.btnSelObra', function () {
      fila = $(this);
      id_obra = parseInt($(this).closest('tr').find('td:eq(0)').text());
      obra = $(this).closest('tr').find('td:eq(2)').text();
      
      $('#id_obra').val(id_obra);
      $('#obra').val(obra);
      $('#modalObra').modal('hide');
      buscarpresupuesto(id_obra);
  })


})

function buscarpresupuesto(obra){
  tabla.clear();
  tabla.draw();




      $.ajax({
          type: "POST",
          url: "bd/buscarpres.php",
          dataType: "json",
          data: { obra: obra },
          success: function(data) {

              for (var i = 0; i < data.length; i++) {
                  tabla.row
                      .add([
                          data[i].id_renglon,
                          data[i].indice_renglon,
                          data[i].clave_renglon,
                          data[i].concepto_renglon,
                          data[i].unidad_renglon,
                          Intl.NumberFormat('es-MX',{ minimumFractionDigits: 2 }).format(parseFloat(data[i].cantidad_renglon).toFixed(2)),
                          Intl.NumberFormat('es-MX',{ minimumFractionDigits: 2 }).format(parseFloat(data[i].precion_renglon).toFixed(2)),
                          Intl.NumberFormat('es-MX',{ minimumFractionDigits: 2 }).format(parseFloat(data[i].monto_renglon).toFixed(2)),
                          //new Intl.NumberFormat('es-MX').format(Math.round((data[i].monto_renglon) * 100,2) / 100) ,
                          data[i].tipo_renglon,
                          data[i].padre_renglon,
                         

                      ])
                      .draw();

                  //tabla += '<tr><td>' + res[i].id_objetivo + '</td><td>' + res[i].desc_objetivo + '</td><td class="text-center">' + icono + '</td><td class="text-center"></td></tr>';
              }
          },
      });
}
/*
  if (response != 0) {
            Swal.fire({
              title: 'Imagen Guardada',
              text: 'Se anexo el documento a la Requisición',
              icon: 'success',
            })
          
          } else {
            //swal incorrecto
            Swal.fire({
              title: 'No fue posible procesar el Archivo',
              text: 'Verifique que el archivo tenga el formato adecuado ',
              icon: 'warning',
            })
          }
*/