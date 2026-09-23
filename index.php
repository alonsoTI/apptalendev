<?php
session_start();

// Crear arreglo de alumnos si todavía no existe
if (!isset($_SESSION['alumnos'])) {
    $_SESSION['alumnos'] = [];
}

// Registrar alumno
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nombre = trim($_POST['nombre'] ?? '');
    $correo = trim($_POST['correo'] ?? '');
    $carrera = trim($_POST['carrera'] ?? '');

    if ($nombre !== '' && $correo !== '' && $carrera !== '') {

        $_SESSION['alumnos'][] = [
            'nombre' => $nombre,
            'correo' => $correo,
            'carrera' => $carrera
        ];

        // Evita volver a enviar el formulario al recargar
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}

// Limpiar registros
if (isset($_GET['accion']) && $_GET['accion'] === 'limpiar') {
    $_SESSION['alumnos'] = [];

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Registro de estudiantes - Talendev</title>

    <!-- Bootstrap -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>

<body class="bg-light">

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-8">

            <div class="card shadow-sm">

                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        Registro de Alumnos
                    </h4>
                </div>

                <div class="card-body">

                    <!-- FORMULARIO -->

                    <form method="POST" id="formAlumno">

                        <div class="row g-3">

                            <div class="col-md-4">
                                <label class="form-label">
                                    Nombre
                                </label>

                                <input
                                    type="text"
                                    name="nombre"
                                    id="nombre"
                                    class="form-control"
                                    placeholder="Ej. Juan Pérez"
                                >
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">
                                    Correo
                                </label>

                                <input
                                    type="email"
                                    name="correo"
                                    id="correo"
                                    class="form-control"
                                    placeholder="correo@ejemplo.com"
                                >
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">
                                    Carrera
                                </label>

                                <input
                                    type="text"
                                    name="carrera"
                                    id="carrera"
                                    class="form-control"
                                    placeholder="Ingeniería de Sistemas"
                                >
                            </div>

                        </div>

                        <div
                            id="mensaje"
                            class="alert alert-danger mt-3 d-none">
                        </div>

                        <div class="mt-4">

                            <button
                                type="submit"
                                class="btn btn-primary">

                                Registrar alumno
                            </button>

                            <a
                                href="?accion=limpiar"
                                class="btn btn-outline-danger">

                                Limpiar tabla
                            </a>

                        </div>

                    </form>

                </div>
            </div>


            <!-- TABLA -->

            <div class="card shadow-sm mt-4">

                <div class="card-header">
                    <h5 class="mb-0">
                        Alumnos registrados
                    </h5>
                </div>

                <div class="card-body p-0">

                    <div class="table-responsive">

                        <table class="table table-striped table-hover mb-0">

                            <thead class="table-dark">

                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Correo</th>
                                    <th>Carrera</th>
                                </tr>

                            </thead>

                            <tbody>

                            <?php if (count($_SESSION['alumnos']) > 0): ?>

                                <?php foreach ($_SESSION['alumnos'] as $indice => $alumno): ?>

                                    <tr>

                                        <td>
                                            <?= $indice + 1 ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($alumno['nombre']) ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($alumno['correo']) ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($alumno['carrera']) ?>
                                        </td>

                                    </tr>

                                <?php endforeach; ?>

                            <?php else: ?>

                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">
                                        No hay alumnos registrados.
                                    </td>
                                </tr>

                            <?php endif; ?>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


<script>

$(document).ready(function () {

    $("#formAlumno").submit(function (event) {

        let nombre = $("#nombre").val().trim();
        let correo = $("#correo").val().trim();
        let carrera = $("#carrera").val().trim();

        // Validar campos
        if (
            nombre === "" ||
            correo === "" ||
            carrera === ""
        ) {

            event.preventDefault();

            $("#mensaje")
                .removeClass("d-none")
                .text("Por favor, completa todos los campos.");

            return false;
        }

        $("#mensaje").addClass("d-none");

    });

});

</script>


<!-- Bootstrap JS -->
<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js">
</script>

</body>
</html>
