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
  <h5>Gestionar Personas </h5>
  <a href="<?php echo base_url('personas') ?>" class="navbar-text">Menu</a>
</nav>
<main role="main" class="pt-5 container">
    <div class="pt-3 table-responsive">

    <div id="personas">
        <div class="text-center">
                <h5 id="pasos">Personas registradas</h5>
        </div>
    <table id="tblPersonas" class="table" >
        <thead>
            <tr>
                <th>Nombres</th>
                <th>Identificación</th>
                <th>Parentesco</th>
                <th><i class="fa fa-cog"></th>
            </tr>
        </thead>
        <tbody id="listPersonas">
        </tbody>
    </table>
    <hr>
    <button type="button" id="btnNuevaPersona" class="btn btn-lg btn-primary btn-block">Registrar nueva persona</button>
    </div>

    <div id="buscarPersona" class="justify-content-center align-self-center" >
        <div class="text-center">
            <h5 id="pasos">Buscar persona</h5>
        </div><br>
        <form action="<?php echo base_url('registro/registrarse2') ?>" method="post">
            <input type="text" id="cedula" name="cedula" class="form-control" placeholder="Cédula" required><br>
            <div class="form-group row justify-content-center">
                <button type="button" id="btnCancelarBuscar" class="col-5 btn btn-lg btn-secondary">Cancelar</button>
                <p class="col-1">&nbsp;</p>
                <button class="col-5 btn btn-lg btn-primary" id="btnBuscar" type="button">Buscar</button>
            </div>
        </form>
    </div>

    <div id="resultadoPersona" class="justify-content-center align-self-center" >
        <div class="text-center">
            <h5 id="pasos">Datos persona</h5>
        </div><br>
        <form id="registrarPariente" action="" method="post">
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

            <div class="form-group row text-left">
                <div class="col">
                    <div class="font-weight-bold">Parentesco</div>                     
                    <select name="tipoPersona" id="tipoPersona" class="form-control" required>
                    </select>
                </div>
            </div>

            <div class="form-check text-left">
              <input class="form-check-input" type="checkbox" value="" id="discapacidad">
              <label class="form-check-label font-weight-bold" for="discapacidad">
                Es persona con discapacidad
              </label>
            </div>
            <br>

            <input type="hidden" name="id" id="id" class="form-control">
            <input type="hidden" name="idHogar" id="idHogar" class="form-control">

            <div class="form-group row justify-content-center">
            <button class="col-5 btn btn-lg btn-secondary" id="btnCancelar" type="button">Cancelar</button>
                <p class="col-1">&nbsp;</p>
                <button class="col-5 btn btn-lg btn-primary" type="submit">Aceptar</button>
            </div>
        </form>
    </div>


    </div>

    <form id="deletePersonaForm" method="post">
        <div class="modal fade" id="deletePersonaModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content text-center">
                    <div class="modal-body">
                        <h4 class="modal-title" id="editModalLabel">Confirmar</h4>
                        ¿Está usted seguro de inactivar a esta persona del hogar?<br>
                        <input type="hidden" name="deletePersonaId" id="deletePersonaId" class="form-control">
                        
                        <div class="form-group row justify-content-center">
                            <div class="col">
                                <button type="button" class="btn btn-info" data-dismiss="modal">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-success">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Si&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </form>

</main>
</body>
    <script type="text/javascript" src="<?php echo base_url() . 'assets/js/Personas.js' ?>"></script>
</html>