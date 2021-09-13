$(document).ready(function () {
    var id, opcion;
    opcion = 4;

    tablaVis = $("#tablaV").DataTable({



        "columnDefs": [{
            "targets": -1,
            "data": null,
            "defaultContent": "<div class='text-center'><button class='btn btn-sm btn-primary  btnEditar'><i class='fas fa-edit'></i></button>\
            <button class='btn btn-sm btn-danger btnBorrar'><i class='fas fa-trash-alt'></i></button></div>"
        }, 
        { className: "hide_column", targets: [3] },
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

    $("#btnNuevo").click(function () {

        //window.location.href = "prospecto.php";
        $("#formDatos").trigger("reset");

        $(".modal-title").text("NUEVO CLIENTE");
        $("#modalCRUD").modal("show");
        id = null;
        opcion = 1; //alta
    });

    var fila; //capturar la fila para editar o borrar el registro

    //botón EDITAR    
    $(document).on("click", ".btnEditar", function () {
        fila = $(this).closest("tr");
        id = parseInt(fila.find('td:eq(0)').text());

        //window.location.href = "actprospecto.php?id=" + id;
        rfc = fila.find('td:eq(1)').text();
        razon = fila.find('td:eq(2)').text();
        dir = fila.find('td:eq(3)').text();
        tel = fila.find('td:eq(4)').text();
       

        $("#razon").val(razon);
     
        $("#rfc").val(rfc);
       
        $("#dir").val(dir);
      
        $("#tel").val(tel);
      
        opcion = 2; //editar


        $(".modal-title").text("EDITAR CLIENTE");
        $("#modalCRUD").modal("show");

    });

    //botón BORRAR
    $(document).on("click", ".btnBorrar", function () {
        fila = $(this);

        id = parseInt($(this).closest("tr").find('td:eq(0)').text());
        opcion = 3 //borrar

        //agregar codigo de sweatalert2
        var respuesta = confirm("¿Está seguro de eliminar el registro: " + id + "?");



        if (respuesta) {
            $.ajax({

                url: "bd/crudcliente.php",
                type: "POST",
                dataType: "json",
                data: { id: id, opcion: opcion },

                success: function (data) {
                    console.log(fila);

                    tablaVis.row(fila.parents('tr')).remove().draw();
                }
            });
        }
    });



    $("#formDatos").submit(function (e) {
        e.preventDefault();
       
        razon =  $("#razon").val();;
      
        rfc =   $("#rfc").val();
        dir =     $("#dir").val();
        tel = $("#tel").val();
       

      

        if (razon.length == 0 || rfc.length == 0  ) {
            Swal.fire({
                title: 'Datos Faltantes',
                text: "Debe ingresar todos los datos del Requeridos",
                icon: 'warning',
            })
            return false;
        } else {
            $.ajax({
                url: "bd/crudcliente.php",
                type: "POST",
                dataType: "json",
                data: { razon: razon, 
                     rfc: rfc, dir: dir, tel: tel,
                      id: id, opcion: opcion },
                success: function (data) {
                   
                    id = data[0].id_clie;
                    rfc = data[0].rfc_clie;
                    razon = data[0].razon_clie;
                  
                    dir = data[0].dir_clie;
                    tel = data[0].tel_clie;
                    
                    if (opcion == 1) {
                        tablaVis.row.add([id, rfc, razon, dir, tel,]).draw();
                    } else {
                        tablaVis.row(fila).data([id, rfc, razon, dir, tel,]).draw();
                    }
                }
            });
            $("#modalCRUD").modal("hide");
        }
    });

});