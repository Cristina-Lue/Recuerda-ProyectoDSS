<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}

$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "Recuerda";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$lista_id = isset($_GET['id']) ? $_GET['id'] : 0;

$sql = "SELECT id, nombre FROM listas WHERE id = $lista_id";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $lista_nombre = $row['nombre'];
} else {
    echo "Lista no encontrada.";
    exit;
}

$sql_productos = "SELECT id, nombre FROM productos WHERE lista_id = $lista_id";
$result_productos = $conn->query($sql_productos);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['producto_id'])) {
    $producto_id = $_POST['producto_id'];

    $sql_delete = "DELETE FROM productos WHERE id = $producto_id AND lista_id = $lista_id";
    if ($conn->query($sql_delete) === TRUE) {
        header("Location: lista_detalle.php?id=$lista_id");
        exit;
    } else {
        echo "Error al eliminar el producto: " . $conn->error;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['producto_nombre'])) {
    $producto_nombre = $_POST['producto_nombre'];

    if (!empty($producto_nombre)) {
        $sql_insert = "INSERT INTO productos (nombre, lista_id) VALUES ('$producto_nombre', $lista_id)";
        if ($conn->query($sql_insert) === TRUE) {
            header("Location: lista_detalle.php?id=$lista_id");
            exit;
        } else {
            echo "Error al agregar el producto: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de Lista</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/estilodetalles.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Detalle de la Lista: <?php echo $lista_nombre; ?></h2>
        
        <a href="listas.php" class="btn btn-secondary mb-3">Atrás</a>
        
        <div class="row">
            
            <?php 
            if ($result_productos->num_rows > 0) {
                while ($row_producto = $result_productos->fetch_assoc()) { ?>
                    <div class="col-md-4">
                        <div class="card mb-3">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <h5 class="card-title"><?php echo $row_producto['nombre']; ?></h5>
                                <form action="lista_detalle.php?id=<?php echo $lista_id; ?>" method="post">
                                    <button type="submit" class="btn btn-danger btn-sm" name="producto_id" value="<?php echo $row_producto['id']; ?>">-</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php }
            } else {
                echo "<p>No hay productos en esta lista.</p>";
            }
            ?>
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Nuevo Producto</h5>
                        <form action="lista_detalle.php?id=<?php echo $lista_id; ?>" method="post">
                            <div class="mb-3">
                                <label for="producto_nombre" class="form-label">Nombre del Producto</label>
                                <input type="text" class="form-control" id="producto_nombre" name="producto_nombre" required>
                            </div>
                            <button type="submit" class="btn btn-success">Agregar Producto</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<?php $conn->close(); ?>
