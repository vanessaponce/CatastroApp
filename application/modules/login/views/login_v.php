<!Doctype html>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />

<html lang="es">

<head>
    <title>Login</title>

    <link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'assets/css/bootstrap.css' ?>">
    <link rel="stylesheet" href="<?php echo base_url() . 'assets/vendor/toastr/toastr.min.css' ?>">
    <link rel="stylesheet" href="<?php echo base_url() . 'assets/css/global.css' ?>">

    <script type="text/javascript" src="<?php echo base_url() . 'assets/js/jquery-3.4.1.js' ?>"></script>
    <script type="text/javascript" src="<?php echo base_url() . 'assets/js/bootstrap.min.js' ?>"></script>
    <script type="text/javascript" src="<?php echo base_url() . 'assets/js/all.js' ?>"></script>
    <script type="text/javascript" src="<?php echo base_url() . 'assets/vendor/toastr/toastr.js' ?>"></script>

</head>

<body class="text-center">
<?php
if (validation_errors()) {
    ?>
        <script type="text/javascript">
            toastr.warning('<?php echo json_encode(validation_errors()); ?>');
        </script>
    <?php }
?>
<nav class="navbar navbar-dark bg-primary fixed-top">
  <h5>Catastro Hogar</h5>
</nav>
<br>
<br>
<br>
<br>
<div class="p-3 justify-content-center align-self-center" >
    <form class="form-signin" action="<?php echo base_url('login') ?>" method="POST" enctype="multipart/form-data">
        <img class="mb-4" src="<?php echo base_url() . 'assets/images/logo.svg' ?>" alt="" width="320" height="100">
        <h1 class="h3 mb-3 font-weight-normal">Iniciar sesión</h1>
        <input type="text" id="userLogin" name="userLogin" class="form-control" placeholder="Usuario" required autofocus><br>
        <input type="password" id="passLogin" name="passLogin" class="form-control" placeholder="Contraseña" required>
        <br>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Ingresar</button>
        <br>
        <br>
        <div class="checkbox mb-3">
            <a href="<?php echo base_url('registro') ?>" class="float-center">Registrarse</a>
        </div>
    </form>
    </div>
</body>

</html>