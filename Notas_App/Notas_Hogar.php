<?php
$notasDir = 'notas/';
if (!is_dir($notasDir)) {
    mkdir($notasDir);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lunes = $_POST['lunes'];
    $martes = $_POST['martes'];
    $miercoles = $_POST['miercoles'];
    $jueves = $_POST['jueves'];
    $viernes = $_POST['viernes'];
    $objetivos = $_POST['objetivos'];
    $notas = $_POST['notas'];

    $svgContent = generateWeeklyPlanner($lunes, $martes, $miercoles, $jueves, $viernes, $objetivos, $notas);
    file_put_contents('weekly-planner.svg', $svgContent);
}

$notasGuardadas = array_diff(scandir($notasDir), array('..', '.'));

function generateWeeklyPlanner($lunes, $martes, $miercoles, $jueves, $viernes, $objetivos, $notas)
{
    $template = '<?xml version="1.0" encoding="UTF-8"?>
    <svg width="600" height="800" viewBox="0 0 600 800" xmlns="http://www.w3.org/2000/svg">
        <rect x="20" y="20" width="560" height="760" fill="#DFF6F0" />
        <text x="30" y="50" font-size="24" font-weight="bold" fill="#007B5F">Planificador Semanal</text>
        
        <rect x="30" y="80" width="540" height="80" fill="#B2E0D5" />
        <text x="40" y="120" font-size="18" fill="#004D40">%s</text>
        
        <rect x="30" y="180" width="540" height="80" fill="#D1F2EB" />
        <text x="40" y="220" font-size="18" fill="#004D40">%s</text>
        
        <rect x="30" y="280" width="540" height="80" fill="#B2E0D5" />
        <text x="40" y="320" font-size="18" fill="#004D40">%s</text>
        
        <rect x="30" y="380" width="540" height="80" fill="#D1F2EB" />
        <text x="40" y="420" font-size="18" fill="#004D40">%s</text>
        
        <rect x="30" y="480" width="540" height="80" fill="#B2E0D5" />
        <text x="40" y="520" font-size="18" fill="#004D40">%s</text>
        
        <rect x="30" y="580" width="540" height="80" fill="#D1F2EB" />
        <text x="40" y="620" font-size="18" fill="#004D40">%s</text>
        
        <rect x="30" y="680" width="540" height="80" fill="#B2E0D5" />
        <text x="40" y="720" font-size="18" fill="#004D40">%s</text>
    </svg>';

    return sprintf($template, $lunes, $martes, $miercoles, $jueves, $viernes, $objetivos, $notas);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notas para el Hogar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 70px;
            background-color:rgba(0, 0, 0, 0.69);
        }
        .container {
            display: flex;
            justify-content: space-between;
            gap: 18px;
        }
        .form-column,
        .planner-column {
            background-color: white;
            padding: 50px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            flex: 1;
        }
        form {
            margin-bottom: 20px;
        }
        textarea {
            width: 100%;
            height: 80px;
            margin-bottom: 10px;
            border: 1px solid #007B5F;
            border-radius: 4px;
            background-color: #E8F5E9; 
        }
        #weekly-planner {
            max-width: 100%;
            margin: 0 auto;
            background-color: #B2E0D5; 
            padding: 10px;
            border-radius: 8px;
        }
        .title {
            font-family: 'Pacifico', cursive;
            color: #007B5F;
            text-align: center;
            margin-bottom: 20px;
        }
        button {
            background-color: #007B5F;
            color: white; 
            border: none;
            border-radius: 4px;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #005f47; 
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="form-column">
            <h1 class="title">NOTAS DE MI HOGAR</h1>
            <form method="POST" action="">
                <label for="lunes">Lunes:</label>
                <textarea id="lunes" name="lunes"><?php echo isset($_POST['lunes']) ? $_POST['lunes'] : ''; ?></textarea>

                <label for="martes">Martes:</label>
                <textarea id="martes" name="martes"><?php echo isset($_POST['martes']) ? $_POST['martes'] : ''; ?></textarea>

                <label for="miercoles">Miércoles:</label>
                <textarea id="miercoles" name="miercoles"><?php echo isset($_POST['miercoles']) ? $_POST['miercoles'] : ''; ?></textarea>

                <label for="jueves">Jueves:</label>
                <textarea id="jueves" name="jueves"><?php echo isset($_POST['jueves']) ? $_POST['jueves'] : ''; ?></textarea>

                <label for="viernes">Viernes:</label>
                <textarea id="viernes" name="viernes"><?php echo isset($_POST['viernes']) ? $_POST['viernes'] : ''; ?></textarea>

                <label for="objetivos">Objetivos:</label>
                <textarea id="objetivos" name="objetivos"><?php echo isset($_POST['objetivos']) ? $_POST['objetivos'] : ''; ?></textarea>

                <label for="notas">Notas:</label>
                <textarea id="notas" name="notas"><?php echo isset($_POST['notas']) ? $_POST['notas'] : ''; ?></textarea>

                <button type="submit">Guardar Planificador</button>
            </form>
        </div>
        <div class="planner-column">
            <div id="weekly-planner">
                <?php
                if (file_exists('weekly-planner.svg')) {
                    echo file_get_contents('weekly-planner.svg');
                } else {
                    echo generateWeeklyPlanner('Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Objetivos', 'Notas');
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
