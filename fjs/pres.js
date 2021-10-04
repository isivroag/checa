$(document).ready(function () {
    const MAXIMO_TAMANIO_BYTES = 12000000;


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
            $("#tabla").html(response)        },
      })
    }

    return false
  })
})
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