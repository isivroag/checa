$(document).ready(function() {
  

    $("#btnaceptar").click(function() {
        var id_obra=$('#obra').val ();

        $.ajax({
            url: "bd/seleccionarobra.php",
            type: "POST",
            dataType: "json",
            data: {
              
              id_obra: id_obra
            },
            success: function (data) {
              if (data == 1) {
                 
                window.location.href = "inicio.php";
              }
              else {
                Swal.fire({
                  title: 'Operacion No Exitosa',
                  icon: 'warning',
                })
              }
            }
          });
       
    });

    $("#btncancelar").click(function() {

        window.location.href = "bd/logout.php";
       
    });

});