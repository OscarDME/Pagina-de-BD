<?php session_start(); ?>
<?php
require '../database.php';
$mensajeEquipo = "";
$mensajeMusculo = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['rutina'])) {
        $rutina = $_POST['rutina'];
        $sql = "INSERT INTO rutina values (NULL, :rutina)";
        try {
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':rutina', $rutina);
            $stmt->execute();
            $mensajeEquipo = "Rutina agregada correctamente.";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        header("Location: agregar_rutinas.php");
        exit();
    }
    if (isset($_POST['rutina1'])) {
        $rutina1 = $_POST['rutina1'];
        $ejercicio = $_POST['ejercicio'];
        $repeticiones=$_POST['repeticiones'];
        $series=$_POST['series'];
        $sql = "INSERT INTO realiza values (NULL, :repeticiones, :series, :ejercicio, :rutina1)";
        try {
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':rutina1', $rutina1);
            $stmt->bindParam(':repeticiones', $repeticiones);
            $stmt->bindParam(':ejercicio', $ejercicio);
            $stmt->bindParam(':series', $series);
            $stmt->execute();
            $mensajeEquipo = "Rutina agregada correctamente.";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        header("Location: agregar_rutinas.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles_u.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Administrador</title>
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <div class="container-fluid">
        <div class="row align-items-start gutter">
            <!--<div class="col-3 border mb-4">
      
    </div>-->
            <div class="container-fluid">
                <div class="row flex-nowrap">
                    <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
                        <div
                            class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                            <a href="index.php"
                                class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                                <span class="fs-5 d-none d-sm-inline">Menu</span>
                            </a>
                            <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start"
                                id="menu">
                                <li class="nav-item">
                                    <a href="perfil.php" class="nav-link align-middle px-0">
                                        <i class="fs-4 bi-house"></i> <span
                                            class="ms-1 d-none d-sm-inline">Perfil</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#submenu1" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                                        <i class="fs-4 bi-speedometer2"></i> <span
                                            class="ms-1 d-none d-sm-inline">Rutinas</span> </a>
                                    <ul class="collapse show nav flex-column ms-1" id="submenu1" data-bs-parent="#menu">
                                        <li class="w-100">
                                            <a href="ver_rutinas.php" class="nav-link px-0"> <span
                                                    class="d-none d-sm-inline">Ver rutinas</span></a>
                                        </li>
                                        <li>
                                            <a href="agregar_rutinas.php" class="nav-link px-0"> <span
                                                    class="d-none d-sm-inline">Agregar rutinas</span></a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="entrenamiento.php" class="nav-link px-0 align-middle">
                                        <i class="fs-4 bi-table"></i> <span
                                            class="ms-1 d-none d-sm-inline">Entrenamiento</span></a>
                                </li>
                                <li>
                                    <a href="#submenu2" data-bs-toggle="collapse" class="nav-link px-0 align-middle ">
                                        <i class="fs-4 bi-bootstrap"></i> <span
                                            class="ms-1 d-none d-sm-inline">Ejercicios</span></a>
                                    <ul class="collapse nav flex-column ms-1" id="submenu2" data-bs-parent="#menu">
                                        <li class="w-100">
                                            <a href="ver_ejercicios.php" class="nav-link px-0"> <span
                                                    class="d-none d-sm-inline">Ver ejercicios</span></a>
                                        </li>
                                        <li>
                                            <a href="agregar_ejercicios.php" class="nav-link px-0"> <span
                                                    class="d-none d-sm-inline">Agregar ejercicios</span></a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="../logout.php" class="nav-link px-0 align-middle">
                                        <i class="fs-4 bi-people"></i> <span class="ms-1 d-none d-sm-inline">Cerrar
                                            sesion</span> </a>
                                </li>
                            </ul>
                            <hr>
                            <div class="dropdown pb-4">
                                <a href="#"
                                    class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                                    id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="profile.jpg" alt="hugenerd" width="30" height="30" class="rounded-circle">
                                    <span class="d-none d-sm-inline mx-1">
                                        <?php echo $_SESSION['id_usuario']; ?>
                                    </span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                                    <li><a class="dropdown-item" href="#">Perfil</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="../logout.php">Sign out</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col py-3">
                        <div class="col">
                            <h3>Agregar rutina</h3>
                            <form action="agregar_rutinas.php" method="POST">
                                <div class="mb-3">
                                    <input class="form-control" type="text" name="rutina"
                                        placeholder="Nombre de la rutina">
                                </div>
                                <button type="submit" value="Submit" class="btn btn-primary btn-block"
                                    href="#">Insertar</button>
                            </form>
                        </div>
                        <div class="col">
                            <?php
                            require '../database.php';
                            $sql = "SELECT * FROM ejercicio";
                            $stmt = $conn->prepare($sql);
                            $stmt->execute();
                            $ejercicios = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            ?>
                            <form method="POST" action="agregar_rutinas.php">
                                <div class="form-group">
                                    <label for="rutina1">Seleccione una rutina:</label>
                                    <select class="form-control" name="rutina1" id="rutina1">
                                        <?php
                                        $sql = "SELECT * FROM rutina";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->execute();
                                        $rutinas = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($rutinas as $rutina) {
                                            echo '<option value="' . $rutina['id_rutina'] . '">' . $rutina['nombre'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="ejercicio">Seleccione un ejercicio:</label>
                                    <select class="form-control" name="ejercicio" id="ejercicio">
                                        <?php
                                        foreach ($ejercicios as $ejercicio) {
                                            echo '<option value="' . $ejercicio['id_ejercicio'] . '">' . $ejercicio['nombre'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="repeticiones">Repeticiones:</label>
                                    <input type="number" class="form-control" id="repeticiones" name="repeticiones"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="series">Series:</label>
                                    <input type="number" class="form-control" id="series" name="series" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Agregar ejercicio a la rutina</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</body>

</html>