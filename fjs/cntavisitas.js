$(document).ready(function () {
    var id_concepto, opcion;
    opcion = 4;

    tablaVis = $("#tablaV").DataTable({
        keys: true,
        stateSave: true,
        "paging": true,


        "columnDefs": [{
            "targets": -1,
            "data": null,
            "defaultContent": "<div class='text-center'><button class='btn btn-sm bg-green  btnVer'><i class='fas fa-eye'></i></button>"
        },
        { className: "hide_column", "targets": [2] },
        { className: "hide_column", "targets": [4] },
       
        ],

        //Para cambiar el lenguaje a español
        "language": {
            "lengthMenu": "Mostrar _MENU_ registros",
            "zeroRecords": "No se encontraron resultados",
            "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sSearch": "Buscar:",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "sProcessing": "Procesando...",
        }



    });

    function commaSeparateNumber(val) {
        while (/(\d+)(\d{3})/.test(val.toString())) {
            val = val.toString().replace(/(\d+)(\d{3})/, '$1' + ',' + '$2');
        }
        val = '$ ' + val
        return val;
    }




    var fila; //capturar la fila para editar o borrar el registro

    //botón EDITAR    
    $(document).on("click", ".btnVer", function () {
        fila = $(this).closest("tr");
        folio = parseInt(fila.find('td:eq(0)').text());

        window.location.href = "registro.php?folio=" + folio;


    });

    $('#btnBuscar').click(function () {
        var inicio = $('#inicio').val()
        var final = $('#final').val()
     
    
        tablaVis.clear()
        tablaVis.draw()

    
        if (inicio != '' && final != '') {
          $.ajax({
            type: 'POST',
            url: 'bd/buscarregistros.php',
            dataType: 'json',
            data: { inicio: inicio, final: final},
            success: function (data) {
              for (var i = 0; i < data.length; i++) {
              
    
                tablaVis.row
                  .add([
                    data[i].folio_reg,
                    data[i].fecha_reg,
                    data[i].id_px,
                    data[i].nom,
                    data[i].id_concepto,
                    data[i].nom_concepto,
                  
                 
                  ])
                  .draw()
    
                //tabla += '<tr><td>' + res[i].id_objetivo + '</td><td>' + res[i].desc_objetivo + '</td><td class="text-center">' + icono + '</td><td class="text-center"></td></tr>';
              }
            },
          })
        } else {
            swal.fire({
                title: 'Debe Seleccionar Ambas Fechas',
                icon: 'warning',
                focusConfirm: true,
                confirmButtonText: 'Aceptar',
            })
        }
      })

    function mensajerror() {
        swal.fire({
            title: 'Pago No Registrado',
            icon: 'error',
            focusConfirm: true,
            confirmButtonText: 'Aceptar',
        })
    }

    function mensajepago() {
        swal.fire({
            title: 'Pago Guardado',
            icon: 'success',
            focusConfirm: true,
            confirmButtonText: 'Aceptar',
        })
    }

 





});