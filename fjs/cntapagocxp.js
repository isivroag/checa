
$(document).ready(function() {
    var id, opcion;
    opcion = 4;

     //FUNCION FORMATO MONEDA 


    tablaVis = $("#tablaV").DataTable({
        dom: "<'row justify-content-center'<'col-sm-12 col-md-4 form-group'l><'col-sm-12 col-md-4 form-group'B><'col-sm-12 col-md-4 form-group'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",

        buttons: [{
                extend: "excelHtml5",
                text: "<i class='fas fa-file-excel'> Excel</i>",
                titleAttr: "Exportar a Excel",
                title: "Reporte de Cuentas x Pagar",
                className: "btn bg-success ",
                exportOptions: { columns: [0, 1, 4,6,7,8,9,10] },
            },
            {
                extend: "pdfHtml5",
                text: "<i class='far fa-file-pdf'> PDF</i>",
                titleAttr: "Reporte de Cuentas x Pagar",
                title: "Listado de Egresos",
                className: "btn bg-danger",
                exportOptions: { columns: [0, 1, 4, 6,7,8,9,10] },
            },
        ],
        stateSave: true,

        columnDefs: [{
            targets: -1,
            data: null,
            defaultContent: "<div class='text-center'>\
            <button class='btn btn-sm bg-danger btnCancelar'><i class='fas fa-ban'></i></button></div></div>",
        },  { className: "hide_column", targets: [2] },
        { className: "hide_column", targets: [3] },
        { className: "hide_column", targets: [5] },
       
    
    ],
    rowCallback: function (row, data) {
        
        $($(row).find('td')['9']).addClass('text-right')
   
        $($(row).find('td')['9']).addClass('currency')
        $($(row).find('td')['10']).addClass('text-right')
   
        $($(row).find('td')['10']).addClass('currency')
  
      
      
  
       
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

 


    $(document).on("click", ".btnCancelar", function() {
        fila = $(this).closest("tr");


        folio = parseInt(fila.find("td:eq(0)").text());


            $("#formcan").trigger("reset");
            /*$(".modal-header").css("background-color", "#28a745");*/
            $(".modal-header").css("color", "white");
            $("#modalcan").modal("show");
            $("#foliocan").val(folio);
        


    });

    $(document).on("click", "#btnGuardarCAN", function() {
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
                url: "bd/cancelarpagocxp.php",
                async: false,
                dataType: "json",
                data: {
                    foliocan: foliocan,
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

 
 

 
    var fila; //capturar la fila para editar o borrar el registro

    //botón EDITAR




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