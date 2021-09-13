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
            "defaultContent": "<div class='text-center'><button class='btn btn-sm btn-primary  btnEditar'><i class='fas fa-edit'></i></button><button class='btn btn-sm btn-danger btnBorrar'><i class='fas fa-trash-alt'></i></button></div>"
        },
        { className: "hide_column", "targets": [2] },
        { className: "hide_column", "targets": [4] },
        { className: "text-right", "targets": [5] },
      /*  {
            "render": function(data, type, row) {
                return commaSeparateNumber(data);
            },
            "targets": [5]
        }*/
       
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
        
        return val;
    }



    $("#btnNuevo").click(function () {

        //window.location.href = "prospecto.php";
        $("#formDatos").trigger("reset");

        $(".modal-header").css("background-color", "#28a745");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Nuevo Concepto");
        $("#modalCRUD").modal("show");
     

        id_concepto = null;
        opcion = 1; //alta
    });

    var fila; //capturar la fila para editar o borrar el registro

    //botón EDITAR    
    $(document).on("click", ".btnEditar", function () {
        fila = $(this).closest("tr");
        id_concepto = parseInt(fila.find('td:eq(0)').text());

        //window.location.href = "actprospecto.php?id=" + id;
        concepto = fila.find('td:eq(1)').text();
        id_tipo = fila.find('td:eq(2)').text();
        tipo = fila.find('td:eq(3)').text();
        costo = fila.find('td:eq(4)').text();
        precio = fila.find('td:eq(5)').text();
        


        $("#tipo").val(id_tipo);
        $("#nombre").val(concepto);
        $("#costo").val(costo);
        $("#precio").val(precio);


        opcion = 2; //editar

        $(".modal-header").css("background-color", "#007bff");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Editar Concepto");
        $("#modalCRUD").modal("show");

    });

    //botón BORRAR
    $(document).on("click", ".btnBorrar", function () {
        fila = $(this);


        id_concepto = parseInt($(this).closest("tr").find('td:eq(0)').text());
        opcion = 3; //borrar


        //agregar codigo de sweatalert2
        var respuesta = confirm("¿Está seguro de eliminar el registro: " + id_concepto + "?");

        console.log(id_concepto);

        if (respuesta) {
            $.ajax({

                url: "bd/crudconcepto.php",
                type: "POST",
                dataType: "json",
                data: { id_concepto: id_concepto, opcion: opcion },

                success: function (data) {
                    console.log(fila);

                    tablaVis.row(fila.parents('tr')).remove().draw();
                }
            });
        }
    });

  



    $("#formDatos").submit(function (e) {
        e.preventDefault();
        var concepto = $.trim($("#nombre").val());
        var id_tipo = $.trim($("#tipo").val());
        var precio = $.trim($("#precio").val());
        var costo = $.trim($("#costo").val());
        
       






        if (concepto.length == 0) {
            Swal.fire({
                title: 'Datos Faltantes',
                text: "Debe ingresar todos los datos del Prospecto",
                icon: 'warning',
            })
            return false;
        } else {
            $.ajax({
                url: "bd/crudconcepto.php",
                type: "POST",
                dataType: "json",
                data: { concepto: concepto, precio: precio, id_tipo: id_tipo, costo: costo,  id_concepto: id_concepto, opcion: opcion },
                success: function (data) {
                    
                    id_tipo = data[0].id_t_concepto;
                    tipo = data[0].nom_t_concepto;
                   
                    id_concepto = data[0].id_concepto;
                    concepto = data[0].nom_concepto;
                    precio = data[0].precio_concepto;
                    costo = data[0].costo_concepto;
                    

                    if (opcion == 1) {
                        tablaVis.row.add([id_concepto, concepto, id_tipo, tipo, costo, precio, ]).draw();
                    } else {
                        tablaVis.row(fila).data([id_concepto, concepto, id_tipo, tipo, costo, precio, ]).draw();
                    }
                }
            });
            $("#modalCRUD").modal("hide");
        }
    });

});