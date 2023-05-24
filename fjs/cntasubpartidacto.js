$(document).ready(function () {
    var id, opcion;
    opcion = 4;

    tablaVis = $("#tablaV").DataTable({
        keys: true,
        stateSave: true,
        "paging": true,


        "columnDefs": [{
            "targets": -1,
            "data": null,
            "defaultContent": "<div class='text-center'><button class='btn btn-sm btn-primary  btnEditar'><i class='fas fa-edit'></i></button>\
            <button class='btn btn-sm btn-danger btnBorrar'><i class='fas fa-trash-alt'></i></button></div>"
        },
       
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

        $("#modalCRUD").modal("show");
     

      
        opcion = 1; //alta
    });

    var fila; //capturar la fila para editar o borrar el registro

    //botón EDITAR    
    $(document).on("click", ".btnEditar", function () {
        fila = $(this).closest("tr");
        id = parseInt(fila.find('td:eq(0)').text());

        //window.location.href = "actprospecto.php?id=" + id;
        partida = fila.find('td:eq(1)').text();
        id_sub = fila.find('td:eq(2)').text();
        


        $("#id").val(id);
        $("#nombre").val(partida);
        $("#partida").val(id_sub)


        opcion = 2; //editar

        $(".modal-header").css("background-color", "#007bff");

        $("#modalCRUD").modal("show");

    });
    //botón EDITAR    


    

    //botón BORRAR
    $(document).on("click", ".btnBorrar", function () {
        fila = $(this);


        ud = parseInt($(this).closest("tr").find('td:eq(0)').text());
        opcion = 3; //borrar


        swal.fire({
            title: 'ELIMINAR',
            text: '¿Desea eliminar el registro seleccionado?',
            showCancelButton: true,
            icon: 'question',
            focusConfirm: true,
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#28B463',
            cancelButtonColor: '#d33',
        })
            .then(function (isConfirm) {
                if (isConfirm.value) {
                    $.ajax({

                        url: "bd/crudpartidacto.php",
                        type: "POST",
                        dataType: "json",
                        data: { id: id, opcion: opcion },
        
                        success: function (data) {
                       
        
                            tablaVis.row(fila.parents('tr')).remove().draw();
                        }
                    });
                } else if (isConfirm.dismiss === swal.DismissReason.cancel) {
                }
            })

    
    });

  



    $("#formDatos").submit(function (e) {
        e.preventDefault();
        var nombre = $.trim($("#nombre").val());
        var id = $.trim($("#id").val());
        var id_partidacto = $("#partida").val();
        
       


        console.log(id_partidacto)



        if (nombre.length == 0 || id_partidacto==0) {
            Swal.fire({
                title: 'Datos Faltantes',
                text: "Debe ingresar todos los datos del Prospecto",
                icon: 'warning',
            })
            return false;
        } else {
            $.ajax({
                url: "bd/crudsubpartidacto.php",
                type: "POST",
                dataType: "json",
                data: { nombre: nombre,  id: id, opcion: opcion,id_partidacto: id_partidacto },
                success: function (data) {
                    
                    id = data[0].id_subpartidacto;
                    subpartida = data[0].nom_subpartidacto;
                    id_partida = data[0].id_partidacto;
                    nom_partida = data[0].nom_partidacto;
                    

                    if (opcion == 1) {
                        tablaVis.row.add([id,subpartida,id_partida,nom_partida, ]).draw();
                    } else {
                        tablaVis.row(fila).data([id, subpartida,id_partida,nom_partida, ]).draw();
                    }
                }
            });
            $("#modalCRUD").modal("hide");
        }
    });

});