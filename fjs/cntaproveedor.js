$(document).ready(function() {
    var id, opcion;
    opcion = 4;

    tablaVis = $("#tablaV").DataTable({



        "columnDefs": [{
            "targets": -1,
            "data": null,
            "defaultContent": "<div class='text-center'><button class='btn btn-sm btn-primary  btnEditar'><i class='fas fa-edit'></i></button><button class='btn btn-sm btn-danger btnBorrar'><i class='fas fa-trash-alt'></i></button></div>"
        },{ className: "hide_column", targets: [3] },],

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

    $("#btnNuevo").click(function() {

        //window.location.href = "prospecto.php";
        $("#formDatos").trigger("reset");
        $(".modal-header").css("background-color", "#28a745");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("NUEVO PROVEEDOR");
        $("#modalCRUD").modal("show");
        id = null;
        opcion = 1; //alta
    });

    var fila; //capturar la fila para editar o borrar el registro

    //botón EDITAR    
    $(document).on("click", ".btnEditar", function() {
        fila = $(this).closest("tr");
        id = parseInt(fila.find('td:eq(0)').text());

        rfc = fila.find('td:eq(1)').text();
        razon = fila.find('td:eq(2)').text();
        dir = fila.find('td:eq(3)').text();
        tel = fila.find('td:eq(4)').text();
        contacto = fila.find('td:eq(5)').text();
        tel_contacto = fila.find('td:eq(6)').text();

        $("#rfc").val(rfc);
        $("#razon").val(razon);
        $("#dir").val(dir);
        $("#tel").val(tel);
        $("#contacto").val(contacto);
        $("#tel_contacto").val(tel_contacto);
        opcion = 2; //editar

        $(".modal-header").css("background-color", "#007bff");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("EDITAR PROVEEDOR");
        $("#modalCRUD").modal("show");

    });

    //botón BORRAR
    $(document).on("click", ".btnBorrar", function() {
        fila = $(this);

        id = parseInt($(this).closest("tr").find('td:eq(0)').text());
        opcion = 3 //borrar

        //agregar codigo de sweatalert2
        var respuesta = confirm("¿Está seguro de eliminar el registro: " + id + "?");



        if (respuesta) {
            $.ajax({

                url: "bd/crudproveedor.php",
                type: "POST",
                dataType: "json",
                data: { id: id, opcion: opcion },

                success: function(data) {
                    console.log(fila);

                    tablaVis.row(fila.parents('tr')).remove().draw();
                }
            });
        }
    });



    $("#formDatos").submit(function(e) {
        e.preventDefault();
        var razon = $.trim($("#razon").val());
        var dir = $.trim($("#dir").val());
        var tel = $.trim($("#tel").val());
        var rfc = $.trim($("#rfc").val());
        var contacto = $.trim($("#contacto").val());
        var tel_contacto = $.trim($("#tel_contacto").val());
    
     

        if (razon.length == 0  || rfc.length == 0 ) {
            Swal.fire({
                title: 'Datos Faltantes',
                text: "Debe ingresar todos los datos del Prospecto",
                icon: 'warning',
            })
            return false;
        } else {
            $.ajax({
                url: "bd/crudproveedor.php",
                type: "POST",
                dataType: "json",
                data: { razon: razon,  tel: tel, rfc: rfc, dir: dir, 
                    id: id, contacto: contacto, tel_contacto: tel_contacto, opcion: opcion },
                success: function(data) {
                
                    id = data[0].id_prov;
                    rfc = data[0].rfc_prov;
                    razon = data[0].razon_prov;
                    tel = data[0].tel_prov;
                    dir = data[0].dir_prov;
                    contacto = data[0].contacto_prov;
                    tel_contacto = data[0].telcon_prov;
                    if (opcion == 1) {
                        tablaVis.row.add([id, rfc,razon, dir, tel,contacto,tel_contacto,]).draw();
                    } else {
                        tablaVis.row(fila).data([id, rfc,razon, dir, tel,contacto,tel_contacto,]).draw();
                    }
                }
            });
            $("#modalCRUD").modal("hide");
        }
    });

});