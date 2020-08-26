$('#actualizar').click(function () {

    var passActual = $('#passActual').val();
    var passNuevo1 = $('#passNuevo1').val();
    var passNuevo2 = $('#passNuevo2').val();

    if (passNuevo1 == passNuevo2) {
        $.ajax({
            type: "POST",
            url: "personas/cambiarPass",
            dataType: "JSON",
            data: {
                passActual: passActual,
                passNuevo: passNuevo1
            },
            success: function (data) {
                if (data == true) {
                    $('#passActual').val('');
                    $('#passNuevo1').val('');
                    $('#passNuevo2').val('');

                    toastr.success("Contraseña actualizada.");

                    setTimeout("window.history.back();",1500);

                } else {
                    toastr.warning(data);
                }
            }
        });
    } else {
        toastr.warning("Contraseñas nuevas no coinciden.");
    }
});