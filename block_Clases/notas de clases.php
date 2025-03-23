<?php
session_start();

if (!isset($_SESSION['notas'])) {
    $_SESSION['notas'] = [];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['nota'])) {
    $_SESSION['notas'][] = htmlspecialchars($_POST['nota']);
}

if (isset($_GET['borrar'])) {
    unset($_SESSION['notas'][$_GET['borrar']]);
    $_SESSION['notas'] = array_values($_SESSION['notas']); 
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notas de clases</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #dcb9b6;
            margin: 0;
            padding: 20px;
        }

        .cuaderno {
            background-color:rgb(255, 255, 255);
            padding: 20px;
            border: 1px solidrgb(220, 187, 184);
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            max-width: 600px;
            margin: auto;
        }

        h1 {
            text-align: center;
            color: #6f3c49;
        }

        textarea {
            width: 100%;
            height: 200px;
            border: 1px solidrgb  rgba(202, 182, 220);
            border-radius: 5px;
            padding: 10px;
            box-sizing: border-box;
            background-image: linear-gradient(white 30%,rgb(236, 225, 222) 70%);
            background-size: 100% 25px;
            background-repeat: repeat-y;
            font-family: 'Courier New', Courier, monospace;
            resize: none;
            color: #6f3c49;
        }

        button {
            background-color: #c36875;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 15px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
            display: block;
            width: 100%;
        }

        button:hover {
            background-color: #808a7a;
        }

        .nota {
            background-color: #c36875;
            border: 1px solid #647765;
            border-radius: 5px;
            padding: 10px;
            margin: 10px 0;
            color: #436070;
        }

        .borrar {
            color: #c36875;
            cursor: pointer;
            float: right;
        }

        .borrar:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="cuaderno">
    <h1>Notas de clases</h1>
    <form method="post">
        <textarea name="nota" placeholder="Escribe tu nota aquí..."></textarea>
        <button type="submit">Guardar Nota</button>
    </form>

    <h2>Notas Guardadas</h2>
    <?php if (!empty($_SESSION['notas'])): ?>
        <?php foreach ($_SESSION['notas'] as $index => $nota): ?>
            <div class="nota">
                <p><?php echo $nota; ?></p>
                <a href="?borrar=<?php echo $index; ?>" class="borrar">Borrar</a>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No hay notas guardadas.</p>
    <?php endif; ?>
</div>

</body>
</html>
