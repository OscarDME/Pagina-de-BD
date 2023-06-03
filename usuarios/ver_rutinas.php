<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles_u.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Usuario</title>
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
                                    <ul class="collapse nav flex-column ms-1" id="submenu1" data-bs-parent="#menu">
                                        <li class="w-100">
                                            <a href="ver_rutinas.php" class="nav-link px-0"> <span
                                                    class="d-none d-sm-inline">Ver rutinas</span></a>
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
                                        <hr class="dropd own-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="../logout.php">Sign out</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col py-3">
                        <h3>Rutinas</h3>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                require '../database.php';
                                $sql = "SELECT * FROM rutina";
                                $stmt = $conn->prepare($sql);
                                $stmt->execute();
                                $rutinas = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($rutinas as $rutina) {
                                    echo '<tr>';
                                    echo '<td>' . $rutina['id_rutina'] . '</td>';
                                    echo '<td>' . $rutina['nombre'] . '</td>';
                                    echo '</tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                        <div class="row align-items-center">
                            <div class="mt-4">
                                <h3>Ejercicios de Rutina</h3>
                                <form method="post" action="">
                                    <div class="mb-3">
                                        <label for="selectRutina" class="form-label">Selecciona una rutina:</label>
                                        <select name="rutina" id="selectRutina" class="form-select">
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
                                    <button type="submit" name="mostrarEjercicios" class="btn btn-primary">Mostrar
                                        Ejercicios</button>
                                </form>
                                <?php
                                if (isset($_POST['mostrarEjercicios'])) {
                                    $rutinaId = $_POST['rutina'];
                                    $sql = "SELECT * FROM realiza
                INNER JOIN ejercicio ON realiza.fk_ejercicio = ejercicio.id_ejercicio
                WHERE realiza.fk_rutina = :rutinaId";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->bindParam(':rutinaId', $rutinaId);
                                    $stmt->execute();
                                    $ejercicios = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                    if (count($ejercicios) > 0) {
                                        echo '<table class="table table-striped mt-4">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Repeticiones</th>
                            <th>Series</th>
                        </tr>
                    </thead>
                    <tbody>';
                                        foreach ($ejercicios as $ejercicio) {
                                            echo '<tr>';
                                            echo '<td>' . $ejercicio['nombre'] . '</td>';
                                            echo '<td>' . $ejercicio['repeticiones'] . '</td>';
                                            echo '<td>' . $ejercicio['series'] . '</td>';
                                            echo '</tr>';
                                        }
                                        echo '</tbody></table>';
                                    } else {
                                        echo '<p>No hay ejercicios disponibles para esta rutina.</p>';
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>