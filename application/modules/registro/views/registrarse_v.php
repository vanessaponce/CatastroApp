<!Doctype html>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />

<html lang="es">
<title>Registrarse</title>

<link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'assets/css/bootstrap.css' ?>">
<link rel="stylesheet" href="<?php echo base_url() . 'assets/vendor/toastr/toastr.min.css' ?>">

<script type="text/javascript" src="<?php echo base_url() . 'assets/js/jquery-3.4.1.js' ?>"></script>
<script type="text/javascript" src="<?php echo base_url() . 'assets/js/bootstrap.min.js' ?>"></script>
<script type="text/javascript" src="<?php echo base_url() . 'assets/js/all.js' ?>"></script>
<script type="text/javascript" src="<?php echo base_url() . 'assets/vendor/toastr/toastr.js' ?>"></script>

</head>

<body class="text-center">

<nav class="navbar navbar-dark bg-primary fixed-top">
  <h5>Catastro Hogar</h5>
  <a href="<?php echo base_url('login') ?>" class="navbar-text">
      Inicio
</a>
</nav>
<main role="main" class="pt-5 container">
<div class="pt-3 row">
    <div class="col text-left">
        <h5 id="pasos"></h5>
    </div>
</div>
<div id="buscarPersona" class="p-3 justify-content-center align-self-center" >
    <form action="<?php echo base_url('registro/registrarse2') ?>" method="post">
        <input type="text" id="cedula" name="cedula" class="form-control" placeholder="Cédula" required><br>
        <button id="btnBuscar" class="btn btn-lg btn-primary btn-block" type="button">Buscar</button><br>
        <button type="button" id="btnSalir" class="btn btn-lg btn-danger btn-block">Cancelar</button>
    </form>
</div>

<div id="resultadoPersona" class="p-3 justify-content-center align-self-center" >
    <form id="registrarPersona" action="" method="post" oninput='email2.setCustomValidity(email2.value != email.value ? "Los correos electrónicos no son iguales." : "")'>
        <div class="form-group row text-left">
                <div class="col-4 font-weight-bold">Identificación: </div>
                <div class="col"><label id="identificacion"></label></div>
        </div>
        <div class="form-group row text-left">
                <div class="col-3 font-weight-bold">Nombres: </div>
                <div class="col"><label id="nombres"></label></div>
        </div>
        <div class="form-group row text-left">
                <div class="col-6 font-weight-bold">Fecha de nacimiento: </div>
                <div class="col"><label id=fechanacimiento></label></div>
        </div>

        <input type="hidden" name="id" id="id" class="form-control">
        <input type="email" id="email" name="email" class="form-control" placeholder="Correo electrónico" required ><br>
        <input type="email" id="email2" name="email2" class="form-control" placeholder="Correo electrónico (repetir)" required ><br>
        <input type="tel" id="telefono" minlength="9" maxlength="10" name="telefono" class="form-control" placeholder="Teléfono" required ><br>

        <div class="form-group row justify-content-center">
            <a class="col-5 btn btn-lg btn-secondary" href="<?php echo base_url('registro') ?>">Cancelar</a>
            <p class="col-1">&nbsp;</p>
            <button class="col-5 btn btn-lg btn-primary" id="registrar" type="subbmit">Aceptar</button>
        </div>
    </form>
</div>

</main>
</body>
<script type="text/javascript" src="<?php echo base_url() . 'assets/js/Registro.js' ?>"></script>
</html>