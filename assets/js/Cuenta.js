$(document).ready(function () {
    showCuenta();

});

function showCuenta(){
    $.ajax({
        type: "ajax",
        url: "personas/showCuenta",
        async: false,
        dataType: "JSON",
        success: function (data) {
            console.log(data);
            if (data != true) {
                for (i = 0; i < data.length; i++) {
                    $('#identificacion').text(data[i].IDENTIFICACION);
                    $('#nombres').text(data[i].NOMBRE);
                    $('#fechanacimiento').text(data[i].FECHA_NACIMIENTO);
                    $('#mail').text(data[i].MAIL);
                    $('#id').val(data[i].ID_USUARIO);
                }
            } else {
                toastr.warning(data);
            }
        }
    });
}