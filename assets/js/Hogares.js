$(document).ready(function () {
    showProvincia();
    showCanton();
    showParroquia();
    document.getElementById("canton").disabled = true;
    document.getElementById("parroquia").disabled = true;

    showHogar();

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
                "sEmptyTable": "Ningún miembro registrado",
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

function showProvincia() {
    $.ajax({
        type: "ajax",
        url: "hogares/showProvincia",
        async: false,
        dataType: "JSON",
        success: function (data) {
            console.log(data);
            var html = '<option value="">- Seleccione -</option>';
            var i;
            if (data != true) {
                for (i = 0; i < data.length; i++) {
                    html += '<option value="' + data[i].ID_PROVINCIA + '">' + data[i].NOMBRE + '</option>';
                }
            } else {
                toastr.warning(data);
            }
            $('#provincia').html(html);
        }
    });
}
function showCanton() {
    $.ajax({
        type: "ajax",
        url: "hogares/showCanton1",
        async: false,
        dataType: "JSON",
        success: function (data) {
            console.log(data);
            var html = '<option value="">- Seleccione -</option>';
            var i;
            if (data != true) {
                for (i = 0; i < data.length; i++) {
                    html += '<option value="' + data[i].ID_CANTON + '">' + data[i].NOMBRE + '</option>';
                }
            } else {
                toastr.warning(data);
            }
            $('#canton').html(html);
        }
    });
}
function showParroquia() {
    $.ajax({
        type: "ajax",
        url: "hogares/showParroquia1",
        async: false,
        dataType: "JSON",
        success: function (data) {
            console.log(data);
            var html = '<option value="">- Seleccione -</option>';
            var i;
            if (data != true) {
                for (i = 0; i < data.length; i++) {
                    html += '<option value="' + data[i].ID_PARROQUIA + '">' + data[i].NOMBRE + '</option>';
                }
            } else {
                toastr.warning(data);
            }
            $('#parroquia').html(html);
        }
    });
}


$('#provincia').change(function () {
    document.getElementById("canton").disabled = false;
    var provincia = $(this).val();
    $.ajax({
        type: "POST",
        url: "hogares/showCanton",
        dataType: "JSON",
        data: {
            provincia: provincia
        },
        success: function (data) {
            console.log(data);
            var html = '<option value="">- Seleccione -</option>';
            var i;
            if (data != true) {
                for (i = 0; i < data.length; i++) {
                    html += '<option value="' + data[i].ID_CANTON + '">' + data[i].NOMBRE + '</option>';
                }
            } else {
                toastr.warning(data);
            }
            $('#canton').html(html);
        }
    });
})

$('#canton').change(function () {
    document.getElementById("parroquia").disabled = false;
    var canton = $(this).val();
    $.ajax({
        type: "POST",
        url: "hogares/showParroquia",
        dataType: "JSON",
        data: {
            canton: canton
        },
        success: function (data) {
            console.log(data);
            var html = '<option value="">- Seleccione -</option>';
            var i;
            if (data != true) {
                for (i = 0; i < data.length; i++) {
                    html += '<option value="' + data[i].ID_PARROQUIA + '">' + data[i].NOMBRE + '</option>';
                }
            } else {
                toastr.warning(data);
            }
            $('#parroquia').html(html);
        }
    });
})

function showHogar() {
    $.ajax({
        type: "ajax",
        url: "hogares/showHogar",
        async: false,
        dataType: "JSON",
        success: function (data) {
            console.log(data);
            if (data != true) {
                for (i = 0; i < data.length; i++) {
                    $('#suministro').val(data[i].SUMINISTRO_ELEC);
                    $('#provincia').val(data[i].ID_PROVINCIA);
                    $('#canton').val(data[i].ID_CANTON);
                    $('#parroquia').val(data[i].ID_PARROQUIA);
                    $('#direccion').val(data[i].DIRECCION);
                    $('#hogar').val(data[i].ID_HOGAR);
                    if (data[i].CALEFON == 1) { document.getElementById("calefon").checked = true; }
                    if (data[i].COCINA == 1) { document.getElementById("cocina").checked = true; }
                    if (data[i].SECADORA == 1) { document.getElementById("secadora").checked = true; }
                }
            } else {
                toastr.warning(data);
            }
        }
    });
}

$('#registrarHogar').submit('click', function () {
    var suministro = $('#suministro').val();
    var provincia = $('#provincia').val();
    var canton = $('#canton').val();
    var parroquia = $('#parroquia').val();
    var direccion = $('#direccion').val();
    var hogar = $('#hogar').val();

    var calefon = 0;
    if ($('#calefon').is(":checked")) { calefon = 1; }
    var cocina = 0;
    if ($('#cocina').is(":checked")) { cocina = 1; }
    var secadora = 0;
    if ($('#secadora').is(":checked")) { secadora = 1; }

    $.ajax({
        type: "POST",
        url: "hogares/registrarHogar",
        dataType: "JSON",
        data: {
            hogar: hogar,
            suministro: suministro,
            provincia: provincia,
            canton: canton,
            parroquia: parroquia,
            direccion: direccion,
            calefon: calefon,
            cocina: cocina,
            secadora: secadora
        },
        success: function (data) {
            if (data == true) {
                toastr.success("Datos guardados.");
                showHogar();
            } else {
                toastr.warning(data);
            }
        }
    });
});

$('#btnCancelar').click(function () {
    window.location.href = "personas";

});


