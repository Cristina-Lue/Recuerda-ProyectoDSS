<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>En Proceso</title>
</head>
<body>
    <h1>En Proceso</h1>
    <p>Esta página está en proceso de desarrollo.</p>
    <a href="listas.php">Listas</a>

    <form action="logout.php" method="post">
        <button type="submit" name="logout">Cerrar sesión</button>
    </form>
</body>
</html>
