<?php

require '../template/header.php';

$txtID = (isset($_POST['txtID'])) ? $_POST['txtID'] : '';
$txtNombre = (isset($_POST['txtNombre'])) ? $_POST['txtNombre'] : '';
$txtImagen = (isset($_FILES['txtImagen']['name'])) ? $_FILES['txtImagen']['name'] : '';
$accion = (isset($_POST['accion'])) ? $_POST['accion'] : '';

require '../config/database.php';

switch ($accion){
    case "Agregar":
        $statement = $conexion->prepare("INSERT INTO libros (nombre, imagen) VALUES (:nombre, :imagen)");
        $statement->bindParam(':nombre', $txtNombre);

        $fecha = new DateTime();
        $nombreArchivo = ($txtImagen != "") ? $fecha->getTimestamp() . "_" . $_FILES['txtImagen']['name'] : 'imagen.jpg';
        $tmpImagen = $_FILES['txtImagen']['tmp_name'];
        if ($tmpImagen != ''){
            move_uploaded_file($tmpImagen, "../../img/" . $nombreArchivo);
        }

        $statement->bindParam(':imagen', $nombreArchivo);
        $statement->execute();

        header('Location:productos.php');
        break;

    case "Editar":
        $statement = $conexion->prepare("UPDATE libros SET nombre = :nombre WHERE id = :id");
        $statement->bindParam(':nombre', $txtNombre);
        $statement->bindParam(':id', $txtID);
        $statement->execute();

        if ($txtImagen != ''){
            $fecha = new DateTime();
            $nombreArchivo = ($txtImagen != "") ? $fecha->getTimestamp() . "_" . $_FILES['txtImagen']['name'] : 'imagen.jpg';
            $tmpImagen = $_FILES['txtImagen']['tmp_name'];
            move_uploaded_file($tmpImagen, "../../img/" . $nombreArchivo);

            $statement = $conexion->prepare("SELECT imagen FROM libros WHERE id = :id");
            $statement->bindParam(':id', $txtID);
            $statement->execute();
            $libro = $statement->fetch(PDO::FETCH_LAZY);

            if (isset($libro['imagen']) && ($libro['imagen'] != 'imagen.jpg')){
                if (file_exists("../../img/" . $libro['imagen'])){
                    unlink("../../img/" . $libro['imagen']);
                }
            }

            $statement = $conexion->prepare("UPDATE libros SET imagen = :imagen WHERE id = :id");
            $statement->bindParam(':imagen', $nombreArchivo);
            $statement->bindParam(':id', $txtID);
            $statement->execute();
        }

        header('Location:productos.php');
        break;

    case "Cancelar":
        header('Location:productos.php');
        break;

    case "Seleccionar":
        $statement = $conexion->prepare("SELECT * FROM libros WHERE id = :id");
        $statement->bindParam(':id', $txtID);
        $statement->execute();
        $libro = $statement->fetch(PDO::FETCH_LAZY);

        $txtNombre = $libro['nombre'];
        $txtImagen = $libro['imagen'];
        break;

    case "Borrar":
        $statement = $conexion->prepare("SELECT imagen FROM libros WHERE id = :id");
        $statement->bindParam(':id', $txtID);
        $statement->execute();
        $libro = $statement->fetch(PDO::FETCH_LAZY);

        if (isset($libro['imagen']) && ($libro['imagen'] != 'imagen.jpg')){
            if (file_exists("../../img/" . $libro['imagen'])){
                unlink("../../img/" . $libro['imagen']);
            }
        }

        $statement = $conexion->prepare("DELETE FROM libros WHERE id = :id");
        $statement->bindParam(':id', $txtID);
        $statement->execute();

        header('Location:productos.php');
        break;
}

$statement = $conexion->prepare("SELECT * FROM libros");
$statement->execute();
$listaLibros = $statement->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="col-md-5">
    <div class="card">
        <div class="card-header">
            <h4>Datos de Libro</h4>
        </div>
        <div class="card-body">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="txtID">ID:</label>
                    <input type="text" required readonly name="txtID" id="txtID" value="<?php echo $txtID; ?>" class="form-control">
                </div>
                <div class="form-group">
                    <label for="txtNombre">Titulo:</label>
                    <input type="text" required name="txtNombre" id="txtNombre" value="<?php echo $txtNombre; ?>" class="form-control">
                </div>
                <div class="form-group">
                    <label for="txtImagen">Imagen:</label>
                    <br/>
                    <?php if ($txtImagen != ''){ ?>
                            <img src="../../img/<?php echo $txtImagen; ?>" class="img-thumbnail rounded" width="200" alt="" srcset="">
                    <?php } ?>
                    <input type="file" name="txtImagen" id="txtImagen" value="" class="form-control mt-2">
                </div>
                <div class="form-group">
                    <div class="btn-group" role="group" aria-label="">
                        <button type="submit" name="accion" <?php echo ($accion == "Seleccionar") ? "disabled" : ""; ?> value="Agregar" class="btn btn-success">Agregar</button>
                        <button type="submit" name="accion" <?php echo ($accion != "Seleccionar") ? "disabled" : ""; ?> value="Editar" class="btn btn-warning">Editar</button>
                        <button type="submit" name="accion" <?php echo ($accion != "Seleccionar") ? "disabled" : ""; ?> value="Cancelar" class="btn btn-info">Cancelar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="col-md-7">
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Imagen</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>

        <?php foreach ($listaLibros as $libro) { ?>

        <tr>
            <td><?php echo $libro['id']; ?></td>
            <td><?php echo $libro['nombre']; ?></td>
            <td>
                <img src="../../img/<?php echo $libro['imagen']; ?>" class="img-thumbnail rounded" width="60" alt="" srcset="">
            </td>
            <td>
                <form action="" method="post">
                    <input type="hidden" name="txtID" id="txtID" value="<?php echo $libro['id']; ?>">
                    <input type="submit" name="accion" value="Seleccionar" class="btn btn-outline-primary">
                    <input type="submit" name="accion" value="Borrar" class="btn btn-outline-danger">
                </form>
            </td>
        </tr>

        <?php } ?>

        </tbody>
    </table>
</div>

<?php require '../template/footer.php'; ?>
