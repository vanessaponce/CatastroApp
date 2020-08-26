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
  <h5>Mi Cuenta</h5>
  <a href="<?php echo base_url('personas') ?>" class="navbar-text">
      Inicio
</a>
</nav>
<main role="main" class="pt-5 container">
<div class="pt-3 row">
    <div class="col">
        <h5 id="pasos">Datos personales</h5>
    </div>
</div>
<div class="p-3 justify-content-center align-self-center" >
    <form id="registrarPersona" action="" method="post" >
        <div class="form-group row text-center">
                <div class="col font-weight-bold">Identificación: </div>
                <div class="col"><label id="identificacion"></label></div>
        </div>
        <div class="form-group row text-center">
                <div class="col font-weight-bold">Nombres: </div>
                <div class="col"><label id="nombres"></label></div>
        </div>
        <div class="form-group row text-center">
                <div class="col font-weight-bold">Fecha de nacimiento: </div>
                <div class="col"><label id=fechanacimiento></label></div>
        </div>
        <div class="pb-5 form-group row text-center">
                <div class="col font-weight-bold">Corréo electrónico: </div>
                <div class="col"><label id=mail></label></div>
        </div>

        <input type="hidden" name="id" id="id" class="form-control">

        <button id="btnDeshabilitar" class="btn btn-lg btn-danger btn-block" type="button">Deshabilitar Cuenta</button><br>
    </form>
</div>

</main>
</body>
<script type="text/javascript" src="<?php echo base_url() . 'assets/js/Cuenta.js' ?>"></script>
</html>