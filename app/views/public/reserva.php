<?php
$error = isset($_GET['error']) ? $_GET['error'] : null;
$success = isset($_GET['success']) ? $_GET['success'] : null;
$fecha = isset($_GET['fecha']) ? $_GET['fecha'] : '';
$hora = isset($_GET['hora']) ? $_GET['hora'] : '';
$comensales = isset($_GET['comensales']) ? $_GET['comensales'] : '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservar Restaurante</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">El Tenedor 4V</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Realiza tu reserva</h2>

        <?php
        if ($error) {
            echo "<div class='alert alert-danger' role='alert'>";
            if ($error == 'fechaInvalida') {
                echo "La fecha seleccionada debe ser posterior al día de hoy.";
            } elseif ($error == 'horaInvalida') {
                echo "La hora debe ser '14:00' o '21:00'.";
            } elseif ($error == 'comensalesInvalidos') {
                echo "El número de comensales es inválido";
            } elseif ($error == 'dbError') {
                echo "Hubo un error al registrar la reserva. Intenta de nuevo.";
            }
            echo "</div>";
        }

        if ($success) {
            echo "<div class='alert alert-success' role='alert'>¡Reserva realizada con éxito!</div>";
        }
        ?>

        <!-- Formulario de Reserva -->
        <form method="POST" action="../../controllers/ReservaController.php">
            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha de la reserva</label>
                <input type="date" class="form-control <?php echo ($error == 'fechaInvalida') ? 'is-invalid' : ''; ?>" id="fecha" name="fecha" value="<?php echo htmlspecialchars($fecha); ?>" required>
                <?php if ($error == 'fechaInvalida'): ?>
                    <div class="invalid-feedback">La fecha seleccionada debe ser posterior al día de hoy.</div>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="hora" class="form-label">Hora de la reserva</label>
                <select class="form-select <?php echo ($error == 'horaInvalida') ? 'is-invalid' : ''; ?>" id="hora" name="hora" required>
                    <option value="14:00" <?php echo ($hora == '14:00') ? 'selected' : ''; ?>>14:00</option>
                    <option value="21:00" <?php echo ($hora == '21:00') ? 'selected' : ''; ?>>21:00</option>
                </select>
                <?php if ($error == 'horaInvalida'): ?>
                    <div class="invalid-feedback">La hora debe ser '14:00' o '21:00'.</div>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="comensales" class="form-label">Número de comensales</label>
                <input type="number" class="form-control <?php echo ($error == 'comensalesInvalidos') ? 'is-invalid' : ''; ?>" id="comensales" name="comensales" value="<?php echo htmlspecialchars($comensales); ?>" min="1" required>
                <?php if ($error == 'comensalesInvalidos'): ?>
                    <div class="invalid-feedback">El número de comensales debe ser un número positivo y menor a 30 .</div>
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary">Realizar reserva</button>
        </form>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>
