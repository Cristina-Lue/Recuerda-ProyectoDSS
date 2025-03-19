<?php
// Conexión a la base de datos
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "Recuerda";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Procesar el formulario de registro
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {
    $new_username = $_POST["new_username"];
    $new_password = $_POST["new_password"];
    $new_email = $_POST["new_email"];

    $sql = "INSERT INTO usuarios (username, password, email) VALUES ('$new_username', '$new_password', '$new_email')";
    if ($conn->query($sql) === TRUE) {
        $registration_success_message = "Registro exitoso.";
    } else {
        $error_message = "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Procesar el formulario de inicio de sesión
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM usuarios WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Inicio de sesión exitoso, redirigir al usuario a la página de inicio
        session_start();
        $_SESSION["username"] = $username;
        header("Location: Inicio.html");
        exit;
    } else {
        $error_message = "Nombre de usuario o contraseña incorrectos. <a href='#' onclick='showRegistrationForm()'>Registrarme</a>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuerda - Iniciar Sesión</title>
    <link rel="stylesheet" href="login-style.css">
    <script>
        function showRegistrationForm() {
            document.getElementById("login-form").style.display = "none";
            document.getElementById("registration-form").style.display = "block";
        }
    </script>
</head>
<body>
    <div class="login-container">
        <div class="logo-container">
            <img src="img/logo.jpg" alt="Logo Recuerda" class="logo">
        </div>
        <?php if (isset($registration_success_message)) { ?>
            <div class="registration-success-message"><?php echo $registration_success_message; ?></div>
        <?php } ?>
        <?php if (isset($error_message)) { ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php } ?>
        <form id="login-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <div class="form-group">
                <label for="username">Usuario</label>
                <input type="text" id="username" name="username" placeholder="Ingresa tu usuario" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" placeholder="Ingresa tu contraseña" required>
            </div>
            <div class="remember-forgot">
                <label>
                    <input type="checkbox"> Recordarme
                </label>
                <a href="#">¿Olvidaste tu contraseña?</a>
            </div>
            <button type="submit" name="login">Iniciar Sesión</button>
        </form>

        <form id="registration-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" style="display: none;">
            <div class="form-group">
                <label for="new_username">Nombre de usuario</label>
                <input type="text" id="new_username" name="new_username" placeholder="Ingresa un nuevo usuario" required>
            </div>
            <div class="form-group">
                <label for="new_password">Contraseña</label>
                <input type="password" id="new_password" name="new_password" placeholder="Ingresa una nueva contraseña" required>
            </div>
            <div class="form-group">
                <label for="new_email">Correo electrónico</label>
                <input type="email" id="new_email" name="new_email" placeholder="Ingresa tu correo electrónico" required>
            </div>
            <button type="submit" name="register">Registrarme</button>
        </form>
    </div>
</body>
</html>
