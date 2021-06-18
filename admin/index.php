<?php

session_start();

if ($_POST){
    if (($_POST['usuario']=='jorge') && ($_POST['contrasena']=='sistema')){
        $_SESSION['usuario']='ok';
        $_SESSION['nombreUsuario']='Jorge';
        header('Location:inicio.php');
    } else {
        $mensaje = 'Error: Las credenciales son incorrectas';
    }
}

?>

<!doctype html>
<html lang="en">
<head>
    <title>Administrador</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>

<div class="container my-5">
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <div class="card my-5">
                <div class="card-header">
                    Login
                </div>
                <div class="card-body">
                    <form action="" method="post">
                        <?php if (isset($mensaje)) { ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $mensaje; ?>
                            </div>
                        <?php } ?>
                        <div class="form-group">
                            <label for="usuario">Usuario:</label>
                            <input type="text" name="usuario" id="usuario" class="form-control" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="password">Contraseña:</label>
                            <input type="password" class="form-control" name="contrasena" id="password">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Entrar al sistema</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
    </div>
</div>

</body>
</html>