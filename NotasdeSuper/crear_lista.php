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

$usuario_logueado = $_SESSION["username"];

$sql_user_id = "SELECT id FROM usuarios WHERE username = '$usuario_logueado'";
$result_user_id = $conn->query($sql_user_id);
if ($result_user_id->num_rows > 0) {
    $row_user = $result_user_id->fetch_assoc();
    $usuario_id = $row_user['id'];
} else {
    echo "Usuario no encontrado.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nombre'])) {
    $nombre_lista = $_POST['nombre'];

    $sql = "INSERT INTO listas (nombre, usuario_id) VALUES ('$nombre_lista', $usuario_id)";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: listas.php");
        exit;
    } else {
        echo "Error al crear la lista: " . $conn->error;
    }
}

$conn->close();
?>
