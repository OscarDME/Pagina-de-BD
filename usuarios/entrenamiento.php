<?php session_start(); ?>
<?php require '../database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['entrenamiento'])) {
        $rutina = $_POST['rutina'];
        $usuario = $_SESSION['id_usuario'];
        $fecha = $_POST['fecha'];
        $sql = "INSERT INTO entrenamiento values (NULL, :fecha, :usuario, :rutina)";
        try {
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':fecha', $fecha);
            $stmt->bindParam(':usuario', $usuario);
            $stmt->bindParam(':rutina', $rutina);
            $stmt->execute();
            $mensajeEquipo = "Entrenamiento agregado correctamente.";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        header("Location: entrenamiento.php");
        exit();
    } elseif (isset($_POST['eliminar'])) {
        $idEntrenamiento = $_POST['eliminar'];
        $sql = "DELETE FROM entrenamiento WHERE id_entrenamiento = :idEntrenamiento";
        try {
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':idEntrenamiento', $idEntrenamiento);
            $stmt->execute();
            $mensajeEquipo = "Entrenamiento eliminado correctamente.";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        header("Location: entrenamiento.php");
        exit();
    } else if (isset($_POST['modificar'])) {
        $idEntrenamiento = $_POST['id_entrenamiento'];
        $fecha = $_POST['fecha'];
        $rutina = $_POST['rutina'];
        $usuario = $_SESSION['id_usuario'];

        $sql = "SELECT fk_usuario FROM entrenamiento WHERE id_entrenamiento = :idEntrenamiento";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':idEntrenamiento', $idEntrenamiento);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result && $result['fk_usuario'] === $_SESSION['id_usuario']) {
            $sql = "UPDATE entrenamiento SET ";
            $params = [];

            if ($fecha !== null) {
                $sql .= "fecha = :fecha, ";
                $params[':fecha'] = $fecha;
            }

            if ($rutina !== null) {
                $sql .= "fk_rutina = :rutina, ";
                $params[':rutina'] = $rutina;
            }

            $sql = rtrim($sql, ', ');
            $sql .= " WHERE id_entrenamiento = :id AND fk_usuario = :usuario";
            $params[':id'] = $idEntrenamiento;
            $params[':usuario'] = $_SESSION['id_usuario'];

            $stmt = $conn->prepare($sql);
            $stmt->execute($params);

            header('Location: ' . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "No tienes permiso para modificar este entrenamiento.";
            exit();
        }
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
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="../logout.php">Sign out</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row py-3">
                        <div class="col py-3">
                            <form action="entrenamiento.php" method="POST">
                                <h3>Registra tu entrenamiento</h3>
                                <div class="mb-3">
                                    <input class="form-control" type="date" name="fecha"
                                        placeholder="Fecha del entrenamiento">
                                </div>
                                <div class="form-group">
                                    <label for="rutina">Seleccione una rutina:</label>
                                    <select class="form-control" name="rutina" id="rutina">
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
                                <button type="submit" name="entrenamiento" value="Submit"
                                    class="btn btn-primary btn-block" href="#">Insertar</button><br>
                                <div class="row">
                                    <br>
                                </div>
                            </form>
                        </div>
                        <div class="col">
                            <?php
                            ?>
                            <div class="container">
                                <h3>Ultimos entrenamientos</h3>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Rutina</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                            </div>
                            <?php
                            require '../database.php';
                            $sql = "SELECT * FROM entrenamiento_rutina";
                            $stmt = $conn->prepare($sql);
                            $stmt->execute();
                            $entrenamientos = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($entrenamientos as $entrenamiento) {
                                echo '<tr>';
                                echo '<td>' . $entrenamiento['fecha'] . '</td>';
                                echo '<td>' . $entrenamiento['nombre'] . '</td>';
                                echo '</tr>';
                            }
                            ?>
                            </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col container">
                            <h3>Todos tus entrenamientos</h3>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Fecha</th>
                                        <th>Rutina</th>
                                        <th>Usuario</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    require '../database.php';
                                    $usuario = $_SESSION['id_usuario'];
                                    $sql = "SELECT e.id_entrenamiento, e.fecha, r.nombre, e.fk_usuario
                                            FROM entrenamiento e
                                            INNER JOIN rutina r ON e.fk_rutina = r.id_rutina
                                            WHERE e.fk_usuario = :usuario
                                            ORDER BY e.fecha DESC";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->bindParam(':usuario', $usuario);
                                    $stmt->execute();
                                    $entrenamientos = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($entrenamientos as $entrenamiento) {
                                        echo '<tr>';
                                        echo '<td>' . $entrenamiento['id_entrenamiento'] . '</td>';
                                        echo '<td>' . $entrenamiento['fecha'] . '</td>';
                                        echo '<td>' . $entrenamiento['nombre'] . '</td>';
                                        echo '<td>' . $entrenamiento['fk_usuario'] . '</td>';
                                        echo '<td>';
                                        echo '<form action="entrenamiento.php" method="POST" style="display:inline">';
                                        echo '<button type="submit" class="btn btn-primary" name="eliminar" value="' . $entrenamiento['id_entrenamiento'] . '">Eliminar</button>';
                                        echo '</form>';
                                        echo '</td>';
                                        echo '</tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <h3>Modificar entrenamiento</h3>
                            <form action="entrenamiento.php" method="POST">
                                <div class="form-group">
                                    <label for="id_entrenamiento">ID:</label>
                                    <input type="text" class="form-control" id="id_entrenamiento"
                                        name="id_entrenamiento" required>
                                </div>
                                <div class="form-group">
                                    <label for="fecha">Fecha:</label>
                                    <input type="date" class="form-control" id="fecha" name="fecha">
                                </div>
                                <div class="form-group">
                                    <label for="rutina">Rutina:</label>
                                    <select name="rutina" class="form-control">
                                        <?php
                                        foreach ($rutinas as $rutina) {
                                            echo '<option value="' . $rutina['id_rutina'] . '">' . $rutina['nombre'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary" name="modificar">Modificar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
</body>

</html>