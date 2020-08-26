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
  <h5>Reportes</h5>
  <a href="<?php echo base_url('personas') ?>" class="navbar-text">Menu</a>
</nav>
<main role="main" class="pt-5 container">
    <div class="pt-3 row">
        <div class="col">
            <h5 id="pasos">Hogar</h5>
        </div>
    </div>
    <div>
        <div class="row text-left">
            <div class="col"><strong>Nro Suministro:  </strong>&nbsp;<a id="suministro"></a></div>
        </div>
        <div class="row text-left">
            <div class="col"><strong>Provincia: </strong>&nbsp;<a id="provincia"></a></div>
        </div>
        <div class="row text-left">
            <div class="col"><strong>Canton: </strong>&nbsp;<a id="canton"></a></div>
        </div>
        <div class="row text-left">
            <div class="col"><strong>Parroquia: </strong>&nbsp;<a id="parroquia"></a></div>
        </div>
        <div class="row text-left">
            <div class="col"><strong>Dirección: </strong>&nbsp;<a id="direccion"></a></div>
        </div>
        <div class="row text-left">
            <div class="col"><strong>Electrodomésticos: </strong>&nbsp;<a id="electrodomesticos"></a></div>
        </div>
    </div>
    <hr>

    <div class="row">
        <div class="col">
            <h5 id="pasos">Personas activas</h5>
        </div>
    </div>
    <div id="listaPerAct">

    </div>
    
    <div class="pt-3 row">
        <div class="col">
            <h5 id="pasos">Personas dadas de baja</h5>
        </div>
    </div>
    <div id="listaPerInac">

    </div>
    <button class="pt-3 col-5 btn btn-lg btn-secondary" id="cerrar" type="button">Cerrar</button>
    
</main>
</body>
    <script type="text/javascript" src="<?php echo base_url() . 'assets/js/Reportes.js' ?>"></script>
</html>