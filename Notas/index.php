<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Block de Notas</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
</head>
<body>
    <div class="container">
        <h1>Notas</h1>
        <div class="form-group">
            <input type="text" id="titulo" placeholder="Título de la nota" class="input-titulo">
            <textarea id="nota" placeholder="Escribe tu nota aquí..." class="input-nota"></textarea>
            <button onclick="guardarNota()" class="btn-guardar">Guardar Nota</button>
        </div>
        <h2>Notas Guardadas</h2>
        <div id="notasGuardadas" class="notas"></div>
    </div>

    <script>
    let editingIndex = -1;  // Variable para saber si estamos editando una nota

    // Función para guardar una nueva nota o editar una existente
    function guardarNota() {
        const titulo = document.getElementById('titulo').value;
        const nota = document.getElementById('nota').value;
        if (titulo && nota) {
            const formData = new URLSearchParams();
            formData.append('titulo', encodeURIComponent(titulo));
            formData.append('nota', encodeURIComponent(nota));
            if (editingIndex !== -1) {
                formData.append('index', editingIndex); // Agregar el índice de la nota a editar
            }

            fetch('guardar.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                // Solo actualizamos las notas, no el formulario
                document.getElementById('notasGuardadas').innerHTML = data;
                // Limpiamos el formulario
                document.getElementById('titulo').value = ''; 
                document.getElementById('nota').value = ''; 
                editingIndex = -1; // Reiniciar la variable de edición
            });
        } else {
            alert("Por favor, ingrese tanto el título como la nota.");
        }
    }

    // Cargar notas al iniciar
    window.onload = function() {
        fetch('guardar.php')
            .then(response => response.text())
            .then(data => {
                document.getElementById('notasGuardadas').innerHTML = data;
            });
    };

    // Función para editar una nota
    function editarNota(index) {
        fetch('guardar.php?edit=' + index)
            .then(response => response.json())
            .then(data => {
                // Decodificamos los valores antes de asignarlos al formulario
                document.getElementById('titulo').value = decodeURIComponent(data.titulo);
                document.getElementById('nota').value = decodeURIComponent(data.nota);
                editingIndex = index;  // Establecer el índice para editar
            });
    }

    // Función para eliminar una nota
    function eliminarNota(index) {
        if (confirm("¿Estás seguro de que deseas eliminar esta nota?")) {
            fetch('guardar.php?delete=' + index)
                .then(response => response.text())
                .then(data => {
                    // Actualizamos las notas
                    document.getElementById('notasGuardadas').innerHTML = data;
                });
        }
    }
</script>

</body>
</html>
