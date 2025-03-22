<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}

// Conexion a la bd
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "Recuerda";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$usuario_logueado = $_SESSION["username"];

$sql_user_id = "SELECT id FROM usuarios WHERE username = '$usuario_logueado'";
$result_user_id = $conn->query($sql_user_id);
if ($result_user_id->num_rows > 0) {
    $row_user = $result_user_id->fetch_assoc();
    $usuario_id = $row_user['id'];

    $sql = "SELECT id, nombre FROM listas WHERE usuario_id = $usuario_id";
    $result = $conn->query($sql);
} else {
    echo "Usuario no encontrado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Listas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/estilolista.css">
</head>
<body>
<header>
  <div class="logo">
    <img src="img/logo.jpg" alt="Logo">
 
  </div>
</header>
    <div class="container mt-5">
        <h2 class="text-center">Mis Listas De Conpras</h2>
        
        <a href="Inicio.php" class="btn btn-secondary mb-3">Atrás</a>
        
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalNuevaLista">+ Nueva Lista</button>
        
        <div class="row">
            <?php while ($row = $result->fetch_assoc()) { ?>
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row['nombre']; ?></h5>
                            <a href="lista_detalle.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-primary">Ver Lista</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <div class="modal fade" id="modalNuevaLista" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Crear Nueva Lista</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="crear_lista.php" method="post">
                        <div class="mb-3">
                            <label for="nombreLista" class="form-label">Nombre de la lista</label>
                            <input type="text" class="form-control" id="nombreLista" name="nombre" required>
                        </div>
                        <button type="submit" class="btn btn-success">Crear</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php $conn->close(); ?>
