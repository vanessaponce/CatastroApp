$(document).ready(function () {
    showPersonas();
    tipoPersona();

    $(document).ready(function () {
        $('#tblPersonas').DataTable({
            "ordering": false,
            "searching": false,
            "lengthChange": true,
            "info": false,
            "paging": false,
            "processing": true,
            "language": {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningúna persona registrada",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }
        });
    });
});

function showPersonas() {
    $.ajax({
        type: "ajax",
        url: "personas/showPersonas",
        async: false,
        dataType: "JSON",
        success: function (data) {
            var html = '';
            var i;
            if (data != true) {
                for (i = 0; i < data.length; i++) {
                    if (data[i].ID_TIPO_PERSONA == 100) {
                        st = '<a href="javascript:void(0);" class="hidden"></a>';
                        $('#idHogar').val(data[i].ID_HOGAR);
                    } else {
                        st = '<a href="javascript:void(0);" class="text-danger delPersona" data-id="' + data[i].ID_PERSONA + '" ><i class="fas fa-times-circle"></i></a>';
                    }

                    html += '<tr id="' + data[i].ID_PERSONA + '">' +
                        '<td>' + data[i].NOMBRE + '</td>' +
                        '<td>' + data[i].IDENTIFICACION + '</td>' +
                        '<td>' + data[i].DESCRIPCION + '</td>' +
                        '<td>' +
                        st +
                        '</td>' +
                        '</tr>';

                }
            } else {
                toastr.warning(data);
            }
            $('#listPersonas').html(html);
        }
    });
}

function tipoPersona() {
    $.ajax({
        type: "ajax",
        url: "personas/tipoPersona",
        async: false,
        dataType: "JSON",
        success: function (data) {
            var html = '<option value="">- Seleccione -</option>';
            var i;
            if (data != true) {
                for (i = 0; i < data.length; i++) {
                    html += '<option value="' + data[i].ID_TIPO_PERSONA + '">' + data[i].DESCRIPCION + '</option>';
                }
            } else {
                toastr.warning(data);
            }
            $('#tipoPersona').html(html);
        }
    });
}

$(document).ready(function () {
    $('#buscarPersona').css('visibility', 'hidden');
    $('#buscarPersona').css('display', 'none');
    $('#resultadoPersona').css('visibility', 'hidden');
    $('#resultadoPersona').css('display', 'none');
    $('#personas').css('display', 'block');
});

$('#btnNuevaPersona').click(function () {
    $('#personas').css('display', 'none');
    $('#personas').css('visibility', 'hidden');
    $('#buscarPersona').css('display', 'block');
    $('#buscarPersona').css('visibility', 'visible');
});

$('#btnBuscar').click(function () {

    var cedula = $('#cedula').val().trim();
    if (cedula == '') { toastr.warning('Ingrese número de cédula.') } else {
        $.ajax({
            type: "POST",
            url: "personas/buscarPersona",
            dataType: "JSON",
            data: {
                cedula: cedula
            },
            success: function (data) {
                if (data != false) {
                    if (data.ESTADO == 0) {
                        toastr.warning('Identificación no válida.');
                    } else if (data.ESTADO_HOGAR == 1) {
                        toastr.warning('Persona consta como miembro o jefe de hogar.');
                    } else {
                        $('#identificacion').text(data.IDENTIFICACION);
                        $('#nombres').text(data.NOMBRE);
                        $('#fechanacimiento').text(data.FECHA_NACIMIENTO);
                        $('#id').val(data.ID_PERSONA);

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

$('#registrarPariente').submit('click', function () {
    var id = $('#id').val();
    var tipoPersona = $('#tipoPersona').val();
    var idHogar = $('#idHogar').val();
    var discapacidad = 0;
    if ($('#discapacidad').is(":checked")) {discapacidad = 1;}else{discapacidad = 0;}

    $.ajax({
        type: "POST",
        url: "personas/registrarPariente",
        dataType: "JSON",
        data: {
            id: id,
            tipoPersona: tipoPersona,
            idHogar: idHogar,
            discapacidad: discapacidad
        },
        success: function (data) {
            if (data == true) {
                $('#id').val('');
                $('#tipoPersona').val('');

                $('#buscarPersona').css('visibility', 'hidden');
                $('#buscarPersona').css('display', 'none');
                $('#resultadoPersona').css('visibility', 'hidden');
                $('#resultadoPersona').css('display', 'none');
                $('#personas').css('visibility', 'visible');
                $('#personas').css('display', 'block');

                showPersonas();
                toastr.success("Registro exitoso.");
            } else {
                toastr.warning(data);
            }
        }
    });
});

$('#btnCancelarBuscar, #btnCancelar').click(function () {
    window.location.href = "/personas/persona";

});

$('#listPersonas').on('click', '.delPersona', function () {
    $('#deletePersonaModal').modal('show');
    $('#deletePersonaId').val($(this).data('id'));
});

$('#deletePersonaForm').submit('click', function () {
    var idPersona = $('#deletePersonaId').val();
    $.ajax({
        type: "POST",
        url: "personas/bajaPersona",
        dataType: "JSON",
        data: { idPersona: idPersona },
        success: function (data) {
            if (data == true) {
                $('#deletePersonaId').val("");
                $('#deletePersonaModal').modal('hide');
                showPersonas();
                toastr.success('Persona inactiva.');
            } else {
                toastr.warning(data);
            }
        }
    });
    return false;
});