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
    $('#buscarPersona').css('display', 'none');
    $('#buscarPersona').css('visibility', 'hidden');
    $('#resultadoPersona').css('display', 'block');
    $('#resultadoPersona').css('visibility', 'visible');
    

});

$('#btnCancelarBuscar').click(function () {
    window.location.href = "personas";    

});


