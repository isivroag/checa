$(document).ready(function () {
    var id_concepto, opcion
    opcion = 4

   //FUNCION FORMATO MONEDA 
    document.getElementById("monto").onblur =function (){    

        //number-format the user input
        this.value = parseFloat(this.value.replace(/,/g, ""))
                        .toFixed(2)
                        .toString()
                        .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    
        //set the numeric value to a number input
//        document.getElementById("monto").value = this.value.replace(/,/g, "")
    
    }
// TERMINA FUNCION FORMATO MONEDA
    tablaclie = $('#tablaEmpresa').DataTable({
      columnDefs: [
        {
          targets: -1,
          data: null,
          defaultContent:
            "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-success btnSelEmp'><i class='fas fa-hand-pointer'></i></button></div></div>",
        },
       
  
  
      ],
  
      //Para cambiar el lenguaje a español
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
  
    tablaemp = $('#tablacliente').DataTable({
      columnDefs: [
        {
          targets: -1,
          data: null,
          defaultContent:
            "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-success btnSelCliente'><i class='fas fa-hand-pointer'></i></button></div></div>",
        },
      ],
  
      //Para cambiar el lenguaje a español
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
  
    function commaSeparateNumber(val) {
      while (/(\d+)(\d{3})/.test(val.toString())) {
        val = val.toString().replace(/(\d+)(\d{3})/, '$1' + ',' + '$2')
      }
  
      return val
    }
  

  
    var fila //capturar la fila para editar o borrar el registro
  
    //botón EDITAR
    $(document).on('click', '#btnGuardar', function () {
        folio = $("#folio").val();
        fecha = $("#fecha").val();
        clave = $("#clave").val();
        id_emp = $("#id_emp").val();
        id_clie = $("#id_clie").val();
        corto = $("#corto").val();
        largo = $("#largo").val();
        monto = $("#monto").val().replace(/,/g, "");
        duracion =$("#duracion").val();
       
        



  
      if ( fecha.length == 0 || corto.length == 0 ||  monto.length == 0 ||  id_emp.length == 0 ||  id_clie.length == 0) {
        Swal.fire({
          title: 'Datos Faltantes',
          text: "Debe ingresar todos los datos Requeridos",
          icon: 'warning',
        })
        return false;
      } else {
  
        if (folio == 0) {
          opcion = 1;
          $.ajax({
            url: "bd/crudobra.php",
            type: "POST",
            dataType: "json",
            data: {
              folio: folio, fecha: fecha,clave: clave,
              id_emp: id_emp, id_clie: id_clie,
              corto: corto, largo: largo, monto: monto,
              duracion: duracion,
              opcion: opcion
            },
            success: function (data) {
              if (data == 1) {
                  mensaje();
                window.location.href = 'cntaobra.php'
              }
              else {
                Swal.fire({
                  title: 'Operacion No Exitosa',
                  icon: 'warning',
                })
              }
            }
          });
        } else {
  
          opcion = 2;
          $.ajax({
            url: "bd/crudobra.php",
            type: "POST",
            dataType: "json",
            data: {
                folio: folio, fecha: fecha,clave: clave,
                id_emp: id_emp, id_clie: id_clie,
                corto: corto, largo: largo, monto: monto,
                duracion: duracion,
                opcion: opcion
            },
            success: function (data) {
              if (data == 1) {
                  mensaje();
                window.location.href = 'cntaobra.php'
              }
              else {
                Swal.fire({
                  title: 'Operacion No Exitosa',
                  icon: 'warning',
                })
              }
            }
          });
  
        }
  
  
      }
    });
  
  
  
  
    $(document).on('click', '#bempresa', function () {
      $('#modalEmpresa').modal('show')
    })
  
    $(document).on('click', '#bcliente', function () {
      $('#modalCliente').modal('show')
    })
  
    //botón BORRAR
    $(document).on('click', '.btnSelEmp', function () {
        fila = $(this)
        id_emp = parseInt($(this).closest('tr').find('td:eq(0)').text())
        empresa = $(this).closest('tr').find('td:eq(2)').text()
        
        $('#id_emp').val(id_emp)
        $('#empresa').val(empresa)
        $('#modalEmpresa').modal('hide')
    })
  
    $(document).on('click', '.btnSelCliente', function () {
        fila = $(this)
        id_clie = parseInt($(this).closest('tr').find('td:eq(0)').text())
        cliente = $(this).closest('tr').find('td:eq(2)').text()
        $('#id_clie').val(id_clie)
        $('#cliente').val(cliente)
        $('#modalCliente').modal('hide')
    })
  
  
    function mensaje() {
        swal.fire({
            title: "Operación Exitosa",
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

 
  
    function round(value, decimals) {
      return Number(Math.round(value + 'e' + decimals) + 'e-' + decimals)
    }
  })
  