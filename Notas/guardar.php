<?php
session_start();

// Verificar si la sesión de notas está iniciada
if (!isset($_SESSION['notas'])) {
    $_SESSION['notas'] = [];
}

// Guardar o actualizar la nota si se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['titulo']) && !empty($_POST['nota'])) {
    $titulo = htmlspecialchars($_POST['titulo']);
    $nota = htmlspecialchars($_POST['nota']);
    
    if (isset($_POST['index']) && is_numeric($_POST['index'])) {
        // Editar una nota existente
        $_SESSION['notas'][$_POST['index']] = [
            'titulo' => $titulo,
            'nota' => $nota
        ];
    } else {
        // Guardar una nueva nota
        $_SESSION['notas'][] = [
            'titulo' => $titulo,
            'nota' => $nota
        ];
    }
    // Devolvemos el HTML actualizado de las notas guardadas sin recargar la página
    mostrarNotas();
    exit;
}

// Eliminar nota si se solicita
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $index = $_GET['delete'];
    unset($_SESSION['notas'][$index]);
    $_SESSION['notas'] = array_values($_SESSION['notas']);  // Reindexar el array
    // Devolvemos el HTML actualizado de las notas guardadas sin recargar la página
    mostrarNotas();
    exit;
}

// Mostrar las notas guardadas
if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
    $index = $_GET['edit'];
    if (isset($_SESSION['notas'][$index])) {
        echo json_encode($_SESSION['notas'][$index]);
    }
    exit;
}

// Mostrar las notas guardadas (función reutilizable)
function mostrarNotas() {
    if (isset($_SESSION['notas']) && is_array($_SESSION['notas'])) {
        foreach ($_SESSION['notas'] as $index => $nota) {
            if (is_array($nota) && isset($nota['titulo'], $nota['nota'])) {
                // Decodificar los datos antes de mostrarlos
                $titulo = urldecode($nota['titulo']);
                $nota_text = urldecode($nota['nota']);
                
                echo "<div class='nota'>";
                echo "<h3>" . htmlspecialchars($titulo) . "</h3>";
                echo "<p>" . htmlspecialchars($nota_text) . "</p>";
                echo "<button onclick='editarNota($index)' class='btn-editar'>Editar</button>";
                echo "<button onclick='eliminarNota($index)' class='btn-eliminar'>Eliminar</button>";
                echo "</div>";
            }
        }
    } else {
        echo "<p>No hay notas guardadas.</p>";
    }
}
?>
