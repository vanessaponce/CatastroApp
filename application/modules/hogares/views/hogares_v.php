<!Doctype html>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />

<html lang="es">
<title>Registrarse</title>

<link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'assets/css/bootstrap.css' ?>">
<link rel="stylesheet" href="<?php echo base_url() . 'assets/vendor/toastr/toastr.min.css' ?>">
<link rel="stylesheet" href="<?php echo base_url() . 'assets/DataTables/datatables.min.css' ?>" />

<script type="text/javascript" src="<?php echo base_url() . 'assets/js/jquery-3.4.1.js' ?>"></script>
<script type="text/javascript" src="<?php echo base_url() . 'assets/js/bootstrap.min.js' ?>"></script>
<script type="text/javascript" src="<?php echo base_url() . 'assets/js/all.js' ?>"></script>
<script type="text/javascript" src="<?php echo base_url() . 'assets/vendor/toastr/toastr.js' ?>"></script>
<script type="text/javascript" src="<?php echo base_url() . 'assets/DataTables/datatables.min.js' ?>"></script>

</head>

<body class="text-center">

<nav class="navbar navbar-dark bg-primary fixed-top">
  <h5>Gestionar Hogar </h5>
  <a href="<?php echo base_url('personas') ?>" class="navbar-text">Menu</a>
</nav>
<main role="main" class="pt-5 container">
    <div class="pt-3 table-responsive">

    <div>
        <div class="text-center">
                <h5 id="pasos">Datos de hogar</h5>
        </div>
    <div class="justify-content-center align-self-center" >
        <form id="registrarHogar" action="" method="post" >
            <div class="form-group row text-left">
                <div class="col">
                    <div class="font-weight-bold">Nro Suministro: </div>
                    <input class="form-control" id="suministro" required></input>
                </div>
            </div>
            <div class="form-group row text-left">
                <div class="col">
                    <div class="font-weight-bold">Provincia: </div>                     
                    <select name="provincia" id="provincia" class="form-control" required>
                    </select>
                </div>
            </div>
            <div class="form-group row text-left">
                <div class="col">
                    <div class="font-weight-bold">Canton: </div>                     
                    <select name="canton" id="canton" class="form-control" required>
                    </select>
                </div>
            </div>
            <div class="form-group row text-left">
                <div class="col">
                    <div class="font-weight-bold">Parroquia: </div>                     
                    <select name="parroquia" id="parroquia" class="form-control" required>
                    </select>
                </div>
            </div>
            <div class="form-group row text-left">
                <div class="col">
                    <div class="font-weight-bold">Dirección: </div>                     
                    <textarea class="form-control" id="direccion" aria-label="With textarea"></textarea>
                </div>
            </div>
            <div class="form-group row text-left">
                    <div class="col font-weight">Seleccione los electrodomésticos que existen en el hogar que funcionen con gas doméstico</div>
            </div>
            <div class="form-check text-left">
              <input class="form-check-input" type="checkbox" value="" id="calefon">
              <label class="form-check-label font-weight-bold" for="calefon">
                Calefón
              </label>
            </div><div class="form-check text-left">
              <input class="form-check-input" type="checkbox" value="" id="cocina">
              <label class="form-check-label font-weight-bold" for="cocina">
                Cocina
              </label>
            </div><div class="form-check text-left">
              <input class="form-check-input" type="checkbox" value="" id="secadora">
              <label class="form-check-label font-weight-bold" for="secadora">
                Secadora de ropa
              </label>
            </div>
            <input class="form-control" type="hidden" id="hogar" name="hogar">
            <br>
            <div class="form-group row justify-content-center">
                <button class="col-5 btn btn-lg btn-secondary" id="btnCancelar">Cancelar</button>
                <p class="col-1">&nbsp;</p>
                <button class="col-5 btn btn-lg btn-primary" id="btnGuardar" type="button">Aceptar</button>
            </div>
        </div>
        </form>
    </div>

    </div>
</main>
</body>
    <script type="text/javascript" src="<?php echo base_url() . 'assets/js/Hogares.js' ?>"></script>
</html>