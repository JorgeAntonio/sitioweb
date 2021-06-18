<?php
require 'template/header.php';
require 'admin/config/database.php';

$statement = $conexion->prepare("SELECT * FROM libros");
$statement->execute();
$listaLibros = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<?php foreach ($listaLibros as $libro){ ?>
    <div class="col-md-3">
        <div class="card my-3">
            <img class="card-img-top" src="./img/<?php echo $libro['imagen'];?>" alt="">
            <div class="card-body">
                <h4 class="card-title"><?php echo $libro['nombre'];?></h4>
                <a name="" id="" class="btn btn-primary" href="#" role="button">Detalles</a>
            </div>
        </div>
    </div>
<?php } ?>
<?php require 'template/footer.php'; ?>
