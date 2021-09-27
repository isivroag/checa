
$(document).ready(function() {
    var id, opcion;
    opcion = 4;

     //FUNCION FORMATO MONEDA 
     document.getElementById("montopagovp").onblur =function (){    

        //number-format the user input
        this.value = parseFloat(this.value.replace(/,/g, ""))
                        .toFixed(2)
                        .toString()
                        .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    
        //set the numeric value to a number input
//        document.getElementById("monto").value = this.value.replace(/,/g, "")
    
    }
// TERMINA FUNCION FORMATO MONEDA

    tablaVis = $("#tablaV").DataTable({
        dom: "<'row justify-content-center'<'col-sm-12 col-md-4 form-group'l><'col-sm-12 col-md-4 form-group'B><'col-sm-12 col-md-4 form-group'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",

        buttons: [{
                extend: "excelHtml5",
                text: "<i class='fas fa-file-excel'> Excel</i>",
                titleAttr: "Exportar a Excel",
                title: "Reporte de Venta",
                className: "btn bg-success ",
                exportOptions: { columns: [0, 1, 2, 3, 4, 5] },
            },
            {
                extend: "pdfHtml5",
                text: "<i class='far fa-file-pdf'> PDF</i>",
                titleAttr: "Exportar a PDF",
                title: "Reporte de Venta",
                className: "btn bg-danger",
                exportOptions: { columns: [0, 1, 2, 3, 4, 5] },
            },
        ],
        stateSave: true,

        columnDefs: [{
            targets: -1,
            data: null,
            defaultContent: "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-primary btnEditar'><i class='fas fa-search'></i></button>\
            <button class='btn btn-sm bg-success btnPagar'><i class='fas fa-dollar-sign'></i></button>\
            <button class='btn btn-sm bg-info btnResumen'><i class='fas fa-bars'></i></button>\
            <button class='btn btn-sm bg-danger btnCancelar'><i class='fas fa-ban'></i></button></div></div>",
        },
       
    
    ],
    rowCallback: function (row, data) {
        
        $($(row).find('td')['5']).addClass('text-right')
        $($(row).find('td')['6']).addClass('text-right')
        $($(row).find('td')['5']).addClass('currency')
        $($(row).find('td')['6']).addClass('currency')
      
      
  
       
      },
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

    tablaResumen = $("#tablaResumen").DataTable({
        
        rowCallback: function (row, data) {
        
            $($(row).find('td')['3']).addClass('text-right')
            
            $($(row).find('td')['3']).addClass('currency')
            
          
      
           
          },columnDefs: [
           
            {
              targets: 3,
              render: function (data, type, full, meta) {
                
                return   new Intl.NumberFormat('es-MX').format(Math.round((data) * 100,2) / 100) 
              },
            },
          ],
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
        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
    
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
    
            // Total over all pages
            total = api
                .column( 3 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
    
            // Total over this page
            pageTotal = api
                .column( 3, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
    
            // Update footer
            $( api.column( 3 ).footer() ).html(
                '$ '+ new Intl.NumberFormat('es-MX').format(Math.round((pageTotal + Number.EPSILON) * 100,2) / 100) 
            );
            }
    });


    $(document).on("click", ".btnCancelar", function() {
        fila = $(this).closest("tr");


        folio_venta = parseInt(fila.find("td:eq(0)").text());

        saldo = fila.find("td:eq(6)").text().replace("$", "");
        saldo = saldo.replace(",", "");
        saldo = parseFloat(saldo);
        total = fila.find("td:eq(5)").text().replace("$", "");
        total = total.replace(",", "");
        total = parseFloat(total);

        if (total == saldo) {
            $("#formcan").trigger("reset");
            /*$(".modal-header").css("background-color", "#28a745");*/
            $(".modal-header").css("color", "white");
            $("#modalcan").modal("show");
        } else {
            swal.fire({
                title: "¡No es posible cancelar la venta!",
                text: "La venta tiene pagos, es necesario cancelar los pagos antes de cancelar la Venta",
                icon: "error",
                focusConfirm: true,
                confirmButtonText: "Aceptar",
            });
        }


    });

    $(document).on("click", "#btnGuardar", function() {
        motivo = $("#motivo").val();
        fecha = $("#fecha").val();
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
                url: "bd/cancelarventa.php",
                async: false,
                dataType: "json",
                data: {
                    folio_venta: folio_venta,
                    motivo: motivo,
                    fecha: fecha,
                    usuario: usuario,
                },
                success: function(res) {
                    if (res == 1) {
                        mensaje();
                        location.reload();
                    } else {
                        mensajeerror();
                    }
                },
            });
        }
    });


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
            title: "Venta Cancelada",
            icon: "success",
            focusConfirm: true,
            confirmButtonText: "Aceptar",
        });
    }

    function mensajeerror() {
        swal.fire({
            title: "Error al Cancelar la venta",
            icon: "error",
            focusConfirm: true,
            confirmButtonText: "Aceptar",
        });
    }

    $("#btnBuscar").click(function() {
        var inicio = $("#inicio").val();
        var final = $("#final").val();
       

        tablaVis.clear();
        tablaVis.draw();

        console.log(opcion);

        if (inicio != "" && final != "") {
            $.ajax({
                type: "POST",
                url: "bd/buscarcxp.php",
                dataType: "json",
                data: { inicio: inicio, final: final, opcion: opcion },
                success: function(data) {

                    for (var i = 0; i < data.length; i++) {
                        tablaVis.row
                            .add([
                                data[i].folio_cxp,
                                data[i].corto_obra,
                                data[i].razon_prov,
                                data[i].fecha_cxp,
                                data[i].desc_cxp,
                                new Intl.NumberFormat('es-MX').format(Math.round((data[i].monto_cxp) * 100,2) / 100) ,
                                new Intl.NumberFormat('es-MX').format(Math.round((data[i].saldo_cxp) * 100,2) / 100) ,
                                

                            ])
                            .draw();

                        //tabla += '<tr><td>' + res[i].id_objetivo + '</td><td>' + res[i].desc_objetivo + '</td><td class="text-center">' + icono + '</td><td class="text-center"></td></tr>';
                    }
                },
            });
        } else {
            alert("Selecciona ambas fechas");
        }
    });

 

    $(document).on("click", ".btnResumen", function() {
        fila = $(this).closest("tr");
        id = parseInt(fila.find("td:eq(0)").text());
        buscarpagos(id);
        $("#modalResumen").modal("show");
    });

    var fila; //capturar la fila para editar o borrar el registro

    //botón EDITAR
    $(document).on("click", ".btnEditar", function() {
        fila = $(this).closest("tr");
        id = parseInt(fila.find("td:eq(0)").text());

        window.location.href = "ingresos.php?id=" + id;
    });



    function buscarpagos(folio) {
        tablaResumen.clear();
        tablaResumen.draw();
        opcion=2;
        $.ajax({
            type: "POST",
            url: "bd/buscarpagocxp.php",
            dataType: "json",

            data: { folio: folio,opcion: opcion },

            success: function(res) {
                for (var i = 0; i < res.length; i++) {
                    tablaResumen.row
                        .add([
                            res[i].folio_pagocxp,
                            res[i].fecha_pagocxp,
                            res[i].referencia_pagocxp,
                            res[i].monto_pagocxp,
                            res[i].metodo_pagocxp,
                        ])
                        .draw();

                    //tabla += '<tr><td>' + res[i].id_objetivo + '</td><td>' + res[i].desc_objetivo + '</td><td class="text-center">' + icono + '</td><td class="text-center"></td></tr>';
                }
            },
        });
    }


    $(document).on('click', '.btnPagar', function () {
        fila = $(this).closest("tr");
        folio_cxc = parseInt(fila.find("td:eq(0)").text());
        saldo = fila.find("td:eq(6)").text();
        $('formPago').trigger("reset");

        $('#foliovp').val(folio_cxc);
        $('#conceptovp').val('');
        $('#obsvp').val('');
        $('#saldovp').val(saldo);
        $('#montpagovp').val('');
        $('#metodovp').val('');
    
        $('.modal-header').css('background-color', '#007bff');
        $('.modal-header').css('color', 'white');
        $('#modalPago').modal('show');
      })

      $(document).on('click', '#btnGuardarvp', function () {
        var foliocxp = $('#foliovp').val()
        var fechavp = $('#fechavp').val()
        var referenciavp = $('#referenciavp').val()
        var observacionesvp = $('#observacionesvp').val()
        var saldovp = ($('#saldovp').val())
        saldovp=saldovp.replace(",", "");
        var montovp = $('#montopagovp').val()
        montovp=montovp.replace(",", "");
        var metodovp = $('#metodovp').val()
        var usuario = $('#nameuser').val()
        var opcion=2
        console.log(saldovp);
        console.log(montovp);
   
    
        if (
            foliocxp.length == 0 ||
            fechavp.length == 0 ||
            referenciavp.length == 0 ||
            montovp.length == 0 ||
            metodovp.length == 0 ||
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
                        foliocxp: foliocxp, opcion: opcion
                    },
                    success: function (res) {
                    saldovp = res;
                    console.log('saldo1 '+saldovp);
                    },
                })
    
            if (parseFloat(saldovp) < parseFloat(montovp)) {
                swal.fire({
                    title: 'Pago Excede el Saldo',
                    text:
                        'El pago no puede exceder el sado de la cuenta, Verifique el monto del Pago',
                    icon: 'warning',
                    focusConfirm: true,
                    confirmButtonText: 'Aceptar',
                    })
            $('#saldovp').val(saldovp)
            console.log('saldo1 '+ saldovp);
          } else {
            saldofin = saldovp - montovp;
            console.log('saldo1 '+ saldovp);
            console.log('monto '+ montovp);
            opcion = 1;
            $.ajax({
              url: 'bd/pagocxp.php',
              type: 'POST',
              dataType: 'json',
              async: false,
              data: {
                foliocxp: foliocxp,
                fechavp: fechavp,
                observacionesvp: observacionesvp,
                referenciavp: referenciavp,
                saldovp: saldovp,
                montovp: montovp,
                saldofin: saldofin,
                metodovp: metodovp,
                usuario: usuario,
                opcion: opcion,
              },
              success: function (res) {

                console.log(res);
                fpago=res;
                operacionexitosa();
                $('#modalPago').modal('hide')
                window.location.reload();
            
              },
            })
          }
        }
      })

    function startTime() {
        var today = new Date();
        var hr = today.getHours();
        var min = today.getMinutes();
        var sec = today.getSeconds();
        //Add a zero in front of numbers<10
        min = checkTime(min);
        sec = checkTime(sec);
        document.getElementById("clock").innerHTML = hr + " : " + min + " : " + sec;
        var time = setTimeout(function() {
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