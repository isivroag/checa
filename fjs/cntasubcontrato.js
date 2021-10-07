
$(document).ready(function () {
    var id, opcion;
    opcion = 4;

    // SOLO NUMEROS MONTO
    document.getElementById("monto").onblur = function () {

     
        this.value = parseFloat(this.value.replace(/,/g, ""))
            .toFixed(2)
            .toString()
            .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

        // SOLO NUMEROS MONTO
        document.getElementById("montoreq").onblur = function () {

     
            this.value = parseFloat(this.value.replace(/,/g, ""))
                .toFixed(2)
                .toString()
                .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

    // SOLO NUMEROS MONTOPAGO
    document.getElementById("montopagovp").onblur = function () {

     
        this.value = parseFloat(this.value.replace(/,/g, ""))
            .toFixed(2)
            .toString()
            .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }


    // TOOLTIP DATATABLE
    $('[data-toggle="tooltip"]').tooltip();
  

    // TABLA PRINCIPAL
    tablaVis = $("#tablaV").DataTable({
        // OPCIONES
        stateSave: true,
        orderCellsTop: true,
        fixedHeader: true,
        paging: false,
        //BUTONES EXPORTAR
        dom: "<'row justify-content-center'<'col-sm-12 col-md-4 form-group'l><'col-sm-12 col-md-4 form-group'B><'col-sm-12 col-md-4 form-group'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",

        buttons: [{
            extend: "excelHtml5",
            text: "<i class='fas fa-file-excel'> Excel</i>",
            titleAttr: "Exportar a Excel",
            title: "Listado de Egresos",
            className: "btn bg-success ",
            exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9] },
        },
        {
            extend: "pdfHtml5",
            text: "<i class='far fa-file-pdf'> PDF</i>",
            titleAttr: "Exportar a PDF",
            title: "Listado de Egresos",
            className: "btn bg-danger",
            exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9] },
        },
        ],
        
        /* <button class='btn btn-sm bg-success btnPagar' data-toggle='tooltip' data-placement='top' title='Pagar'><i class='fas fa-dollar-sign'></i></button>\ */
        
        
        //COLUMNAS
        columnDefs: [{
            targets: -1,
            data: null,
            defaultContent: "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-primary btnEditar'  data-toggle='tooltip' data-placement='top' title='Editar'><i class='fas fa-edit'></i></button>\
            <button class='btn btn-sm bg-purple btnRequisicion' data-toggle='tooltip' data-placement='top' title='Requisición'><i class='fas fa-hand-holding-usd'></i></button>\
            <button class='btn btn-sm bg-info btnResumen'><i class='fas fa-bars' data-toggle='tooltip' data-placement='top' title='Ver Requisiciones'></i></button>\
            <button class='btn btn-sm bg-danger btnCancelar' data-toggle='tooltip' data-placement='top' title='Cancelar'><i class='fas fa-ban'></i></button></div></div>",
        }, { className: "hide_column", "targets": [3] },


        ],
        rowCallback: function (row, data) {
            
            // FORMATO DE CELDAS
            $($(row).find('td')['7']).addClass('text-right')
            $($(row).find('td')['8']).addClass('text-right')
            $($(row).find('td')['7']).addClass('currency')
            $($(row).find('td')['8']).addClass('currency')
        },
        
        // SUMA DE SALDO Y TOTAL PARA EL FOOTER
        footerCallback: function (row, data, start, end, display) {
            var api = this.api(), data;

            var intVal = function (i) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '') * 1 :
                    typeof i === 'number' ?
                        i : 0;
            };

            
            total = api
                .column(7)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
                saldo = api
                .column(8)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
         
            $(api.column(7).footer()).html(
                Intl.NumberFormat('es-MX',{ minimumFractionDigits: 2 }).format(parseFloat(total).toFixed(2))
            );

            $(api.column(8).footer()).html(
                Intl.NumberFormat('es-MX',{ minimumFractionDigits: 2 }).format(parseFloat(total).toFixed(2))
            );
        },

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


    //TABLA RESUMEN DE REQUISICIONES
    tablaResumen = $("#tablaResumen").DataTable({

        rowCallback: function (row, data) {
            $($(row).find('td')['4']).addClass('text-right')
            $($(row).find('td')['4']).addClass('currency')
       }, 
       columnDefs: [
            {
                targets: 4,
                render: function (data, type, full, meta) {
                    return new Intl.NumberFormat('es-MX').format(Math.round((data) * 100, 2) / 100)
                },
            },
        ],

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
        footerCallback: function (row, data, start, end, display) {
            var api = this.api(), data;

            var intVal = function (i) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '') * 1 :
                    typeof i === 'number' ?
                        i : 0;
            };

            total = api
                .column(4)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            pageTotal = api
                .column(4, { page: 'current' })
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

       
            $(api.column(4).footer()).html(
                '$ ' + new Intl.NumberFormat('es-MX').format(Math.round((pageTotal + Number.EPSILON) * 100, 2) / 100)
            );
        }
    });


    // TABLA BUSCAR OBRA

    tablaobra = $('#tablaObra').DataTable({
        columnDefs: [
            {
                targets: -1,
                data: null,
                defaultContent:
                    "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-success btnSelObra'><i class='fas fa-hand-pointer'></i></button></div></div>",
            },
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

    // TABLA BUSCAR PROVEEDOR
    tablaprov = $('#tablaProveedor').DataTable({
        columnDefs: [
            {
                targets: -1,
                data: null,
                defaultContent:
                    "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-success btnSelProveedor'><i class='fas fa-hand-pointer'></i></button></div></div>",
            },
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

    //BOTON BUSCAR OBRA
    $(document).on('click', '#bobra', function () {
        $('#modalObra').modal('show')
    })
//BOTON SELECCIONAR OBRA
    $(document).on('click', '.btnSelObra', function () {
        fila = $(this)
        id_obra = parseInt($(this).closest('tr').find('td:eq(0)').text())
        obra = $(this).closest('tr').find('td:eq(2)').text()

        $('#id_obra').val(id_obra)
        $('#obra').val(obra)
        $('#modalObra').modal('hide')
    })

//BOTON SELECCIONAR PROVEEDOR
    $(document).on('click', '.btnSelProveedor', function () {
        fila = $(this)
        id_prov = parseInt($(this).closest('tr').find('td:eq(0)').text())
        proveedor = $(this).closest('tr').find('td:eq(2)').text()

        $('#id_prov').val(id_prov)
        $('#proveedor').val(proveedor)
        $('#modalProveedor').modal('hide')
    })
//BOTON BUSCAR PROVEEDOR
    $(document).on('click', '#bproveedor', function () {
        $('#modalProveedor').modal('show')
    })
//BOTON NUEVO
    $("#btnNuevo").click(function () {

        $("#formAlta").trigger("reset");
        $("#modalAlta").modal("show");
        id = null;
        opcion = 1;
    });

    //BOTON EDITAR
    $(document).on("click", ".btnEditar", function () {
        fila = $(this).closest("tr");
        id = parseInt(fila.find('td:eq(0)').text());
       
        saldo=fila.find('td:eq(8)').text().replace(/,/g, '');
        monto=fila.find('td:eq(7)').text().replace(/,/g, '');
       
        if(parseFloat(monto)==parseFloat(saldo)){
            opcion = 2; 
            $("#modalAlta").modal("show");
        }else{
            swal.fire({
                title: "No es posible editar el Subcontrato",
                text:"El documento ya tiene operaciones posteriores",
                icon: "warning",
                focusConfirm: true,
                confirmButtonText: "Aceptar",
            }); 
        }
    });

    //BOTON GUARDAR SUBCONTRATO
    $(document).on('click', '#btnGuardar', function () {
        folio = $('#folio').val();
    
        fecha = $('#fecha').val();
        clave = $('#clave').val();
        id_obra = $('#id_obra').val();
        id_prov = $('#id_prov').val();
        tipo = 'SUBCONTRATO';
        descripcion = $('#descripcion').val();
        monto = $('#monto').val().replace(/,/g, '');

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
            $.ajax({
                url: 'bd/crudsubcontrato.php',
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
                        subcontratoguardado()
                        window.location.reload();
                    } else {
                        Swal.fire({
                            title: 'Operacion No Exitosa',
                            icon: 'warning',
                        })
                    }
                },
            })
        }
    })

    // BOTON NUEVA REQUISICION
    $(document).on("click", ".btnRequisicion", function () {
        fila = $(this).closest("tr");
        id = parseInt(fila.find('td:eq(0)').text());
        $("#formReq").trigger("reset");
        $("#modalReq").modal("show");
        $("#foliosubcontrato").val(id);  
    });

  //BOTON GUARDAR REQUISICION
  $(document).on('click', '#btnGuardarreq', function () {
    folioreq = $('#folioreq').val();
    subcontrato = $('#foliosubcontrato').val();

    fechareq = $('#fechareq').val();
    clavereq = $('#clavereq').val();
    opcionreq=1;
    descripcionreq = $('#descripcionreq').val();
    montoreq = $('#montoreq').val().replace(/,/g, '');

    if (
        fechareq.length == 0 ||
        clavereq.length == 0 ||
        descripcionreq.length == 0 ||
        montoreq.length == 0
    ) {
        Swal.fire({
            title: 'Datos Faltantes',
            text: 'Debe ingresar todos los datos Requeridos',
            icon: 'warning',
        })
        return false
    } else {
        $.ajax({
            url: 'bd/crudrequisicion.php',
            type: 'POST',
            dataType: 'json',
            data: {
                folioreq: folioreq,
                fechareq: fechareq,
                clavereq: clavereq,
                subcontrato: subcontrato,
                descripcionreq: descripcionreq,
                montoreq: montoreq,
                opcionreq: opcionreq,
            },
            success: function (data) {
                if (data == 1) {
                    Swal.fire({
                        title: 'Requisicion Guardada',
                        icon: 'success',
                    })
                    window.location.reload();
                } else {
                    Swal.fire({
                        title: 'Operacion No Exitosa',
                        icon: 'warning',
                    })
                }
            },
        })
    }
})


    $(document).on("click", ".btnCancelar", function () {
        fila = $(this).closest("tr");


        folio = parseInt(fila.find("td:eq(0)").text());

        saldo = fila.find("td:eq(9)").text();
        saldo = saldo.replace(",", "");
        saldo = parseFloat(saldo);
        total = fila.find("td:eq(8)").text()
        total = total.replace(",", "");
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
                text: "La venta tiene pagos, es necesario cancelar los pagos antes de cancelar la Venta",
                icon: "error",
                focusConfirm: true,
                confirmButtonText: "Aceptar",
            });
        }


    });

    $(document).on("click", "#btnGuardarCAN", function () {
        foliocan = $("#foliocan").val();
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
                url: "bd/cancelarcxp.php",
                async: false,
                dataType: "json",
                data: {
                    foliocan: foliocan,
                    motivo: motivo,
                    fecha: fecha,
                    usuario: usuario,
                },
                success: function (res) {
                    if (res == 1) {
                        subcontratoguardado();
                        location.reload();
                    } else {
                        subcontratoerror();
                    }
                },
            });
        }
    });

    function subcontratoguardado() {
        swal.fire({
            title: "Subcontrato Guardado",
            icon: "success",
            focusConfirm: true,
            confirmButtonText: "Aceptar",
        });
    }

    function subcontratoerror() {
        swal.fire({
            title: "Error al Guardar el Registro",
            icon: "error",
            focusConfirm: true,
            confirmButtonText: "Aceptar",
        });
    }
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
            title: "Registro Cancelado",
            icon: "warning",
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

    $("#btnBuscar").click(function () {
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
                success: function (data) {

                    for (var i = 0; i < data.length; i++) {
                        tablaVis.row
                            .add([
                                data[i].folio_cxp,
                                data[i].tipo_cxp,
                                data[i].clave_cxp,
                                data[i].corto_obra,
                                data[i].id_prov,
                                data[i].razon_prov,
                                data[i].fecha_cxp,
                                data[i].desc_cxp,
                                new Intl.NumberFormat('es-MX').format(Math.round((data[i].monto_cxp) * 100, 2) / 100),
                                new Intl.NumberFormat('es-MX').format(Math.round((data[i].saldo_cxp) * 100, 2) / 100),


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



    $(document).on("click", ".btnResumen", function () {
        fila = $(this).closest("tr");
        id = parseInt(fila.find("td:eq(0)").text());
        buscarpagos(id);
        $("#modalResumen").modal("show");
    });

    var fila; 

  


    function buscarpagos(folio) {
        tablaResumen.clear();
        tablaResumen.draw();
        opcion = 2;
        $.ajax({
            type: "POST",
            url: "bd/buscarpagocxp.php",
            dataType: "json",

            data: { folio: folio, opcion: opcion },

            success: function (res) {
                for (var i = 0; i < res.length; i++) {
                    tablaResumen.row
                        .add([
                            res[i].folio_pagocxp,
                            res[i].fact_pagocxp,
                            res[i].fecha_pagocxp,
                            res[i].referencia_pagocxp,
                            res[i].monto_pagocxp,
                            res[i].metodo_pagocxp,
                        ])
                        .draw();

            
                }
            },
        });
    }


    $(document).on('click', '.btnPagar', function () {
        fila = $(this).closest("tr");
        folio_cxc = parseInt(fila.find("td:eq(0)").text());
        tipo = fila.find("td:eq(1)").text();
        factura = fila.find("td:eq(2)").text();
        id_prov = fila.find("td:eq(4)").text();
        saldo = fila.find("td:eq(9)").text();

        $('formPago').trigger("reset");

        if (tipo == "FACTURA") {
            $('#clavevp').val(factura);
        } else {
            $('#clavevp').val('');
        }
        $('#foliovp').val(folio_cxc);
        $('#conceptovp').val('');
        $('#obsvp').val('');
        $('#saldovp').val(saldo);
        $('#montpagovp').val('');
        $('#metodovp').val('');
        $('#id_prov').val(id_prov);

        $('.modal-header').css('background-color', '#007bff');
        $('.modal-header').css('color', 'white');
        $('#modalPago').modal('show');
    })



    $(document).on('click', '#btnGuardarvp', function () {
        var foliocxp = $('#foliovp').val()
        var fechavp = $('#fechavp').val()
        var factura = $('#clavevp').val()
        var id_prov = $('#id_prov').val()
        var referenciavp = $('#referenciavp').val()
        var observacionesvp = $('#observacionesvp').val()
        var saldovp = ($('#saldovp').val())
        saldovp = saldovp.replace(",", "");
        var montovp = $('#montopagovp').val()
        montovp = montovp.replace(",", "");
        var metodovp = $('#metodovp').val()
        var usuario = $('#nameuser').val()
        var opcion = 2
        console.log(saldovp);
        console.log(montovp);


        if (
            foliocxp.length == 0 ||
            fechavp.length == 0 ||
            factura.length == 0 ||
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
                    console.log('saldo1 ' + saldovp);
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
                console.log('saldo1 ' + saldovp);
            } else {
                saldofin = saldovp - montovp;
                console.log('saldo1 ' + saldovp);
                console.log('monto ' + montovp);
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
                        factura: factura,
                        saldovp: saldovp,
                        id_prov: id_prov,
                        montovp: montovp,
                        saldofin: saldofin,
                        metodovp: metodovp,
                        usuario: usuario,
                        opcion: opcion,
                    },
                    success: function (res) {
                        console.log(res);
                        if (res == 0) {
                            Swal.fire({
                                title:
                                    'El Folio de la factura ya fue registrada para este proveedor',
                                icon: 'error',
                            })
                        } else if (res == 1) {
                            fpago = res;
                            operacionexitosa();
                            $('#modalPago').modal('hide')
                            window.location.reload();
                        } else {
                            Swal.fire({
                                title:
                                    'La operación no pudo ser registrada',
                                icon: 'error',
                            })
                        }



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
        var time = setTimeout(function () {
            startTime();
        }, 500);
    }

    function checkTime(i) {
        if (i < 10) {
            i = "0" + i;
        }
        return i;
    }

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
        return preg.test(__val__) === true
      }
});

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
    return preg.test(__val__) === true
  }