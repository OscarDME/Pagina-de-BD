<?php session_start(); ?>
<?php
require '../database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nuevoEmail = $_POST['nuevo_email'];
    $nuevoSexo = $_POST['nuevo_sexo'];
    $nuevaEstatura = $_POST['nueva_estatura'];
    $nuevoPeso = $_POST['nuevo_peso'];

    require '../database.php';

    $sql = "UPDATE usuario SET ";

    $updateFields = array();
    $params = array();

    if (!empty($nuevoEmail)) {
        $updateFields[] = "email = :email";
        $params[':email'] = $nuevoEmail;
    }
    if (!empty($nuevoSexo)) {
        $updateFields[] = "sexo = :sexo";
        $params[':sexo'] = $nuevoSexo;
    }
    if (!empty($nuevaEstatura)) {
        $updateFields[] = "estatura = :estatura";
        $params[':estatura'] = $nuevaEstatura;
    }
    if (!empty($nuevoPeso)) {
        $updateFields[] = "peso = :peso";
        $params[':peso'] = $nuevoPeso;
    }

    if (empty($updateFields)) {
        header('Location: perfil.php');
        exit();
    }

    $sql .= implode(", ", $updateFields);
    $sql .= " WHERE id_usuario = :id_usuario";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_usuario', $_SESSION['id_usuario']);
    
    $keys = array_keys($params);
    for ($i = 0; $i < count($keys); $i++) {
        $stmt->bindParam($keys[$i], $params[$keys[$i]]);
    }

    if ($stmt->execute()) {
        // Redirigir al perfil después de la actualización exitosa
        header('Location: perfil.php');
        exit();
    } else {
        // Manejar el error en caso de que la actualización falle
        echo "Error al actualizar el perfil. Por favor, inténtalo de nuevo.";
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
                                    <a href="#" class="nav-link px-0 align-middle">
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
                                    <li><a class="dropdown-item" href="perfil.php">Perfil</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="../logout.php">Sign out</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col py-3">
                        <div class="container-fluid contenedorp border">
                            <div class="row align-items-start">
                                <div class="col">
                                    <h2>Usuario:
                                        <?php echo $_SESSION['id_usuario'] ?>
                                    </h2>
                                    <table class="table">
                                        <tbody>
                                            <?php
                                            require '../database.php';
                                            $sql = "SELECT email, sexo, estatura, fecha_nacimiento, tipo_usuario, peso FROM usuario WHERE id_usuario= '{$_SESSION['id_usuario']}'";
                                            $result = $conn->query($sql);
                                            $row = $result->fetch(PDO::FETCH_ASSOC);

                                            $fechaNacimiento = new DateTime($row['fecha_nacimiento']);
                                            $hoy = new DateTime();
                                            $edad = $fechaNacimiento->diff($hoy)->y;

                                            echo "<tr>
        <td>Email:</td>
        <td>" . $row['email'] . "</td>
        <td>
            <form action='perfil.php' method='POST'>
                <input type='hidden' name='campo' value='email'>
                <input type='text' name='nuevo_email'>
                <button type='submit' class='btn btn-primary'>Modificar</button>
            </form>
        </td>
    </tr>";
                                            echo "<tr>
    <td>Sexo:</td>
    <td>" . ($row['sexo'] == 'H' ? 'Hombre' : 'Mujer') . "</td>
    <td>
        <form action='perfil.php' method='POST'>
            <input type='hidden' name='campo' value='sexo'>
            <select name='nuevo_sexo'>
                <option value='H'>Hombre</option>
                <option value='M'>Mujer</option>
            </select>
            <button type='submit' class='btn btn-primary'>Modificar</button>
        </form>
    </td>
</tr>";

                                            echo "<tr>
    <td>Estatura:</td>
    <td>" . $row['estatura'] . "cm</td>
    <td>
        <form action='perfil.php' method='POST'>
            <input type='hidden' name='campo' value='estatura'>
            <input type='text' name='nueva_estatura'>
            <button type='submit' class='btn btn-primary'>Modificar</button>
        </form>
    </td>
</tr>";
                                            echo "<tr>
                                                    <td>Edad:</td>
                                                    <td>" . $edad . " años</td>
                                                    <td></td>
                                                </tr>";
                                                echo "<tr>
                                                <td>Peso:</td>
                                                <td>" . $row['peso'] . "kg</td>
                                                <td>
                                                    <form action='perfil.php' method='POST'>
                                                        <input type='hidden' name='campo' value='peso'>
                                                        <input type='text' name='nuevo_peso'>
                                                        <button type='submit' class='btn btn-primary'>Modificar</button>
                                                    </form>
                                                </td>
                                            </tr>";
                                            echo "<tr>
                                                    <td>Tipo de usuario:</td>
                                                    <td>" . ($row['tipo_usuario'] == 1 ? 'Usuario' : 'Administrador') . "</td>
                                                    <td></td>
                                                </tr>";
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col py-3">
                    <img class="img-fluid" src="../assets/img/imagen2.jpg" alt="nada">
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</body>

</html>