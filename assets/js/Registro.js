$(document).ready(function () {
    $('#pasos').text('Paso 1: Buscar Persona');
    $('#buscarPersona').css('visibility', 'visible');
    $('#resultadoPersona').css('visibility', 'hidden');

});

$('#btnBuscar').click(function (e) {
    var cedula = $('#cedula').val().trim();
    if (cedula == '') { toastr.warning('Ingrese número de cédula.') } else {
        $.ajax({
            type: "POST",
            url: "registro/validarUsuario",
            dataType: "JSON",
            data: {
                cedula: cedula
            },
            success: function (data) {
                if (data != false) {
                    if (data.ESTADO_PERSONA == 0) {
                        toastr.warning('Identificación no válida.');
                    } else if (data.ESTADO_HOGAR == 1) {
                        toastr.warning('Persona consta como miembro o jefe de hogar.');
                    } else {
                        $('#identificacion').text(data.IDENTIFICACION);
                        $('#nombres').text(data.NOMBRE);
                        $('#fechanacimiento').text(data.FECHA_NACIMIENTO);
                        $('#id').val(data.ID_PERSONA);

                        $('#pasos').text('Paso 2: Completar información');
                        $('#buscarPersona').css('visibility', 'hidden');
                        $('#buscarPersona').css('display', 'none');
                        $('#resultadoPersona').css('visibility', 'visible');
                        $('#resultadoPersona').css('display', 'block');
                    }
                } else {
                    toastr.warning('No existe persona.');
                }
            }
        });
    }
});

$('#registrarPersona').submit('click', function () {
    var identificacion = $('#identificacion').text();
    var id = $('#id').val();
    var mail = $('#email').val();

    $.ajax({
        type: "POST",
        url: "registro/registrarUsuario",
        dataType: "JSON",
        data: {
            identificacion: identificacion,
            id: id,
            mail: mail
        },
        success: function (data) {
            if (data == true) {
                $('#identificacion').text('');
                $('#id').val('');
                $('#email').val('');

                /*$('#pasos').text('Paso 1: Buscar Persona');
                $('#buscarPersona').css('visibility', 'visible');
                $('#buscarPersona').css('display', 'block');
                $('#resultadoPersona').css('visibility', 'hidden');
                $('#resultadoPersona').css('display', 'none');*/

                toastr.success('Registro exito. \n Verifique el correo ' + mail);
                
                setTimeout("window.history.back();",4000);
            } else {
                toastr.warning(data);
            }
        }
    });
    return false;
});

$('#btnSalir').click(function () {
    window.location.href = "login";
});


