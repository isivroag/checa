$(document).ready(function () {
    var id_concepto, opcion;
    opcion = 4;

    tablaVis = $("#tablaV").DataTable({
        keys: true,
        stateSave: true,
        "paging": false,
/* buton editar */
/*<button class='btn btn-sm btn-primary  btnEditar'><i class='fas fa-edit'></i></button> */
        "columnDefs": [{
            "targets": -1,
            "data": null,
            "defaultContent": "<div class='text-center'>\
            <button class='btn btn-sm btn-success btnPagar'><i class='fas fa-dollar-sign'> </i></button>\
            <button class='btn btn-sm btn-info btnResumen'><i class='fas fa-search-dollar'></i></button>\
            <button class='btn btn-sm btn-danger btnCancelar'><i class='fas fa-ban'></i></button></div>"
        },
        { className: "hide_column", "targets": [2] },
        { className: "hide_column", "targets": [4] },
        {
            "render": function (data, type, row) {
                return commaSeparateNumber(data);
            },
            "targets": [6]
        },
        {
            "render": function (data, type, row) {
                return commaSeparateNumber(data);
            },
            "targets": [7]
        }

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

    tablaResumen = $("#tablaResumen").DataTable({
        //Para cambiar el lenguaje a español
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


    $(document).on("click", ".btnCancelar", function() {
        fila = $(this).closest("tr");


        folio = parseInt(fila.find("td:eq(0)").text());

        saldo = fila.find("td:eq(7)").text().replace("$", "");
       
        saldo = saldo.replace(",", "");
        saldo = parseFloat(saldo);
        console.log(saldo);
        total = fila.find("td:eq(6)").text().replace("$", "");
        total = total.replace(",", "");
        console.log(total);
        total = parseFloat(total);

        if (total == saldo) {
            $("#formcan").trigger("reset");
            /*$(".modal-header").css("background-color", "#28a745");*/
            $(".modal-header").css("color", "white");
            $("#modalcan").modal("show");
            $("#foliocan").val(folio);
        } else {
            swal.fire({
                title: "¡No es posible cancelar la venta!",
                text: "El Registro tiene pagos, es necesario cancelar los pagos antes de cancelar la Venta",
                icon: "error",
                focusConfirm: true,
                confirmButtonText: "Aceptar",
            });
        }


    });

    $(document).on("click", "#btnGuardarc", function() {
        motivo = $("#motivo").val();
        folio = $("#foliocan").val();
        fecha = $("#fechac").val();
        usuario = $("#nameuser").val();
        $("#modalcan").modal("hide");
       


        if (motivo === "") {
            swal.fire({
                title: "Datos Incompletos",
                text: "Verifique sus datos",
                icon: "warning",
                focusConfirm: true,
                confirmButtonText: "Aceptar",
            });
        } else {
            $.ajax({
                type: "POST",
                url: "bd/cancelarregistro.php",
                async: false,
                dataType: "json",
                data: {
                    folio: folio,
                    motivo: motivo,
                    fecha: fecha,
                    usuario: usuario,
                },
                success: function(res) {
                    if (res == 1) {
                        mensaje();
                        window.setTimeout(function() {
                            window.location.reload();
                        }, 1500);
                    } else {
                        mensajeerror();
                    }
                },
            });
        }
    });

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

    function commaSeparateNumber(val) {
        while (/(\d+)(\d{3})/.test(val.toString())) {
            val = val.toString().replace(/(\d+)(\d{3})/, '$1' + ',' + '$2');
        }
        val = '$ ' + val
        return val;
    }



    $("#btnNuevo").click(function () {

        window.location.href = "registro.php";

    });

    var fila; //capturar la fila para editar o borrar el registro

    //botón EDITAR    
    $(document).on("click", ".btnEditar", function () {
        fila = $(this).closest("tr");
        folio = parseInt(fila.find('td:eq(0)').text());

        window.location.href = "registro.php?folio=" + folio;


    });


  


    $(document).on('click', '.btnPagar', function () {
        fila = $(this);

        folio = parseInt($(this).closest('tr').find('td:eq(0)').text());

        saldo = $(this).closest('tr').find('td:eq(7)').text();

        saldo = saldo.replace('$', '');
        saldo = saldo.replace(',', '');
        saldo = parseFloat(saldo);

        $('#foliop').val(folio);

        $('#obsp').val('');
        $('#saldop').val(saldo);
        $('#montp').val('');
        $('#metodo').val('');

        $('.modal-header').css('background-color', '#007bff');
        $('.modal-header').css('color', 'white');
        $('#modalPago').modal('show');


    })



    $(document).on('click', '#btnGuardarvp', function () {
        folio = $('#foliop').val()
        var fechap = $('#fechap').val()
        var conceptop = $('#conceptop').val()
        var obsp = $('#obsp').val()
        var saldop = parseFloat($('#saldop').val())
        var montop = $('#montop').val()
        var metodo = $('#metodo').val()
        var usuario = $('#nameuser').val()


        if (
            folio.length == 0 ||
            fechap.length == 0 ||
            conceptop.length == 0 ||
            montop.length == 0 ||
            metodo.length == 0 ||
            usuario.length == 0
        ) {
            swal.fire({
                title: 'Datos Incompletos',
                text: 'Verifique sus datos',
                icon: 'warning',
                focusConfirm: true,
                confirmButtonText: 'Aceptar',
            })
        } else {
            $.ajax({
                url: 'bd/buscarsaldo.php',
                type: 'POST',
                dataType: 'json',
                async: false,
                data: {
                    folio: folio,
                },
                success: function (res) {
                    saldop = res;

                },
            })
           
            if (parseFloat(saldop) < parseFloat(montop)) {
                swal.fire({
                    title: 'Pago Excede el Saldo',
                    text:
                        'El pago no puede exceder el sado de la cuenta, Verifique el monto del Pago',
                    icon: 'warning',
                    focusConfirm: true,
                    confirmButtonText: 'Aceptar',
                })
                $('#saldop').val(saldop)

            } else {

                $.ajax({
                    url: 'bd/pago.php',
                    type: 'POST',
                    dataType: 'json',
                    async: false,
                    data: {
                        folio: folio,
                        fechap: fechap,
                        obsp: obsp,
                        conceptop: conceptop,
                        saldop: saldop,
                        montop: montop,
                        metodo: metodo,
                        usuario: usuario,
                    },
                    success: function (res) {
                        console.log(res);
                        if (res != 0) {

                            mensajepago();
                            $('#modalPago').modal('hide');
                            window.setTimeout(function() {
                                window.location.reload();
                            }, 1500);
                            

                        } else {
                            mensajerror()

                        }



                    },
                })
            }
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

    $(document).on("click", ".btnResumen", function () {
        fila = $(this).closest("tr");
        id = parseInt(fila.find("td:eq(0)").text());
        buscarpagos(id);
        $("#modalResumen").modal("show");


        
    });

    function buscarpagos(folio) {
        tablaResumen.clear();
        tablaResumen.draw();

        $.ajax({
            type: "POST",
            url: "bd/buscarpagocxp.php",
            dataType: "json",

            data: { folio: folio },

            success: function (res) {
                for (var i = 0; i < res.length; i++) {
                    tablaResumen.row
                        .add([
                            res[i].folio_pago,
                            res[i].fecha,
                            res[i].concepto,
                            res[i].monto,
                            res[i].metodo
                        ])
                        .draw();

                    //tabla += '<tr><td>' + res[i].id_objetivo + '</td><td>' + res[i].desc_objetivo + '</td><td class="text-center">' + icono + '</td><td class="text-center"></td></tr>';
                }
            },
        });
    }





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
                    data[i].total_reg,
                    data[i].saldo_reg,
                  
                 
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



});