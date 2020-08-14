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
  <h5>MENU</h5>
</nav>
<main role="main" class="pt-5 container">
    <div class="pt-3">

    <button type="button" id="btnGestionP" class="btn btn-lg btn-success btn-block">
    <div class="card bg-success" >
      <div class="card-body">
        <div class="row">
            <div class="col-2">
                <i class="fas fa-users fa-lg"></i>
            </div>
            <div class="col">
                <p class="card-text">Gestionar Personas</p>
            </div>
        </div>
      </div>
    </div>
    </button>

    <button type="button" id="btnGestionH" class="btn btn-lg btn-info btn-block">
    <div class="card bg-info" >
      <div class="card-body">
        <div class="row">
            <div class="col-2">
                <i class="fas fa-home fa-lg"></i>
            </div>
            <div class="col">
            <p class="card-text">Gestionar Hogar</p>
            </div>
        </div>
      </div>
    </div>
    </button>    
    <div class="dropdown-divider"></div>

    <button type="button" id="btnReportes" class="btn btn-lg btn-secondary btn-block">
    <div class="card bg-secondary" >
      <div class="card-body">
        <div class="row">
            <div class="col-2">
                <i class="fas fa-file fa-lg"></i>
            </div>
            <div class="col">
                <p class="card-text">Reportes</p>
            </div>
        </div>
      </div>
    </div>
    </button>
    <div class="dropdown-divider"></div>

    <button type="button" id="btnMiCuenta" class="btn btn-lg btn-success btn-block">
    <div class="card bg-success" >
      <div class="card-body">
        <div class="row">
            <div class="col-2">
                <i class="fas fa-user fa-lg"></i>
            </div>
            <div class="col">
                <p class="card-text">Mi Cuenta</p>
            </div>
        </div>
      </div>
    </div>
    </button>
    <button type="button" id="btnCambioPass" class="btn btn-lg btn-info btn-block">
    <div class="card bg-info" >
      <div class="card-body">
        <div class="row">
            <div class="col-2">
                <i class="fas fa-key fa-lg"></i>
            </div>
            <div class="col">
                <p class="card-text">Cambiar Contraseña</p>
            </div>
        </div>
      </div>
    </div>
    </button>
    <div class="dropdown-divider"></div>

    <button type="button" id="btnSalir" class="btn btn-lg btn-danger btn-block ">Salir</button>

    </div>
</main>
</body>
<script type="text/javascript" src="<?php echo base_url() . 'assets/js/Menu.js' ?>"></script>
</html>