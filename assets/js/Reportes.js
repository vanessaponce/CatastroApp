$('#cerrar').click(function () {
    window.location.href = "personas";
});
$(document).ready(function () {
    hogar();
    personaActiva();
    personaInactiva();
});

function hogar(){
    $.ajax({
        type: "ajax",
        url: "reportes/reporteHogar",
        async: false,
        dataType: "JSON",
        success: function (data) {
            var elect = '';
            if (data != true) {
                for (i = 0; i < data.length; i++) {
                    $('#suministro').text(data[i].SUMINISTRO_ELEC);
                    $('#provincia').text(data[i].nProvincia);
                    $('#canton').text(data[i].nCanton);
                    $('#parroquia').text(data[i].nParroquia);
                    $('#direccion').text(data[i].DIRECCION);
                    if(data[i].CALEFON == 1){elect += 'Calefón, '}
                    if(data[i].COCINA == 1){elect += 'Cocina, '}
                    if(data[i].SECADORA == 1){elect += ' Secadora de ropa'}
                    $('#electrodomesticos').text(elect);
                }
            } else {
                toastr.warning(data);
            }
        }
    });
}
function personaActiva(){
    $.ajax({
        type: "ajax",
        url: "reportes/reportePersonaActiva",
        async: false,
        dataType: "JSON",
        success: function (data) {
            var html = '';
            if (data != true) {
                for (i = 0; i < data.length; i++) {
                    html += '<div class="row text-left"><div class="col"><strong>Identificación:  </strong>&nbsp;' + data[i].IDENTIFICACION + '</div></div>'+
                    '<div class="row text-left"><div class="col"><strong>Nombres:  </strong>&nbsp;' + data[i].NOMBRE + '</div></div>'+
                    '<div class="row text-left"><div class="col"><strong>Fecha de nacimiento:  </strong>&nbsp;' + data[i].FECHA_NACIMIENTO + '</div></div>'+
                    '<div class="row text-left"><div class="col"><strong>Parentesco:  </strong>&nbsp;' + data[i].DESCRIPCION + '</div></div>'+
                    '<div class="dropdown-divider"></div>';
                }
            } else {
                toastr.warning(data);
            }
            $('#listaPerAct').html(html);
        }
    });
}
function personaInactiva(){
    $.ajax({
        type: "ajax",
        url: "reportes/reportePersonaInactiva",
        async: false,
        dataType: "JSON",
        success: function (data) {
            var html = '';
            if (data != true) {
                for (i = 0; i < data.length; i++) {
                    html += '<div class="row text-left"><div class="col"><strong>Identificación:  </strong>&nbsp;' + data[i].IDENTIFICACION + '</div></div>'+
                    '<div class="row text-left"><div class="col"><strong>Nombres:  </strong>&nbsp;' + data[i].NOMBRE + '</div></div>'+
                    '<div class="row text-left"><div class="col"><strong>Fecha de nacimiento:  </strong>&nbsp;' + data[i].FECHA_NACIMIENTO + '</div></div>'+
                    '<hr>';
                }
            } else {
                toastr.warning(data);
            }
            $('#listaPerInac').html(html);
        }
    });
}