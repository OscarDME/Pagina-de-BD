<?php
require 'database.php';
$message = '';

if(!empty($_POST['email']) && !empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['peso']) && !empty($_POST['estatura']) && !empty($_POST['fecha'])){
$sql = "INSERT INTO usuario VALUES(:username, :email, :password,  :genero, :peso, :estatura, :fecha)";
$stmt=$conn->prepare($sql);
$stmt->bindParam(':username', $_POST['username']);
$stmt->bindParam(':email', $_POST['email']);
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
$stmt->bindParam(':password', $password);
$stmt->bindParam(':peso', $_POST['peso']);
$stmt->bindParam(':estatura', $_POST['estatura']);
$stmt->bindParam(':fecha', $_POST['fecha']);
$stmt->bindParam(':genero', $_POST['genero']);
if ($stmt->execute()) {
    $message = 'Successfully created new user';
  } else {
    $message = 'Sorry there must have been an issue creating your account';
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
    <title>Registro</title>
</head>
<body>
<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <div class="container d-flex align-items-center justify-content-center h-100">
        <div class="border p-4 contenedor-login">
            <h3 class="text-center mb-4">Registrate</h3>
            <form action="registro.php" method="POST">
                <div class="mb-3">
                    <input type="text" name="username" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                </div>
                <div class="mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Correo electrónico" required>
                </div>
                <div class="mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
                </div>
                <div class="mb-3">
                    <input type="number" name="peso" class="form-control" placeholder="Peso(Kg)" required>
                </div>
                <div class="mb-3">
                    <input type="number" name="estatura" class="form-control" placeholder="Estatura(cm)" required>
                </div>
                <div class="mb-3">
                    <input type="date" name="fecha" class="form-control" placeholder="Fecha de nacimiento" required>
                </div>
                  <div class="form-check">
                    <input class="form-check-input" name="genero" value="Hombre" type="radio" id="flexRadioDefault1" id="flexRadioDefault1">
                    <label class="form-check-label" for="flexRadioDefault1">
                    Hombre
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio"   name="genero" value="Mujer" id="flexRadioDefault2" id="flexRadioDefault2" checked>
                    <label class="form-check-label" for="flexRadioDefault2">
                    Mujer
                    </label>
                  </div>
                <button type="submit" value="Submit" class="btn btn-primary btn-block" href="ingreso.php">Ingresar</button>
                <br>
                <a class="cambio "href="login.php">¿Deseas iniciar sesion?</a>
            </form>
        </div>
    </div>
</body>
</html>