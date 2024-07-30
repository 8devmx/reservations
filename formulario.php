<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"/>
    <title>Formulario de Reservación</title>
</head>
<body>
<div class="container mt-5">
    <h2>Formulario de Reservación</h2>
    <form action="procesar_formulario.php" method="POST">
        <div class="mb-3">
            <label for="titulo" class="form-label">Titulo</label>
            <input type="text" class="form-control" id="titulo" name="titulo" required>
        </div>
        <div class="mb-3">
            <label for="horaEntrada" class="form-label">Hora de Entrada</label>
            <input type="time" class="form-control" id="horaEntrada" name="horaEntrada" required>
        </div>
        <div class="mb-3">
            <label for="horaFin" class="form-label">Hora de Fin</label>
            <input type="time" class="form-control" id="horaFin" name="horaFin" required>
        </div>
        <input type="hidden" id="fecha" name="fecha" value="<?php echo htmlspecialchars($_GET['fecha']); ?>">
        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>