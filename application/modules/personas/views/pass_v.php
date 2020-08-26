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
  <a href="<?php echo base_url('personas') ?>" class="navbar-text">
      Inicio
</a>
</nav>
<main role="main" class="pt-5 container">
<div class="pt-3 row">
    <div class="col">
        <h5 id="pasos">Cambiar Contraseña</h5>
    </div>
</div>
<div class="p-3 justify-content-center align-self-center" >
    <form id="cambiarPass" action="" method="post" oninput='passNuevo2.setCustomValidity(passNuevo2.value != passNuevo1.value ? "Las contraseñas no son iguales." : "")'>
        <div class="form-group row text-left">
            <div class="col">
                <div class="font-weight-bold">Contraseña actual </div>
                <input type="password" class="form-control" id="passActual" required></input>
            </div>
        </div>
        <div class="form-group row text-left">
            <div class="col">
                <div class="font-weight-bold">Contraseña nueva </div>
                <input type="password" class="form-control" id="passNuevo1" required></input>
            </div>
        </div>
        <div class="form-group row text-left">
            <div class="col">
                <div class="font-weight-bold">Contraseña nueva (repetir) </div>
                <input type="password" class="form-control" id="passNuevo2" required></input>
            </div>
        </div>

        <input type="hidden" name="id" id="id" class="form-control">
        <br>
        <div class="form-group row justify-content-center">
            <a class="col-5 btn btn-lg btn-secondary" href="<?php echo base_url('personas') ?>">Cancelar</a>
            <p class="col-1">&nbsp;</p>
            <button class="col-5 btn btn-lg btn-primary" id="actualizar" type="button">Cambiar</button>
        </div>
    </form>
</div>

</main>
</body>
<script type="text/javascript" src="<?php echo base_url() . 'assets/js/Pass.js' ?>"></script>
</html>