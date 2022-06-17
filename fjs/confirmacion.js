$(document).ready(function () {
    var id, opcion;
    opcion = 4;

    tablaVis = $("#tablaV").DataTable({

        "paging": false,
        "order": [[ 5, "asc" ]],

        "columnDefs": [{
            "targets": -1,
            "data": null,
            "defaultContent": "<div class='text-center'><button class='btn btn-sm btn-success  btnAceptar'><i class='fas fa-phone'></i></button>\
            <button class='btn btn-sm btn-danger btnNoConfirmar'><i class='fas fa-phone-slash'></i></button>\
            <button class='btn btn-sm btn-danger btnCancelar'><i class='fas fa-ban'></i></button>"
        }, { className: "hide_column", "targets": [1] },
        { className: "hide_column", "targets": [7] },
        { className: "hide_column", "targets": [8] },
        { className: "text-center", "targets": [9] },
        { className: "text-center", "targets": [2] }

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
        },
        rowCallback: function (row, data) {

           

            //estado de la cita
            if (data[8] == 1) {
                icono = '<i class="fas fa-hospital-user text-info fa-2x text-center"></i>';
                $($(row).find('td')[8]).html(icono)
                //$($(row).find('td')[3]).css('background-color', '#77BCF5');
            }
            else if (data[8] == 2){
                icono = '<i class="fas fa-user-check text-success fa-2x text-center"></i>';
                $($(row).find('td')[8]).html(icono)
                //$($(row).find('td')[3]).css('background-color', '#A6EBC5');
            }else if (data[8] == 3){
                icono = '<i class="fas fa-user-slash text-danger fa-2x text-center"></i>';
                $($(row).find('td')[8]).html(icono)
                //$($(row).find('td')[3]).css('background-color', '#A6EBC5');
            }else if (data[8]==4){
                icono = '<i class="fas fa-ban text-danger fa-2x text-center"></i>';
                $($(row).find('td')[8]).html(icono)
            }else{
                icono = '<i class="fas fa-user-clock text-warning fa-2x text-center"></i>';
                $($(row).find('td')[8]).html(icono)
            }

            $($(row).find('td')[6]).css('background-color', data[7]);
            if (data[2] == 1) {
                icono = '<i class="fas fa-user-injured text-success fa-2x text-center"></i>';
                //$($(row).find("td")[6]).css("background-color", "warning");
                //$($(row).find('td')[2]).addClass('bg-gradient-secondary')
                $($(row).find('td')['2']).html(icono)
            } else if (data[2] == 0) {
                icono = '<i class="fas fa-user-injured text-secondary fa-2x text-center"></i>';
                //$($(row).find("td")[2]).css("background-color", "blue");
                //$($(row).find('td')[2]).addClass('bg-gradient-green')
                $($(row).find('td')['2']).html(icono)
            }

            if (data[9] == 1) {
                icono = '<i class="fas fa-phone text-success fa-2x text-center"></i>';
                $($(row).find('td')[9]).html(icono)
                //$($(row).find('td')[3]).css('background-color', '#77BCF5');
            }
            else if (data[9]==2){
                icono = '<i class="fas fa-phone-slash text-danger fa-2x text-center"></i>';
                $($(row).find('td')[9]).html(icono)
                //$($(row).find('td')[3]).css('background-color', '#A6EBC5');
            } else if (data[9]==3) {
                icono = '<i class="fas fa-ban text-danger fa-2x text-center"></i>';
                $($(row).find('td')[9]).html(icono)

            }else{
                icono = '<i class="fas fa-phone-alt text-secondary fa-2x text-center"></i>';
                $($(row).find('td')[9]).html(icono)
            }
        },


    });


    $(document).on("click", ".btnAceptar", function () {
        fila = $(this);

        id = parseInt($(this).closest("tr").find('td:eq(0)').text());
        opcion = 6;



        $.ajax({

            url: "bd/buscarcita.php",
            type: "POST",
            dataType: "json",
            async: "false",
            data: { id: id, opcion: opcion },

            success: function (data) {
                Swal.fire({
                    title: "Cita Confirmada",
                    text: "Paciente Confirmó su Cita",
                    icon: "success",
                    timer:1000,
                });

               

                buscar();
               // window.setTimeout(function() {
               //     window.location.href = "confirmacion.php";
               // }, 1500);
            }
        });
    });


    $(document).on("click", ".btnNoConfirmar", function () {
        fila = $(this);
        opcion=7;
        id = parseInt($(this).closest("tr").find('td:eq(0)').text());
        $.ajax({

            url: "bd/buscarcita.php",
            type: "POST",
            dataType: "json",
            async: "false",
            data: { id: id, opcion: opcion },

            success: function (data) {
                Swal.fire({
                    title: "Paciente No Confirmó la cita",
                    text: "Cita Suspendida",
                    icon: "warning",
                    timer:1000,
                });


                buscar();
               
               // window.setTimeout(function() {
               //     window.location.href = "confirmacion.php";
               // }, 1500);
            }
        });
    });


    function buscar(){
        fechad =   $("#fechad").val();
        tablaVis.clear();
        tablaVis.draw();


        $.ajax({

            url: "bd/buscarcalendario.php",
            type: "POST",
            dataType: "json",
            async: "false",
            data: { fechad: fechad },

            success: function (data) {
                for (var i = 0; i < data.length; i++) {
                  
                    tablaVis.row
                        .add([
                            data[i].id,
                            data[i].id_pros,
                            data[i].tipo_p,
                            data[i].title,
                            data[i].descripcion,
                            data[i].hora,
                            data[i].nombre,
                            data[i].color,
                            data[i].estado,
                            data[i].confirmar,
                        ])
                        .draw()
                }
               
            }
        });
    }

    $(document).on("click", "#btnBuscar", function () {
        buscar()
      
    });

    $(document).on("click", ".btnCancelar", function () {
        fila = $(this);
        opcion=4;
        id = parseInt($(this).closest("tr").find('td:eq(0)').text());
        $("#formcan").trigger("reset");
        /*$(".modal-header").css("background-color", "#28a745");*/
        $(".modal-header").css("color", "white");
        $("#modalcan").modal("show");
        $("#foliocan").val(id);
    });
   

    $(document).on("click", "#btnGuardarc", function() {
        motivo = $("#motivo").val();
        id = $("#foliocan").val();
        fecha = $("#fechac").val();
        usuario = $("#nameuser").val();
        $("#modalcan").modal("hide");
        opcion=4;
        console.log(id);
        console.log(motivo);
        console.log(fecha);
        console.log(usuario);

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
                url: "bd/buscarcita.php",
                async: false,
                dataType: "json",
                data: {
                    id: id, opcion: opcion,
                    motivo: motivo,
                    fecha: fecha,
                    usuario: usuario,
                },
                success: function(data) {
                    if (data[0].id == id) {
                        mensaje();
                        window.setTimeout(function() {
                           buscar();
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
            timer: 2000
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



});