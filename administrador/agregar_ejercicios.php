<?php
session_start();
require '../database.php';
$mensajeEquipo = "";
$mensajeMusculo = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['equipo'])) {
        $equipo = $_POST['equipo'];
        $sql = "INSERT INTO equipo values (NULL, :equipo)";
        try {
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':equipo', $equipo);
            $stmt->execute();
            $mensajeEquipo = "Equipo agregado correctamente.";
            header("Location: agregar_ejercicios.php");
            exit();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    if (isset($_POST['musculo'])) {
        $musculo = $_POST['musculo'];
        $sql = "INSERT INTO grupo_muscular values (NULL, :musculo)";
        try {
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':musculo', $musculo);
            $stmt->execute();
            $mensajeMusculo = "Musculo agregado correctamente.";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        header("Location: agregar_ejercicios.php");
        exit();
    }
    if (isset($_POST['ejercicio'])) {
        $ejercicio = $_POST['ejercicio'];
        $eMusculo = $_POST['eMusculo'];
        $eEquipo = $_POST['eEquipo'];
        $sql = "INSERT INTO ejercicio values (NULL, :ejercicio, :eMusculo, :eEquipo)";
        try {
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':ejercicio', $ejercicio);
            $stmt->bindParam(':eMusculo', $eMusculo);
            $stmt->bindParam(':eEquipo', $eEquipo);
            $stmt->execute();
            $mensajeMusculo = "Musculo agregado correctamente.";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        header("Location: agregar_ejercicios.php");
        exit();
    }
    if (isset($_POST['eliminar_musculo'])) {
        $idMusculo = $_POST['id_musculo'];
        $sql = "DELETE FROM grupo_muscular WHERE id_musculo = :id_musculo";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_musculo', $idMusculo);
        $stmt->execute();

        header("Location: agregar_ejercicios.php");
        exit();
    }
    if (isset($_POST['eliminar_equipo'])) {
        $idEquipo = $_POST['id_equipo'];
        $sql = "DELETE FROM equipo WHERE id_equipo = :id_equipo";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_equipo', $idEquipo);
        $stmt->execute();

        header("Location: agregar_ejercicios.php");
        exit();
    }
    if (isset($_POST['eliminar_ejercicio'])) {
        $idEjercicio = $_POST['id_ejercicio'];
        $sql = "DELETE FROM ejercicio WHERE id_ejercicio = :id_ejercicio";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_ejercicio', $idEjercicio);
        $stmt->execute();

        header("Location: agregar_ejercicios.php");
        exit();
    }
    if (isset($_POST['modificar_ejercicio'])) {
        $idEjercicio = $_POST['id_ejercicio'];
        $nombreEjercicio = $_POST['nombre_ejercicio'];
        $fkMusculo = $_POST['fk_musculo'];
        $fkEquipo = $_POST['fk_equipo'];

        if ($nombreEjercicio === "") {
            $sql = "SELECT nombre FROM ejercicio WHERE id_ejercicio = :id_ejercicio";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id_ejercicio', $idEjercicio);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            $nombreEjercicio = $resultado['nombre'];
        }

        if ($fkMusculo === "NULL") {
            $sql = "SELECT fk_musculo FROM ejercicio WHERE id_ejercicio = :id_ejercicio";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id_ejercicio', $idEjercicio);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            $fkMusculo = $resultado['fk_musculo'];
        }

        if ($fkEquipo === "NULL") {
            $sql = "SELECT fk_equipo FROM ejercicio WHERE id_ejercicio = :id_ejercicio";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id_ejercicio', $idEjercicio);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            $fkEquipo = $resultado['fk_equipo'];
        }

        $sql = "UPDATE ejercicio SET nombre = :nombre, fk_musculo = :fk_musculo, fk_equipo = :fk_equipo WHERE id_ejercicio = :id_ejercicio";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nombre', $nombreEjercicio);
        $stmt->bindParam(':fk_musculo', $fkMusculo);
        $stmt->bindParam(':fk_equipo', $fkEquipo);
        $stmt->bindParam(':id_ejercicio', $idEjercicio);
        $stmt->execute();

        header("Location: agregar_ejercicios.php");
        exit();
    }
    if (isset($_POST['modificar_musculo'])) {
        $idMusculo = $_POST['id_musculo'];
        $nombreMusculo = $_POST['nombre_musculo'];
    
        if ($nombreMusculo === "") {
            $sql = "SELECT nombre FROM grupo_muscular WHERE id_musculo = :id_musculo";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id_musculo', $idMusculo);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            $nombreMusculo = $resultado['nombre'];
        }
        $sql = "UPDATE grupo_muscular SET nombre = :nombre WHERE id_musculo = :id_musculo";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nombre', $nombreMusculo);
        $stmt->bindParam(':id_musculo', $idMusculo);
        $stmt->execute();
    
        header("Location: agregar_ejercicios.php");
        exit();
    }
    if (isset($_POST['modificar_equipo'])) {
        $idEquipo = $_POST['id_equipo'];
        $nombreEquipo = $_POST['nombre_equipo'];
    
        if ($nombreEquipo === "") {
            $sql = "SELECT nombre FROM equipo WHERE id_equipo = :id_equipo";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id_equipo', $idEquipo);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            $nombreEquipo = $resultado['nombre'];
        }
    
        $sql = "UPDATE equipo SET nombre = :nombre WHERE id_equipo = :id_equipo";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nombre', $nombreEquipo);
        $stmt->bindParam(':id_equipo', $idEquipo);
        $stmt->execute();
    
        header("Location: agregar_ejercicios.php");
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
                                    <ul class="collapse nav flex-column ms-1" id="submenu1" data-bs-parent="#menu">
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
                        <div class="container-fluid">
                            <div class="row align-items-start">
                                <div class="col">
                                    <form action="agregar_ejercicios.php" method="POST">
                                        <h3>Agregar equipo:</h3>
                                        <div class="mb-3">
                                            <input class="form-control" type="text" name="equipo"
                                                placeholder="Nombre del material">
                                        </div>
                                        <button type="submit" value="Submit" class="btn btn-primary btn-block"
                                            href="#">Insertar</button>
                                    </form>
                                </div>
                                <div class="col">
                                    <form action="agregar_ejercicios.php" method="POST">
                                        <h3>Agregar grupo muscular:</h3>
                                        <div class="mb-3">
                                            <input class="form-control" type="text" name="musculo"
                                                placeholder="Nombre del musculo">
                                        </div>
                                        <button type="submit" value="Submit" class="btn btn-primary btn-block"
                                            href="#">Insertar</button>
                                    </form>
                                </div>
                                <div class="row align-items-center">
                                    <h3>Agregar ejercicio:</h3>
                                    <form action="agregar_ejercicios.php" method="POST">
                                        <div class="mb-3">
                                            <input class="form-control" type="text" name="ejercicio"
                                                placeholder="Nombre del ejercicio">
                                        </div>
                                        <div class="mb-3">
                                            <label for="musculo">Seleccionar músculo:</label>
                                            <select class="form-control" name="eMusculo" id="musculo">
                                                <?php
                                                $sql = "SELECT * FROM grupo_muscular";
                                                $stmt = $conn->prepare($sql);
                                                $stmt->execute();
                                                $musculos = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                                foreach ($musculos as $musculo) {
                                                    echo '<option value="' . $musculo['id_musculo'] . '">' . $musculo['nombre'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="equipo">Seleccionar equipo:</label>
                                            <select class="form-control" name="eEquipo" id="equipo">
                                                <?php
                                                $sql = "SELECT * FROM equipo";
                                                $stmt = $conn->prepare($sql);
                                                $stmt->execute();
                                                $equipos = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                                foreach ($equipos as $equipo) {
                                                    echo '<option value="' . $equipo['id_equipo'] . '">' . $equipo['nombre'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <button type="submit" value="Submit" class="btn btn-primary btn-block"
                                            href="#">Insertar</button>
                                    </form>
                                </div>
                                <div class="row align-items-center">
                                    <h3>Grupos Musculares</h3>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <?php
                                                $sql = "SELECT * FROM grupo_muscular";
                                                $stmt = $conn->prepare($sql);
                                                $stmt->execute();
                                                $grupo_musculares = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                                ?>
                                                <th>ID</th>
                                                <th>Nombre</th>
                                                <th>Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($grupo_musculares as $grupo_muscular) { ?>
                                                <tr>
                                                    <td>
                                                        <?php echo $grupo_muscular['id_musculo']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $grupo_muscular['nombre']; ?>
                                                    </td>
                                                    <td>
                                                        <form action="agregar_ejercicios.php" method="POST">
                                                            <input type="hidden" name="id_musculo"
                                                                value="<?php echo $grupo_muscular['id_musculo']; ?>">
                                                            <button type="submit" name="eliminar_musculo"
                                                                class="btn btn-danger btn-sm">Eliminar</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                    <h3>Ejercicios</h3>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <?php
                                                $sql = "SELECT * FROM ejercicio";
                                                $stmt = $conn->prepare($sql);
                                                $stmt->execute();
                                                $ejercicios = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                                ?>
                                                <th>ID/th>
                                                <th>Nombre</th>
                                                <th>Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($ejercicios as $ejercicio) { ?>
                                                <tr>
                                                    <td>
                                                        <?php echo $ejercicio['id_ejercicio']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $ejercicio['nombre']; ?>
                                                    </td>
                                                    <td>
                                                        <form action="agregar_ejercicios.php" method="POST">
                                                            <input type="hidden" name="id_ejercicio"
                                                                value="<?php echo $ejercicio['id_ejercicio']; ?>">
                                                            <button type="submit" name="eliminar_ejercicio"
                                                                class="btn btn-danger btn-sm">Eliminar</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>

                                    <h3>Equipos</h3>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <?php
                                                $sql = "SELECT * FROM equipo";
                                                $stmt = $conn->prepare($sql);
                                                $stmt->execute();
                                                $equipos = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                                ?>
                                                <th>ID</th>
                                                <th>Equipo</th>
                                                <th>Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($equipos as $equipo) { ?>
                                                <tr>
                                                    <td>
                                                        <?php echo $equipo['id_equipo']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $equipo['nombre']; ?>
                                                    </td>
                                                    <td>
                                                        <form action="agregar_ejercicios.php" method="POST">
                                                            <input type="hidden" name="id_equipo"
                                                                value="<?php echo $equipo['id_equipo']; ?>">
                                                            <button type="submit" name="eliminar_equipo"
                                                                class="btn btn-danger btn-sm">Eliminar</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row align-items-start">
                                    <div class="col py-3">
                                        <div class="container">
                                            <h3>Modificar Grupo Muscular</h3>
                                            <form action="agregar_ejercicios.php" method="POST">
                                                <div class="form-group">
                                                    <label for="id_musculo">ID:</label>
                                                    <input type="text" class="form-control" id="id_musculo"
                                                        name="id_musculo" placeholder="ID del grupo muscular">
                                                </div>
                                                <div class="form-group">
                                                    <label for="nombre_musculo">Nombre:</label>
                                                    <input type="text" class="form-control" id="nombre_musculo"
                                                        name="nombre_musculo" placeholder="Nombre del grupo muscular">
                                                </div>
                                                <button type="submit" name="modificar_musculo"
                                                    class="btn btn-primary">Modificar</button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col py-3">
                                        <div class="container">
                                            <h3>Modificar Equipo</h3>
                                            <form action="agregar_ejercicios.php" method="POST">
                                                <div class="form-group">
                                                    <label for="id_equipo">ID:</label>
                                                    <input type="text" class="form-control" id="id_equipo"
                                                        name="id_equipo" placeholder="ID del equipo">
                                                </div>
                                                <div class="form-group">
                                                    <label for="nombre_equipo">Nombre:</label>
                                                    <input type="text" class="form-control" id="nombre_equipo"
                                                        name="nombre_equipo" placeholder="Nombre del equipo">
                                                </div>
                                                <button type="submit" name="modificar_equipo"
                                                    class="btn btn-primary">Modificar</button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="container">
                                            <h3>Modificar Ejercicio</h3>
                                            <form action="agregar_ejercicios.php" method="POST">
                                                <div class="form-group">
                                                    <label for="id_ejercicio">ID:</label>
                                                    <input type="text" class="form-control" id="id_ejercicio"
                                                        name="id_ejercicio" placeholder="ID del ejercicio">
                                                </div>
                                                <div class="form-group">
                                                    <label for="nombre_ejercicio">Nombre:</label>
                                                    <input type="text" class="form-control" id="nombre_ejercicio"
                                                        name="nombre_ejercicio" placeholder="Nombre del ejercicio">
                                                </div>
                                                <div class="form-group">
                                                    <label for="fk_musculo">Grupo Muscular:</label>
                                                    <select class="form-control" id="fk_musculo" name="fk_musculo">
                                                        <?php
                                                        $sql = "SELECT * FROM grupo_muscular";
                                                        $stmt = $conn->prepare($sql);
                                                        $stmt->execute();
                                                        $grupo_musculares = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                                        foreach ($grupo_musculares as $grupo_muscular) {
                                                            echo '<option value="' . $grupo_muscular['id_musculo'] . '">' . $grupo_muscular['nombre'] . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="fk_equipo">Equipo:</label>
                                                    <select class="form-control" id="fk_equipo" name="fk_equipo">
                                                        <?php
                                                        $sql = "SELECT * FROM equipo";
                                                        $stmt = $conn->prepare($sql);
                                                        $stmt->execute();
                                                        $equipos = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                                        foreach ($equipos as $equipo) {
                                                            echo '<option value="' . $equipo['id_equipo'] . '">' . $equipo['nombre'] . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <button type="submit" name="modificar_ejercicio"
                                                    class="btn btn-primary">Modificar</button>
                                            </form>
                                        </div>

                                    </div>
                                </div>
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