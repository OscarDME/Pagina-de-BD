<?php
session_start();

if (isset($_SESSION['id_usuario'])) {
  header("Location: main.php");
}
require 'database.php';

if (!empty($_POST['email']) && !empty($_POST['password'])) {
    $records = $conn->prepare('SELECT id_usuario, email, password FROM usuario WHERE email = :email');
    $records->bindParam(':email', $_POST['email']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);
    if ( $results !== false && count($results) > 0 && password_verify($_POST['password'], $results['password'])) {
        $_SESSION['id_usuario'] = $results['id_usuario'];
        header("Location: main.php");
      } else {
        $message = 'Algo fue mal ingresado';
      }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/styles_login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Ingreso</title>
</head>
<body>
<?php require 'header.php' ?>
<?php if(!empty($message)): ?>
  <p> <?= $message ?></p>
<?php endif; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <div class="container-fluid d-flex align-items-center justify-content-center h-100">
        <div class="border p-4 contenedor-login">
            <h3 class="text-center mb-4">Iniciar sesión</h3>
            <form action="login.php" method="POST">
                <div class="mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Correo electrónico" required>
                </div>
                <div class="mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
                </div>
                <button type="submit" value="submit" class="btn btn-primary btn-block" href="Inicio de sesion exitoso">Ingresar</button>
                <br>
                <a class="cambio "href="registro.php">¿Deseas registrarte?</a>
            </form>
        </div>
    </div>
</body>
</html>