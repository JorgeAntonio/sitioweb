<?php require 'template/header.php'; ?>

    <div class="col-md-12">
        <div class="jumbotron">
            <h1 class="display-3">Bienvenido <?php echo $nombreUsuario; ?></h1>
            <p class="lead">Aqui puede administrar su biblioteca.</p>
            <hr class="my-2">
            <p>Más detalles</p>
            <p class="lead">
                <a class="btn btn-primary btn-lg" href="seccion/productos.php" role="button">Administrar Libros</a>
            </p>
        </div>
    </div>

<?php require 'template/footer.php'; ?>